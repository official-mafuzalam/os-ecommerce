<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'customer_email',
        'customer_phone'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function getTotalQuantityAttribute()
    {
        return $this->items()->sum('quantity');
    }

    public function getSubtotalAttribute()
    {
        return $this->items()->with('product')->get()->sum(function ($item) {
            return $item->product ? $item->product->final_price * $item->quantity : 0;
        });
    }

    public function addItem($productId, $quantity = 1)
    {
        $item = $this->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $item = $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return $item;
    }

    public function updateItem($productId, $quantity)
    {
        $item = $this->items()->where('product_id', $productId)->first();

        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->quantity = $quantity;
                $item->save();
            }
        }

        return $this;
    }

    public function removeItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
        return $this;
    }

    public function clear()
    {
        $this->items()->delete();
        return $this;
    }

    public function isEmpty()
    {
        return $this->items()->count() === 0;
    }
}