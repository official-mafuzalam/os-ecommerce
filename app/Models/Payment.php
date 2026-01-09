<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'customer_id',
        'payment_number',
        'transaction_id',
        'gateway_transaction_id',
        'payment_method',
        'amount',
        'paid_amount',
        'status',
        'paid_at',
        'expires_at',
        'gateway_response',
        'gateway_parameters',
        'gateway_name',
        'notes',
        'metadata'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'gateway_response' => 'array',
        'gateway_parameters' => 'array',
        'metadata' => 'array'
    ];

    protected $appends = [
        'formatted_amount',
        'formatted_paid_amount',
        'is_paid',
        'is_failed',
        'is_expired',
        'payment_method_name'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return '৳' . number_format($this->amount, 2);
    }

    public function getFormattedPaidAmountAttribute(): string
    {
        return '৳' . number_format($this->paid_amount, 2);
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsFailedAttribute(): bool
    {
        return $this->status === 'failed';
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->status === 'expired' || ($this->expires_at && $this->expires_at < now());
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

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'warning',
            'authorized' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'partially_paid' => 'info',
            'failed' => 'danger',
            'refunded' => 'warning',
            'cancelled' => 'secondary',
            'expired' => 'dark',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Methods
    public static function generatePaymentNumber(): string
    {
        $prefix = 'PAY-' . date('ymd') . '-';
        $lastPayment = self::withTrashed()
            ->where('payment_number', 'like', $prefix . '%')
            ->orderBy('payment_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = intval(substr($lastPayment->payment_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $nextNumber;
    }

    public function markAsCompleted(float $paidAmount = null, ?string $transactionId = null): self
    {
        $this->status = 'completed';
        $this->paid_amount = $paidAmount ?? $this->amount;
        $this->paid_at = now();

        if ($transactionId) {
            $this->transaction_id = $transactionId;
        }

        $this->save();

        // Update order payment status
        $this->order->markAsPaid($this);

        return $this;
    }

    public function markAsFailed(?string $reason = null): self
    {
        $this->status = 'failed';
        $this->save();

        if ($reason) {
            $this->notes = $reason;
            $this->save();
        }

        return $this;
    }

    public function markAsExpired(): self
    {
        $this->status = 'expired';
        $this->save();

        return $this;
    }

    public function addPartialPayment(float $amount, ?string $transactionId = null): self
    {
        $this->paid_amount += $amount;

        if ($this->paid_amount >= $this->amount) {
            $this->markAsCompleted($this->paid_amount, $transactionId);
        } else {
            $this->status = 'partially_paid';
            $this->save();
        }

        return $this;
    }

    public function canBeRefunded(): bool
    {
        return $this->is_paid && $this->order->canBeRefunded();
    }

    public function getDueAmount(): float
    {
        return max(0, $this->amount - $this->paid_amount);
    }

    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->amount;
    }

    public function getGatewayResponse(string $key = null)
    {
        if (!$this->gateway_response) {
            return null;
        }

        if ($key) {
            return data_get($this->gateway_response, $key);
        }

        return $this->gateway_response;
    }

    public function storeGatewayResponse(array $response): self
    {
        $this->gateway_response = $response;
        $this->save();

        return $this;
    }
}