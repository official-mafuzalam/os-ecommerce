<x-app-layout>
    <x-slot name="main">
        @php
            $layoutSetting = setting('default_layout_type');

            // Split deals dynamically
            $leftDeals = $allDeals->slice(0, 2);
            $rightDeals = $allDeals->slice(2, 2);
            $bottomDeals = $allDeals->slice(4);
        @endphp

        <!-- Hero Section -->
        <section class="relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div
                    class="{{ $layoutSetting === 'layout2' ? 'grid grid-cols-1 lg:grid-cols-4 gap-6' : 'grid grid-cols-1 gap-6' }}">

                    {{-- Left Deals (Layout2 only) --}}
                    @if ($layoutSetting === 'layout2' && $leftDeals->count())
                        <div class="hidden lg:block space-y-4">
                            @foreach ($leftDeals as $deal)
                                @include('public.partials.deal-card', ['deal' => $deal, 'compact' => true])
                            @endforeach
                        </div>
                    @endif

                    {{-- Main Carousel --}}
                    <div class="{{ $layoutSetting === 'layout2' ? 'lg:col-span-2' : '' }}">
                        @include('public.partials.carousel', ['carousels' => $carousels])
                    </div>

                    {{-- Right Deals (Layout2 only) --}}
                    @if ($layoutSetting === 'layout2' && $rightDeals->count())
                        <div class="hidden lg:block space-y-4">
                            @foreach ($rightDeals as $deal)
                                @include('public.partials.deal-card', ['deal' => $deal, 'compact' => true])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Flash Deals Banner --}}
        @if ($bottomDeals->count())
            <section class="py-8 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">🔥 Flash Deals</h2>
                        <p class="text-gray-600 mt-2">Limited time offers ending soon</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($bottomDeals as $deal)
                            @include('public.partials.flash-deal-banner', ['deal' => $deal])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Categories Section -->
        @if ($categories->isNotEmpty())
            <section class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Shop by Category</h2>
                        <p class="text-gray-600 text-lg">Discover products curated for you</p>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4 md:gap-6">
                        @foreach ($categories as $category)
                            <a href="{{ route('public.categories.show', $category->slug) }}"
                                class="group relative bg-white rounded-2xl p-4 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100">
                                <div class="relative w-16 h-16 mx-auto mb-3">
                                    @if ($category->image)
                                        <div
                                            class="w-full h-full rounded-xl overflow-hidden bg-gradient-to-br from-indigo-50 to-purple-50 p-2">
                                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                                class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div
                                            class="w-full h-full rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                            <i class="fas fa-th-large text-indigo-500 text-xl"></i>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ $category->products_count }}
                                    </div>
                                </div>
                                <h3
                                    class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">
                                    {{ $category->name }}
                                </h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Featured Products -->
        @if ($featuredProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">✨ Featured Products</h2>
                            <p class="text-gray-600 mt-2">Handpicked items just for you</p>
                        </div>
                        <a href="{{ route('public.featured.products') }}"
                            class="mt-4 sm:mt-0 inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold group">
                            View All Products
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <div class="relative">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                            @foreach ($featuredProducts as $product)
                                @include('public.products.partial.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Promotional Banner -->
        @if ($deal)
            <section class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @include('public.partials.promotional-banner', ['deal' => $deal])
                </div>
            </section>
        @endif

        <!-- New Arrivals -->
        @if ($allProducts->isNotEmpty())
            <section class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">🆕 New Arrivals</h2>
                            <p class="text-gray-600 mt-2">Fresh products just landed</p>
                        </div>
                        <a href="{{ route('public.products') }}"
                            class="mt-4 sm:mt-0 inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold group">
                            Browse All New
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                        @foreach ($allProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Value Proposition -->
        <section class="py-16 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Shop With Us</h2>
                    <p class="text-lg text-gray-600">Experience premium shopping with unbeatable benefits</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-shipping-fast text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Free Shipping</h3>
                        <p class="text-gray-600 text-center">On orders over $50</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Secure Payment</h3>
                        <p class="text-gray-600 text-center">100% secure transactions</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-headset text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">24/7 Support</h3>
                        <p class="text-gray-600 text-center">Dedicated customer service</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 rounded-full bg-gradient-to-r from-orange-500 to-red-600 flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-undo-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Easy Returns</h3>
                        <p class="text-gray-600 text-center">30-day return policy</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="py-12 bg-gradient-to-r from-indigo-600 to-purple-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 md:p-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Stay Updated</h2>
                    <p class="text-indigo-100 mb-6">Subscribe to our newsletter for exclusive deals and updates</p>
                    <form class="max-w-md mx-auto">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="email" placeholder="Enter your email"
                                class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                            <button type="submit"
                                class="bg-white text-indigo-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                Subscribe
                            </button>
                        </div>
                        <p class="text-sm text-indigo-200 mt-3">By subscribing, you agree to our Privacy Policy</p>
                    </form>
                </div>
            </div>
        </section>
    </x-slot>
</x-app-layout>
