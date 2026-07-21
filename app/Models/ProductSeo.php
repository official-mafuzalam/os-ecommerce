<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSeo extends Model
{
    protected $fillable = [
        'product_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
