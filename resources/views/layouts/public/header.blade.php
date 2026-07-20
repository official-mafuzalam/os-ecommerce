<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-meta />

    <title>@yield('title', setting('site_name', 'Octosync Software Ltd'))</title>

    <!-- Favicon -->
    @if (setting('site_favicon'))
        <link rel="icon" href="{{ Storage::url(setting('site_favicon')) }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ Storage::url(setting('site_favicon')) }}">
    @else
        <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/x-icon">
    @endif

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fashion E-commerce Critical CSS -->
    <style>
        :root {
            --font-elegant: 'Playfair Display', serif;
            --font-heading: 'Montserrat', sans-serif;
            --font-body: 'Inter', sans-serif;
            --color-primary: #111827;
            --color-secondary: #7C3AED;
            --color-accent: #F59E0B;
            --color-light: #F9FAFB;
            --color-dark: #1F2937;
            --nav-bg: rgba(255, 255, 255, 0.95);
            --nav-border: rgba(0, 0, 0, 0.05);
            --btn-bg: var(--color-primary);
            --btn-outline-text: var(--color-primary);
            --card-border: rgba(0, 0, 0, 0.05);
            --hero-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --hero-text: white;
            --newsletter-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --footer-bg: var(--color-primary);
            --footer-text: white;
            --overlay-bg: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        }

        body.theme-natural {
            --font-elegant: 'Libre Caslon Text', serif;
            --font-heading: 'Libre Caslon Text', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --color-primary: #1f4c2f;
            --color-secondary: #6b8e23;
            --color-accent: #a7c957;
            --color-light: #f5faf0;
            --color-dark: #11331e;
            --nav-bg: rgba(245, 248, 238, 0.95);
            --nav-border: rgba(30, 70, 32, 0.08);
            --btn-bg: #1f4c2f;
            --btn-outline-text: #1f4c2f;
            --card-border: rgba(30, 70, 32, 0.08);
            --hero-bg: linear-gradient(135deg, #e4f4e1 0%, #b0d2a4 100%);
            --hero-text: #0f2a15;
            --newsletter-bg: linear-gradient(135deg, #eff7ec 0%, #d4e8c9 100%);
            --footer-bg: #16391f;
            --footer-text: #f7faf7;
            --overlay-bg: linear-gradient(to top, rgba(20, 50, 20, 0.85), transparent);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #ffffff;
            color: var(--color-primary);
            overflow-x: hidden;
        }

        /* Elegant Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-elegant);
            font-weight: 600;
            letter-spacing: -0.025em;
        }

        .elegant-heading {
            font-family: var(--font-elegant);
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        .brand-logo {
            font-family: var(--font-elegant);
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        /* Fashion Navigation */
        .fashion-nav {
            background: var(--nav-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--nav-border);
            transition: all 0.3s ease;
        }

        .fashion-nav.scrolled {
            background: var(--nav-bg);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            font-family: var(--font-elegant);
            position: relative;
            padding: 0.5rem 0;
            margin: 0 1rem;
            font-weight: 500;
            color: var(--color-primary);
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--color-primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Fashion Button */
        .fashion-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            background: var(--btn-bg);
            color: white;
            font-weight: 500;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .fashion-btn-outline {
            background: transparent;
            border: 1.5px solid var(--btn-outline-text);
            color: var(--btn-outline-text);
        }

        .fashion-btn-outline:hover {
            background: var(--btn-bg);
            color: white;
        }

        .fashion-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .fashion-btn-outline {
            background: transparent;
            border: 1.5px solid var(--color-primary);
            color: var(--color-primary);
        }

        .fashion-btn-outline:hover {
            background: var(--color-primary);
            color: white;
        }

        /* Fashion Product Card */
        .fashion-product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--card-border);
            position: relative;
        }

        .fashion-product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border-color: transparent;
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background: #f8fafc;
        }

        .product-image-wrapper img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fashion-product-card:hover .product-image-wrapper img {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .fashion-product-card:hover .product-actions {
            opacity: 1;
        }

        .quick-view-btn,
        .wishlist-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: white;
            border: none;
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .quick-view-btn:hover,
        .wishlist-btn:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Fashion Category Card */
        .fashion-category-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fashion-category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--overlay-bg);
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .fashion-category-card:hover .category-overlay {
            transform: translateY(0);
        }

        /* Fashion Price */
        .fashion-price {
            font-family: var(--font-heading);
            font-weight: 600;
            color: var(--color-primary);
        }

        .original-price {
            text-decoration: line-through;
            color: #9CA3AF;
            font-weight: 400;
        }

        .discount-price {
            color: #EF4444;
            font-weight: 600;
        }

        /* Elegant Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Loading Animation */
        .fashion-loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--color-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Fashion Hero Section */
        .fashion-hero {
            background: var(--hero-bg);
            color: var(--hero-text);
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-family: var(--font-elegant);
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        /* Fashion Newsletter */
        .fashion-newsletter {
            background: var(--newsletter-bg);
            padding: 4rem 0;
        }

        .newsletter-input {
            padding: 1rem 1.5rem;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: white;
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .nav-link {
                margin: 0 0.5rem;
            }
        }

        /* Natural theme utility overrides */
        body.theme-natural .text-indigo-600 {
            color: #2f5f2a !important;
        }

        body.theme-natural .hover\:text-indigo-800:hover {
            color: #254f26 !important;
        }

        body.theme-natural .bg-indigo-600 {
            background-color: #1f4c2f !important;
        }

        body.theme-natural .hover\:bg-indigo-700:hover {
            background-color: #1b4127 !important;
        }

        body.theme-natural .from-indigo-50 {
            --tw-gradient-from: #eff7ec !important;
        }

        body.theme-natural .to-purple-50 {
            --tw-gradient-to: #e2f1db !important;
        }

        body.theme-natural .bg-gray-50 {
            background-color: #f5faf0 !important;
        }

        body.theme-natural .bg-gray-100 {
            background-color: #eef4e8 !important;
        }

        body.theme-natural .border-gray-100 {
            border-color: rgba(30, 70, 32, 0.15) !important;
        }

        body.theme-natural .text-gray-900 {
            color: #11331e !important;
        }

        body.theme-natural .text-gray-600 {
            color: #4a5d43 !important;
        }

        body.theme-natural .text-gray-700 {
            color: #2a4230 !important;
        }

        body.theme-natural .bg-white {
            background-color: #f7faf4 !important;
        }

        body.theme-natural .bg-white\/20 {
            background-color: rgba(247, 250, 244, 0.8) !important;
        }

        body.theme-natural .bg-white\/90 {
            background-color: rgba(247, 250, 244, 0.9) !important;
        }

        body.theme-natural .bg-white\/20:hover {
            background-color: rgba(247, 250, 244, 1) !important;
        }

        /* Fashion Animations */
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
            animation: fadeInUp 0.6s ease-out;
        }

        /* Fashion Footer */
        .fashion-footer {
            background: var(--footer-bg);
            color: var(--footer-text);
            padding: 4rem 0 2rem;
        }

        .footer-heading {
            font-family: var(--font-elegant);
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: white;
            color: var(--color-primary);
            transform: translateY(-3px);
        }
    </style>

    @stack('styles')

    @include('layouts.public.head-scripts')

    <!-- Performance Optimizations -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">

    <!-- Theme Color -->
    <meta name="theme-color" content="{{ setting('site_theme', 'fashion') === 'natural' ? '#16391f' : '#111827' }}">
    <meta name="msapplication-navbutton-color" content="{{ setting('site_theme', 'fashion') === 'natural' ? '#16391f' : '#111827' }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{ setting('site_theme', 'fashion') === 'natural' ? '#16391f' : '#111827' }}">
</head>

<body class="bg-white theme-{{ setting('site_theme', 'fashion') }}">
    <!-- Loading Screen -->
    <div id="fashionLoader" class="fashion-loader">
        <div class="loader-spinner"></div>
    </div>

    @if (setting('google_tag_manager_id'))
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ setting('google_tag_manager_id') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif

    <!-- Fashion Navigation -->
    <nav class="fashion-nav fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('public.welcome') }}"
                    class="brand-logo text-2xl font-bold text-gray-900 hover:text-gray-700 transition-colors">
                        {{ setting('site_name', 'OS Ecommerce') }}
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('public.products') }}" class="nav-link">Shop</a>

                    <!-- Fashion Categories Dropdown -->
                    <div class="relative group">
                        <button class="nav-link flex items-center gap-1">
                            Categories <i
                                class="fas fa-chevron-down text-xs transition-transform group-hover:rotate-180"></i>
                        </button>
                        <div
                            class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            @php
                                $categories = App\Models\Category::where('is_active', true)->take(8)->get();
                            @endphp
                            @foreach ($categories as $category)
                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                    class="nav-link flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b last:border-b-0">
                                    @if ($category->image)
                                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                            class="w-6 h-6 rounded">
                                    @else
                                        <div class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-folder text-gray-400 text-sm"></i>
                                        </div>
                                    @endif
                                    <span class="text-sm font-medium">{{ $category->name }}</span>
                                </a>
                            @endforeach
                            <div class="p-4 border-t">
                                <a href="{{ route('public.categories') }}"
                                    class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900 flex items-center gap-2">
                                    View All Categories <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('public.brands') }}" class="nav-link">Brands</a>
                    <a href="{{ route('public.deals') }}" class="nav-link">Deals</a>
                    <a href="{{ route('public.parcel.tracking') }}" class="nav-link text-red-500 font-semibold">Track
                        Order</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center gap-6">
                    <!-- Search -->
                    <button onclick="toggleFashionSearch()" class="text-gray-700 hover:text-gray-900 transition-colors">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- User Account -->
                    {{-- <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 transition-colors">
                        <i class="far fa-user text-lg"></i>
                    </a> --}}

                    <!-- Cart -->
                    @php
                        $sessionCart = App\Models\ShoppingCart::where('session_id', session()->getId())->first();
                        $cartCount = $sessionCart ? $sessionCart->items()->sum('quantity') : 0;
                    @endphp
                    <a href="{{ route('public.cart') }}"
                        class="text-gray-700 hover:text-gray-900 transition-colors relative">
                        <i class="fas fa-shopping-bag text-lg"></i>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-gray-900 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden text-gray-700 hover:text-gray-900" onclick="toggleFashionMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Fashion Search Modal -->
        <div id="fashionSearch" class="absolute top-full left-0 right-0 bg-white shadow-xl hidden">
            <div class="container mx-auto px-4 py-6">
                <div class="relative">
                    <input type="text" placeholder="Search for products, brands, and many more..."
                        class="w-full px-6 py-4 text-lg border-0 focus:ring-0 focus:outline-none"
                        onkeyup="performFashionSearch(event)">
                    <button onclick="closeFashionSearch()"
                        class="absolute right-0 top-0 h-full px-6 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <div id="fashionSearchResults"
                        class="absolute top-full left-0 right-0 bg-white mt-2 rounded-lg shadow-xl hidden max-h-96 overflow-y-auto">
                    </div>
                </div>
            </div>
        </div>

        <!-- Fashion Mobile Menu -->
        <div id="fashionMobileMenu" class="lg:hidden absolute top-full left-0 right-0 bg-white shadow-xl hidden">
            <div class="py-4">
                <a href="{{ route('public.welcome') }}" class="block px-6 py-3 hover:bg-gray-50">Home</a>
                <a href="{{ route('public.products') }}" class="block px-6 py-3 hover:bg-gray-50">Shop All</a>
                <div class="border-t border-gray-100">
                    <button class="w-full flex items-center justify-between px-6 py-3 hover:bg-gray-50"
                        onclick="toggleMobileFashionCategories()">
                        <span>Categories</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div id="mobileFashionCategories" class="hidden">
                        @foreach ($categories as $category)
                            <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                class="block px-10 py-2 hover:bg-gray-50 text-sm">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('public.brands') }}" class="block px-6 py-3 hover:bg-gray-50">Brands</a>
                <a href="{{ route('public.deals') }}" class="block px-6 py-3 hover:bg-gray-50">Deals</a>
                <a href="{{ route('public.parcel.tracking') }}"
                    class="block px-6 py-3 hover:bg-gray-50 text-red-500 font-semibold">Track Order</a>
            </div>
        </div>
    </nav>


    <!-- Fashion Scripts -->
    @push('scripts')
        <script>
            // Hide loader when page loads
            window.addEventListener('load', function() {
                const loader = document.getElementById('fashionLoader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.style.display = 'none', 300);
                }

                // Add scroll effect to navigation
                window.addEventListener('scroll', function() {
                    const nav = document.querySelector('.fashion-nav');
                    if (window.scrollY > 50) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                });
            });

            // Search functionality
            function toggleFashionSearch() {
                const search = document.getElementById('fashionSearch');
                search.classList.toggle('hidden');
                if (!search.classList.contains('hidden')) {
                    search.querySelector('input').focus();
                }
            }

            function closeFashionSearch() {
                document.getElementById('fashionSearch').classList.add('hidden');
            }

            // Mobile menu functionality
            function toggleFashionMobileMenu() {
                const menu = document.getElementById('fashionMobileMenu');
                menu.classList.toggle('hidden');
            }

            function toggleMobileFashionCategories() {
                const categories = document.getElementById('mobileFashionCategories');
                categories.classList.toggle('hidden');
            }

            // Fashion search with debounce
            let searchTimeout;

            function performFashionSearch(event) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const query = event.target.value.trim();
                    const resultsContainer = document.getElementById('fashionSearchResults');

                    if (query.length < 2) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    // Simulate search results (replace with actual API call)
                    fetch(`{{ route('public.search.live') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data || data.length === 0) {
                                resultsContainer.innerHTML = `
                                <div class="p-8 text-center text-gray-500">
                                    <i class="fas fa-search text-3xl mb-4"></i>
                                    <p>No products found</p>
                                </div>
                            `;
                            } else {
                                let html = '<div class="divide-y">';
                                data.forEach(product => {
                                    html += `
                                    <a href="{{ route('public.products.show', '') }}/${product.slug}" 
                                       class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors">
                                        <img src="${product.image_url || 'https://placehold.co/80x80?text=Product'}" 
                                             alt="${product.name}" 
                                             class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <div class="font-medium text-gray-900">${product.name}</div>
                                            <div class="text-sm text-gray-600">${product.category || 'Fashion'}</div>
                                            <div class="text-sm font-semibold text-gray-900 mt-1">৳${product.price || '0'}</div>
                                        </div>
                                    </a>
                                `;
                                });
                                html += '</div>';
                                resultsContainer.innerHTML = html;
                            }
                            resultsContainer.classList.remove('hidden');
                        })
                        .catch(err => {
                            console.error('Search error:', err);
                            resultsContainer.innerHTML =
                                '<div class="p-4 text-center text-gray-500">Search failed</div>';
                            resultsContainer.classList.remove('hidden');
                        });
                }, 300);
            }

            // Close search on escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeFashionSearch();
                }
            });

            // Close search when clicking outside
            document.addEventListener('click', function(e) {
                const search = document.getElementById('fashionSearch');
                const searchInput = search.querySelector('input');
                if (!search.contains(e.target) && !e.target.closest('button[onclick*="toggleFashionSearch"]')) {
                    closeFashionSearch();
                }
            });
        </script>
    @endpush
