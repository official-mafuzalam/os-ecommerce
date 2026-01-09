<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\CartItem;
use App\Models\CartItemAttribute;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Attribute;
use App\Mail\OrderPlaced;
use App\Mail\NewOrderNotification;
use App\Events\OrderCreated;
use App\Events\LowStockAlert;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function process(Request $request, FacebookCapiService $fbService)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|size:11',
            'full_address' => 'required|string|max:500',
            'delivery_area' => 'required|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'nullable|in:cash_on_delivery,bkash,nagad,rocket,sslcommerz,bank_transfer,card',
            'notes' => 'nullable|string|max:1000',
            'save_address' => 'nullable|boolean',
        ]);

        // Get delivery charges from settings
        $deliveryChargeInsideDhaka = setting('delivery_charge_inside_dhaka', 80);
        $deliveryChargeOutsideDhaka = setting('delivery_charge_outside_dhaka', 150);

        // Get tax rate if applicable
        $taxRate = setting('tax_rate', 0);

        // Determine delivery charge
        $deliveryCharge = $request->delivery_area === 'inside_dhaka'
            ? $deliveryChargeInsideDhaka
            : $deliveryChargeOutsideDhaka;

        // Get or create customer
        $customer = $this->getOrCreateCustomer($request);

        // Start transaction
        DB::beginTransaction();

        try {
            // Create or get shipping address
            $shippingAddress = $this->createShippingAddress($request, $customer);

            // Get billing address (same as shipping for now)
            $billingAddress = $shippingAddress;

            // Get cart with items and attributes
            $cart = $this->getCart();
            $cartItems = $cart->items()->with(['product', 'attributes'])->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('public.products')->with('error', 'Your cart is empty.');
            }

            // Calculate totals
            $totals = $this->calculateCartTotals($cartItems, $deliveryCharge, $taxRate);

            // Create Order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address_id' => $shippingAddress->id,
                'billing_address_id' => $billingAddress->id,
                'subtotal' => $totals['subtotal'],
                'shipping_cost' => $deliveryCharge,
                'tax_amount' => $totals['tax_amount'],
                'discount_amount' => $totals['discount_amount'] ?? 0,
                'discount_code' => $request->discount_code ?? null,
                'total_amount' => $totals['total'],
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'shipping_method' => 'standard',
                'status' => 'pending',
                'payment_status' => 'pending',
                'customer_notes' => $request->notes,
                'ip_address' => $request->ip(),
                'referral_source' => $request->header('referer'),
            ]);

            // Create Order Items with Attributes
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                if (!$product) {
                    throw new \Exception("Product not found for cart item ID: {$cartItem->id}");
                }

                // Get attribute values
                $attributeValues = $this->getAttributeValues($cartItem);

                // Calculate discount
                $hasDiscount = $product->final_price < $product->original_price;
                $discountPrice = $hasDiscount ? $product->final_price : null;

                // Create order item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->final_price,
                    'original_price' => $product->original_price,
                    'discount_price' => $discountPrice,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->total_price,
                    'tax_amount' => ($cartItem->total_price * $taxRate) / 100,
                    'variant_options' => $attributeValues,
                    'metadata' => [
                        'cart_item_id' => $cartItem->id,
                        'attributes' => $attributeValues,
                    ],
                ]);

                // Store attributes in pivot table (if you have order_item_attributes table)
                $this->storeOrderItemAttributes($orderItem, $cartItem);

                // Reduce stock
                $this->reduceStock($product, $cartItem->quantity);
            }

            // Create Payment Record if not COD
            if ($order->payment_method !== 'cash_on_delivery') {
                $this->createPayment($order);
            }

            // Clear cart after successful checkout
            $cart->items()->delete();

            // Also clear the cart model if it's session-based
            if ($cart->session_id) {
                $cart->delete();
            }

            // Send confirmation email
            if ($request->email) {
                $this->sendOrderConfirmation($order);
            }

            DB::commit();

            // Facebook CAPI Purchase event
            $this->sendFacebookEvent($fbService, $order);

            // Dispatch order created event
            event(new OrderCreated($order));

            // Clear cart session
            $this->clearCartSession();

            return redirect()->route('public.order.complete', ['order_number' => $order->order_number])
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order processing failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to place order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Get or create customer from request
     */
    private function getOrCreateCustomer(Request $request): Customer
    {
        $customer = null;

        // Check if user is authenticated as a customer
        if (Auth::check()) {
            $user = Auth::user();
            // Check if the user is a Customer model
            if ($user instanceof Customer) {
                return $user;
            }
            // If using different user model, try to find customer by email/phone
            if ($user->email) {
                $customer = Customer::where('email', $user->email)->first();
            }
        }

        // Try to find existing customer by phone or email
        if (!$customer && $request->email) {
            $customer = Customer::where('email', $request->email)->first();
        }

        if (!$customer && $request->phone) {
            $customer = Customer::where('phone', $request->phone)->first();
        }

        // Create new customer if not found
        if (!$customer) {
            $customer = Customer::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => 'guest',
                'password' => bcrypt(Str::random(16)), // Random password for guest
            ]);
        }

        return $customer;
    }

    /**
     * Create shipping address
     */
    private function createShippingAddress(Request $request, Customer $customer): CustomerAddress
    {
        // Parse address components from full address
        $addressComponents = $this->parseAddress($request->full_address);

        $addressData = [
            'customer_id' => $customer->id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address_line_1' => $request->full_address,
            'city' => $addressComponents['city'] ?? 'Dhaka',
            'area' => $addressComponents['area'] ?? null,
            'division' => $addressComponents['division'] ?? 'Dhaka',
            'country' => 'Bangladesh',
            'address_type' => 'shipping',
        ];

        // Set as default if requested and customer doesn't have a default address
        if ($request->save_address) {
            $hasDefaultShipping = $customer->addresses()->where('is_default_shipping', true)->exists();
            $hasDefaultBilling = $customer->addresses()->where('is_default_billing', true)->exists();

            $addressData['is_default_shipping'] = !$hasDefaultShipping;
            $addressData['is_default_billing'] = !$hasDefaultBilling;
        }

        return CustomerAddress::create($addressData);
    }

    /**
     * Calculate cart totals
     */
    private function calculateCartTotals($cartItems, $deliveryCharge, $taxRate): array
    {
        $subtotal = 0;
        $taxAmount = 0;
        $discountAmount = 0;

        foreach ($cartItems as $item) {
            $itemTotal = $item->total_price;
            $subtotal += $itemTotal;

            // Calculate tax for this item
            $taxAmount += ($itemTotal * $taxRate) / 100;

            // Calculate discount if any
            $product = $item->product;

            if ($product && $product->original_price && $product->final_price < $product->original_price) {
                $discountAmount += ($product->original_price - $product->final_price) * $item->quantity;
            }
        }

        $total = $subtotal + $deliveryCharge + $taxAmount - $discountAmount;

        return [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ];
    }

    /**
     * Get attribute values from cart item
     */
    private function getAttributeValues(CartItem $cartItem): ?array
    {
        if ($cartItem->attributes->isEmpty()) {
            return null;
        }

        $attributes = [];
        foreach ($cartItem->attributes as $attribute) {
            $attributes[] = [
                'attribute_id' => $attribute->id,
                'attribute_name' => $attribute->name,
                'value' => $attribute->pivot->value,
                'order' => $attribute->pivot->order,
            ];
        }

        return $attributes;
    }

    /**
     * Store order item attributes (if you have order_item_attributes table)
     */
    private function storeOrderItemAttributes(OrderItem $orderItem, CartItem $cartItem): void
    {
        if ($cartItem->attributes->isEmpty()) {
            return;
        }

        // If you have an order_item_attributes table, store attributes there
        // First check if the relationship exists
        if (method_exists($orderItem, 'attributes')) {
            $attributeData = [];
            foreach ($cartItem->attributes as $attribute) {
                $attributeData[$attribute->id] = [
                    'value' => $attribute->pivot->value,
                    'order' => $attribute->pivot->order,
                ];
            }

            $orderItem->attributes()->attach($attributeData);
        }
    }

    /**
     * Reduce product stock
     */
    private function reduceStock(Product $product, int $quantity): void
    {
        // Check if product has stock management enabled
        if ($product->manage_stock) {
            $newStock = max(0, $product->stock - $quantity);
            $product->update(['stock' => $newStock]);

            // Update low stock notification if needed
            $lowStockThreshold = setting('low_stock_threshold', 10);
            if ($newStock <= $lowStockThreshold) {
                event(new LowStockAlert($product));
            }
        }
    }

    /**
     * Create payment record
     */
    private function createPayment(Order $order): Payment
    {
        return Payment::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'payment_number' => Payment::generatePaymentNumber(),
            'payment_method' => $order->payment_method,
            'amount' => $order->total_amount,
            'status' => 'pending',
            'expires_at' => now()->addHours(24),
        ]);
    }

    /**
     * Send order confirmation email
     */
    private function sendOrderConfirmation(Order $order): void
    {
        try {
            // Configure mail settings from database
            if (function_exists('setMailConfigFromDB')) {
                setMailConfigFromDB();
            }

            Mail::to($order->customer_email)->send(new OrderPlaced($order));

            // Also send to admin if configured
            $adminEmail = setting('admin_email');
            if ($adminEmail) {
                // Mail::to($adminEmail)->send(new NewOrderNotification($order));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
        }
    }

    /**
     * Send Facebook CAPI event
     */
    private function sendFacebookEvent(FacebookCapiService $fbService, Order $order): void
    {
        try {
            $eventId = function_exists('fb_event_id') ? fb_event_id() : 'event_' . uniqid();

            $fbPixelId = setting('fb_pixel_id');
            $fbAccessToken = setting('facebook_access_token');

            if ($fbPixelId && $fbAccessToken && $fbService) {
                // Load items with product for SKU
                $order->load('items.product');

                $contents = [];
                $contentIds = [];

                foreach ($order->items as $item) {
                    if ($item->product_sku) {
                        $contentIds[] = $item->product_sku;
                    }
                    $contents[] = [
                        'id' => $item->product_sku ?? $item->product_id,
                        'quantity' => $item->quantity,
                        'item_price' => $item->unit_price
                    ];
                }

                $fbService->sendEvent('Purchase', $eventId, [
                    'em' => $order->customer_email ? [hash('sha256', strtolower($order->customer_email))] : [],
                    'ph' => [hash('sha256', $order->customer_phone)],
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ], [
                    'currency' => 'BDT',
                    'value' => $order->total_amount,
                    'content_ids' => $contentIds,
                    'contents' => $contents,
                    'num_items' => $order->items->sum('quantity'),
                ]);

                Session::flash('fb_event_id', $eventId);
            }
        } catch (\Exception $e) {
            Log::error('Facebook CAPI event failed: ' . $e->getMessage());
        }
    }

    /**
     * Clear cart session
     */
    private function clearCartSession(): void
    {
        Session::forget('cart_id');
        Session::forget('cart_count');
        Session::forget('cart');
    }

    /**
     * Parse address string into components
     */
    private function parseAddress(string $fullAddress): array
    {
        $components = [
            'area' => null,
            'city' => null,
            'division' => null,
        ];

        // Simple parsing logic
        $parts = array_map('trim', explode(',', $fullAddress));

        if (count($parts) >= 2) {
            $components['area'] = $parts[0];
            $components['city'] = $parts[1];

            // Check for division
            $divisionKeywords = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Barishal', 'Sylhet', 'Rangpur', 'Mymensingh'];
            foreach ($divisionKeywords as $division) {
                if (stripos($fullAddress, $division) !== false) {
                    $components['division'] = $division;
                    break;
                }
            }
        }

        return $components;
    }

    /**
     * Get cart from session or create new
     */
    private function getCart(): ShoppingCart
    {
        $cartId = Session::get('cart_id');

        if ($cartId) {
            $cart = ShoppingCart::find($cartId);
            if ($cart) {
                return $cart;
            }
        }

        // Create new cart
        $cart = ShoppingCart::create([
            'session_id' => Session::getId(),
        ]);

        Session::put('cart_id', $cart->id);

        return $cart;
    }

    /**
     * Complete order page
     */
    public function complete($orderNumber)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'billingAddress'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('public.order.complete', compact('order'));
    }

    /**
     * Order details
     */
    public function show($orderNumber)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'billingAddress', 'payments'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Check if customer owns this order
        if (Auth::check()) {
            $user = Auth::user();
            if ($user instanceof Customer && $order->customer_id !== $user->id) {
                abort(403);
            }
        } else {
            // For guest, check session or ask for verification
            if (!Session::has('guest_order_' . $orderNumber)) {
                return redirect()->route('public.order.verify', $orderNumber);
            }
        }

        return view('public.order.show', compact('order'));
    }

    /**
     * Verify guest order access
     */
    public function verify($orderNumber, Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'phone' => 'required|string|size:11',
                'email' => 'nullable|email',
            ]);

            $order = Order::where('order_number', $orderNumber)
                ->where(function ($q) use ($request) {
                    $q->where('customer_phone', $request->phone);
                    if ($request->email) {
                        $q->orWhere('customer_email', $request->email);
                    }
                })
                ->first();

            if ($order) {
                Session::put('guest_order_' . $orderNumber, true);
                return redirect()->route('public.order.show', $orderNumber);
            }

            return back()->with('error', 'Order not found with provided details.');
        }

        return view('public.order.verify', compact('orderNumber'));
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $cart = $this->getCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('public.cart')->with('error', 'Your cart is empty.');
        }

        $deliveryChargeInsideDhaka = setting('delivery_charge_inside_dhaka', 80);
        $deliveryChargeOutsideDhaka = setting('delivery_charge_outside_dhaka', 150);

        $subtotal = $cart->subtotal;
        $totalItems = $cart->total_quantity;

        return view('public.checkout', compact(
            'cartItems',
            'subtotal',
            'totalItems',
            'deliveryChargeInsideDhaka',
            'deliveryChargeOutsideDhaka'
        ));
    }

    /**
     * Add to cart (helper method)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'attributes' => 'nullable|array',
        ]);

        $cart = $this->getCart();
        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->manage_stock && $product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Only ' . $product->stock . ' items available.'
            ]);
        }

        // Check if item already in cart with same attributes
        $existingItem = $this->findCartItemWithSameAttributes($cart, $request->product_id, $request->attributes ?? []);

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;

            // Check stock again for updated quantity
            if ($product->manage_stock && $product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Cannot add more items.'
                ]);
            }

            $existingItem->update(['quantity' => $newQuantity]);
            $item = $existingItem;
        } else {
            // Create new cart item
            $item = $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            // Attach attributes if provided
            if (!empty($request->attributes)) {
                $this->attachAttributesToCartItem($item, $request->attributes);
            }
        }

        // Update cart session
        Session::put('cart_count', $cart->items()->sum('quantity'));

        return response()->json([
            'success' => true,
            'cart_count' => $cart->items()->sum('quantity'),
            'message' => 'Item added to cart'
        ]);
    }

    /**
     * Find cart item with same attributes
     */
    private function findCartItemWithSameAttributes(ShoppingCart $cart, $productId, $attributes): ?CartItem
    {
        $cartItems = $cart->items()->where('product_id', $productId)->get();

        foreach ($cartItems as $item) {
            $itemAttributes = $item->attributes()->pluck('attribute_id', 'value')->toArray();

            // Convert request attributes to same format for comparison
            $requestAttributes = [];
            foreach ($attributes as $attrId => $value) {
                $requestAttributes[$value] = $attrId;
            }

            if ($itemAttributes == $requestAttributes) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Attach attributes to cart item
     */
    private function attachAttributesToCartItem(CartItem $cartItem, array $attributes): void
    {
        $syncData = [];
        $order = 1;

        foreach ($attributes as $attributeId => $value) {
            $syncData[$attributeId] = [
                'value' => $value,
                'order' => $order++
            ];
        }

        $cartItem->attributes()->sync($syncData);
    }
}