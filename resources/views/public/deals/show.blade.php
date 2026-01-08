<x-app-layout>
    @section('title', $deal->title)
    <x-slot name="main">
        <!-- Fashion Deal Hero -->
        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
            <!-- Pattern Overlay -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60"
                    height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none"
                    fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath
                    d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                    /%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
            </div>

            <!-- Content -->
            <div class="relative container mx-auto px-4 py-12 md:py-16">

                <div class="grid lg:grid-cols-2 gap-8 items-center">
                    <!-- Deal Content -->
                    <div class="text-white">
                        <!-- Deal Badge -->
                        <div
                            class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                            <i class="fas fa-bolt text-yellow-400"></i>
                            <span class="text-sm font-semibold">EXCLUSIVE DEAL</span>
                        </div>

                        <!-- Deal Title -->
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight elegant-heading">
                            {{ $deal->title }}
                        </h1>

                        <!-- Deal Description -->
                        <p class="text-lg text-white/90 mb-8 max-w-2xl leading-relaxed">
                            {{ $deal->description }}
                        </p>

                        <!-- Deal Stats -->
                        <div class="flex flex-wrap gap-6 mb-8">
                            @if ($deal->discount_percentage)
                                <div class="text-center">
                                    <div class="text-4xl md:text-5xl font-bold text-white mb-1">
                                        {{ $deal->discount_percentage }}%
                                    </div>
                                    <div class="text-sm text-white/80 uppercase">OFF</div>
                                </div>
                            @endif

                            <div class="text-center">
                                <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                                    {{ $deal->products->count() }}
                                </div>
                                <div class="text-sm text-white/80">Products</div>
                            </div>

                            @if ($deal->ends_at)
                                <div class="text-center">
                                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                                        {{ $deal->ends_at->diffInDays(now()) }}
                                    </div>
                                    <div class="text-sm text-white/80">Days Left</div>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Button -->
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ $deal->button_link ?? '#' }}"
                                class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-4">
                                {{ $deal->button_text }}
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>

                            <button onclick="shareDeal()"
                                class="fashion-btn-outline text-white border-white hover:bg-white/10 inline-flex items-center justify-center gap-3 px-6 py-4">
                                <i class="fas fa-share-alt"></i>
                                Share Deal
                            </button>
                        </div>
                    </div>

                    <!-- Deal Image -->
                    @if ($deal->image_url)
                        <div class="relative">
                            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                                <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                    class="w-full h-auto object-cover">
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
                            </div>

                            <!-- Countdown Timer -->
                            @if ($deal->ends_at)
                                <div
                                    class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-xl p-4 min-w-[300px]">
                                    <div class="text-center">
                                        <div class="text-sm text-gray-600 mb-2 font-medium">HURRY UP! OFFER ENDS IN
                                        </div>
                                        <div id="deal-countdown" class="flex justify-center gap-3">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 days">00</div>
                                                <div class="text-xs text-gray-600 uppercase">Days</div>
                                            </div>
                                            <div class="text-gray-400">:</div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 hours">00</div>
                                                <div class="text-xs text-gray-600 uppercase">Hours</div>
                                            </div>
                                            <div class="text-gray-400">:</div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 minutes">00</div>
                                                <div class="text-xs text-gray-600 uppercase">Mins</div>
                                            </div>
                                            <div class="text-gray-400">:</div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 seconds">00</div>
                                                <div class="text-xs text-gray-600 uppercase">Secs</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if ($deal->featuredProducts->count() > 0)
            <div class="bg-gray-50 py-12 md:py-16">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">✨ Featured Collection</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Handpicked items from this exclusive deal</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                        @foreach ($deal->featuredProducts as $product)
                            <div class="fashion-product-card">
                                @include('public.products.partial.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- All Products Section -->
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">All Products in This Deal</h2>
                    <p class="text-gray-600">{{ $deal->products->count() }} premium products available</p>
                </div>

                <!-- View Toggle -->
                <div class="mt-4 md:mt-0 flex items-center gap-4">
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <button id="grid-view" class="p-2 bg-gray-900 text-white">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button id="list-view" class="p-2 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <span class="text-sm text-gray-600">{{ $deal->products->count() }} items</span>
                </div>
            </div>

            @if ($deal->products->count() > 0)
                <!-- Grid View -->
                <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                    @foreach ($deal->products as $product)
                        <div class="fashion-product-card">
                            @include('public.products.partial.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <!-- List View (Hidden by default) -->
                <div id="products-list" class="hidden">
                    <div class="space-y-4">
                        @foreach ($deal->products as $product)
                            <div
                                class="fashion-product-card flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 p-4 md:p-6">
                                <!-- Product Image -->
                                <div class="md:w-32 md:h-32 w-full aspect-square overflow-hidden rounded-lg">
                                    <img src="{{ $product->images->where('is_primary', true)->first()
                                        ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                                        : 'https://placehold.co/400x400?text=No+Image' }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>

                                <!-- Product Info -->
                                <div class="flex-grow">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div>
                                            <h3
                                                class="text-lg font-medium text-gray-900 mb-1 hover:text-gray-700 transition-colors">
                                                <a href="{{ route('public.products.show', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center gap-2 mb-2">
                                                @if ($product->brand)
                                                    <span class="text-sm text-gray-600">By
                                                        {{ $product->brand->name }}</span>
                                                @endif
                                                <span class="text-gray-400">•</span>
                                                <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                                            </div>

                                            <!-- Price -->
                                            <div class="flex items-baseline gap-2 mb-3">
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
                                            <div class="flex items-center gap-3">
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
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('public.products.show', $product->slug) }}"
                                                    class="fashion-btn-outline px-4 py-2 text-sm">
                                                    <i class="fas fa-eye mr-2"></i> View
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
                                                        class="inline-block bg-red-100 text-red-600 text-xs font-semibold px-2 py-1 rounded">
                                                        {{ round(($product->discount / $product->price) * 100) }}% OFF
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div
                        class="mx-auto w-24 h-24 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full mb-6">
                        <i class="fas fa-tag text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Products Available</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        This exclusive deal doesn't have any products yet. Check back soon or explore other amazing
                        deals!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.deals') }}"
                            class="fashion-btn inline-flex items-center justify-center gap-3 px-6 py-3">
                            <i class="fas fa-fire"></i>
                            View All Deals
                        </a>
                        <a href="{{ route('public.products') }}"
                            class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-6 py-3">
                            <i class="fas fa-store"></i>
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Related Deals -->
        @if ($relatedDeals->count() > 0)
            <div class="bg-gray-50 py-12 md:py-16">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">🔥 More Exclusive Deals</h2>
                        <p class="text-gray-600">Don't miss out on these amazing offers</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relatedDeals as $relatedDeal)
                            <a href="{{ route('public.deals.show', $relatedDeal->id) }}"
                                class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                                <!-- Deal Image -->
                                <div class="relative aspect-video overflow-hidden">
                                    <img src="{{ $relatedDeal->image_url }}" alt="{{ $relatedDeal->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                                    <!-- Deal Badge -->
                                    @if ($relatedDeal->discount_percentage)
                                        <div class="absolute top-4 left-4">
                                            <span
                                                class="bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg">
                                                {{ $relatedDeal->discount_percentage }}% OFF
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Deal Timer -->
                                    @if ($relatedDeal->ends_at)
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <div class="bg-black/60 backdrop-blur-sm rounded-lg p-2 text-center">
                                                <div class="text-xs text-white mb-1">ENDS IN</div>
                                                <div class="text-sm font-bold text-white">
                                                    {{ $relatedDeal->ends_at->diffInDays(now()) }} days
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Deal Content -->
                                <div class="p-6">
                                    <h3
                                        class="text-lg font-bold text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                                        {{ $relatedDeal->title }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $relatedDeal->description }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500">
                                            {{ $relatedDeal->products->count() }} products
                                        </div>
                                        <span
                                            class="inline-flex items-center text-blue-600 font-medium text-sm group-hover:text-blue-700 transition-colors">
                                            View Deal
                                            <i
                                                class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- View All Button -->
                    <div class="text-center mt-10">
                        <a href="{{ route('public.deals') }}"
                            class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-eye"></i>
                            View All Exclusive Deals
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Share Modal -->
        <div id="shareModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Share This Deal</h3>
                        <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank"
                            class="flex flex-col items-center justify-center p-4 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors">
                            <i class="fab fa-facebook text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($deal->title) }}"
                            target="_blank"
                            class="flex flex-col items-center justify-center p-4 bg-blue-100 text-blue-500 rounded-xl hover:bg-blue-200 transition-colors">
                            <i class="fab fa-twitter text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Twitter</span>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($deal->title . ' ' . url()->current()) }}"
                            target="_blank"
                            class="flex flex-col items-center justify-center p-4 bg-green-50 text-green-600 rounded-xl hover:bg-green-100 transition-colors">
                            <i class="fab fa-whatsapp text-2xl mb-2"></i>
                            <span class="text-sm font-medium">WhatsApp</span>
                        </a>
                        <button onclick="copyShareLink()"
                            class="flex flex-col items-center justify-center p-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                            <i class="fas fa-link text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Copy Link</span>
                        </button>
                    </div>

                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <input type="text" id="share-link" value="{{ url()->current() }}" readonly
                            class="flex-grow px-4 py-2 text-sm bg-gray-50">
                        <button onclick="copyShareLink()"
                            class="px-4 py-2 bg-gray-900 text-white hover:bg-black transition-colors">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Countdown timer
                @if ($deal->ends_at)
                    const endTime = new Date('{{ $deal->ends_at->toIso8601String() }}').getTime();

                    function updateCountdown() {
                        const now = new Date().getTime();
                        const distance = endTime - now;

                        if (distance <= 0) {
                            document.getElementById('deal-countdown').innerHTML = `
                                <div class="text-center">
                                    <div class="text-red-600 font-bold text-xl">DEAL EXPIRED</div>
                                    <div class="text-sm text-gray-600">This offer is no longer available</div>
                                </div>
                            `;
                            clearInterval(countdownInterval);
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.querySelector('.days').textContent = String(days).padStart(2, '0');
                        document.querySelector('.hours').textContent = String(hours).padStart(2, '0');
                        document.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
                        document.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
                    }

                    updateCountdown();
                    const countdownInterval = setInterval(updateCountdown, 1000);
                @endif

                // View toggle functionality
                const gridViewBtn = document.getElementById('grid-view');
                const listViewBtn = document.getElementById('list-view');
                const productsGrid = document.getElementById('products-grid');
                const productsList = document.getElementById('products-list');

                gridViewBtn.addEventListener('click', () => {
                    productsGrid.classList.remove('hidden');
                    productsList.classList.add('hidden');
                    gridViewBtn.classList.add('bg-gray-900', 'text-white');
                    gridViewBtn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    listViewBtn.classList.remove('bg-gray-900', 'text-white');
                    listViewBtn.classList.add('text-gray-600', 'hover:bg-gray-100');
                });

                listViewBtn.addEventListener('click', () => {
                    productsGrid.classList.add('hidden');
                    productsList.classList.remove('hidden');
                    listViewBtn.classList.add('bg-gray-900', 'text-white');
                    listViewBtn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    gridViewBtn.classList.remove('bg-gray-900', 'text-white');
                    gridViewBtn.classList.add('text-gray-600', 'hover:bg-gray-100');
                });

                // Add fade-in animation to product cards
                const productCards = document.querySelectorAll('.fashion-product-card');
                productCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.05}s`;
                    card.classList.add('animate-fade-in-up');
                });
            });

            // Share functionality
            function shareDeal() {
                document.getElementById('shareModal').classList.remove('hidden');
            }

            function closeShareModal() {
                document.getElementById('shareModal').classList.add('hidden');
            }

            function copyShareLink() {
                const shareLink = document.getElementById('share-link');
                shareLink.select();
                shareLink.setSelectionRange(0, 99999);
                document.execCommand('copy');

                // Show feedback
                const copyBtn = document.querySelector('[onclick="copyShareLink()"]');
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
                copyBtn.classList.remove('bg-gray-900');
                copyBtn.classList.add('bg-green-600');

                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                    copyBtn.classList.add('bg-gray-900');
                    copyBtn.classList.remove('bg-green-600');
                }, 2000);
            }

            // Close modal on outside click
            document.getElementById('shareModal').addEventListener('click', function(e) {
                if (e.target.id === 'shareModal') {
                    closeShareModal();
                }
            });

            // Close modal on escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeShareModal();
                }
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

            /* Custom scrollbar for list view */
            #products-list {
                max-height: 800px;
                overflow-y: auto;
            }

            #products-list::-webkit-scrollbar {
                width: 6px;
            }

            #products-list::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            #products-list::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 3px;
            }

            #products-list::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
    </x-slot>
</x-app-layout>
