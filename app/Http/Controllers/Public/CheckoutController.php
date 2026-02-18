<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Attribute;
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
    public function index()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with(['product', 'attributes'])->get();

        if ($items->isEmpty()) {
            return redirect()->route('public.products')->with('error', 'Your cart is empty.');
        }

        // 🔹 Professional Hybrid Tracking (FB CAPI + GTM + Pixel)
        // The helper automatically handles Hashing, IP, User Agent, and Deduplication IDs.
        track_event('InitiateCheckout', [
            'currency' => 'BDT',
            'value' => $cart->subtotal,
            'content_type' => 'product',
            // Standard GA4 Item Schema (used by both GTM and FB)
            'items' => $items->map(function ($item) {
                return [
                    'item_id' => $item->product->sku,
                    'item_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ];
            })->toArray(),
            // FB Specifics (The helper/service extracts these into 'contents')
            'content_ids' => $items->pluck('product.sku')->toArray(),
            'num_items' => $items->sum('quantity'),
        ]);

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
    public function process(Request $request)
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

        $deliveryCharge = $request->delivery_area === 'inside_dhaka'
            ? setting('delivery_charge_inside_dhaka', 80)
            : setting('delivery_charge_outside_dhaka', 150);

        DB::beginTransaction();

        try {
            $shippingAddress = ShippingAddress::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'full_address' => $request->full_address,
                'delivery_area' => $request->delivery_area,
            ]);

            $cart = $this->getCart();
            $cartItems = $cart->items()->with(['product.category', 'product.brand', 'attributes'])->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('public.products')->with('error', 'Your cart is empty.');
            }

            $subtotal = $cartItems->sum('total_price');

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'subtotal' => $subtotal,
                'shipping_cost' => $deliveryCharge,
                'discount_amount' => 0,
                'total_amount' => $subtotal + $deliveryCharge,
                'shipping_address_id' => $shippingAddress->id,
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                $orderItem = $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'unit_price' => $cartItem->product->final_price,
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->total_price,
                ]);

                if ($cartItem->attributes->count() > 0) {
                    foreach ($cartItem->attributes as $attribute) {
                        $orderItem->attributes()->attach($attribute->id, [
                            'value' => $attribute->pivot->value,
                            'order' => $attribute->pivot->order
                        ]);
                    }
                }

                $cartItem->product->decreaseStock($cartItem->quantity);
            }

            $cart->items()->delete();

            setMailConfigFromDB();
            if ($request->email) {
                Mail::to($request->email)->send(new OrderPlaced($order));
            }

            DB::commit();

            // 🔹 PROFESSIONAL HYBRID TRACKING: Purchase
            // We pass the email/phone from the order to ensure even guest checkouts are tracked accurately.
            track_event('Purchase', [
                'transaction_id' => $order->order_number,
                'value' => $order->total_amount,
                'currency' => 'BDT', // Or your specific currency
                'tax' => 0,
                'shipping' => $deliveryCharge,
                'items' => $order->items->map(fn($item) => [
                    'item_id' => $item->product->sku,
                    'item_name' => $item->product->name,
                    'price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'item_category' => $item->product->category->name ?? '',
                    'item_brand' => $item->product->brand->name ?? '',
                ])->toArray(),
                // Pass user data for CAPI hashing
                'user_data' => [
                    'em' => $order->customer_email,
                    'ph' => $order->customer_phone,
                    'fn' => $request->full_name,
                ]
            ]);

            return redirect()->route('public.order.complete', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to place order.');
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