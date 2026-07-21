<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-meta />
    <title>@yield('title', setting('site_name', 'OS Ecommerce'))</title>
    <!-- Favicon -->
    @if (setting('site_favicon'))
        <link rel="icon" href="{{ Storage::url(setting('site_favicon')) }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ Storage::url(setting('site_favicon')) }}">
    @else
        <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/x-icon">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.public.head-scripts')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-header {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .organic-shape {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -12px rgba(0, 69, 37, 0.08);
        }

        /* Mobile Drawer */
        #mobile-drawer {
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #drawer-overlay {
            transition: opacity 0.3s ease;
        }
    </style>
    @stack('head')
</head>

<body class="bg-background text-on-background font-body-md selection:bg-primary/10 selection:text-primary">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-surface/70 backdrop-blur-xl shadow-sm h-20 transition-all duration-300">
        <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-full">
            <a href="{{ route('public.welcome') }}"
                class="font-headline-md text-headline-md text-primary tracking-tight cursor-pointer active:scale-95 transition-transform">
                {{ setting('site_name', 'OS Ecommerce') }}
            </a>
            <div class="hidden md:flex items-center space-x-lg">
                <a class="font-label-md text-label-md text-primary border-b-2 {{ request()->routeIs('public.products') && !request()->filled('category') ? 'border-primary' : 'border-transparent hover:border-primary' }} pb-1 transition-colors duration-300"
                    href="{{ route('public.products') }}">Shop</a>

                @php
                    $categories = App\Models\Category::where('is_active', true)->take(8)->get();
                @endphp
                <!-- Fashion Categories Dropdown -->
                @if ($categories->count() > 0)
                    <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false"
                        class="relative z-50">
                        <a href="#"
                            class="nav-link flex items-center font-label-md text-label-md text-primary border-b-2 {{ request()->filled('category') ? 'border-primary' : 'border-transparent hover:border-primary' }} pb-1 transition-colors duration-300"
                            @click.prevent="open = !open">
                            Categories
                            <i class="fas fa-chevron-down ml-1 text-xs transition-transform"
                                :class="open ? 'rotate-180' : ''"></i>
                        </a>

                        <div x-show="open" x-cloak @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="absolute top-full left-0 w-64 mt-2 py-2 bg-white rounded-lg shadow-xl border border-gray-100 z-[100]">
                            @foreach ($categories as $category)
                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            <a href="{{ route('public.categories') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                See All Categories
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @endif
                <a href="{{ route('public.brands') }}"
                    class="font-label-md text-label-md text-primary border-b-2 {{ request()->routeIs('public.brands') ? 'border-primary' : 'border-transparent hover:border-primary' }} pb-1 transition-colors duration-300">
                    Brands
                </a>
                <a href="{{ route('public.deals') }}"
                    class="font-label-md text-label-md text-primary border-b-2 {{ request()->routeIs('public.deals') || request()->routeIs('public.deals.show') ? 'border-primary' : 'border-transparent hover:border-primary' }} pb-1 transition-colors duration-300">Deals</a>
                <a href="{{ route('public.parcel.tracking') }}"
                    class="font-label-md text-label-md text-primary border-b-2 {{ request()->routeIs('public.parcel.tracking') ? 'border-primary' : 'border-transparent hover:border-primary' }} pb-1 transition-colors duration-300">Track
                    Order</a>
            </div>
            <div class="flex items-center space-x-md">
                @php
                    $sessionCart = App\Models\ShoppingCart::where('session_id', session()->getId())->first();
                    $cartCount = $sessionCart ? $sessionCart->items()->sum('quantity') : 0;
                @endphp
                <a href="{{ route('public.cart') }}"
                    class="hidden md:inline relative material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">
                    shopping_cart
                    <span
                        class="cart-count data-cart-count absolute -top-2 -right-2 bg-tertiary-fixed text-on-tertiary-fixed px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter {{ $cartCount > 0 ? '' : 'hidden' }}"
                        data-cart-count>{{ $cartCount }}</span>
                </a>
                <button id="mobile-menu-btn"
                    class="md:hidden material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">menu</button>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay -->
    <div id="drawer-overlay" class="fixed inset-0 bg-black/40 z-[90] opacity-0 pointer-events-none"></div>

    <!-- Mobile Drawer Panel -->
    <div id="mobile-drawer"
        class="fixed top-0 right-0 h-full w-72 bg-surface z-[95] shadow-2xl translate-x-full flex flex-col">

        <!-- Drawer Header -->
        <div class="flex items-center justify-between px-6 h-20 border-b border-surface-variant">
            <span class="font-headline-md text-primary">{{ setting('site_name', 'OS Ecommerce') }}</span>
            <button id="mobile-menu-close"
                class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors cursor-pointer">close</button>
        </div>

        <!-- Drawer Nav Links -->
        <nav class="flex-1 overflow-y-auto py-6 px-6 space-y-1">
            <a href="{{ route('public.products') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-label-md transition-all {{ request()->routeIs('public.products') && !request()->filled('category') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <span class="material-symbols-outlined text-[20px]">store</span>
                Shop
            </a>

            <!-- Mobile Categories Accordion -->
            @if (isset($categories) && $categories->count() > 0)
                <div>
                    <button id="mobile-cat-toggle"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl font-label-md text-label-md transition-all {{ request()->filled('category') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                        <span class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">category</span>
                            Categories
                        </span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-300"
                            id="mobile-cat-chevron">expand_more</span>
                    </button>
                    <div id="mobile-cat-panel" class="hidden mt-1 ml-4 pl-4 border-l border-surface-variant space-y-1">
                        @foreach ($categories as $category)
                            <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                class="block px-3 py-2 rounded-lg text-sm text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all">
                                {{ $category->name }}
                            </a>
                        @endforeach
                        <a href="{{ route('public.categories') }}"
                            class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm text-tertiary hover:bg-surface-container transition-all font-bold">
                            All Categories <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endif

            <a href="{{ route('public.brands') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-label-md transition-all {{ request()->routeIs('public.brands') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <span class="material-symbols-outlined text-[20px]">verified</span>
                Brands
            </a>

            <a href="{{ route('public.deals') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-label-md transition-all {{ request()->routeIs('public.deals') || request()->routeIs('public.deals.show') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <span class="material-symbols-outlined text-[20px]">local_offer</span>
                Deals
            </a>

            <a href="{{ route('public.parcel.tracking') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-label-md transition-all {{ request()->routeIs('public.parcel.tracking') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                Track Order
            </a>
        </nav>

        <!-- Drawer Footer -->
        <div class="border-t border-surface-variant px-6 py-4">
            <a href="{{ route('public.cart') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all">
                <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                Cart
                @if ($cartCount > 0)
                    <span
                        class="ml-auto bg-tertiary-fixed text-on-tertiary-fixed px-2 py-0.5 rounded-full text-[10px] font-bold">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('mobile-menu-close');
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('drawer-overlay');
        const catToggle = document.getElementById('mobile-cat-toggle');
        const catPanel = document.getElementById('mobile-cat-panel');
        const catChevron = document.getElementById('mobile-cat-chevron');

        function openDrawer() {
            drawer.classList.remove('translate-x-full');
            drawer.classList.add('translate-x-0');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            drawer.classList.add('translate-x-full');
            drawer.classList.remove('translate-x-0');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            document.body.style.overflow = '';
        }

        if (menuBtn) menuBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);

        if (catToggle && catPanel) {
            catToggle.addEventListener('click', () => {
                catPanel.classList.toggle('hidden');
                catChevron.classList.toggle('rotate-180');
            });
        }
    </script>
</body>

</html>
