<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'type',
        'avatar',
        'date_of_birth',
        'gender',
        'is_active',
        'accepts_marketing'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'accepts_marketing' => 'boolean',
    ];

    // Relationships
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(CustomerAddress::class)->where('is_default_shipping', true);
    }

    public function defaultBillingAddress()
    {
        return $this->hasOne(CustomerAddress::class)->where('is_default_billing', true);
    }

    public function activeOrders()
    {
        return $this->orders()->whereNotIn('status', ['cancelled', 'delivered', 'refunded']);
    }

    public function completedOrders()
    {
        return $this->orders()->where('status', 'delivered');
    }

    // Accessors
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->full_name);
        $initials = '';
        
        if (count($names) >= 2) {
            $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
        } elseif (!empty($this->full_name)) {
            $initials = strtoupper(substr($this->full_name, 0, 2));
        }
        
        return $initials;
    }

    public function getFirstNameAttribute()
    {
        $names = explode(' ', $this->full_name);
        return $names[0] ?? $this->full_name;
    }

    public function getLastNameAttribute()
    {
        $names = explode(' ', $this->full_name);
        return count($names) > 1 ? end($names) : '';
    }

    // Methods
    public function getTotalSpentAttribute()
    {
        return $this->orders()->where('status', 'delivered')->sum('total_amount');
    }

    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    public function getAverageOrderValueAttribute()
    {
        $count = $this->orders()->where('status', 'delivered')->count();
        if ($count === 0) return 0;
        
        return $this->total_spent / $count;
    }

    public function hasDefaultAddress($type = 'shipping')
    {
        return $this->addresses()
            ->where('is_default_' . $type, true)
            ->exists();
    }

    public function createOrder($data)
    {
        return $this->orders()->create(array_merge($data, [
            'order_number' => Order::generateOrderNumber(),
        ]));
    }

    public function markAsRegistered()
    {
        $this->type = 'registered';
        $this->save();
        return $this;
    }

    public function updateProfile($data)
    {
        $this->update($data);
        return $this;
    }
}