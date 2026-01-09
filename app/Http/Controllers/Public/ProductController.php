<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $perPageProducts = 20;

    public function products(Request $request)
    {
        // Base query - only select necessary columns for performance
        $query = Product::with([
            'category:id,name,slug',
            'brand:id,name,slug',
            'images' => function ($q) {
                // Remove 'order' column since it doesn't exist
                $q->where('is_primary', true)->limit(1);
            }
        ])
            ->where('is_active', true)
            ->select('products.*');

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
                $categoryData = $category;
            }
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $brand = Brand::where('slug', $request->brand)
                ->where('is_active', true)
                ->first();

            if ($brand) {
                $query->where('brand_id', $brand->id);
                $brandData = $brand;
            }
        }

        // Price filter - using calculated final_price
        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $minPrice = (float) $request->min_price;
            $query->where(function ($q) use ($minPrice) {
                $q->whereRaw('(price - IFNULL(discount, 0)) >= ?', [$minPrice])
                    ->orWhereRaw('price >= ?', [$minPrice]);
            });
        }

        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $maxPrice = (float) $request->max_price;
            $query->where(function ($q) use ($maxPrice) {
                $q->whereRaw('(price - IFNULL(discount, 0)) <= ?', [$maxPrice])
                    ->orWhereRaw('price <= ?', [$maxPrice]);
            });
        }

        // New arrivals filter (last 30 days)
        if ($request->boolean('new')) {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        // Featured filter
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // In stock filter
        if ($request->boolean('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        // On sale filter (has discount)
        if ($request->boolean('on_sale')) {
            $query->where('discount', '>', 0);
        }

        // Sorting logic
        $sort = $request->get('sort', 'newest');

        switch ($sort) {
            case 'price_low_high':
                $query->orderByRaw('(price - IFNULL(discount, 0)) asc');
                break;

            case 'price_high_low':
                $query->orderByRaw('(price - IFNULL(discount, 0)) desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'popular':
                // Check if views_count column exists
                $connection = DB::connection();
                $schema = $connection->getSchemaBuilder();
                if ($schema->hasColumn('products', 'views_count')) {
                    $query->orderBy('views_count', 'desc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
                break;

            case 'best_selling':
                // Check if sales_count column exists
                $connection = DB::connection();
                $schema = $connection->getSchemaBuilder();
                if ($schema->hasColumn('products', 'sales_count')) {
                    $query->orderBy('sales_count', 'desc');
                } else {
                    $query->latest();
                }
                break;

            case 'trending':
                // Simple trending logic based on creation date and stock
                $query->where('stock_quantity', '>', 0)
                    ->orderBy('created_at', 'desc')
                    ->orderBy('stock_quantity', 'asc'); // Low stock appears first
                break;

            default: // 'newest' and fallback
                $query->latest();
                break;
        }

        // Always sort by ID as secondary to ensure consistent pagination
        $query->orderBy('id', 'desc');

        // Get total count for display
        $totalProductsCount = (clone $query)->count();

        // Paginate results
        $perPage = $request->get('per_page', 48); // Configurable per page
        $products = $query->paginate($perPage)->withQueryString();

        // Transform products with calculated fields
        $products->getCollection()->transform(function ($product) {
            // Calculate discount percentage
            $product->discount_percentage = $product->price > 0
                ? round(($product->discount / $product->price) * 100, 1)
                : 0;

            // Calculate final price
            $product->final_price = $product->price - $product->discount;

            // Mark as new if created in last 30 days
            $product->is_new = $product->created_at->greaterThanOrEqualTo(now()->subDays(30));

            // Mark as low stock if quantity <= 10
            $product->is_low_stock = $product->stock_quantity > 0 && $product->stock_quantity <= 10;

            // Get average rating and reviews count
            $product->average_rating = $product->reviews()->avg('rating') ?? 0;
            $product->reviews_count = $product->reviews()->count();

            // Get primary image URL
            $primaryImage = $product->images()->where('is_primary', true)->first();
            $product->primary_image_url = $primaryImage
                ? Storage::url($primaryImage->image_path)
                : asset('images/default-product.jpg');

            return $product;
        });

        // Get categories with product counts
        $categories = Category::where('is_active', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug']);

        // Get brands with product counts
        $brands = Brand::where('is_active', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug']);

        // Calculate price range for filter UI - simplified version
        $priceRange = Product::where('is_active', true)
            ->selectRaw('
            MIN(price) as min_price,
            MAX(price) as max_price
        ')
            ->first();

        // Prepare view data
        $viewData = [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'totalProductsCount' => $totalProductsCount,
            'currentSort' => $sort,
            'minPrice' => $priceRange->min_price ?? 0,
            'maxPrice' => $priceRange->max_price ?? 10000,
            'activeFilters' => [
                'category' => $request->category ?? null,
                'brand' => $request->brand ?? null,
                'min_price' => $request->min_price ?? null,
                'max_price' => $request->max_price ?? null,
                'new' => $request->boolean('new'),
                'featured' => $request->boolean('featured'),
                'in_stock' => $request->boolean('in_stock'),
                'on_sale' => $request->boolean('on_sale'),
            ]
        ];

        // Add category/brand data if filtered
        if (isset($categoryData)) {
            $viewData['category'] = $categoryData;
        }

        if (isset($brandData)) {
            $viewData['brand'] = $brandData;
        }

        // Check for featured page
        if ($request->routeIs('public.featured.products')) {
            $viewData['is_featured'] = true;
        }

        // Track view for analytics (optional) - check if column exists first
        if (isset($categoryData)) {
            $connection = DB::connection();
            $schema = $connection->getSchemaBuilder();
            if ($schema->hasColumn('categories', 'views_count')) {
                $categoryData->increment('views_count');
            }
        }

        if (isset($brandData)) {
            $connection = DB::connection();
            $schema = $connection->getSchemaBuilder();
            if ($schema->hasColumn('brands', 'views_count')) {
                $brandData->increment('views_count');
            }
        }

        return view('public.products.index', $viewData);
    }

    public function productShow($slug, FacebookCapiService $fbService)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Eager load relationships
        $product->load(['category', 'brand', 'attributes', 'reviews.user']);

        // Related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        // Group attributes
        $groupedAttributes = $product->attributes
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->unique()->toArray(),
                ];
            })
            ->values();

        // 🔹 Initialize eventId to avoid undefined variable error
        $eventId = null;

        // 🔹 Facebook Pixel + CAPI Event
        if (setting('fb_pixel_id') && setting('facebook_access_token')) {
            $eventId = fb_event_id();

            // Fire Pixel in Blade view (pass eventId to JS)
            // and fire CAPI from backend
            $fbService->sendEvent('ViewContent', $eventId, [
                'em' => [hash('sha256', strtolower(auth()->user()->email ?? ''))],
                'ph' => [hash('sha256', auth()->user()->phone ?? '')],
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ], [
                'currency' => 'USD',
                'value' => $product->price,
                'content_type' => 'product',
                'content_ids' => [$product->sku],
                'contents' => [
                    [
                        'id' => $product->sku,
                        'quantity' => 1,
                    ]
                ],
            ]);
        }

        return view('public.products.show', compact(
            'product',
            'relatedProducts',
            'groupedAttributes',
            'eventId'
        ));
    }


    public function brands()
    {
        $brands = Brand::withCount('products')
            ->active()
            ->orderBy('name')
            ->paginate(24);

        $featuredBrands = Brand::withCount('products')
            ->active()
            ->take(8)
            ->get();
        return view('public.brands.index', compact('brands', 'featuredBrands'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')
            ->active()
            ->orderBy('name')
            ->paginate(12);

        $featuredCategories = Category::withCount('products')
            ->active()
            ->take(6)
            ->get();

        return view('public.categories.index', compact('categories', 'featuredCategories'));
    }

    public function deals()
    {
        // Get active deals
        $activeDeals = Deal::active()
            ->ordered()
            ->get();

        // Get featured products from all active deals
        $featuredProducts = Product::whereHas('deals', function ($query) {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', now());
                })
                ->where('deal_product.is_featured', true);
        })
            ->with([
                'deals' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->active()
            ->inStock()
            ->take(8)
            ->get();

        // Get all products from active deals (paginated)
        $allDealProducts = Product::whereHas('deals', function ($query) {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', now());
                });
        })
            ->with([
                'deals' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->active()
            ->orderBy('name')
            ->paginate(10);

        return view('public.deals.index', compact('activeDeals', 'featuredProducts', 'allDealProducts'));
    }

    public function dealShow(Deal $deal, Request $request)
    {
        // Check if deal is active
        if (!$deal->isCurrentlyActive()) {
            abort(404, 'This deal is no longer available.');
        }

        // Load products with their primary images
        $deal->load([
            'products' => function ($query) {
                $query->with([
                    'images' => function ($q) {
                        $q->where('is_primary', true);
                    }
                ])
                    ->where('is_active', true)
                    ->where('stock_quantity', '>', 0)
                    ->orderBy('deal_product.order');
            },
            'featuredProducts' => function ($query) {
                $query->with([
                    'images' => function ($q) {
                        $q->where('is_primary', true);
                    }
                ])
                    ->where('is_active', true)
                    ->where('stock_quantity', '>', 0);
            }
        ]);

        // Count featured products
        $featuredProductsCount = $deal->featuredProducts->count();

        // Get related deals (excluding current one)
        $relatedDeals = Deal::active()
            ->where('id', '!=', $deal->id)
            ->where('is_featured', true)
            ->orderBy('priority', 'desc')
            ->limit(3)
            ->get();

        return view('public.deals.show', compact(
            'deal',
            'featuredProductsCount',
            'relatedDeals'
        ));
    }

    public function submitReview(Request $request, $productId)
    {
        try {
            $validated = $request->validate([
                'order_number' => 'required|string|exists:orders,order_number',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|min:5|max:1000',
            ]);

            $order = Order::where('order_number', $validated['order_number'])->firstOrFail();
            $product = Product::findOrFail($productId);

            // Check if shipping address exists
            if (!$order->shippingAddress) {
                return redirect()->back()->with('error', 'Shipping address not found for this order.');
            }

            $review = Review::create([
                'product_id' => $product->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'user_id' => $order->shippingAddress->id,
                'is_approved' => false,
            ]);

            return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit review: ' . $e->getMessage());
        }
    }


}
