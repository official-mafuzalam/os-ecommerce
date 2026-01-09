<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\CartItem;
use App\Models\CustomerAddress;
use App\Models\Payment;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Attribute;
use App\Models\Customer;
use App\Models\OrderItemAttribute;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        $sessionId = session()->getId();
        return ShoppingCart::firstOrCreate(['session_id' => $sessionId]);
    }

    // Show checkout page for cart items
    public function index(FacebookCapiService $fbService)
    {
        $cart = $this->getCart();
        $items = $cart->items()->with(['product', 'attributes'])->get();

        if ($items->isEmpty()) {
            return redirect()->route('public.products')->with('error', 'Your cart is empty.');
        }

        // 🔹 Facebook Pixel + CAPI InitiateCheckout Event
        if (setting('fb_pixel_id') && setting('facebook_access_token')) {
            $eventId = fb_event_id();

            $fbService->sendEvent('InitiateCheckout', $eventId, [
                'em' => [hash('sha256', strtolower(auth()->user()->email ?? ''))],
                'ph' => [hash('sha256', auth()->user()->phone ?? '')],
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ], [
                'currency' => 'USD',
                'value' => $cart->subtotal,
                'content_type' => 'product',
                'num_items' => $items->sum('quantity'),
                'content_ids' => $items->pluck('product.sku')->toArray(),
                'contents' => $items->map(function ($item) {
                    return [
                        'id' => $item->product->sku,
                        'quantity' => $item->quantity,
                    ];
                })->toArray(),
            ]);

            session()->flash('fb_event_id', $eventId);
        }

        return view('public.checkout', [
            'cart' => $cart,
            'cartItems' => $items,
            'subtotal' => $cart->subtotal,
            'tax' => 0,
            'total' => $cart->subtotal,
        ]);
    }

    // Buy now for a single product
    public function buyNow(Product $product, Request $request)
    {
        Log::info('Buy Now Request Data:', $request->all());

        $quantity = $request->input('quantity', 1);

        if ($quantity < 1)
            $quantity = 1;
        if ($quantity > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart = $this->getCart();

        // Clear current cart for single product checkout
        $cart->items()->delete();

        // Create cart item
        $item = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);

        // Handle attributes if provided
        $attributes = $request->input('attributes', []);
        if (!empty($attributes)) {
            Log::info('Attributes received:', $attributes);

            foreach ($attributes as $attributeIdentifier => $value) {
                if ($value) {
                    Log::info("Processing attribute: ID={$attributeIdentifier}, Value={$value}");

                    // Find attribute by ID, slug, or name
                    $attribute = null;

                    // First, try to find by ID (if numeric)
                    if (is_numeric($attributeIdentifier)) {
                        $attribute = Attribute::find($attributeIdentifier);
                    }

                    // If not found by ID, try slug or name
                    if (!$attribute) {
                        $attribute = Attribute::where('slug', $attributeIdentifier)
                            ->orWhere('name', $attributeIdentifier)
                            ->first();
                    }

                    if ($attribute) {
                        Log::info("Found attribute: ID={$attribute->id}, Name={$attribute->name}");

                        $item->attributes()->attach($attribute->id, [
                            'value' => $value,
                            'order' => $attribute->order ?? 0
                        ]);

                        Log::info("Attribute attached successfully");
                    } else {
                        Log::warning("Attribute not found: {$attributeIdentifier}");
                    }
                }
            }
        }

        Log::info('Cart item created:', $item->toArray());

        // Reload the item with attributes
        $item->load('attributes');

        Log::info('Attributes attached to cart item: ', [
            'count' => $item->attributes->count(),
            'attributes' => $item->attributes->map(function ($attr) {
                return [
                    'id' => $attr->id,
                    'name' => $attr->name,
                    'value' => $attr->pivot->value
                ];
            })->toArray()
        ]);

        return redirect()->route('public.checkout')->with('success', $product->name . ' added for checkout.');
    }

    // Process checkout
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

            // Get billing address (same as shipping for now, can be separate if needed)
            $billingAddress = $shippingAddress;

            // Get cart items with attributes
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

                // Get attribute values from cart item
                $attributeValues = $this->getAttributeValues($cartItem);

                // Create the order item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->final_price,
                    'original_price' => $product->original_price,
                    'discount_price' => $product->final_price < $product->original_price ? $product->final_price : null,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->total_price,
                    'tax_amount' => ($cartItem->total_price * $taxRate) / 100,
                    'variant_options' => $attributeValues, // Store attributes as variant_options
                    'metadata' => [
                        'cart_item_id' => $cartItem->id,
                        'attributes' => $attributeValues,
                    ],
                ]);

                // Store attribute values in a separate pivot table if needed
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

            // Send confirmation email
            if ($request->email) {
                $this->sendOrderConfirmation($order);
            }

            // Send SMS notification
            if (setting('sms_enabled')) {
                $this->sendOrderSMS($order);
            }

            DB::commit();

            // Facebook CAPI Purchase event
            $this->sendFacebookEvent($fbService, $order);

            // Dispatch order created event
            // event(new OrderCreated($order));

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
     * Store order item attributes in pivot table
     */
    private function storeOrderItemAttributes(OrderItem $orderItem, CartItem $cartItem): void
    {
        if ($cartItem->attributes->isEmpty()) {
            return;
        }

        $attributeData = [];
        foreach ($cartItem->attributes as $attribute) {
            $attributeData[$attribute->id] = [
                'value' => $attribute->pivot->value,
                'order' => $attribute->pivot->order,
            ];
        }

        // If you have an order_item_attributes pivot table
        if (method_exists($orderItem, 'attributes')) {
            $orderItem->attributes()->attach($attributeData);
        }
    }

    /**
     * Reduce product stock
     */
    private function reduceStock(Product $product, int $quantity): void
    {
        $product->decrement('stock', $quantity);

        // Update low stock notification if needed
        if ($product->stock <= setting('low_stock_threshold', 10)) {
            // event(new LowStockAlert($product));
        }
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
            $subtotal += $item->total_price;

            // Calculate tax for this item
            $taxAmount += ($item->total_price * $taxRate) / 100;

            // Calculate discount if any
            $product = $item->product;

            if ($product->original_price && $product->final_price < $product->original_price) {
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
     * Send Facebook CAPI event
     */
    private function sendFacebookEvent(FacebookCapiService $fbService, Order $order): void
    {
        try {
            $eventId = fb_event_id();
            if (setting('fb_pixel_id') && setting('facebook_access_token')) {
                $fbService->sendEvent('Purchase', $eventId, [
                    'em' => $order->customer_email ? [hash('sha256', strtolower($order->customer_email))] : [],
                    'ph' => [hash('sha256', $order->customer_phone)],
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ], [
                    'currency' => 'BDT',
                    'value' => $order->total_amount,
                    'content_ids' => $order->items->pluck('product_sku')->filter()->toArray(),
                    'contents' => $order->items->map(fn($i) => [
                        'id' => $i->product_sku,
                        'quantity' => $i->quantity,
                        'item_price' => $i->unit_price
                    ])->toArray(),
                    'num_items' => $order->items->sum('quantity'),
                ]);

                session()->flash('fb_event_id', $eventId);
            }
        } catch (\Exception $e) {
            Log::error('Facebook CAPI event failed: ' . $e->getMessage());
        }
    }

    // Show order completion page
    public function orderComplete(Request $request)
    {
        $orderNumber = $request->query('order_number');
        $order = Order::with(['items.product', 'items.attributes', 'shippingAddress'])
            ->where('order_number', $orderNumber)
            ->first();

        if (!$order) {
            return redirect()->route('public.products')->with('error', 'Order not found.');
        }

        return view('public.order-complete', compact('order'));
    }

    // Show order tracking form
    public function orderTrack()
    {
        return view('public.parcel-tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255'
        ]);

        $order = Order::with(['items.product', 'items.attributes', 'shippingAddress'])
            ->where('order_number', $request->tracking_number)
            ->first();

        if (!$order) {
            return back()->withErrors(['message' => 'No order found with provided tracking number.'])->withInput();
        }

        return view('public.parcel-tracking', ['order' => $order]);
    }
}