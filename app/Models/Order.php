<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'customer_id',
        'shipping_address_id',
        'billing_address_id',
        'subtotal',
        'shipping_cost',
        'tax_amount',
        'discount_amount',
        'discount_code',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_method',
        'tracking_number',
        'courier_name',
        'estimated_delivery_date',
        'shipped_at',
        'delivered_at',
        'customer_notes',
        'admin_notes',
        'ip_address',
        'referral_source',
        'metadata'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'estimated_delivery_date' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected $appends = [
        'status_badge',
        'payment_method_name',
        'items_count',
        'is_overdue',
        'days_since_created'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'billing_address_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->whereIn('status', ['confirmed', 'processing']);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', today()->subDay());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeNeedsAttention($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed', 'processing'])
                     ->orWhere(function ($q) {
                         $q->where('status', 'shipped')
                           ->where('delivered_at', null)
                           ->where('estimated_delivery_date', '<', now());
                     });
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'success',
            'delivered' => 'dark',
            'returned' => 'warning',
            'refunded' => 'info',
            'cancelled' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getPaymentMethodNameAttribute(): string
    {
        $methods = [
            'cash_on_delivery' => 'Cash on Delivery',
            'bkash' => 'bKash',
            'nagad' => 'Nagad',
            'rocket' => 'Rocket',
            'sslcommerz' => 'SSLCommerz',
            'bank_transfer' => 'Bank Transfer',
            'card' => 'Credit/Debit Card',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getItemsCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->estimated_delivery_date && 
               $this->estimated_delivery_date < now() && 
               $this->status !== 'delivered';
    }

    public function getDaysSinceCreatedAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getFormattedTotalAttribute(): string
    {
        return '৳' . number_format($this->total_amount, 2);
    }

    // Methods
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('ymd') . '-';
        $lastOrder = self::withTrashed()
            ->where('order_number', 'like', $prefix . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $nextNumber;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    public function canBeRefunded(): bool
    {
        return in_array($this->status, ['delivered']) && $this->payment_status === 'paid';
    }

    public function updateStatus(string $status, ?string $notes = null): self
    {
        $validStatuses = [
            'pending', 'confirmed', 'processing', 'shipped',
            'delivered', 'returned', 'refunded', 'cancelled'
        ];

        if (in_array($status, $validStatuses)) {
            $oldStatus = $this->status;
            $this->status = $status;
            
            // Set timestamps for specific statuses
            if ($status === 'shipped' && !$this->shipped_at) {
                $this->shipped_at = now();
            } elseif ($status === 'delivered' && !$this->delivered_at) {
                $this->delivered_at = now();
            }
            
            $this->save();
            
            // Create status history record
            if ($oldStatus !== $status) {
                $this->createStatusHistory($oldStatus, $status, $notes);
            }
        }

        return $this;
    }

    public function markAsPaid(?Payment $payment = null): self
    {
        $this->payment_status = 'paid';
        $this->save();

        if ($this->status === 'pending') {
            $this->updateStatus('confirmed');
        }

        return $this;
    }

    public function calculateTotals(): array
    {
        $subtotal = $this->items->sum('total_price');
        $tax = $this->tax_amount;
        $shipping = $this->shipping_cost;
        $discount = $this->discount_amount;
        $total = $subtotal + $tax + $shipping - $discount;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total
        ];
    }

    public function recalculateTotals(): self
    {
        $totals = $this->calculateTotals();
        
        $this->subtotal = $totals['subtotal'];
        $this->total_amount = $totals['total'];
        $this->save();

        return $this;
    }

    public function addItem(array $itemData): OrderItem
    {
        $item = $this->items()->create($itemData);
        $this->recalculateTotals();
        
        return $item;
    }

    private function createStatusHistory(string $from, string $to, ?string $notes = null): void
    {
        // Optional: Create status history record if you have the table
        // OrderStatusHistory::create([
        //     'order_id' => $this->id,
        //     'status_from' => $from,
        //     'status_to' => $to,
        //     'notes' => $notes
        // ]);
    }

    public function getEstimatedDeliveryDays(): ?int
    {
        if (!$this->estimated_delivery_date) {
            return null;
        }

        return $this->created_at->diffInDays($this->estimated_delivery_date);
    }

    public function getShippingAddressName(): string
    {
        return $this->shippingAddress ? $this->shippingAddress->full_name : 'N/A';
    }

    public function getCustomerName(): string
    {
        return $this->customer ? $this->customer->full_name : 'Guest';
    }
}