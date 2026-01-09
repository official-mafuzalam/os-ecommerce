<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'address_type',
        'label',
        'full_name',
        'phone',
        'email',
        'company',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'division',
        'district',
        'area',
        'landmark',
        'is_default_shipping',
        'is_default_billing',
        'custom_fields'
    ];

    protected $casts = [
        'is_default_shipping' => 'boolean',
        'is_default_billing' => 'boolean',
        'custom_fields' => 'array'
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    public function billingOrders()
    {
        return $this->hasMany(Order::class, 'billing_address_id');
    }

    // Scopes
    public function scopeShipping($query)
    {
        return $query->where('address_type', 'shipping')->orWhere('address_type', 'both');
    }

    public function scopeBilling($query)
    {
        return $query->where('address_type', 'billing')->orWhere('address_type', 'both');
    }

    public function scopeDefaultShipping($query)
    {
        return $query->where('is_default_shipping', true);
    }

    public function scopeDefaultBilling($query)
    {
        return $query->where('is_default_billing', true);
    }

    // Accessors
    public function getFormattedAddressAttribute(): string
    {
        $parts = [];

        if ($this->company) {
            $parts[] = $this->company;
        }

        $parts[] = $this->address_line_1;

        if ($this->address_line_2) {
            $parts[] = $this->address_line_2;
        }

        if ($this->area) {
            $parts[] = $this->area;
        }

        if ($this->city) {
            $parts[] = $this->city;
        }

        if ($this->state) {
            $parts[] = $this->state;
        }

        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }

        if ($this->country) {
            $parts[] = $this->country;
        }

        return implode(', ', array_filter($parts));
    }

    public function getShortAddressAttribute(): string
    {
        $parts = [];

        if ($this->area) {
            $parts[] = $this->area;
        }

        if ($this->city) {
            $parts[] = $this->city;
        }

        return implode(', ', $parts);
    }

    public function getFullNameWithPhoneAttribute(): string
    {
        return "{$this->full_name} ({$this->phone})";
    }

    public function getIsDefaultAttribute(): bool
    {
        return $this->is_default_shipping || $this->is_default_billing;
    }

    // Methods
    public function markAsDefaultShipping(): self
    {
        // Remove default from other addresses
        $this->customer->addresses()->update(['is_default_shipping' => false]);

        $this->is_default_shipping = true;
        $this->save();

        return $this;
    }

    public function markAsDefaultBilling(): self
    {
        // Remove default from other addresses
        $this->customer->addresses()->update(['is_default_billing' => false]);

        $this->is_default_billing = true;
        $this->save();

        return $this;
    }

    public function isSameAs(CustomerAddress $address): bool
    {
        return $this->address_line_1 === $address->address_line_1 &&
            $this->address_line_2 === $address->address_line_2 &&
            $this->city === $address->city &&
            $this->postal_code === $address->postal_code &&
            $this->country === $address->country;
    }

    public function copyFrom(array $data): self
    {
        $this->update($data);
        return $this;
    }
}