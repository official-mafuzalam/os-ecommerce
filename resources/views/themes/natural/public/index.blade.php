<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce'))
    <x-slot name="main">
        <!-- Hero Section -->
        <section
            class="relative min-h-[921px] flex items-center px-margin-desktop max-w-container-max mx-auto overflow-visible">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center w-full py-xl">
                <div class="lg:col-span-6 z-10">
                    <span
                        class="inline-block font-label-md text-label-md text-secondary uppercase tracking-widest mb-md">Pure
                        Bangladeshi Apothecary</span>
                    <h1
                        class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary leading-tight mb-lg">
                        Nature's Purest Essence for <span class="italic text-tertiary">Modern Vitality.</span>
                    </h1>
                    <a href="{{ route('public.products') }}"
                        class="inline-flex items-center justify-center bg-primary text-white px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary-container transition-all duration-300 active:scale-95 shadow-lg shadow-primary/10">
                        Explore the Collection
                    </a>
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
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Featured Superfoods</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Carefully selected adaptogens and
                            minerals from the heart of nature, processed with artisanal precision to preserve their
                            vital
                            force.</p>
                    </div>
                    <a class="hidden md:flex items-center gap-xs font-label-md text-primary hover:gap-base transition-all"
                        href="{{ route('public.products') }}">
                        View All <span class="material-symbols-outlined">arrow_right_alt</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @foreach ($featuredProducts->take(3) as $product)
                        <div
                            class="group bg-white rounded-2xl overflow-hidden hover-lift p-base {{ $loop->index > 0 ? 'mt-lg md:mt-0' : '' }} shadow-sm hover:shadow-md transition-shadow">
                            <a href="{{ route('public.products.show', $product->slug) }}"
                                class="block relative aspect-[4/5] rounded-xl overflow-hidden mb-md bg-surface-container-low">
                                @if ($product->images->where('is_primary', true)->first())
                                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        alt="{{ $product->name }}"
                                        src="{{ Storage::url($product->images->where('is_primary', true)->first()->image_path) }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary/30">
                                        <span class="material-symbols-outlined text-[64px]">image</span>
                                    </div>
                                @endif

                                @if ($product->category)
                                    <div
                                        class="absolute top-md right-md {{ $loop->index % 3 == 0 ? 'bg-secondary' : ($loop->index % 3 == 1 ? 'bg-tertiary' : 'bg-primary') }} text-white px-sm py-xs rounded-full font-label-md text-caption shadow-md">
                                        {{ $product->category->name }}
                                    </div>
                                @endif
                            </a>
                            <div class="px-sm pb-md">
                                <a href="{{ route('public.products.show', $product->slug) }}" class="block">
                                    <h3
                                        class="font-headline-md text-[24px] text-primary mb-xs group-hover:text-secondary transition-colors truncate">
                                        {{ $product->name }}</h3>
                                </a>
                                <p
                                    class="font-body-md text-on-surface-variant text-sm mb-md leading-relaxed line-clamp-2">
                                    {{ strip_tags($product->description) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <div>
                                        @if ($product->discount_price)
                                            <span
                                                class="font-label-md text-primary text-lg font-bold mr-2">৳{{ number_format($product->discount_price, 2) }}</span>
                                            <span
                                                class="font-caption text-on-surface-variant line-through">৳{{ number_format($product->base_price, 2) }}</span>
                                        @else
                                            <span
                                                class="font-label-md text-primary text-lg font-bold">৳{{ number_format($product->base_price, 2) }}</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="material-symbols-outlined text-primary border border-primary/20 rounded-full p-xs hover:bg-primary hover:text-white transition-all active:scale-95 shadow-sm">add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                            class="font-label-md text-label-md text-tertiary-fixed-variant uppercase tracking-widest mb-md block">Our
                            Philosophy</span>
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-lg leading-tight">Grounded in
                            Ancient Wisdom, Refined by Modern Science.</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg leading-relaxed">
                            OS Ecommerce is more than a brand; it is a bridge between the lush, fertile lands of
                            Bangladesh and the modern pursuit of longevity. We believe that true vitality comes from
                            respect—for the soil, for the season, and for the complex intelligence of the plant kingdom.
                        </p>
                        <ul class="space-y-md mb-xl">
                            <li class="flex items-start gap-md">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim mt-1"
                                    style="font-variation-settings: 'FILL' 1;">eco</span>
                                <div>
                                    <h4 class="font-label-md text-primary">Ethically Wild-Harvested</h4>
                                    <p class="text-on-surface-variant text-sm">Working directly with local farmers to
                                        ensure biodiversity and fair wages.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-md">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim mt-1"
                                    style="font-variation-settings: 'FILL' 1;">science</span>
                                <div>
                                    <h4 class="font-label-md text-primary">Precision Extraction</h4>
                                    <p class="text-on-surface-variant text-sm">Cold-processed methods to preserve
                                        delicate enzymes and phytonutrients.</p>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('public.about') }}"
                            class="inline-flex items-center justify-center border-2 border-primary text-primary px-lg py-base rounded-full font-label-md text-label-md hover:bg-primary hover:text-white transition-all duration-300">
                            Learn Our Story
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
