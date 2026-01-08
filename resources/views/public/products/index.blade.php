<x-app-layout>
    @section('title', 'Products - ' . setting('site_title'))
    <x-slot name="main">
        <!-- Fashion Products Header -->
        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800 py-12 md:py-16">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60"
                    height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none"
                    fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath
                    d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                    /%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
            </div>

            <div class="relative container mx-auto px-4">
                <div class="max-w-3xl">
                    <!-- Breadcrumb -->
                    {{-- <nav class="mb-6" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm">
                            <li>
                                <a href="{{ route('public.welcome') }}"
                                    class="text-white/80 hover:text-white transition-colors">
                                    Home
                                </a>
                            </li>
                            <li><i class="fas fa-chevron-right text-white/60 text-xs"></i></li>
                            <li class="text-white font-medium">Products</li>
                        </ol>
                    </nav> --}}

                    <!-- Page Title -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 elegant-heading">
                        @if (isset($category))
                            {{ $category->name }} Collection
                        @elseif(isset($brand))
                            {{ $brand->name }} Collection
                        @elseif(isset($is_featured) && $is_featured)
                            ✨ Featured Collection
                        @elseif(isset($deal))
                            {{ $deal->title }}
                        @else
                            Shop All Products
                        @endif
                    </h1>

                    <!-- Page Description -->
                    <p class="text-lg text-white/90 mb-6 max-w-2xl">
                        @if (isset($category))
                            {{ $category->description ?? 'Discover our curated collection of ' . $category->name . ' products' }}
                        @elseif(isset($brand))
                            Experience premium quality from {{ $brand->name }}
                        @elseif(isset($is_featured) && $is_featured)
                            Discover our handpicked collection of premium products
                        @elseif(isset($deal))
                            {{ $deal->description ?? 'Exclusive products under this amazing deal' }}
                        @else
                            Discover our complete collection of premium fashion and lifestyle products
                        @endif
                    </p>

                    <!-- Results Count -->
                    <div class="flex items-center gap-4">
                        <span
                            class="bg-white/20 backdrop-blur-sm text-white text-sm font-medium px-3 py-1 rounded-full">
                            {{ $products->total() }} items
                        </span>
                        @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'sort', 'deal']))
                            <a href="{{ route('public.products') }}"
                                class="text-white/80 hover:text-white text-sm font-medium inline-flex items-center gap-1 transition-colors">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Fashion Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-4">
                        <!-- Filter Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900">Filters</h2>
                            @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'sort']))
                                <a href="{{ route('public.products') }}"
                                    class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                                    Clear All
                                </a>
                            @endif
                        </div>

                        <!-- Price Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Price Range
                            </h3>
                            <form method="GET" action="{{ route('public.products') }}" id="priceFilterForm">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif

                                <div class="space-y-3">
                                    <!-- Price Inputs -->
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="min_price" placeholder="Min"
                                            value="{{ request('min_price') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                        <span class="text-gray-500">to</span>
                                        <input type="number" name="max_price" placeholder="Max"
                                            value="{{ request('max_price') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                    </div>

                                    <!-- Apply Button -->
                                    <button type="submit" class="w-full fashion-btn text-sm py-2">
                                        Apply Price Filter
                                    </button>

                                    <!-- Clear Price Filter -->
                                    @if (request('min_price') || request('max_price'))
                                        <a href="{{ route('public.products', array_filter(['category' => request('category'), 'brand' => request('brand'), 'sort' => request('sort')])) }}"
                                            class="block text-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                                            Clear Price Filter
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Sort By</h3>
                            <form method="GET" action="{{ route('public.products') }}" id="sortForm">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif
                                @if (request('min_price'))
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if (request('max_price'))
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif

                                <div class="space-y-2">
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="sort" value="newest"
                                            {{ request('sort') == 'newest' ? 'checked' : '' }}
                                            onchange="document.getElementById('sortForm').submit()"
                                            class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300">
                                        <span class="text-sm font-medium text-gray-900">Newest Arrivals</span>
                                    </label>

                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="sort" value="price_low_high"
                                            {{ request('sort') == 'price_low_high' ? 'checked' : '' }}
                                            onchange="document.getElementById('sortForm').submit()"
                                            class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300">
                                        <span class="text-sm font-medium text-gray-900">Price: Low to High</span>
                                    </label>

                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="sort" value="price_high_low"
                                            {{ request('sort') == 'price_high_low' ? 'checked' : '' }}
                                            onchange="document.getElementById('sortForm').submit()"
                                            class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300">
                                        <span class="text-sm font-medium text-gray-900">Price: High to Low</span>
                                    </label>

                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="sort" value="name_asc"
                                            {{ request('sort') == 'name_asc' ? 'checked' : '' }}
                                            onchange="document.getElementById('sortForm').submit()"
                                            class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300">
                                        <span class="text-sm font-medium text-gray-900">Name: A to Z</span>
                                    </label>

                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="sort" value="name_desc"
                                            {{ request('sort') == 'name_desc' ? 'checked' : '' }}
                                            onchange="document.getElementById('sortForm').submit()"
                                            class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300">
                                        <span class="text-sm font-medium text-gray-900">Name: Z to A</span>
                                    </label>
                                </div>
                            </form>
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Categories
                            </h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="flex items-center justify-between py-2 px-3 rounded-lg text-sm font-medium
                                          {{ !request('category') && !request('brand') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}
                                          transition-colors">
                                    <span>All Categories</span>
                                    <span class="text-xs text-gray-400">{{ $totalProductsCount }}</span>
                                </a>
                                @foreach ($categories as $cat)
                                    <a href="{{ route('public.products', ['category' => $cat->slug]) }}"
                                        class="flex items-center justify-between py-2 px-3 rounded-lg text-sm font-medium
                                              {{ request('category') == $cat->slug ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}
                                              transition-colors">
                                        <span>{{ $cat->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $cat->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Brands</h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="flex items-center justify-between py-2 px-3 rounded-lg text-sm font-medium
                                          {{ !request('brand') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}
                                          transition-colors">
                                    <span>All Brands</span>
                                    <span class="text-xs text-gray-400">{{ $totalProductsCount }}</span>
                                </a>
                                @foreach ($brands as $br)
                                    <a href="{{ route('public.products', ['brand' => $br->slug]) }}"
                                        class="flex items-center justify-between py-2 px-3 rounded-lg text-sm font-medium
                                              {{ request('brand') == $br->slug ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}
                                              transition-colors">
                                        <span>{{ $br->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $br->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price']))
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Active
                                    Filters</h3>
                                <div class="flex flex-wrap gap-2">
                                    @if (request('category'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">
                                            Category:
                                            {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                                            <button onclick="removeFilter('category')"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('brand'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">
                                            Brand:
                                            {{ $brands->firstWhere('slug', request('brand'))->name ?? request('brand') }}
                                            <button onclick="removeFilter('brand')"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('min_price'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">
                                            Min: {{ request('min_price') }} TK
                                            <button onclick="removeFilter('min_price')"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                    @if (request('max_price'))
                                        <span
                                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">
                                            Max: {{ request('max_price') }} TK
                                            <button onclick="removeFilter('max_price')"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Fashion Products Grid -->
                <div class="lg:w-3/4">
                    <!-- Mobile Filter Toggle -->
                    <div class="lg:hidden mb-6">
                        <div class="flex items-center justify-between gap-4">
                            <button onclick="toggleMobileFilters()"
                                class="flex-1 fashion-btn-outline flex items-center justify-center gap-2 py-3">
                                <i class="fas fa-filter"></i>
                                Filters
                            </button>
                            <button onclick="toggleViewMode()"
                                class="flex-1 fashion-btn-outline flex items-center justify-center gap-2 py-3">
                                <i class="fas fa-th-large" id="viewIcon"></i>
                                <span id="viewText">Grid</span>
                            </button>
                        </div>
                    </div>

                    <!-- Products Display -->
                    @if ($products->count() > 0)
                        <!-- Grid View -->
                        <div id="gridView" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                            @foreach ($products as $product)
                                <div class="fashion-product-card">
                                    @include('public.products.partial.product-card', [
                                        'product' => $product,
                                    ])
                                </div>
                            @endforeach
                        </div>

                        <!-- List View -->
                        <div id="listView" class="hidden space-y-4">
                            @foreach ($products as $product)
                                <div
                                    class="fashion-product-card flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 p-4 md:p-6">
                                    <!-- Product Image -->
                                    <div class="md:w-48 md:h-48 w-full aspect-square overflow-hidden rounded-xl">
                                        <img src="{{ $product->images->where('is_primary', true)->first()
                                            ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                                            : 'https://placehold.co/400x400?text=No+Image' }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-grow">
                                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                            <div>
                                                <!-- Category & Brand -->
                                                <div class="flex items-center gap-2 mb-2">
                                                    @if ($product->category)
                                                        <a href="{{ route('public.products', ['category' => $product->category->slug]) }}"
                                                            class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors">
                                                            {{ $product->category->name }}
                                                        </a>
                                                    @endif
                                                    @if ($product->brand)
                                                        <span class="text-gray-400">•</span>
                                                        <a href="{{ route('public.products', ['brand' => $product->brand->slug]) }}"
                                                            class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors">
                                                            {{ $product->brand->name }}
                                                        </a>
                                                    @endif
                                                </div>

                                                <!-- Product Name -->
                                                <h3
                                                    class="text-lg font-medium text-gray-900 mb-2 hover:text-gray-700 transition-colors">
                                                    <a href="{{ route('public.products.show', $product->slug) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h3>

                                                <!-- Short Description -->
                                                @if ($product->short_description)
                                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                        {{ $product->short_description }}
                                                    </p>
                                                @endif

                                                <!-- Price -->
                                                <div class="flex items-baseline gap-2 mb-4">
                                                    <span class="text-xl font-bold text-gray-900">
                                                        {{ number_format($product->final_price) }} TK
                                                    </span>
                                                    @if ($product->discount > 0)
                                                        <span class="text-sm text-gray-500 line-through">
                                                            {{ number_format($product->price) }} TK
                                                        </span>
                                                        <span class="text-sm font-semibold text-red-600">
                                                            Save {{ number_format($product->discount) }} TK
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Stock Status -->
                                                <div class="flex items-center gap-4">
                                                    @if ($product->stock_quantity > 0)
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                            <span class="text-sm text-green-600">In Stock</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                                            <span class="text-sm text-red-600">Out of Stock</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex flex-col gap-3">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('public.products.show', $product->slug) }}"
                                                        class="fashion-btn-outline px-4 py-2 text-sm">
                                                        <i class="fas fa-eye mr-2"></i> View Details
                                                    </a>
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="fashion-btn px-4 py-2 text-sm"
                                                            {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                                            <i class="fas fa-shopping-bag mr-2"></i> Add to Cart
                                                        </button>
                                                    </form>
                                                </div>
                                                @if ($product->discount > 0)
                                                    <div class="text-center">
                                                        <span
                                                            class="inline-block bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full">
                                                            {{ round(($product->discount / $product->price) * 100) }}%
                                                            OFF
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <div
                                class="mx-auto w-24 h-24 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full mb-6">
                                <i class="fas fa-search text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Products Found</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                We couldn't find any products matching your criteria. Try adjusting your filters or
                                browse our featured collections.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('public.products') }}"
                                    class="fashion-btn inline-flex items-center justify-center gap-3 px-6 py-3">
                                    <i class="fas fa-redo"></i>
                                    Clear All Filters
                                </a>
                                <a href="{{ route('public.deals') }}"
                                    class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-6 py-3">
                                    <i class="fas fa-fire"></i>
                                    View Deals
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Filters Modal -->
        <div id="mobileFilters" class="fixed inset-0 bg-black/50 z-50 hidden lg:hidden">
            <div class="absolute right-0 top-0 h-full w-80 bg-white overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Filters</h2>
                        <button onclick="toggleMobileFilters()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Mobile filter content -->
                    <div class="space-y-6">
                        <!-- Categories -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Categories
                            </h3>
                            <div class="space-y-2">
                                <!-- Same as desktop categories -->
                            </div>
                        </div>

                        <!-- Brands -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Brands</h3>
                            <div class="space-y-2">
                                <!-- Same as desktop brands -->
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Price Range
                            </h3>
                            <!-- Same as desktop price filter -->
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Sort By</h3>
                            <!-- Same as desktop sort options -->
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="sticky bottom-0 bg-white pt-4 border-t border-gray-200">
                            <button onclick="applyMobileFilters()" class="w-full fashion-btn py-3">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let isGridView = true;

            function toggleMobileFilters() {
                document.getElementById('mobileFilters').classList.toggle('hidden');
                document.body.style.overflow = document.getElementById('mobileFilters').classList.contains('hidden') ? 'auto' :
                    'hidden';
            }

            function toggleViewMode() {
                const gridView = document.getElementById('gridView');
                const listView = document.getElementById('listView');
                const viewIcon = document.getElementById('viewIcon');
                const viewText = document.getElementById('viewText');

                isGridView = !isGridView;

                if (isGridView) {
                    gridView.classList.remove('hidden');
                    listView.classList.add('hidden');
                    viewIcon.className = 'fas fa-th-large';
                    viewText.textContent = 'Grid';
                } else {
                    gridView.classList.add('hidden');
                    listView.classList.remove('hidden');
                    viewIcon.className = 'fas fa-list';
                    viewText.textContent = 'List';
                }
            }

            function removeFilter(filterName) {
                const url = new URL(window.location.href);
                url.searchParams.delete(filterName);
                window.location.href = url.toString();
            }

            function applyMobileFilters() {
                // Collect filter values from mobile modal
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '{{ route('public.products') }}';

                // Add current URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.forEach((value, key) => {
                    if (!['category', 'brand', 'min_price', 'max_price', 'sort'].includes(key)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }
                });

                // Add mobile filter values (you would need to collect these from the mobile modal)
                // This is a simplified version - you would need to implement based on your mobile modal structure

                document.body.appendChild(form);
                form.submit();
            }

            // Close mobile filters on outside click
            document.getElementById('mobileFilters').addEventListener('click', function(e) {
                if (e.target.id === 'mobileFilters') {
                    toggleMobileFilters();
                }
            });

            // Close mobile filters on escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('mobileFilters').classList.contains('hidden')) {
                    toggleMobileFilters();
                }
            });

            // Add animation to product cards on load
            document.addEventListener('DOMContentLoaded', function() {
                const productCards = document.querySelectorAll('.fashion-product-card');
                productCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.05}s`;
                    card.classList.add('animate-fade-in-up');
                });
            });
        </script>

        <style>
            .animate-fade-in-up {
                animation: fadeInUp 0.5s ease-out forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Custom pagination styling */
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
                margin-top: 3rem;
            }

            .pagination li a,
            .pagination li span {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.2s;
            }

            .pagination li.active a {
                background-color: #111827;
                color: white;
            }

            .pagination li:not(.active) a {
                background-color: #f9fafb;
                color: #6b7280;
                border: 1px solid #e5e7eb;
            }

            .pagination li:not(.active) a:hover {
                background-color: #e5e7eb;
                color: #374151;
            }

            .pagination li.disabled span {
                color: #9ca3af;
                cursor: not-allowed;
            }
        </style>
    </x-slot>
</x-app-layout>
