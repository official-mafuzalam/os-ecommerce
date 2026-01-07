<x-app-layout>
    @section('title', 'Our Premium Brands')
    <x-slot name="main">
        <!-- Fashion Brands Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <div class="w-24 h-24 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-crown text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 elegant-heading">Premium Brands</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover luxury fashion from world-renowned brands and emerging designers
                </p>
            </div>

            <!-- Alphabetical Filter -->
            @if ($brands->count() > 15)
                <div class="mb-12">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Browse by Letter
                        </h3>
                        <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                            <a href="#all"
                                class="w-10 h-10 flex items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-900 hover:text-white rounded-lg transition-colors border border-gray-200">
                                All
                            </a>
                            @foreach (range('A', 'Z') as $letter)
                                @if ($brands->where('name', 'LIKE', $letter . '%')->count() > 0)
                                    <a href="#{{ $letter }}"
                                        class="w-10 h-10 flex items-center justify-center text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white rounded-lg transition-colors border border-gray-200">
                                        {{ $letter }}
                                    </a>
                                @else
                                    <span
                                        class="w-10 h-10 flex items-center justify-center text-sm font-medium text-gray-400 rounded-lg border border-gray-200">
                                        {{ $letter }}
                                    </span>
                                @endif
                            @endforeach
                            <a href="#0-9"
                                class="w-10 h-10 flex items-center justify-center text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white rounded-lg transition-colors border border-gray-200">
                                0-9
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Brands Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @forelse($brands as $brand)
                    <div class="group">
                        <a href="{{ route('public.products', ['brand' => $brand->slug]) }}" class="block">
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center 
                                        hover:shadow-lg hover:border-gray-300 transition-all duration-300 h-full">
                                <!-- Brand Logo -->
                                <div class="mb-6 h-24 flex items-center justify-center">
                                    @if ($brand->logo)
                                        <div class="relative w-full h-full flex items-center justify-center">
                                            <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                                class="max-h-20 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                            @if ($brand->is_featured)
                                                <span
                                                    class="absolute -top-2 -right-2 bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded-full">
                                                    <i class="fas fa-star text-xs"></i>
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div
                                            class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 
                                                    flex items-center justify-center group-hover:from-gray-300 group-hover:to-gray-400 transition-all">
                                            <span
                                                class="text-2xl font-bold text-gray-700">{{ substr($brand->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Brand Name -->
                                <h3 class="font-bold text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                                    {{ $brand->name }}
                                </h3>

                                <!-- Product Count -->
                                <p class="text-sm text-gray-500 mb-4">
                                    {{ $brand->products_count }} premium items
                                </p>

                                <!-- View Products -->
                                <div
                                    class="flex items-center justify-center gap-2 text-gray-600 group-hover:text-gray-900 transition-colors">
                                    <span class="text-sm font-medium">View Collection</span>
                                    <i
                                        class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
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
                                <i class="fas fa-crown text-5xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Brands Available</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Our brand catalog is being updated. Please check back soon for our latest fashion
                                brands.
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
            @if ($brands->hasPages())
                <div class="mt-16">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        {{ $brands->links() }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Featured Brands -->
        @if ($featuredBrands->count() > 0)
            <section class="bg-gradient-to-b from-white to-gray-50 py-16 md:py-20">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 elegant-heading">Featured Designers
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Discover exclusive collections from our most celebrated fashion designers
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                        @foreach ($featuredBrands as $brand)
                            <div class="group relative">
                                <a href="{{ route('public.products', ['brand' => $brand->slug]) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center 
                                                hover:shadow-lg hover:border-gray-300 transition-all duration-300">
                                        <!-- Brand Logo -->
                                        <div class="mb-6 h-32 flex items-center justify-center">
                                            @if ($brand->logo)
                                                <div class="relative w-full h-full flex items-center justify-center">
                                                    <img src="{{ Storage::url($brand->logo) }}"
                                                        alt="{{ $brand->name }}"
                                                        class="max-h-28 max-w-full object-contain group-hover:scale-110 transition-transform duration-300">
                                                </div>
                                            @else
                                                <div
                                                    class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-900 to-gray-800 
                                                            flex items-center justify-center">
                                                    <span
                                                        class="text-3xl font-bold text-white">{{ substr($brand->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Brand Name -->
                                        <h3
                                            class="text-xl font-bold text-gray-900 mb-3 group-hover:text-gray-700 transition-colors">
                                            {{ $brand->name }}
                                        </h3>

                                        <!-- Description -->
                                        @if ($brand->description)
                                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                                {{ $brand->description }}
                                            </p>
                                        @endif

                                        <!-- View Button -->
                                        <div class="mt-4">
                                            <span
                                                class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 
                                                       group-hover:text-gray-900 transition-colors">
                                                Explore Collection
                                                <i
                                                    class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Brand Stories -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">About Our Brands</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        We collaborate with brands that share our commitment to quality, style, and sustainability
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-gem text-gray-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Premium Quality</h3>
                        <p class="text-gray-600">
                            Each brand undergoes rigorous quality checks to ensure exceptional craftsmanship
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-leaf text-gray-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Sustainable Fashion</h3>
                        <p class="text-gray-600">
                            We partner with brands committed to ethical and sustainable practices
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-award text-gray-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Award-Winning</h3>
                        <p class="text-gray-600">
                            Many of our brands have received industry recognition and awards
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Brand Categories (Optional - if you have brand categories) -->
        @php
            // Example - customize based on your data structure
            $brandCategories = [
                'Luxury Brands' => $brands->where('is_premium', true)->take(6),
                'Designer Brands' => $brands->where('is_designer', true)->take(6),
                'Sustainable Brands' => $brands->where('is_sustainable', true)->take(6),
            ];
        @endphp

        @foreach ($brandCategories as $categoryName => $categoryBrands)
            @if ($categoryBrands->count() > 0)
                <section class="py-12 bg-gray-50">
                    <div class="container mx-auto px-4">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $categoryName }}</h2>
                                <p class="text-gray-600">Explore premium brands in this category</p>
                            </div>
                            <a href="{{ route('public.products') }}"
                                class="text-gray-900 hover:text-gray-700 font-medium flex items-center gap-2 transition-colors">
                                View All
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
                            @foreach ($categoryBrands as $brand)
                                <a href="{{ route('public.products', ['brand' => $brand->slug]) }}" class="group">
                                    <div class="bg-white rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                                        @if ($brand->logo)
                                            <div class="h-16 flex items-center justify-center mb-3">
                                                <img src="{{ Storage::url($brand->logo) }}"
                                                    alt="{{ $brand->name }}"
                                                    class="max-h-12 max-w-full object-contain">
                                            </div>
                                        @else
                                            <div class="h-16 flex items-center justify-center mb-3">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <span
                                                        class="font-bold text-gray-700">{{ substr($brand->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <h4
                                            class="text-sm font-medium text-gray-900 group-hover:text-gray-700 transition-colors">
                                            {{ $brand->name }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        <!-- Newsletter -->
        <section class="py-16 bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-4">Stay Updated on New Brands</h2>
                    <p class="text-gray-300 mb-8">
                        Subscribe to be the first to know about new brand launches and exclusive collections
                    </p>
                    <form class="max-w-md mx-auto" action="{{ route('public.subscribe') }}" method="POST">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="email" placeholder="Your email address" name="email"
                                class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 text-gray-900">
                            <button type="submit"
                                class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                                Subscribe
                            </button>
                        </div>
                        <p class="text-sm text-gray-400 mt-3">
                            By subscribing, you agree to our Privacy Policy
                        </p>
                    </form>
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

            /* Animation for brand cards */
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

            .animate-fade-in-up {
                animation: fadeInUp 0.5s ease-out forwards;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add fade-in animation to brand cards
                const brandCards = document.querySelectorAll('.group');
                brandCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.05}s`;
                    card.classList.add('animate-fade-in-up');
                });

                // Alphabetical filter functionality
                const letterLinks = document.querySelectorAll('a[href^="#"]');
                letterLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetLetter = this.getAttribute('href').substring(1);

                        // Smooth scroll to brands starting with this letter
                        const brandElements = document.querySelectorAll('.group');
                        let foundBrand = null;

                        brandElements.forEach(brand => {
                            const brandName = brand.querySelector('h3')?.textContent.trim() ||
                                '';
                            if (brandName.toLowerCase().startsWith(targetLetter
                                    .toLowerCase()) ||
                                (targetLetter === '0-9' && /^\d/.test(brandName)) ||
                                targetLetter === 'all') {
                                foundBrand = brand;
                                brand.style.display = 'block';
                            } else {
                                brand.style.display = 'none';
                            }
                        });

                        if (foundBrand && targetLetter !== 'all') {
                            foundBrand.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }

                        // Update active letter
                        letterLinks.forEach(l => {
                            l.classList.remove('bg-gray-900', 'text-white');
                            l.classList.add('text-gray-700');
                        });
                        this.classList.add('bg-gray-900', 'text-white');
                        this.classList.remove('text-gray-700');
                    });
                });

                // Reset all filters
                const allLink = document.querySelector('a[href="#all"]');
                if (allLink) {
                    allLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        const brandElements = document.querySelectorAll('.group');
                        brandElements.forEach(brand => {
                            brand.style.display = 'block';
                        });
                    });
                }

                // Add hover effects to brand cards
                brandCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-4px)';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
