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
        <!-- Hero Section -->
        <section
            class="min-h-screen px-margin-desktop py-xl max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-12 gap-xl items-center">
            <!-- Hero Image Left -->
            <div class="md:col-span-7 relative stagger-in">
                <div
                    class="aspect-[4/5] w-full rounded-[24px] overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,69,37,0.08)] bg-surface-container">
                    @if ($product->images->count() > 0)
                        <img id="main-image" class="w-full h-full object-cover"
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
                    <div class="flex gap-md mt-md">
                        @foreach ($product->images->take(4) as $image)
                            <button
                                onclick="document.getElementById('main-image').src='{{ Storage::url($image->image_path) }}'"
                                class="w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary transition-colors flex-shrink-0">
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Decorative botanical element -->
                <div class="absolute -bottom-10 -left-10 w-40 h-40 opacity-10 pointer-events-none">
                    <span class="material-symbols-outlined text-[160px]"
                        style="font-variation-settings: 'opsz' 48;">eco</span>
                </div>
            </div>

            <!-- Product Details Right -->
            <div class="md:col-span-5 flex flex-col gap-md stagger-in" style="animation-delay: 0.2s;">
                <div class="flex flex-col gap-xs">
                    <span
                        class="font-label-md text-label-md text-secondary uppercase tracking-[0.2em]">{{ $product->category?->name ?? 'Ayurvedic Vitality' }}</span>
                    <h1 class="font-display-lg text-display-lg text-primary leading-tight">{{ $product->name }}</h1>
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

                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[480px]">
                    {{ $product->short_description ?? 'Premium natural product crafted for healthy living.' }}
                </p>

                <div class="flex flex-col gap-gutter mt-base">
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-md">
                            <div class="flex items-center border border-outline-variant rounded-full h-14 px-md">
                                <button type="button"
                                    class="material-symbols-outlined text-primary hover:bg-surface-container rounded-full p-xs transition-colors"
                                    onclick="const el = document.getElementById('qty-{{ $product->id }}'); el.value = Math.max(1, parseInt(el.value) - 1)">remove</button>
                                <input type="number" id="qty-{{ $product->id }}" name="quantity" value="1"
                                    min="1"
                                    class="font-label-md text-label-md w-12 text-center bg-transparent border-none focus:ring-0 p-0" />
                                <button type="button"
                                    class="material-symbols-outlined text-primary hover:bg-surface-container rounded-full p-xs transition-colors"
                                    onclick="const el = document.getElementById('qty-{{ $product->id }}'); el.value = parseInt(el.value) + 1">add</button>
                            </div>
                            <button type="submit"
                                class="flex-1 bg-primary text-on-primary font-label-md text-label-md h-14 rounded-[16px] shadow-lg hover:shadow-xl hover:translate-y-[-2px] active:scale-95 transition-all duration-300">
                                Add to Ritual
                            </button>
                        </div>
                    </form>
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
        <section class="bg-surface-container-low py-xl px-margin-desktop overflow-hidden relative">
            <div class="max-w-container-max mx-auto relative z-10">
                <div class="flex flex-col items-center text-center mb-xl">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-sm">Pure Composition</h2>
                    <div class="w-16 h-1 bg-tertiary-fixed-dim rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-xl">
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">
                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">filter_vintage</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-primary">Single Origin</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">100% Wild-harvested leaves
                            from high-altitude natural groves.</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">
                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">nature</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-primary">No Additives</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Free from synthetic fillers,
                            colors, or preservatives. Just pure, ground plant life.</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center gap-md p-lg bg-surface/50 backdrop-blur-sm rounded-[24px] hover:shadow-xl transition-all duration-500">
                        <div class="w-16 h-16 bg-primary-container/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[32px]">science</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-primary">Lab Tested</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Rigorous third-party testing
                            for
                            purity, potency, and heavy metal clearance.</p>
                    </div>
                </div>

                {{-- Product Details --}}
                @if ($product->ingredients || $product->weight)
                    <div class="mt-xl grid grid-cols-1 md:grid-cols-2 gap-gutter">
                        @if ($product->weight)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary">Weight</span>
                                <p class="font-body-md text-on-surface-variant mt-xs">{{ $product->weight }}</p>
                            </div>
                        @endif
                        @if ($product->ingredients)
                            <div class="p-md bg-surface/50 rounded-[24px]">
                                <span class="font-label-md text-primary">Ingredients</span>
                                <p class="font-body-md text-on-surface-variant mt-xs">{{ $product->ingredients }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <!-- Background Illustration -->
            <span
                class="absolute -right-20 top-20 material-symbols-outlined text-[400px] text-primary opacity-5 select-none pointer-events-none">eco</span>
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
                    <div class="flex justify-between items-end mb-xl">
                        <div class="flex flex-col gap-xs">
                            <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">Enhance
                                Your
                                Journey</span>
                            <h2 class="font-headline-lg text-headline-lg text-primary">Related Rituals</h2>
                        </div>
                        <a class="font-label-md text-label-md text-primary border-b border-primary pb-1"
                            href="{{ route('public.products') }}">View Collection</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                        @foreach ($relatedProducts->take(3) as $relatedProduct)
                            @include('themes.natural.public.products.partial.product-card', [
                                'product' => $relatedProduct,
                            ])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
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
        </script>
    @endpush
</x-app-layout>
