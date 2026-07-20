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
                <a class="font-label-md text-label-md text-primary border-b-2 border-primary pb-1 transition-colors duration-300"
                    href="{{ route('public.products') }}">Shop</a>

                @php
                    $categories = App\Models\Category::where('is_active', true)->take(8)->get();
                @endphp
                <!-- Fashion Categories Dropdown -->
                @if ($categories->count() > 0)
                    <div x-data="{ open: false }" class="relative">
                        <a href="#"
                            class="nav-link flex items-center font-label-md text-label-md text-primary border-b-2 border-primary pb-1 transition-colors duration-300"
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
                            class="absolute top-full left-0 w-64 mt-2 py-2 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                            @foreach ($categories as $category)
                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <a href="{{ route('public.deals') }}"
                    class="font-label-md text-label-md text-primary border-b-2 border-primary pb-1 transition-colors duration-300">Deals</a>
                <a href="{{ route('public.parcel.tracking') }}"
                    class="font-label-md text-label-md text-primary border-b-2 border-primary pb-1 transition-colors duration-300">Track
                    Order</a>
            </div>
            <div class="flex items-center space-x-md">
                @php
                    $sessionCart = App\Models\ShoppingCart::where('session_id', session()->getId())->first();
                    $cartCount = $sessionCart ? $sessionCart->items()->sum('quantity') : 0;
                @endphp
                <a href="{{ route('public.cart') }}"
                    class="relative material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">
                    shopping_cart
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-tertiary-fixed text-on-tertiary-fixed px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter">{{ $cartCount }}</span>
                    @endif
                </a>
                <button
                    class="material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">person</button>
                <button class="md:hidden material-symbols-outlined text-primary">menu</button>
            </div>
        </div>
    </nav>
