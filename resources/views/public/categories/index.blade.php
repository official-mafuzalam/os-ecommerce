<x-app-layout>
    @section('title', 'Our Premium Categories')
    <x-slot name="main">
        <!-- Fashion Categories Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <div
                    class="w-24 h-24 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-th-large text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 elegant-heading">Browse Collections</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover our curated collections of premium fashion items, organized by category for your
                    convenience
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse($categories as $category)
                    <div class="fashion-category-card group">
                        <a href="{{ route('public.products', ['category' => $category->slug]) }}" class="block">
                            <!-- Category Image -->
                            <div class="relative overflow-hidden bg-gray-100 rounded-t-xl h-64">
                                @if ($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <i class="fas fa-th-large text-6xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                </div>

                                <!-- Product Count -->
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-semibold px-3 py-1.5 rounded-full">
                                        {{ $category->products_count }} items
                                    </span>
                                </div>

                                <!-- View Button -->
                                <div class="absolute bottom-4 left-4 right-4">
                                    <div
                                        class="bg-white/90 backdrop-blur-sm rounded-lg p-3 transform translate-y-2 opacity-0 
                                                group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                        <span
                                            class="text-sm font-medium text-gray-900 flex items-center justify-center gap-2">
                                            View Collection
                                            <i
                                                class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Info -->
                            <div class="bg-white p-6 rounded-b-xl border border-t-0 border-gray-200">
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                                    {{ $category->name }}
                                </h3>

                                @if ($category->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $category->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                        class="text-gray-700 hover:text-gray-900 text-sm font-medium flex items-center gap-1 transition-colors">
                                        Explore Collection
                                        <i class="fas fa-chevron-right text-xs mt-0.5"></i>
                                    </a>

                                    @if ($category->is_featured)
                                        <span class="text-xs font-medium bg-gray-900 text-white px-2 py-1 rounded">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 md:p-16 text-center max-w-2xl mx-auto">
                            <div
                                class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-8">
                                <i class="fas fa-th-large text-5xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Collections Available</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Our collections are being updated. Please check back soon for our latest fashion
                                categories.
                            </p>
                            <a href="{{ route('public.products') }}"
                                class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-3">
                                <i class="fas fa-store"></i>
                                Browse All Products
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($categories->hasPages())
                <div class="mt-16">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Featured Collections -->
        @if ($featuredCategories->count() > 0)
            <section class="bg-gray-50 py-16 md:py-20">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 elegant-heading">Featured
                            Collections</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Discover our most sought-after fashion collections curated for style and quality
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        @foreach ($featuredCategories as $index => $category)
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-start gap-6">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 rounded-xl bg-gray-900 text-white flex items-center justify-center">
                                            @if ($category->icon)
                                                <i class="{{ $category->icon }} text-2xl"></i>
                                            @else
                                                <i class="fas fa-star text-2xl"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-grow">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                                    class="hover:text-gray-700 transition-colors">
                                                    {{ $category->name }}
                                                </a>
                                            </h3>
                                            <span
                                                class="text-xs font-medium bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                #{{ $index + 1 }}
                                            </span>
                                        </div>

                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ $category->description ?? 'Premium collection of fashion items' }}
                                        </p>

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">
                                                {{ $category->products_count }} premium items
                                            </span>
                                            <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                                class="text-gray-900 hover:text-gray-700 text-sm font-medium flex items-center gap-2 transition-colors">
                                                Explore
                                                <i class="fas fa-arrow-right text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- View All Featured -->
                    <div class="text-center mt-12">
                        <a href="{{ route('public.products') }}"
                            class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-eye"></i>
                            View All Products
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Categories by Type (Optional - Add if you have category types) -->
        @php
            // Example grouping - customize based on your data structure
            $categoryTypes = [
                'Clothing' => $categories->where('type', 'clothing')->take(4),
                'Accessories' => $categories->where('type', 'accessories')->take(4),
                'Footwear' => $categories->where('type', 'footwear')->take(4),
            ];
        @endphp

        @foreach ($categoryTypes as $typeName => $typeCategories)
            @if ($typeCategories->count() > 0)
                <section class="py-16">
                    <div class="container mx-auto px-4">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $typeName }}</h2>
                                <p class="text-gray-600">Explore our curated {{ strtolower($typeName) }} collections
                                </p>
                            </div>
                            <a href="{{ route('public.products') }}?type={{ strtolower($typeName) }}"
                                class="text-gray-900 hover:text-gray-700 font-medium flex items-center gap-2 transition-colors">
                                View All
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($typeCategories as $category)
                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                    class="group">
                                    <div
                                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-4">
                                            @if ($category->image)
                                                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                                    <img src="{{ Storage::url($category->image) }}"
                                                        alt="{{ $category->name }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                </div>
                                            @endif
                                            <div>
                                                <h4
                                                    class="font-semibold text-gray-900 group-hover:text-gray-700 transition-colors">
                                                    {{ $category->name }}
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $category->products_count }} items
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        <!-- How to Shop -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">How to Shop by Category</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Simple steps to find your perfect fashion items</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div
                            class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold">1</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Browse Collections</h3>
                        <p class="text-gray-600">Explore our curated fashion categories to find styles you love</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold">2</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Select Products</h3>
                        <p class="text-gray-600">Choose from premium quality items within each collection</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold">3</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Complete Order</h3>
                        <p class="text-gray-600">Add to cart and checkout for fast, secure delivery</p>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Custom pagination styling */
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
            }

            .pagination li a,
            .pagination li span {
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                border: 1px solid #e5e7eb;
                color: #374151;
                font-weight: 500;
                transition: all 0.2s;
            }

            .pagination li a:hover {
                background-color: #f9fafb;
                border-color: #d1d5db;
            }

            .pagination li.active span {
                background-color: #111827;
                border-color: #111827;
                color: white;
            }

            .pagination li.disabled span {
                color: #9ca3af;
                cursor: not-allowed;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add fade-in animation to category cards
                const categoryCards = document.querySelectorAll('.fashion-category-card');
                categoryCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                    card.classList.add('animate-fade-in-up');
                });

                // Add hover effect to featured category cards
                const featuredCards = document.querySelectorAll('.hover\\:shadow-md');
                featuredCards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.transform = 'translateY(-4px)';
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'translateY(0)';
                    });
                });

                // Smooth scroll for pagination links
                const paginationLinks = document.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (this.getAttribute('href').includes('#')) return;

                        e.preventDefault();
                        const url = this.getAttribute('href');

                        // Show loading state
                        const mainContent = document.querySelector('[x-slot="main"]');
                        if (mainContent) {
                            mainContent.style.opacity = '0.5';
                            mainContent.style.transition = 'opacity 0.3s';
                        }

                        setTimeout(() => {
                            window.location.href = url;
                        }, 300);
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
