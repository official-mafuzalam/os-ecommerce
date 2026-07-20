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
        'description',
        'short_description',
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
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
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
        'category_id',
        'brand_id',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array',
        'tags' => 'array',
        'certifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_bestseller' => 'boolean',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'buy_price' => 'decimal:2',
        'weight' => 'decimal:3',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    protected $appends = ['final_price', 'discount_percentage', 'average_rating', 'reviews_count'];

    // Automatically generate slug from name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
            // Ensure unique slug
            $originalSlug = $product->slug;
            $count = 1;
            while (static::where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
                // Ensure unique slug
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    // Relationships
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

    // Accessors
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeWithDiscount($query)
    {
        return $query->whereNotNull('discount')->where('discount', '>', 0);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= low_stock_threshold');
    }

    // Methods
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function hasDiscount()
    {
        return !is_null($this->discount) && $this->discount > 0;
    }

    public function decreaseStock($quantity)
    {
        $this->stock_quantity -= $quantity;
        return $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock_quantity += $quantity;
        return $this->save();
    }
}