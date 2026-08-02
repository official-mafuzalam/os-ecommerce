<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_email',
        'customer_phone',
        'ip_address',
        'subtotal',
        'shipping_cost',
        'discount_amount',
        'total_amount',
        'shipping_address_id',
        'affiliate_id',
        'status',
        'payment_method',
        'payment_status',
        'notes',
        'tracking_number'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Booted
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = Order::generateOrderNumber();
        });
    }

    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function earning()
    {
        return $this->hasOne(AffiliateEarning::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    // Methods
    public static function generateOrderNumber()
    {
        return 'OS-' . date('Ymd') . '-' . rand(1000, 9999);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function markAsPaid()
    {
        $this->payment_status = 'paid';
        $this->save();

        if ($this->status === 'pending') {
            $this->status = 'confirmed';
            $this->save();
        }

        return $this;
    }

    public function updateStatus($status)
    {
        $validStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (in_array($status, $validStatuses)) {
            $this->status = $status;
            $this->save();
        }

        return $this;
    }
}