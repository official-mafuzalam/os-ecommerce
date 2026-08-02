<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateEarning extends Model
{
    protected $fillable = [
        'affiliate_id', 'order_id', 'amount', 'status'
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
