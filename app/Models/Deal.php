<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'discount_text',
        'discount_percentage',
        'discount_details',
        'button_text',
        'button_link',
        'image_url',
        'background_color',
        'is_active',
        'is_featured',
        'starts_at',
        'ends_at',
        'priority',
    ];

    /**
     * Auto-generate slug from title on create.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($deal) {
            if (empty($deal->slug)) {
                $deal->slug = static::generateUniqueSlug($deal->title);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * The products that belong to the deal.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'deal_product')
            ->withPivot('order', 'is_featured')
            ->withTimestamps()
            ->orderBy('deal_product.order');
    }

    /**
     * Get the featured products for this deal.
     */
    public function featuredProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'deal_product')
            ->wherePivot('is_featured', true)
            ->withPivot('order', 'is_featured')
            ->withTimestamps()
            ->orderBy('deal_product.order');
    }

    /**
     * Scope a query to only include active deals that are currently running.
     */
    public function scopeActive(Builder $query): void
    {
        $now = now();

        $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            });
    }

    /**
     * Scope a query to only include featured deals.
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by priority (highest first) and then by creation date.
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the currently active deal with the highest priority.
     */
    public static function getCurrentDeal()
    {
        return self::active()->ordered()->first();
    }

    /**
     * Check if the deal is currently active based on time constraints.
     */
    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }

        if ($this->ends_at && $this->ends_at->lt($now)) {
            return false;
        }

        return true;
    }

    /**
     * Attach products to the deal with optional ordering and featured status.
     */
    public function attachProducts(array $productIds, array $pivotData = []): void
    {
        $syncData = [];
        foreach ($productIds as $index => $productId) {
            $syncData[$productId] = array_merge([
                'order' => $index,
                'is_featured' => false
            ], $pivotData[$productId] ?? []);
        }

        $this->products()->sync($syncData);
    }
}