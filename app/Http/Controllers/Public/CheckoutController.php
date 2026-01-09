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
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        $sessionId = session()->getId();
        
        // Try to find existing cart first
        $cart = ShoppingCart::where('session_id', $sessionId)->first();
        
        // If not found, create new cart
        if (!$cart) {
            $cart = ShoppingCart::create([
                'session_id' => $sessionId,
            ]);
        }
        
        return $cart;
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
            $eventId = $this->generateEventId();

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

    public function process(Request $request, FacebookCapiService $fbService)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|size:11',
            'full_address' => 'required|string|max:500',
            'delivery_area' => 'required|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'nullable|in:cash_on_delivery,bkash,nagad,sslcommerz',
            'notes' => 'nullable|string|max:1000',
        ]);

        $deliveryChargeInsideDhaka = setting('delivery_charge_inside_dhaka', 80);
        $deliveryChargeOutsideDhaka = setting('delivery_charge_outside_dhaka', 150);

        // Determine delivery charge
        $deliveryCharge = $request->delivery_area === 'inside_dhaka' ? $deliveryChargeInsideDhaka : $deliveryChargeOutsideDhaka;

        // Start transaction
        DB::beginTransaction();

        try {
            // Create or get customer
            $customer = $this->getOrCreateCustomer($request);

            // Create or get shipping address using new system
            $shippingAddress = $this->createShippingAddress($request, $customer);

            // Get cart items with attributes
            $cart = $this->getCart();
            $cartItems = $cart->items()->with(['product', 'attributes'])->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('public.products')->with('error', 'Your cart is empty.');
            }

            // Calculate subtotal
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->total_price;
            }

            // Create Order using new model
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address_id' => $shippingAddress->id,
                'billing_address_id' => $shippingAddress->id, // Same as shipping for now
                'subtotal' => $subtotal,
                'shipping_cost' => $deliveryCharge,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $subtotal + $deliveryCharge,
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'status' => 'pending',
                'payment_status' => 'pending',
                'customer_notes' => $request->notes,
                'ip_address' => $request->ip(),
                'referral_source' => $request->header('referer'),
            ]);

            // Create Order Items with Attributes
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                
                // Get attribute values
                $attributeValues = $this->getAttributeValues($cartItem);
                
                // Create the order item using new model
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->final_price,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->total_price,
                    'variant_options' => $attributeValues,
                    'metadata' => [
                        'cart_item_id' => $cartItem->id,
                        'attributes' => $attributeValues,
                    ],
                ]);

                // Copy attributes from cart item to order item if you have order_item_attributes table
                if ($cartItem->attributes->count() > 0) {
                    foreach ($cartItem->attributes as $attribute) {
                        // Check if you have an order_item_attributes table
                        if (class_exists('App\Models\OrderItemAttribute')) {
                            OrderItemAttribute::create([
                                'order_item_id' => $orderItem->id,
                                'attribute_id' => $attribute->id,
                                'value' => $attribute->pivot->value,
                                'order' => $attribute->pivot->order ?? 0,
                            ]);
                        }
                    }
                }

                // Reduce stock
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->decreaseStock($cartItem->quantity);
                }
            }

            // Create Payment Record if not COD
            if ($order->payment_method !== 'cash_on_delivery') {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_number' => $this->generatePaymentNumber(),
                    'payment_method' => $order->payment_method,
                    'amount' => $order->total_amount,
                    'status' => 'pending',
                    'expires_at' => now()->addHours(24),
                ]);
            }

            // Clear cart after checkout
            $cart->items()->delete();
            $cart->delete(); // Also delete the cart record

            // Send email if email provided
            setMailConfigFromDB();
            if ($request->email) {
                Mail::to($request->email)->send(new OrderPlaced($order));
            }

            DB::commit();

            // Facebook CAPI Purchase event
            $eventId = $this->generateEventId();
            if (setting('fb_pixel_id') && setting('facebook_access_token')) {
                $fbService->sendEvent('Purchase', $eventId, [
                    'em' => [hash('sha256', strtolower($order->customer_email))],
                    'ph' => [hash('sha256', $order->customer_phone)],
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ], [
                    'currency' => 'USD',
                    'value' => $order->total_amount,
                    'content_ids' => $order->items->pluck('product.sku')->toArray(),
                    'contents' => $order->items->map(fn($i) => ['id' => $i->product->sku, 'quantity' => $i->quantity])->toArray(),
                ]);

                session()->flash('fb_event_id', $eventId);
            }

            return redirect()->route('public.order.complete', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order processing failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * Get or create customer from request
     */
    private function getOrCreateCustomer(Request $request): Customer
    {
        $customer = null;
        
        // Try to find existing customer by phone or email
        if ($request->email) {
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
        
        return CustomerAddress::create([
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
        ]);
    }

    /**
     * Get attribute values from cart item
     */
    private function getAttributeValues(CartItem $cartItem): ?array
    {
        if (is_array($cartItem->attributes) ? empty($cartItem->attributes) : $cartItem->attributes->isEmpty()) {
            return null;
        }

        $attributes = [];
        foreach ($cartItem->attributes as $attribute) {
            $attributes[$attribute->name] = $attribute->pivot->value;
        }

        return $attributes;
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
     * Generate event ID for Facebook
     */
    private function generateEventId(): string
    {
        if (function_exists('fb_event_id')) {
            return fb_event_id();
        }
        
        return 'event_' . uniqid();
    }

    /**
     * Generate payment number
     */
    private function generatePaymentNumber(): string
    {
        return 'PAY-' . date('ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
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