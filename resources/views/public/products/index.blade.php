<x-app-layout>
    @section('title', 'Products')
    <x-slot name="main">
        <!-- Page Header -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                            @if (isset($category))
                                {{ $category->name }} Products
                            @elseif(isset($brand))
                                {{ $brand->name }} Products
                            @elseif(isset($is_featured) && $is_featured)
                                Featured Products
                            @elseif(isset($deal))
                                {{ $deal->title }} Products
                            @else
                                All Products
                            @endif
                        </h1>
                        <p class="text-gray-600">
                            @if (isset($category))
                                {{ $category->description ?? 'Browse our collection of ' . $category->name . ' products' }}
                            @elseif(isset($brand))
                                Discover premium products from {{ $brand->name }}
                            @elseif(isset($is_featured) && $is_featured)
                                Discover our handpicked collection of featured products
                            @elseif(isset($deal))
                                {{ $deal->description ?? 'Explore products under the ' . $deal->title . ' deal' }}
                            @else
                                Discover our complete collection of premium products
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 md:mt-0">
                        <p class="text-sm text-gray-600">
                            Showing {{ $products->total() }} results
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="block py-2 px-3 rounded-lg text-sm font-medium {{ !request('category') && !request('brand') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    All Categories
                                </a>
                                @foreach ($categories as $cat)
                                    <a href="{{ route('public.products', ['category' => $cat->slug]) }}"
                                        class="block py-2 px-3 rounded-lg text-sm font-medium {{ request('category') == $cat->slug ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                        {{ $cat->name }}
                                        <span class="text-gray-400 float-right">({{ $cat->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Brands</h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="block py-2 px-3 rounded-lg text-sm font-medium {{ !request('brand') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    All Brands
                                </a>
                                @foreach ($brands as $br)
                                    <a href="{{ route('public.products', ['brand' => $br->slug]) }}"
                                        class="block py-2 px-3 rounded-lg text-sm font-medium {{ request('brand') == $br->slug ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                        {{ $br->name }}
                                        <span class="text-gray-400 float-right">({{ $br->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Range</h3>
                            <form method="GET" action="{{ route('public.products') }}">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif
                                <div class="space-y-3">
                                    <div class="flex space-x-2">
                                        <input type="number" name="min_price" placeholder="Min"
                                            value="{{ request('min_price') }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="number" name="max_price" placeholder="Max"
                                            value="{{ request('max_price') }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700">
                                        Apply Filter
                                    </button>
                                    @if (request('min_price') || request('max_price'))
                                        <a href="{{ route('public.products', array_filter(['category' => request('category'), 'brand' => request('brand')])) }}"
                                            class="block text-center text-sm text-indigo-600 hover:text-indigo-700">
                                            Clear Filter
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Sort -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sort By</h3>
                            <form method="GET" action="{{ route('public.products') }}">
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
                                <select name="sort" onchange="this.form.submit()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                        First</option>
                                    <option value="price_low_high"
                                        {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High
                                    </option>
                                    <option value="price_high_low"
                                        {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low
                                    </option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                        Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                        Name: Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:w-3/4">
                    <!-- Mobile Filter Toggle -->
                    <div class="lg:hidden mb-4">
                        <button onclick="toggleMobileFilters()"
                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center justify-between">
                            <span>Filters</span>
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>

                    <!-- Products Grid -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                            @foreach ($products as $product)
                                @include('public.products.partial.product-card', ['product' => $product])
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-md p-8 text-center">
                            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria</p>
                            <a href="{{ route('public.products') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Filters Modal -->
        <div id="mobileFilters" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
            <div class="absolute right-0 top-0 h-full w-80 bg-white overflow-y-auto">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Filters</h2>
                        <button onclick="toggleMobileFilters()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Mobile filter content (same as sidebar filters) -->
                    <div class="space-y-6">
                        <!-- Categories -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                            <div class="space-y-2">
                                <!-- Same category links as sidebar -->
                            </div>
                        </div>

                        <!-- Brands -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Brands</h3>
                            <div class="space-y-2">
                                <!-- Same brand links as sidebar -->
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Range</h3>
                            <!-- Same price filter as sidebar -->
                        </div>

                        <!-- Sort -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sort By</h3>
                            <!-- Same sort options as sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>

        <script>
            function toggleMobileFilters() {
                document.getElementById('mobileFilters').classList.toggle('hidden');
            }

            // Close mobile filters when clicking outside
            document.getElementById('mobileFilters').addEventListener('click', function(e) {
                if (e.target.id === 'mobileFilters') {
                    toggleMobileFilters();
                }
            });
        </script>
    </x-slot>
</x-app-layout>
