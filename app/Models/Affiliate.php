<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Affiliate extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'referral_code', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function earnings()
    {
        return $this->hasMany(AffiliateEarning::class);
    }

    public function getReferralLinkAttribute()
    {
        return url('/?ref=' . $this->referral_code);
    }
}
