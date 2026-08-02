<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce'))
    <x-slot name="main">
        <!-- Hero Section -->
        <style>
            /* Attractive blob frame for hero image */
            .hero-blob-frame {
                border-radius: 60% 40% 55% 45% / 45% 55% 40% 60%;
                transition: border-radius 0.8s ease-in-out;
            }
            .hero-blob-frame:hover {
                border-radius: 45% 55% 40% 60% / 60% 40% 55% 45%;
            }

            /* Slowly rotating conic-gradient ring */
            .hero-spin-ring {
                background: conic-gradient(
                    from 0deg,
                    var(--color-primary, #4a7c59) 0%,
                    var(--color-secondary, #8fbc8f) 25%,
                    var(--color-tertiary, #c8a96e) 50%,
                    var(--color-primary, #4a7c59) 75%,
                    var(--color-secondary, #8fbc8f) 100%
                );
                animation: hero-ring-spin 8s linear infinite;
            }
            @keyframes hero-ring-spin {
                from { transform: rotate(0deg); }
                to   { transform: rotate(360deg); }
            }

            /* Slow ping for the live indicator dot */
            @keyframes ping-slow {
                0%, 100% { transform: scale(1); opacity: 1; }
                60%       { transform: scale(1.8); opacity: 0; }
            }
            .animate-ping-slow {
                animation: ping-slow 2s ease-in-out infinite;
            }

            /* Slow pulse for background aura */
            @keyframes pulse-slow {
                0%, 100% { opacity: 0.6; transform: scale(1.08); }
                50%       { opacity: 1;   transform: scale(1.14); }
            }
            .animate-pulse-slow {
                animation: pulse-slow 4s ease-in-out infinite;
            }
        </style>

        <!-- Hero Carousel Section -->
        <section class="relative overflow-hidden" id="hero-carousel">

            @if ($carousels && $carousels->count() > 0)

                {{-- Slides --}}
                <div id="carousel-track" class="relative">
                    @foreach ($carousels as $index => $carousel)
                        <div class="carousel-slide {{ $index === 0 ? 'opacity-100 translate-x-0 z-10' : 'opacity-0 translate-x-full z-0' }} absolute inset-0 transition-all duration-700 ease-in-out"
                            style="position: {{ $index === 0 ? 'relative' : 'absolute' }}; top:0; left:0; width:100%;"
                            data-index="{{ $index }}">

                            <div
                                class="min-h-[921px] flex items-center px-margin-desktop max-w-container-max mx-auto overflow-visible">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center w-full py-xl">

                                    {{-- Text Content --}}
                                    <div class="lg:col-span-6 z-10">
                                        <!-- <span
                                                    class="inline-block font-label-md text-label-md text-secondary uppercase tracking-widest mb-md">
                                                    প্রকৃতির বিশুদ্ধ পুষ্টি
                                                </span> -->

                                        <h1
                                            class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary leading-tight mb-lg">
                                            {{ $carousel->title }}
                                        </h1>

                                        @if ($carousel->description)
                                            <p class="text-body-lg text-on-surface-variant max-w-2xl mb-xl leading-relaxed">
                                                {{ $carousel->description }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap gap-4">
                                            @if ($carousel->button_text && $carousel->button_url)
                                                <a href="{{ $carousel->button_url }}"
                                                    class="inline-flex items-center justify-center bg-primary text-white px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary-container transition-all duration-300 active:scale-95 shadow-lg shadow-primary/10">
                                                    {{ $carousel->button_text }}
                                                </a>
                                            @else
                                                <a href="{{ route('public.products') }}"
                                                    class="inline-flex items-center justify-center bg-primary text-white px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary-container transition-all duration-300 active:scale-95 shadow-lg shadow-primary/10">
                                                    পণ্যসমূহ দেখুন
                                                </a>
                                            @endif

                                            @if ($carousel->secondary_button_text && $carousel->secondary_button_url)
                                                <a href="{{ $carousel->secondary_button_url }}"
                                                    class="inline-flex items-center justify-center border border-primary text-primary px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary/5 transition-all duration-300">
                                                    {{ $carousel->secondary_button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Image --}}
                                    <div class="lg:col-span-6 relative mt-xl lg:mt-0">
                                        <div class="relative w-full aspect-square max-w-[560px] mx-auto">

                                            <!-- Glowing background aura -->
                                            <div class="absolute inset-0 bg-gradient-to-br from-secondary-container/40 via-tertiary-container/20 to-primary-container/30 rounded-full blur-3xl scale-110 -z-10 animate-pulse-slow"></div>

                                            <!-- Outer rotating gradient ring -->
                                            <div class="absolute inset-0 rounded-full p-[3px] hero-spin-ring">
                                                <div class="w-full h-full rounded-full bg-surface"></div>
                                            </div>

                                            <!-- Decorative dashed ring -->
                                            <div class="absolute -inset-3 rounded-full border-2 border-dashed border-primary/20"></div>

                                            <!-- Decorative solid ring -->
                                            <div class="absolute -inset-6 rounded-full border border-secondary/10"></div>

                                            <!-- Main blob image frame -->
                                            <div class="absolute inset-[3px] overflow-hidden hero-blob-frame shadow-2xl">
                                                <img class="w-full h-full object-cover transform hover:scale-108 transition-transform duration-700 ease-out"
                                                    alt="{{ $carousel->title }}" src="{{ Storage::url($carousel->image) }}" />
                                                <!-- Subtle inner gradient overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-primary/10 via-transparent to-transparent"></div>
                                            </div>

                                            <!-- Floating badge — bottom left -->
                                            <div class="absolute -bottom-4 -left-4 z-10 hidden md:flex items-center gap-2 bg-white/90 backdrop-blur-md pl-2 pr-4 py-2 rounded-2xl shadow-xl border border-surface-container-high">
                                                <div class="relative w-8 h-8 bg-tertiary-container rounded-xl flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-white animate-ping-slow"></span>
                                                </div>
                                                <div>
                                                    <p class="font-label-md text-label-md text-primary leading-none">Lab-Tested</p>
                                                    <p class="text-[10px] text-on-surface-variant leading-none mt-0.5">100% Pure Quality</p>
                                                </div>
                                            </div>

                                            <!-- Floating badge — top right -->
                                            <div class="absolute -top-4 -right-4 z-10 hidden md:flex items-center gap-1 bg-primary text-white pl-2 pr-3 py-1.5 rounded-full shadow-lg">
                                                <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                                                <span class="text-[11px] font-semibold tracking-wide">100% Natural</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($carousels->count() > 1)
                    {{-- Prev / Next Arrows --}}
                    <button id="carousel-prev"
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white/80 backdrop-blur-md hover:bg-white text-primary rounded-full w-12 h-12 flex items-center justify-center shadow-lg border border-surface-container-high transition-all duration-200 hover:scale-110"
                        aria-label="Previous slide">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button id="carousel-next"
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-white/80 backdrop-blur-md hover:bg-white text-primary rounded-full w-12 h-12 flex items-center justify-center shadow-lg border border-surface-container-high transition-all duration-200 hover:scale-110"
                        aria-label="Next slide">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>

                    {{-- Dot Indicators --}}
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                        @foreach ($carousels as $index => $carousel)
                            <button
                                class="carousel-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-primary w-6' : 'bg-primary/30 hover:bg-primary/60' }}"
                                data-index="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif

            @else
                {{-- Fallback static hero --}}
                <div class="min-h-[921px] flex items-center px-margin-desktop max-w-container-max mx-auto overflow-visible">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center w-full py-xl">
                        <div class="lg:col-span-6 z-10">
                            <span
                                class="inline-block font-label-md text-label-md text-secondary uppercase tracking-widest mb-md">
                                প্রকৃতির বিশুদ্ধ পুষ্টি
                            </span>
                            <h1
                                class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary leading-tight mb-lg">
                                সুস্থ জীবনের জন্য <span class="italic text-tertiary">প্রকৃতির সেরা উপহার</span>
                            </h1>
                            <p class="text-body-lg text-on-surface-variant max-w-2xl mb-xl leading-relaxed">
                                বিশুদ্ধ উপাদান, যত্নশীল প্রস্তুতি এবং প্রিমিয়াম মানের সুপার ফুড—
                                আপনার প্রতিদিনের স্বাস্থ্যকর জীবনযাত্রার বিশ্বস্ত সঙ্গী।
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('public.products') }}"
                                    class="inline-flex items-center justify-center bg-primary text-white px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary-container transition-all duration-300 active:scale-95 shadow-lg shadow-primary/10">
                                    পণ্যসমূহ দেখুন
                                </a>
                            </div>
                        </div>
                        <div class="lg:col-span-6 relative mt-xl lg:mt-0">
                            <div class="relative w-full aspect-square max-w-[560px] mx-auto">
                                <!-- Glowing background aura -->
                                <div class="absolute inset-0 bg-gradient-to-br from-secondary-container/40 via-tertiary-container/20 to-primary-container/30 rounded-full blur-3xl scale-110 -z-10 animate-pulse-slow"></div>
                                <!-- Outer rotating gradient ring -->
                                <div class="absolute inset-0 rounded-full p-[3px] hero-spin-ring">
                                    <div class="w-full h-full rounded-full bg-surface"></div>
                                </div>
                                <!-- Decorative dashed ring -->
                                <div class="absolute -inset-3 rounded-full border-2 border-dashed border-primary/20"></div>
                                <!-- Decorative solid ring -->
                                <div class="absolute -inset-6 rounded-full border border-secondary/10"></div>
                                <!-- Main blob image frame -->
                                <div class="absolute inset-[3px] overflow-hidden hero-blob-frame shadow-2xl">
                                    <img class="w-full h-full object-cover transform hover:scale-108 transition-transform duration-700 ease-out"
                                        alt="Hero Image"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbWrds_KT3YCmlhSGLOzs3P5DEqXoY3DXYYjCwVc7KXFIVSSa91lOgJmaWb-io8ZR3F6fxvGq9iS6URaCLHyzKRA-4-XJA4RYn4JqVp5ireOIdv3FnbwKAGJ4Y-kGPb_byr6IXNOwJbcfrCdPPzKW-43y1c2nEajwwTZM_2bN3e992xgrzGGYFMqADfBKkYO-OpQ6Zno9ndkvUUL1kmBOUIpzFN9StLFsUahOgs5_UAu3ulPNVWoMpWb3sDdEYPYm9gRjK5eWYNx8b" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 via-transparent to-transparent"></div>
                                </div>
                                <!-- Floating badge — bottom left -->
                                <div class="absolute -bottom-4 -left-4 z-10 hidden md:flex items-center gap-2 bg-white/90 backdrop-blur-md pl-2 pr-4 py-2 rounded-2xl shadow-xl border border-surface-container-high">
                                    <div class="relative w-8 h-8 bg-tertiary-container rounded-xl flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-white animate-ping-slow"></span>
                                    </div>
                                    <div>
                                        <p class="font-label-md text-label-md text-primary leading-none">Lab-Tested</p>
                                        <p class="text-[10px] text-on-surface-variant leading-none mt-0.5">100% Pure Quality</p>
                                    </div>
                                </div>
                                <!-- Floating badge — top right -->
                                <div class="absolute -top-4 -right-4 z-10 hidden md:flex items-center gap-1 bg-primary text-white pl-2 pr-3 py-1.5 rounded-full shadow-lg">
                                    <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                                    <span class="text-[11px] font-semibold tracking-wide">100% Natural</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </section>

        {{-- Carousel JS --}}
        @if ($carousels && $carousels->count() > 1)
            <script>
                (function () {
                    const slides = document.querySelectorAll('.carousel-slide');
                    const dots = document.querySelectorAll('.carousel-dot');
                    const total = slides.length;
                    let current = 0;
                    let timer = null;

                    function goTo(next) {
                        const prev = current;
                        if (next === prev) return;

                        // Outgoing slide
                        slides[prev].style.position = 'absolute';
                        slides[prev].classList.remove('opacity-100', 'translate-x-0', 'z-10');
                        slides[prev].classList.add('opacity-0', next > prev ? '-translate-x-full' : 'translate-x-full', 'z-0');

                        // Incoming slide
                        slides[next].style.position = 'relative';
                        slides[next].classList.remove('opacity-0', '-translate-x-full', 'translate-x-full', 'z-0');
                        slides[next].classList.add('opacity-100', 'translate-x-0', 'z-10');

                        // Dots
                        dots[prev].classList.remove('bg-primary', 'w-6');
                        dots[prev].classList.add('bg-primary/30', 'w-2.5');
                        dots[next].classList.remove('bg-primary/30', 'w-2.5');
                        dots[next].classList.add('bg-primary', 'w-6');

                        current = next;
                    }

                    function next() { goTo((current + 1) % total); }
                    function prev() { goTo((current - 1 + total) % total); }

                    function startTimer() {
                        stopTimer();
                        timer = setInterval(next, 5000);
                    }
                    function stopTimer() {
                        if (timer) { clearInterval(timer); timer = null; }
                    }

                    document.getElementById('carousel-next')?.addEventListener('click', function () { next(); startTimer(); });
                    document.getElementById('carousel-prev')?.addEventListener('click', function () { prev(); startTimer(); });

                    dots.forEach(function (dot) {
                        dot.addEventListener('click', function () {
                            goTo(parseInt(this.dataset.index));
                            startTimer();
                        });
                    });

                    // Pause on hover
                    const section = document.getElementById('hero-carousel');
                    section?.addEventListener('mouseenter', stopTimer);
                    section?.addEventListener('mouseleave', startTimer);

                    // Touch / swipe support
                    let touchStartX = 0;
                    section?.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
                    section?.addEventListener('touchend', function (e) {
                        const diff = touchStartX - e.changedTouches[0].clientX;
                        if (Math.abs(diff) > 50) { diff > 0 ? next() : prev(); startTimer(); }
                    });

                    startTimer();
                })();
            </script>
        @endif

        <!-- Featured Products Bento Grid -->
        @if (isset($featuredProducts) && $featuredProducts->count() > 0)
            <section class="py-xl px-margin-desktop max-w-container-max mx-auto">
                <div class="flex justify-between items-end mb-xl">
                    <div class="max-w-[480px]">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-md">
                            আমাদের প্রিমিয়াম সংগ্রহ
                        </h2>

                        <p class="font-body-md text-body-md text-on-surface-variant">
                            প্রকৃতির সেরা উপাদান থেকে তৈরি বিশুদ্ধ ও মানসম্মত পণ্য—
                            স্বাস্থ্যকর ও সচেতন জীবনযাপনের জন্য যত্নের সঙ্গে নির্বাচিত।
                        </p>
                    </div>
                    <a class="hidden md:flex items-center gap-xs font-label-md text-primary hover:gap-base transition-all"
                        href="{{ route('public.products') }}">
                        View All <span class="material-symbols-outlined">arrow_right_alt</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @foreach ($featuredProducts->take(3) as $product)
                        @include('themes.natural.public.products.partial.product-card', [
                            'product' => $product,
                        ])
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Our Botanical Philosophy -->
        <section class="bg-surface-container-low py-xl overflow-hidden mt-xl">
            <div class="px-margin-desktop max-w-container-max mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
                    <div class="order-2 lg:order-1">
                        <div class="relative inline-block">
                            <img class="w-full max-w-[500px] h-auto drop-shadow-sm" alt="Philosophy Illustration"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCI73VNGVDzBp1j0DnvmJJur5kmAyjT8RuM6xI5fVmve9VQIN9i8GDUOo6lJCsUSchq_jMQGzHnmWjlP0fUoLJJsFlaXNKYGRcbE6Vk2vKkJdW2jLpZ9IDK6UPVD_hpPRjaqgCgflKmXY9FHm3TrFARBr-fwQqqU5yruyR8glfISdsRrpfl_Amk9HVM6Yx2Imxvcm9mZl8ECDCffBJfcU1cRMUNk-9UpZQ-4UzdHt_UsvdyCnt33x8DxO7bsv4eN53JIeR53haX6Jzx" />
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <span
                            class="font-label-md text-label-md text-tertiary-fixed-variant uppercase tracking-widest mb-md block">
                            আমাদের অঙ্গীকার
                        </span>

                        <h2 class="font-headline-lg text-headline-lg text-primary mb-lg leading-tight">
                            প্রকৃতির বিশুদ্ধতা, আপনার সুস্থতার জন্য।
                        </h2>

                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg leading-relaxed">
                            Prokiti Sudha-তে আমরা বিশ্বাস করি, সুস্থ জীবনের ভিত্তি হলো বিশুদ্ধ ও মানসম্মত প্রাকৃতিক
                            পুষ্টি।
                            তাই প্রতিটি পণ্য যত্নের সঙ্গে নির্বাচিত উপাদান, নিরাপদ প্রক্রিয়াকরণ এবং মান নিয়ন্ত্রণের
                            মাধ্যমে
                            প্রস্তুত করা হয়, যাতে আপনি প্রতিদিন আত্মবিশ্বাসের সঙ্গে ব্যবহার করতে পারেন।
                        </p>

                        <ul class="space-y-md mb-xl">
                            <li class="flex items-start gap-md">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim mt-1"
                                    style="font-variation-settings: 'FILL' 1;">eco</span>

                                <div>
                                    <h4 class="font-label-md text-primary">
                                        যত্নে নির্বাচিত প্রাকৃতিক উপাদান
                                    </h4>

                                    <p class="text-on-surface-variant text-sm">
                                        বিশ্বস্ত উৎস থেকে সংগ্রহ করা মানসম্মত উপাদান দিয়ে তৈরি প্রতিটি পণ্য।
                                    </p>
                                </div>
                            </li>

                            <li class="flex items-start gap-md">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim mt-1"
                                    style="font-variation-settings: 'FILL' 1;">verified</span>

                                <div>
                                    <h4 class="font-label-md text-primary">
                                        বিশুদ্ধতা ও মানের প্রতি অঙ্গীকার
                                    </h4>

                                    <p class="text-on-surface-variant text-sm">
                                        পরিচ্ছন্ন প্রক্রিয়াকরণ, নিরাপদ প্যাকেজিং এবং প্রতিটি ধাপে গুণগত মান বজায় রাখার
                                        চেষ্টা।
                                    </p>
                                </div>
                            </li>

                            <li class="flex items-start gap-md">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim mt-1"
                                    style="font-variation-settings: 'FILL' 1;">favorite</span>

                                <div>
                                    <h4 class="font-label-md text-primary">
                                        স্বাস্থ্যকর জীবনযাপনের সঙ্গী
                                    </h4>

                                    <p class="text-on-surface-variant text-sm">
                                        প্রতিদিনের খাদ্যাভ্যাসকে আরও পুষ্টিকর ও স্বাস্থ্যসচেতন করতে প্রাকৃতিক ওয়েলনেস
                                        পণ্য।
                                    </p>
                                </div>
                            </li>
                        </ul>

                        <a href="{{ route('public.about') }}"
                            class="inline-flex items-center justify-center border-2 border-primary text-primary px-lg py-base rounded-full font-label-md text-label-md hover:bg-primary hover:text-white transition-all duration-300">
                            আমাদের সম্পর্কে জানুন
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter / CTA -->
        <section class="py-xl px-margin-desktop mt-xl">
            <div class="max-w-container-max mx-auto bg-primary rounded-[40px] p-xl relative overflow-hidden">
                <!-- Background Decorative Pattern -->
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <div class="absolute top-0 right-0 w-64 h-64 border-4 border-white rounded-full -mr-32 -mt-32">
                    </div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 border-2 border-white rounded-full -ml-48 -mb-48">
                    </div>
                </div>
                <div class="relative z-10 text-center max-w-[600px] mx-auto">
                    <h2 class="font-headline-lg text-headline-lg text-white mb-md">Join the Vitality Circle</h2>
                    <p class="font-body-md text-primary-fixed-dim mb-lg">Receive curated wellness tips and early access
                        to our rarest seasonal harvests.</p>

                    @if (session('success'))
                        <div class="bg-primary-fixed text-on-primary-fixed px-md py-sm rounded-xl mb-md font-label-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-error text-on-error px-md py-sm rounded-xl mb-md font-label-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('public.subscribe') }}" method="POST"
                        class="flex flex-col md:flex-row gap-base max-w-md mx-auto">
                        @csrf
                        <input name="email" required
                            class="flex-grow bg-white/10 border-white/20 text-white placeholder:text-white/50 rounded-full px-md py-base focus:ring-2 focus:ring-tertiary-fixed-dim focus:border-transparent transition-all outline-none"
                            placeholder="Your email address" type="email" />
                        <button type="submit"
                            class="bg-tertiary-fixed-dim text-primary font-label-md px-lg py-base rounded-full hover:bg-white transition-colors duration-300 active:scale-95">Subscribe</button>
                    </form>
                </div>
            </div>
        </section>

    </x-slot>

    @push('scripts')
        <script>
            // Hover animation for buttons
            document.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('mousedown', () => {
                    btn.style.transform = 'scale(0.95)';
                });
                btn.addEventListener('mouseup', () => {
                    btn.style.transform = 'scale(1)';
                });
            });
        </script>
    @endpush
</x-app-layout>