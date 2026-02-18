<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected function getCart()
    {
        $sessionId = session()->getId();
        return ShoppingCart::firstOrCreate(['session_id' => $sessionId]);
    }

    // Show cart page
    public function index()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with(['product', 'attributes'])->get();

        // 🔹 PROFESSIONAL TRACKING: ViewCart (GA4 + FB)
        if ($items->isNotEmpty()) {
            track_event('ViewCart', [
                'currency' => 'USD',
                'value' => $cart->subtotal,
                'content_type' => 'product',
                'content_ids' => $items->pluck('product.sku')->toArray(),
                'items' => $items->map(fn($item) => [
                    'item_id' => $item->product->sku,
                    'item_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ])->toArray()
            ]);
        }

        return view('public.cart.index', [
            'cart' => $cart,
            'cartItems' => $items,
            'subtotal' => $cart->subtotal,
            'total' => $cart->subtotal,
            'tax' => 0,
        ]);
    }

    // Add product to cart
    public function add(Request $request, Product $product)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . ($product->stock_quantity ?? 100)
            ]);

            $cart = $this->getCart();
            $item = $cart->items()->where('product_id', $product->id)->first();

            if ($item) {
                $item->quantity += $request->quantity;
                $item->save();
            } else {
                $item = $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity
                ]);
            }

            // Handle attributes
            $attributes = $request->input('attributes', []);
            if (!empty($attributes)) {
                $item->attributes()->detach();
                foreach ($attributes as $attributeIdentifier => $value) {
                    if ($value) {
                        $attribute = is_numeric($attributeIdentifier)
                            ? Attribute::find($attributeIdentifier)
                            : Attribute::where('slug', $attributeIdentifier)->orWhere('name', $attributeIdentifier)->first();

                        if ($attribute) {
                            $item->attributes()->attach($attribute->id, ['value' => $value, 'order' => $attribute->order ?? 0]);
                        }
                    }
                }
            }

            // 🔹 PROFESSIONAL HYBRID TRACKING: AddToCart
            // This replaces the old FacebookCapiService injection and manual logic
            track_event('AddToCart', [
                'currency' => 'USD',
                'value' => $product->price * $request->quantity,
                'content_type' => 'product',
                'content_ids' => [$product->sku],
                'items' => [
                    [
                        'item_id' => $product->sku,
                        'item_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => (int) $request->quantity,
                        'item_category' => $product->category->name ?? '',
                    ]
                ]
            ]);

            return back()->with('success', 'Product added to cart!');

        } catch (\Exception $e) {
            Log::error('Add to cart error: ' . $e->getMessage());
            return back()->with('error', 'Failed to add product to cart.');
        }
    }

    // Update quantity (Usually for AJAX)
    public function update(Request $request, $itemId)
    {
        try {
            $request->validate(['quantity' => 'required|integer|min:1']);

            $cart = $this->getCart();
            $item = $cart->items()->find($itemId);

            if (!$item)
                return response()->json(['success' => false, 'message' => 'Not found'], 404);

            $item->quantity = $request->quantity;
            $item->save();

            return response()->json([
                'success' => true,
                'cart_count' => $cart->total_quantity,
                'subtotal' => $cart->subtotal,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Remove item (Usually for AJAX)
    public function remove($itemId)
    {
        try {
            $cart = $this->getCart();
            $item = $cart->items()->find($itemId);
            if ($item)
                $item->delete();

            return response()->json([
                'success' => true,
                'cart_count' => $cart->total_quantity,
                'subtotal' => $cart->subtotal,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function clear()
    {
        $this->getCart()->items()->delete();
        return response()->json(['success' => true]);
    }
}