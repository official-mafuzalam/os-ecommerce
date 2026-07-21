<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'buy_price',
        'price',
        'discount',
        'stock_quantity',
        'low_stock_threshold',
        'is_active',
        'is_featured',
        'is_new_arrival',
        'is_bestseller',
        'published_at',
        'views_count',
        'sales_count',
        'min_order_quantity',
        'max_order_quantity',
        'category_id',
        'brand_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_featured'  => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_bestseller'  => 'boolean',
        'price'        => 'decimal:2',
        'discount'     => 'decimal:2',
        'buy_price'    => 'decimal:2',
        'published_at' => 'datetime',
    ];

    protected $appends = ['final_price', 'discount_percentage', 'average_rating', 'reviews_count'];

    // Auto-generate slug from name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
            $originalSlug = $product->slug;
            $count = 1;
            while (static::where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    // =========================================================
    // Relationships
    // =========================================================

    public function detail()
    {
        return $this->hasOne(ProductDetail::class)->withDefault();
    }

    public function seo()
    {
        return $this->hasOne(ProductSeo::class)->withDefault();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')
            ->withPivot('value', 'order')
            ->withTimestamps();
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_product')
            ->withPivot('order', 'is_featured')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // =========================================================
    // Proxy Accessors → ProductDetail
    // All blade views continue working without changes.
    // =========================================================

    public function getDescriptionAttribute()      { return $this->detail?->description; }
    public function getShortDescriptionAttribute() { return $this->detail?->short_description; }
    public function getWeightAttribute()           { return $this->detail?->weight; }
    public function getLengthAttribute()           { return $this->detail?->length; }
    public function getWidthAttribute()            { return $this->detail?->width; }
    public function getHeightAttribute()           { return $this->detail?->height; }
    public function getTagsAttribute()             { return $this->detail?->tags; }
    public function getLabelAttribute()            { return $this->detail?->label; }
    public function getIngredientsAttribute()      { return $this->detail?->ingredients; }
    public function getUsageInstructionsAttribute(){ return $this->detail?->usage_instructions; }
    public function getWarrantyInfoAttribute()     { return $this->detail?->warranty_info; }
    public function getOriginCountryAttribute()    { return $this->detail?->origin_country; }
    public function getCertificationsAttribute()   { return $this->detail?->certifications; }
    public function getMaterialAttribute()         { return $this->detail?->material; }
    public function getCareInstructionsAttribute() { return $this->detail?->care_instructions; }
    public function getSpecificationsAttribute()   { return $this->detail?->specifications; }

    // =========================================================
    // Proxy Accessors → ProductSeo
    // =========================================================

    public function getMetaTitleAttribute()       { return $this->seo?->meta_title; }
    public function getMetaDescriptionAttribute() { return $this->seo?->meta_description; }
    public function getMetaKeywordsAttribute()    { return $this->seo?->meta_keywords; }
    public function getOgImageAttribute()         { return $this->seo?->og_image; }

    // =========================================================
    // Computed Accessors
    // =========================================================

    public function getFinalPriceAttribute()
    {
        return $this->discount ? $this->price - $this->discount : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->discount ? round(($this->discount / $this->price) * 100) : 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    public function getSeoTitleAttribute()
    {
        return $this->meta_title ?: $this->name;
    }

    public function getSeoDescriptionAttribute()
    {
        return $this->meta_description ?: Str::limit(strip_tags($this->short_description ?: $this->description), 160);
    }

    // =========================================================
    // Scopes
    // =========================================================

    public function scopeActive($query)      { return $query->where('is_active', true); }
    public function scopeInactive($query)    { return $query->where('is_active', false); }
    public function scopeFeatured($query)    { return $query->where('is_featured', true); }
    public function scopeInStock($query)     { return $query->where('stock_quantity', '>', 0); }
    public function scopeWithDiscount($query){ return $query->whereNotNull('discount')->where('discount', '>', 0); }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeNewArrivals($query)  { return $query->where('is_new_arrival', true); }
    public function scopeBestsellers($query)  { return $query->where('is_bestseller', true); }
    public function scopeLowStock($query)     { return $query->whereRaw('stock_quantity <= low_stock_threshold'); }

    // =========================================================
    // Methods
    // =========================================================

    public function isInStock()  { return $this->stock_quantity > 0; }
    public function hasDiscount(){ return !is_null($this->discount) && $this->discount > 0; }

    public function decreaseStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        $this->increment('sales_count', $quantity);
        return $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock_quantity += $quantity;
        return $this->save();
    }

    public function incrementViews()
    {
        return $this->increment('views_count');
    }

    public function incrementSales($quantity = 1)
    {
        return $this->increment('sales_count', $quantity);
    }
}