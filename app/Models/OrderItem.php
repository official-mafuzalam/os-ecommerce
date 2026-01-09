<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'unit_price',
        'original_price',
        'discount_price',
        'tax_amount',
        'quantity',
        'total_price',
        'metadata'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'metadata' => 'array'
    ];

    protected $appends = [
        'has_discount',
        'discount_percentage',
        'formatted_unit_price',
        'formatted_total_price'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'order_item_attributes')
            ->withPivot('value', 'order')
            ->withTimestamps();
    }

    // Or if you're using OrderItemAttribute model
    public function orderItemAttributes()
    {
        return $this->hasMany(OrderItemAttribute::class);
    }

    // Accessors
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null &&
            $this->original_price !== null &&
            $this->discount_price < $this->original_price;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->has_discount || $this->original_price == 0) {
            return 0;
        }

        return round((($this->original_price - $this->discount_price) / $this->original_price) * 100, 2);
    }

    public function getFormattedUnitPriceAttribute(): string
    {
        return '৳' . number_format($this->unit_price, 2);
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return '৳' . number_format($this->total_price, 2);
    }

    public function getActualUnitPriceAttribute(): float
    {
        return $this->discount_price ?? $this->unit_price;
    }

    public function getLineTotalAttribute(): float
    {
        return $this->actual_unit_price * $this->quantity;
    }

    // Methods
    public function calculateTotal(): float
    {
        return $this->actual_unit_price * $this->quantity;
    }

    public function updateQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->total_price = $this->calculateTotal();
        $this->save();

        $this->order->recalculateTotals();

        return $this;
    }

    public function updatePrice(float $price): self
    {
        $this->unit_price = $price;
        $this->total_price = $this->calculateTotal();
        $this->save();

        $this->order->recalculateTotals();

        return $this;
    }

    public function applyDiscount(float $discountPrice): self
    {
        $this->discount_price = $discountPrice;
        $this->total_price = $this->calculateTotal();
        $this->save();

        $this->order->recalculateTotals();

        return $this;
    }

    public function removeDiscount(): self
    {
        $this->discount_price = null;
        $this->total_price = $this->calculateTotal();
        $this->save();

        $this->order->recalculateTotals();

        return $this;
    }

    public function getProductName(): string
    {
        return $this->product ? $this->product->name : 'Unknown Product';
    }

    public function getProductSku(): ?string
    {
        return $this->product ? $this->product->sku : null;
    }

    public function getProductImage(): ?string
    {
        return $this->product ? $this->product->getFirstMediaUrl('products') : null;
    }
}