<x-app-layout>
    @section('title', $product->name . ' | ' . setting('site_name', 'OS Ecommerce'))

    @push('styles')
        <style>
            .stagger-in {
                animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
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
        </style>
    @endpush

    <x-slot name="main">
        @php
            $lang = setting('order_form_bangla') ? '1' : '0';
        @endphp
        <!-- Hero Section -->
        <section
            class="px-margin-desktop py-md md:py-lg max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-12 gap-xl items-start md:items-center">
            <!-- Hero Image Left -->
            <div class="md:col-span-7 relative stagger-in">
                <div id="image-zoom-container"
                    class="aspect-square w-full rounded-[24px] overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,69,37,0.08)] bg-surface-container relative cursor-zoom-in">
                    @if ($product->images->count() > 0)
                        <img id="main-image"
                            class="w-full h-full object-contain transition-transform duration-200 ease-out origin-center pointer-events-none"
                            src="{{ Storage::url($product->images->where('is_primary', true)->first()?->image_path ?? $product->images->first()->image_path) }}"
                            alt="{{ $product->name }}" />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-low">
                            <span
                                class="material-symbols-outlined text-[80px] text-outline-variant">image_not_supported</span>
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Gallery --}}
                @if ($product->images->count() > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-2 mt-md">
                        @foreach ($product->images as $image)
                            <button
                                onclick="document.getElementById('main-image').src='{{ Storage::url($image->image_path) }}'; document.querySelectorAll('.thumb-btn').forEach(btn => btn.classList.remove('border-primary')); this.classList.add('border-primary')"
                                class="thumb-btn aspect-square w-full rounded-xl overflow-hidden border-2 {{ $image->is_primary || ($loop->first && !$product->images->where('is_primary', true)->count()) ? 'border-primary' : 'border-transparent' }} hover:border-primary transition-colors">
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-contain" />
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Decorative botanical element -->
                <div class="hidden md:block absolute -bottom-10 -left-10 w-40 h-40 opacity-10 pointer-events-none">
                    <span class="material-symbols-outlined text-[160px]"
                        style="font-variation-settings: 'opsz' 48;">eco</span>
                </div>
            </div>

            <!-- Product Details Right -->
            <div class="md:col-span-5 flex flex-col gap-md stagger-in" style="animation-delay: 0.2s;">
                <div class="flex flex-col gap-xs">
                    <span
                        class="font-label-md text-label-md text-secondary uppercase tracking-[0.2em]">{{ $product->category?->name ?? 'Ayurvedic Vitality' }}</span>
                    <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary leading-tight">{{ $product->name }}</h1>
                </div>

                <div class="flex items-baseline gap-sm">
                    <span class="font-headline-md text-headline-md text-on-surface">
                        ৳ {{ number_format($product->final_price) }}
                    </span>
                    @if ($product->discount > 0)
                        <span class="font-caption text-caption text-on-surface-variant line-through">
                            ৳ {{ number_format($product->price) }}
                        </span>
                        <span
                            class="font-label-md text-[10px] bg-tertiary-fixed text-on-tertiary-fixed px-sm py-xs rounded-full uppercase tracking-tighter">
                            -{{ round(($product->discount / max($product->price, 1)) * 100) }}% off
                        </span>
                    @endif
                </div>

                <p class="font-body-lg text-body-lg text-on-surface-variant md:max-w-[480px]">
                    {{ $product->short_description ?? 'Premium natural product crafted for healthy living.' }}
                </p>

                <div class="flex flex-col gap-md mt-base">
                    @php
                        $themeMinQty = max(1, (int) ($product->min_order_quantity ?? 1));
                        $themeMaxQty = $product->max_order_quantity && $product->max_order_quantity > 0
                            ? min((int) $product->max_order_quantity, (int) $product->stock_quantity)
                            : (int) $product->stock_quantity;
                    @endphp

                    <!-- Quantity Controller -->
                    <div class="flex flex-col gap-1">
                        <div
                            class="flex items-center justify-between border border-outline-variant rounded-full h-14 px-md">
                            <button type="button"
                                class="material-symbols-outlined text-primary hover:bg-surface-container rounded-full p-xs transition-colors"
                                onclick="const el = document.getElementById('qty-{{ $product->id }}'); el.value = Math.max({{ $themeMinQty }}, parseInt(el.value) - 1); document.getElementById('buy-now-qty-{{ $product->id }}').value = el.value">remove</button>
                            <input type="number" id="qty-{{ $product->id }}" name="quantity" value="{{ $themeMinQty }}"
                                min="{{ $themeMinQty }}" max="{{ $themeMaxQty > 0 ? $themeMaxQty : 1 }}"
                                oninput="document.getElementById('buy-now-qty-{{ $product->id }}').value = this.value"
                                class="font-label-md text-label-md w-12 text-center bg-transparent border-none focus:ring-0 p-0" />
                            <button type="button"
                                class="material-symbols-outlined text-primary hover:bg-surface-container rounded-full p-xs transition-colors"
                                onclick="const el = document.getElementById('qty-{{ $product->id }}'); el.value = Math.min({{ $themeMaxQty > 0 ? $themeMaxQty : 9999 }}, parseInt(el.value) + 1); document.getElementById('buy-now-qty-{{ $product->id }}').value = el.value">add</button>
                        </div>
                        @if ($themeMinQty > 1 || $product->max_order_quantity)
                            <div class="flex justify-between px-md text-xs text-on-surface-variant font-medium">
                                @if ($themeMinQty > 1)
                                    <span>Min order: {{ $themeMinQty }}</span>
                                @endif
                                @if ($product->max_order_quantity)
                                    <span>Max order: {{ $product->max_order_quantity }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch gap-sm">
                        <!-- Add to Cart (Secondary Outline) -->
                        <form action="{{ route('cart.add', $product) }}" method="POST"
                            class="flex-1 flex items-stretch">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $themeMinQty }}"
                                id="add-to-cart-qty-{{ $product->id }}">
                            @if ($groupedAttributes->count() > 0)
                                @foreach ($groupedAttributes as $attribute)
                                    <input type="hidden" name="attributes[{{ $attribute['id'] }}]"
                                        id="nat-attr-{{ $attribute['id'] }}" value="">
                                @endforeach
                            @endif
                            <button type="submit"
                                onclick="document.getElementById('add-to-cart-qty-{{ $product->id }}').value = document.getElementById('qty-{{ $product->id }}').value"
                                class="w-full border-2 border-primary text-primary hover:bg-primary/10 font-label-md text-label-md h-14 rounded-[16px] font-bold hover:translate-y-[-2px] active:scale-95 transition-all duration-300 flex items-center justify-center gap-sm"
                                {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                <span class="material-symbols-outlined">shopping_bag</span>
                                {{ $lang === '1' ? 'কার্টে যোগ করুন' : 'Add To Cart' }}
                            </button>
                        </form>

                        <!-- Order Now (Highlighted High Conversion Primary CTA) -->
                        <form action="{{ route('public.products.buy-now', $product) }}" method="GET"
                            class="flex-1 flex items-stretch">
                            <input type="hidden" name="quantity" value="{{ $themeMinQty }}" id="buy-now-qty-{{ $product->id }}">
                            @if ($groupedAttributes->count() > 0)
                                @foreach ($groupedAttributes as $attribute)
                                    <input type="hidden" name="attributes[{{ $attribute['id'] }}]"
                                        id="nat-buy-attr-{{ $attribute['id'] }}" value="">
                                @endforeach
                            @endif
                            <button type="submit"
                                onclick="document.getElementById('buy-now-qty-{{ $product->id }}').value = document.getElementById('qty-{{ $product->id }}').value"
                                class="w-full bg-gradient-to-r from-emerald-600 via-primary to-emerald-700 text-white font-label-md text-label-md text-base h-14 rounded-[16px] shadow-lg shadow-emerald-700/30 hover:shadow-xl hover:shadow-emerald-700/40 hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-sm font-bold relative overflow-hidden group">
                                <span class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 ease-in-out"></span>
                                <span class="material-symbols-outlined text-amber-300 animate-bounce">bolt</span>
                                <span>{{ $lang === '1' ? 'অর্ডার করুন' : 'Order Now' }}</span>
                            </button>
                        </form>
                    </div>

                    <!-- Contact Options -->
                    <div class="grid grid-cols-2 gap-sm">
                        @if (setting('site_phone'))
                            <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                class="flex items-center justify-center gap-2 h-12 bg-secondary/10 hover:bg-secondary/15 text-primary rounded-[12px] transition-all font-label-md text-xs">
                                <span class="material-symbols-outlined text-sm">call</span>
                                {{ $lang === '1' ? 'কল করুন' : 'Call Now' }}
                            </a>
                        @endif
                        @if (setting('whatsapp_enabled', true))
                            <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode('I want to know about ' . $product->name) }}"
                                target="_blank"
                                class="flex items-center justify-center gap-2 h-12 bg-green-500/10 hover:bg-green-500/15 text-green-700 rounded-[12px] transition-all font-label-md text-xs">
                                <span class="material-symbols-outlined text-sm">chat</span>
                                {{ $lang === '1' ? 'হোয়াটসঅ্যাপ' : 'WhatsApp' }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-md pt-lg border-t border-outline-variant/30">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-secondary">verified</span>
                        <span class="font-caption text-caption uppercase tracking-wider">Premium Grade</span>
                    </div>
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-secondary">package_2</span>
                        <span class="font-caption text-caption uppercase tracking-wider">Eco-Packaging</span>
                    </div>
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-secondary">inventory_2</span>
                        <span class="font-caption text-caption uppercase tracking-wider">
                            {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    @if ($product->sku)
                        <div class="flex items-center gap-sm">
                            <span class="material-symbols-outlined text-secondary">tag</span>
                            <span class="font-caption text-caption uppercase tracking-wider">SKU:
                                {{ $product->sku }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Pure Composition Section -->
        <section class="bg-surface-container-low px-margin-desktop overflow-hidden relative">
            <div class="max-w-container-max mx-auto relative z-10">
                {{-- Product Details --}}
                @if (
                    $product->ingredients ||
                        $product->weight ||
                        $product->length ||
                        $product->shipping_class ||
                        $product->origin_country ||
                        $product->material ||
                        $product->warranty_info ||
                        $product->usage_instructions ||
                        $product->care_instructions ||
                        ($product->certifications && count($product->certifications) > 0) ||
                        ($product->tags && count($product->tags) > 0))
                    <div class="mt-xl grid grid-cols-1 md:grid-cols-2 gap-gutter">
                        @if ($product->ingredients)
                            <div class="p-md bg-surface/50 rounded-[24px] md:col-span-2">
                                <span class="font-label-md text-primary block mb-xs">Ingredients</span>
                                <p class="font-body-md text-on-surface-variant whitespace-pre-line">
                                    {{ $product->ingredients }}</p>
                            </div>
                        @endif
                        @if ($product->usage_instructions)
                            <div class="p-md bg-surface/50 rounded-[24px] md:col-span-2">
                                <span class="font-label-md text-primary block mb-xs">Usage Instructions</span>
                                <p class="font-body-md text-on-surface-variant whitespace-pre-line">
                                    {{ $product->usage_instructions }}</p>
                            </div>
                        @endif
                        @if ($product->care_instructions)
                            <div class="p-md bg-surface/50 rounded-[24px] md:col-span-2">
                                <span class="font-label-md text-primary block mb-xs">Care Instructions</span>
                                <p class="font-body-md text-on-surface-variant whitespace-pre-line">
                                    {{ $product->care_instructions }}</p>
                            </div>
                        @endif
                        @if ($product->material)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Material / Fabric</span>
                                <p class="font-body-md text-on-surface-variant">{{ $product->material }}</p>
                            </div>
                        @endif
                        @if ($product->warranty_info)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Warranty Info</span>
                                <p class="font-body-md text-on-surface-variant">{{ $product->warranty_info }}</p>
                            </div>
                        @endif
                        @if ($product->weight)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Weight</span>
                                <p class="font-body-md text-on-surface-variant">{{ $product->weight }} kg</p>
                            </div>
                        @endif
                        @if ($product->length || $product->width || $product->height)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Dimensions (L × W × H)</span>
                                <p class="font-body-md text-on-surface-variant">
                                    {{ $product->length ?? '-' }} × {{ $product->width ?? '-' }} ×
                                    {{ $product->height ?? '-' }} cm
                                </p>
                            </div>
                        @endif
                        @if ($product->shipping_class)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Shipping</span>
                                <p class="font-body-md text-on-surface-variant">{{ $product->shipping_class }}</p>
                            </div>
                        @endif
                        @if ($product->origin_country)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary block mb-xs">Origin Country</span>
                                <p class="font-body-md text-on-surface-variant">{{ $product->origin_country }}</p>
                            </div>
                        @endif
                        @if ($product->certifications && count($product->certifications) > 0)
                            <div class="p-md bg-surface/50 rounded-[24px] md:col-span-2">
                                <span class="font-label-md text-primary block mb-xs">Certifications</span>
                                <div class="flex flex-wrap gap-xs mt-xs">
                                    @foreach ($product->certifications as $cert)
                                        <span
                                            class="px-sm py-xs bg-primary/10 text-primary font-label-md text-xs rounded-full">{{ $cert }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($product->tags && count($product->tags) > 0)
                            <div class="p-md bg-surface/50 rounded-[24px] md:col-span-2">
                                <span class="font-label-md text-primary block mb-xs">Tags</span>
                                <div class="flex flex-wrap gap-xs mt-xs">
                                    @foreach ($product->tags as $tag)
                                        <span
                                            class="px-sm py-xs bg-secondary/10 text-secondary font-label-md text-xs rounded-full">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <!-- Background Illustration -->
            <span
                class="hidden md:block absolute -right-20 top-20 material-symbols-outlined text-[400px] text-primary opacity-5 select-none pointer-events-none">eco</span>
        </section>

        <!-- Product Description Section -->
        @if ($product->description)
            <section class="py-xl px-margin-desktop max-w-container-max mx-auto">
                <div class="flex flex-col gap-md">
                    <h2 class="font-headline-lg text-headline-lg text-primary">Product Description</h2>
                    <div class="w-16 h-1 bg-tertiary-fixed-dim rounded-full mb-sm"></div>
                    <div class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed prose max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </section>
        @endif

        <!-- Related Rituals (Upsell) -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="py-xl px-margin-desktop bg-surface-container-high/30">
                <div class="max-w-container-max mx-auto">
                    <div class="flex flex-wrap justify-between items-end gap-sm mb-xl">
                        <div class="flex flex-col gap-xs">
                            <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">Enhance
                                Your
                                Journey</span>
                            <h2 class="font-headline-lg text-headline-lg text-primary">Related Rituals</h2>
                        </div>
                        <a class="font-label-md text-label-md text-primary border-b border-primary pb-1"
                            href="{{ route('public.products') }}">View Collection</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-gutter">
                        @foreach ($relatedProducts->take(3) as $relatedProduct)
                            @include('themes.natural.public.products.partial.product-card', [
                                'product' => $relatedProduct,
                            ])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        
        <section class="bg-surface-container-low py-xl px-margin-desktop overflow-hidden relative">
            <div class="max-w-container-max mx-auto relative z-10">
                <div class="flex flex-col items-center text-center mb-xl">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-sm">
                        কেন {{ setting('site_name') }}?
                    </h2>
                    <div class="w-16 h-1 bg-tertiary-fixed-dim rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-xl">

                    <!-- Card 1 -->
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">

                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">
                                eco
                            </span>
                        </div>

                        <h3 class="font-label-md text-label-md text-primary">
                            যত্নে নির্বাচিত প্রাকৃতিক উপাদান
                        </h3>

                        <p class="font-body-md text-body-md text-on-surface-variant">
                            বিশ্বস্ত উৎস থেকে সংগ্রহ করা প্রাকৃতিক উপাদান দিয়ে তৈরি
                            স্বাস্থ্যকর ওয়েলনেস পণ্য।
                        </p>

                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">

                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">
                                verified
                            </span>
                        </div>

                        <h3 class="font-label-md text-label-md text-primary">
                            বিশুদ্ধতা ও মানের প্রতি অঙ্গীকার
                        </h3>

                        <p class="font-body-md text-body-md text-on-surface-variant">
                            পরিচ্ছন্ন প্রক্রিয়াকরণ, নিরাপদ প্যাকেজিং এবং প্রতিটি ধাপে
                            গুণগত মান বজায় রাখার প্রচেষ্টা।
                        </p>

                    </div>

                    <!-- Card 3 -->
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">

                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">
                                favorite
                            </span>
                        </div>

                        <h3 class="font-label-md text-label-md text-primary">
                            স্বাস্থ্যকর জীবনযাপনের সঙ্গী
                        </h3>

                        <p class="font-body-md text-body-md text-on-surface-variant">
                            প্রতিদিনের খাদ্যাভ্যাসকে আরও পুষ্টিকর ও স্বাস্থ্যসচেতন করতে
                            আপনার বিশ্বস্ত সঙ্গী।
                        </p>

                    </div>

                </div>

            </div>
        </section>
    </x-slot>

    @push('scripts')
        <script>
            // Intersection Observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.stagger-in').forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });

            // Update attribute values in forms
            function updateAttributeValues() {
                const forms = [
                    document.querySelector('form[action*="cart/add"]'),
                    document.querySelector('form[action*="buy-now"]')
                ];

                forms.forEach(form => {
                    if (form) {
                        const attributeInputs = form.querySelectorAll('input[name^="attributes["]');
                        attributeInputs.forEach(input => {
                            const attributeId = input.name.match(/\[(\d+)\]/)[1];
                            const radio = document.querySelector(
                                `input[name="attributes[${attributeId}]"]:checked`
                            );
                            if (radio) {
                                input.value = radio.value;
                            }
                        });
                    }
                });
            }

            // Add event listeners to attribute radios
            const attributeRadios = document.querySelectorAll('input[name^="attributes["]');
            attributeRadios.forEach(radio => {
                radio.addEventListener('change', updateAttributeValues);
            });

            // Update forms on page load
            updateAttributeValues();

            // Advanced hover zoom (cursor tracking zoom)
            const zoomContainer = document.getElementById('image-zoom-container');
            const mainImg = document.getElementById('main-image');

            if (zoomContainer && mainImg) {
                let isZoomed = false;

                zoomContainer.addEventListener('mousemove', (e) => {
                    const rect = zoomContainer.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    // Clamp to [0,100] to prevent out-of-bounds origin
                    const xPercent = Math.max(0, Math.min(100, (x / rect.width) * 100));
                    const yPercent = Math.max(0, Math.min(100, (y / rect.height) * 100));

                    mainImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                    mainImg.style.transform = 'scale(1.8)';
                    isZoomed = true;
                });

                zoomContainer.addEventListener('mouseleave', () => {
                    mainImg.style.transform = 'scale(1)';
                    mainImg.style.transformOrigin = 'center center';
                    isZoomed = false;
                });

                // Ensure reset if mouse never leaves properly
                zoomContainer.addEventListener('mouseenter', () => {
                    mainImg.style.transform = 'scale(1)';
                    mainImg.style.transformOrigin = 'center center';
                });
            }
        </script>
    @endpush
</x-app-layout>
