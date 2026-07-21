<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = [
        'product_id',
        'description',
        'short_description',
        'weight',
        'length',
        'width',
        'height',
        'tags',
        'label',
        'ingredients',
        'usage_instructions',
        'warranty_info',
        'origin_country',
        'certifications',
        'material',
        'care_instructions',
        'specifications',
    ];

    protected $casts = [
        'tags'           => 'array',
        'certifications' => 'array',
        'specifications' => 'array',
        'weight'         => 'decimal:3',
        'length'         => 'decimal:2',
        'width'          => 'decimal:2',
        'height'         => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
