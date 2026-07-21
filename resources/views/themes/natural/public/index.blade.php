<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce'))
    <x-slot name="main">
        <!-- Hero Section -->
        <section
            class="relative min-h-[921px] flex items-center px-margin-desktop max-w-container-max mx-auto overflow-visible">
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

                        {{-- <a href="{{ route('public.blog.index') }}"
                            class="inline-flex items-center justify-center border border-primary text-primary px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary/5 transition-all duration-300">
                            সুপার ফুড সম্পর্কে জানুন
                        </a> --}}
                    </div>
                </div>
                <div class="lg:col-span-6 relative mt-xl lg:mt-0">
                    <div class="relative w-full aspect-square max-w-[600px] mx-auto">
                        <!-- Decorative Botanical Background -->
                        <div
                            class="absolute -top-10 -right-10 w-full h-full bg-secondary-container/20 rounded-full blur-3xl -z-10">
                        </div>

                        <!-- Main Hero Image with Organic Masking -->
                        <div class="w-full h-full overflow-hidden organic-shape shadow-2xl rounded-full">
                            @if ($carousels && $carousels->count() > 0)
                                <img class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700"
                                    alt="{{ $carousels->first()->title }}"
                                    src="{{ Storage::url($carousels->first()->image) }}" />
                            @else
                                <img class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700"
                                    alt="Hero Image"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbWrds_KT3YCmlhSGLOzs3P5DEqXoY3DXYYjCwVc7KXFIVSSa91lOgJmaWb-io8ZR3F6fxvGq9iS6URaCLHyzKRA-4-XJA4RYn4JqVp5ireOIdv3FnbwKAGJ4Y-kGPb_byr6IXNOwJbcfrCdPPzKW-43y1c2nEajwwTZM_2bN3e992xgrzGGYFMqADfBKkYO-OpQ6Zno9ndkvUUL1kmBOUIpzFN9StLFsUahOgs5_UAu3ulPNVWoMpWb3sDdEYPYm9gRjK5eWYNx8b" />
                            @endif
                        </div>
                        <!-- Floating Accent -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-white/80 backdrop-blur-md p-md rounded-2xl shadow-xl border border-surface-container-high hidden md:block">
                            <div class="flex items-center gap-base">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim"
                                    style="font-variation-settings: 'FILL' 1;">stars</span>
                                <span class="font-label-md text-label-md text-primary">Lab-Tested Purity</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
