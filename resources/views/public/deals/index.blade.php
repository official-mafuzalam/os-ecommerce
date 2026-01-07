<x-app-layout>
    @section('title', 'Deals & Offers')
    <x-slot name="main">
        <!-- Fashion Deals Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <!-- Breadcrumb -->
            {{-- <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('public.welcome') }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Home</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                    <li class="text-gray-900 font-medium">Deals & Offers</li>
                </ol>
            </nav> --}}

            <!-- Page Header -->
            <div class="text-center mb-12">
                <div
                    class="w-24 h-24 rounded-full bg-gradient-to-br from-red-500 to-orange-500 text-white flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tag text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 elegant-heading">Exclusive Deals</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover limited-time offers and special discounts on premium fashion items
                </p>
            </div>

            <!-- Active Deals -->
            @if ($activeDeals->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">🔥 Flash Sales</h2>
                            <p class="text-gray-600">Limited-time offers ending soon</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-red-500"></i>
                            <span class="text-sm font-medium text-gray-700">Ends Soon</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        @foreach ($activeDeals as $deal)
                            <div class="fashion-deal-card">
                                <!-- Deal Header -->
                                <div class="relative">
                                    <!-- Deal Image -->
                                    <div class="h-64 overflow-hidden rounded-t-2xl">
                                        <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                        <!-- Gradient Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
                                        </div>

                                        <!-- Badge -->
                                        <div class="absolute top-4 left-4">
                                            <span
                                                class="bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                                FLASH DEAL
                                            </span>
                                        </div>

                                        <!-- Countdown -->
                                        @if ($deal->ends_at)
                                            <div class="absolute bottom-4 left-4 right-4">
                                                <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3">
                                                    <div class="text-center">
                                                        <p class="text-xs text-gray-600 mb-1">Ends in</p>
                                                        <div id="countdown-{{ $deal->id }}"
                                                            class="flex justify-center gap-1 text-sm font-bold text-gray-900">
                                                            <span class="days px-1">00</span>d
                                                            <span class="hours px-1">00</span>h
                                                            <span class="minutes px-1">00</span>m
                                                            <span class="seconds px-1">00</span>s
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Deal Content -->
                                <div class="bg-white p-6 rounded-b-2xl border border-t-0 border-gray-200">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $deal->title }}</h3>

                                    <p class="text-gray-600 text-sm mb-4">{{ $deal->description }}</p>

                                    @if ($deal->discount_percentage)
                                        <div class="flex items-center gap-4 mb-4">
                                            <div
                                                class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-4 py-2 rounded-lg">
                                                <span
                                                    class="block text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
                                                <span class="text-xs font-medium">OFF</span>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">{{ $deal->discount_details }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <a href="{{ $deal->button_link }}"
                                        class="w-full fashion-btn flex items-center justify-center gap-2 py-3">
                                        {{ $deal->button_text }}
                                        <i
                                            class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Featured Products on Sale -->
            @if ($featuredProducts->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">⭐ Featured Deals</h2>
                            <p class="text-gray-600">Premium products with special discounts</p>
                        </div>
                        <a href="{{ route('public.products') }}?sort=discount"
                            class="text-gray-900 hover:text-gray-700 font-medium flex items-center gap-2 transition-colors">
                            View All
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                        @foreach ($featuredProducts as $product)
                            <div class="fashion-product-card">
                                @include('public.products.partial.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- All Products on Sale -->
            @if ($allDealProducts->count() > 0)
                <section class="mb-16">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Section Header -->
                        <div class="border-b border-gray-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900 mb-1">🛍️ All Sale Items</h2>
                                    <p class="text-gray-600">Browse all discounted fashion products</p>
                                </div>
                                <span class="bg-red-50 text-red-600 text-sm font-medium px-3 py-1 rounded-full">
                                    {{ $allDealProducts->total() }} items on sale
                                </span>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Discount
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Stock
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($allDealProducts as $product)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <!-- Product Info -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <!-- Product Image -->
                                                    <div
                                                        class="w-16 h-16 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                                                        <img src="{{ $product->images->where('is_primary', true)->first()
                                                            ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                                                            : 'https://placehold.co/400x400?text=No+Image' }}"
                                                            alt="{{ $product->name }}"
                                                            class="w-full h-full object-cover">
                                                    </div>

                                                    <!-- Product Details -->
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="font-medium text-gray-900 truncate">
                                                            {{ $product->name }}
                                                        </h4>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <span class="text-xs text-gray-500">
                                                                SKU: {{ $product->sku ?? 'N/A' }}
                                                            </span>
                                                            @if ($product->discount > 0)
                                                                <span
                                                                    class="text-xs font-medium bg-red-100 text-red-600 px-2 py-0.5 rounded">
                                                                    -{{ number_format(($product->discount / $product->price) * 100) }}%
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Price -->
                                            <td class="px-6 py-4">
                                                @if ($product->discount > 0)
                                                    <div class="space-y-1">
                                                        <div class="text-lg font-bold text-gray-900">
                                                            {{ number_format($product->price - $product->discount) }}
                                                            TK
                                                        </div>
                                                        <div class="text-sm text-gray-500 line-through">
                                                            {{ number_format($product->price) }} TK
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-lg font-bold text-gray-900">
                                                        {{ number_format($product->price) }} TK
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Discount -->
                                            <td class="px-6 py-4">
                                                @if ($product->discount > 0)
                                                    <div class="inline-flex flex-col items-center">
                                                        <span class="text-sm font-semibold text-green-600">
                                                            Save {{ number_format($product->discount) }} TK
                                                        </span>
                                                        @php
                                                            $discountPercent = round(
                                                                ($product->discount / $product->price) * 100,
                                                            );
                                                        @endphp
                                                        <span class="text-xs text-gray-500">
                                                            {{ $discountPercent }}% discount
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500">Regular price</span>
                                                @endif
                                            </td>

                                            <!-- Stock -->
                                            <td class="px-6 py-4">
                                                @if ($product->stock_quantity > 0)
                                                    <div class="inline-flex items-center gap-2">
                                                        @if ($product->stock_quantity <= 10)
                                                            <div
                                                                class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse">
                                                            </div>
                                                            <span class="text-sm font-medium text-yellow-600">
                                                                {{ $product->stock_quantity }} left
                                                            </span>
                                                        @else
                                                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                            <span class="text-sm font-medium text-green-600">
                                                                In stock
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center gap-2">
                                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                                        <span class="text-sm font-medium text-red-600">
                                                            Out of stock
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('public.products.show', $product->slug) }}"
                                                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                                                        title="Quick View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit"
                                                            class="p-2 bg-gray-900 text-white hover:bg-black rounded-lg transition-colors"
                                                            title="Add to Cart"
                                                            {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                                            <i class="fas fa-shopping-bag"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($allDealProducts->hasPages())
                            <div class="border-t border-gray-100 px-6 py-4">
                                {{ $allDealProducts->links() }}
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- No Deals Message -->
            @if ($activeDeals->count() == 0 && $featuredProducts->count() == 0 && $allDealProducts->count() == 0)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 md:p-16 text-center max-w-2xl mx-auto">
                    <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-tag text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Active Deals</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        There are currently no active deals. Check back soon for exclusive fashion discounts and offers!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.products') }}"
                            class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-store"></i>
                            Browse All Products
                        </a>
                        <a href="{{ route('public.categories') }}"
                            class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-th-large"></i>
                            View Categories
                        </a>
                    </div>
                </div>
            @endif

            <!-- Newsletter for Deals -->
            <div class="mt-16">
                <div class="bg-gradient-to-r from-gray-900 to-black rounded-2xl p-8 md:p-12 text-white">
                    <div class="max-w-3xl mx-auto text-center">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">Never Miss a Deal</h3>
                        <p class="text-gray-300 mb-6">
                            Subscribe to our newsletter and be the first to know about exclusive fashion deals and new
                            arrivals
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
            </div>
        </div>

        <style>
            /* Deal Card Animation */
            .fashion-deal-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .fashion-deal-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            }

            /* Table row hover effect */
            tr:hover {
                background-color: rgba(249, 250, 251, 0.5);
            }

            /* Product card in deals */
            .fashion-product-card {
                position: relative;
            }

            /* Countdown styling */
            .countdown-digit {
                min-width: 1.5rem;
                text-align: center;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Countdown timers for deals
                @foreach ($activeDeals as $deal)
                    @if ($deal->ends_at)
                        (function() {
                            const countdownId = 'countdown-{{ $deal->id }}';
                            const endTime = new Date('{{ $deal->ends_at }}').getTime();

                            function updateCountdown(id, endTime) {
                                const countdownEl = document.getElementById(id);
                                if (!countdownEl) return;

                                const now = new Date().getTime();
                                const distance = endTime - now;

                                if (distance <= 0) {
                                    countdownEl.innerHTML = '<span class="text-red-600">Expired</span>';
                                    clearInterval(window[`interval_${id}`]);
                                    return;
                                }

                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                const daysEl = countdownEl.querySelector('.days');
                                const hoursEl = countdownEl.querySelector('.hours');
                                const minutesEl = countdownEl.querySelector('.minutes');
                                const secondsEl = countdownEl.querySelector('.seconds');

                                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                            }

                            // Initial update
                            updateCountdown(countdownId, endTime);

                            // Set interval for updates
                            window[`interval_${countdownId}`] = setInterval(() => {
                                updateCountdown(countdownId, endTime);
                            }, 1000);
                        })();
                    @endif
                @endforeach

                // Add hover effects to deal cards
                const dealCards = document.querySelectorAll('.fashion-deal-card');
                dealCards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    });
                });

                // Animate table rows on load
                const tableRows = document.querySelectorAll('tbody tr');
                tableRows.forEach((row, index) => {
                    row.style.animationDelay = `${index * 0.05}s`;
                    row.classList.add('animate-fade-in-up');
                });

                // Quick view functionality
                const quickViewButtons = document.querySelectorAll('[title="Quick View"]');
                quickViewButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');

                        // Implement quick view modal here
                        console.log('Quick view for:', url);
                    });
                });

                // Sort by discount percentage
                const sortByDiscountBtn = document.querySelector('a[href*="sort=discount"]');
                if (sortByDiscountBtn) {
                    sortByDiscountBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(window.location.href);
                        url.searchParams.set('sort', 'discount');
                        window.location.href = url.toString();
                    });
                }
            });

            // Animation for fade-in-up
            if (!document.querySelector('style#fade-in-animation')) {
                const style = document.createElement('style');
                style.id = 'fade-in-animation';
                style.textContent = `
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
                        opacity: 0;
                    }
                `;
                document.head.appendChild(style);
            }
        </script>
    </x-slot>
</x-app-layout>
