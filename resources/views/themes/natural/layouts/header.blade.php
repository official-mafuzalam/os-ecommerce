<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', setting('site_name', 'Prokiti Sudha'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:wght@400;700&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    </script>
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
                Prokiti Sudha
            </a>
            <div class="hidden md:flex items-center space-x-lg">
                <a class="font-label-md text-label-md text-primary border-b-2 border-primary pb-1 transition-colors duration-300"
                    href="{{ route('public.products') }}">Shop</a>
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300"
                    href="{{ route('public.about') }}">Our Story</a>
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-300"
                    href="{{ route('public.contact') }}">Contact</a>
            </div>
            <div class="flex items-center space-x-md">
                <button
                    class="material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">shopping_cart</button>
                <button
                    class="material-symbols-outlined text-primary cursor-pointer active:scale-95 transition-transform">person</button>
                <button class="md:hidden material-symbols-outlined text-primary">menu</button>
            </div>
        </div>
    </nav>
