<x-app-layout>
    @section('title', $deal->title . ' | ' . setting('site_name', 'OS Ecommerce'))

    @push('styles')
        <style>
            .pulse-soft {
                animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse-soft {
                0%, 100% { opacity: 1; }
                50% { opacity: .7; }
            }

            .countdown-box {
                background: rgba(255,255,255,0.1);
                backdrop-filter: blur(8px);
            }

            .reveal-item {
                transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            }

            .custom-scrollbar::-webkit-scrollbar { height: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f0eee7; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #4c3800; border-radius: 10px; }
        </style>
    @endpush

    <x-slot name="main">

        <!-- Deal Hero -->
        <section class="relative overflow-hidden bg-primary text-white">
            <!-- Botanical overlay -->
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <div class="absolute -top-20 -right-20 w-96 h-96 border border-white rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 border border-white rounded-full -translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="relative z-10 max-w-container-max mx-auto px-gutter py-xl grid md:grid-cols-2 gap-xl items-center">
                <!-- Left: Content -->
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/20 px-4 py-1.5 rounded-full font-label-md text-xs uppercase tracking-widest mb-6">
                        <span class="material-symbols-outlined text-[16px] text-tertiary-fixed">bolt</span>
                        Exclusive Deal
                    </span>
                    <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg mb-4 leading-tight">{{ $deal->title }}</h1>
                    <p class="font-body-lg text-body-lg opacity-80 mb-8 max-w-lg">{{ $deal->description }}</p>

                    <div class="flex flex-wrap gap-8 mb-8">
                        @if ($deal->discount_percentage)
                            <div class="text-center">
                                <div class="text-5xl font-bold">{{ $deal->discount_percentage }}%</div>
                                <div class="text-xs uppercase opacity-70 tracking-widest mt-1">Off</div>
                            </div>
                        @endif
                        <div class="text-center">
                            <div class="text-4xl font-bold">{{ $deal->products->count() }}</div>
                            <div class="text-xs uppercase opacity-70 tracking-widest mt-1">Products</div>
                        </div>
                        @if ($deal->ends_at && $deal->ends_at->isFuture())
                            <div class="text-center">
                                <div class="text-4xl font-bold">{{ $deal->ends_at->diffInDays(now()) }}</div>
                                <div class="text-xs uppercase opacity-70 tracking-widest mt-1">Days Left</div>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ $deal->button_link ?? '#deals-products' }}"
                            class="inline-flex items-center gap-2 bg-white text-primary font-label-md uppercase tracking-wider px-8 py-4 rounded-xl hover:bg-primary-fixed transition-all shadow-lg active:scale-95">
                            {{ $deal->button_text ?? 'Shop Now' }}
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <button onclick="openShareModal()"
                            class="inline-flex items-center gap-2 border border-white/40 text-white font-label-md px-6 py-4 rounded-xl hover:bg-white/10 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                            Share
                        </button>
                    </div>
                </div>

                <!-- Right: Image + Countdown -->
                <div class="relative">
                    @if ($deal->image_url)
                        <div class="rounded-[32px] overflow-hidden shadow-2xl aspect-[4/3]">
                            <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent rounded-[32px]"></div>
                        </div>
                    @endif

                    @if ($deal->ends_at && $deal->ends_at->isFuture())
                        <div class="mt-6 bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                            <p class="text-center text-xs uppercase tracking-widest opacity-70 mb-4">Hurry! Offer ends in</p>
                            <div id="deal-countdown" class="flex justify-center gap-4">
                                <div class="text-center">
                                    <div class="text-3xl font-bold days tabular-nums">00</div>
                                    <div class="text-[10px] uppercase opacity-60">Days</div>
                                </div>
                                <div class="text-2xl font-light opacity-40 self-start mt-1">:</div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold hours tabular-nums">00</div>
                                    <div class="text-[10px] uppercase opacity-60">Hrs</div>
                                </div>
                                <div class="text-2xl font-light opacity-40 self-start mt-1">:</div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold minutes tabular-nums">00</div>
                                    <div class="text-[10px] uppercase opacity-60">Min</div>
                                </div>
                                <div class="text-2xl font-light opacity-40 self-start mt-1">:</div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold seconds tabular-nums">00</div>
                                    <div class="text-[10px] uppercase opacity-60">Sec</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Featured Products Carousel -->
        @if ($deal->featuredProducts->count() > 0)
            <section class="py-xl px-gutter bg-surface-container-low">
                <div class="max-w-container-max mx-auto">
                    <div class="flex items-end justify-between mb-lg">
                        <div>
                            <span class="font-label-md text-tertiary uppercase tracking-widest block mb-1">Handpicked</span>
                            <h2 class="font-headline-lg text-headline-lg text-primary">Featured Collection</h2>
                        </div>
                        <div class="flex gap-xs">
                            <button id="feat-prev" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-all">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button id="feat-next" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-all">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-md overflow-x-auto pb-4 custom-scrollbar snap-x" id="feat-carousel">
                        @foreach ($deal->featuredProducts as $product)
                            <div class="flex-none w-52 snap-start">
                                @include('themes.natural.public.products.partial.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- All Deal Products Grid -->
        <section id="deals-products" class="py-xl px-gutter">
            <div class="max-w-container-max mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-lg gap-4">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-primary">All Products in This Deal</h2>
                        <p class="text-on-surface-variant font-body-md mt-1">{{ $deal->products->count() }} premium products available</p>
                    </div>
                </div>

                @if ($deal->products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-md md:gap-lg">
                        @foreach ($deal->products as $product)
                            <div class="opacity-0 translate-y-8 reveal-item">
                                @include('themes.natural.public.products.partial.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-4xl text-outline-variant">loyalty</span>
                        </div>
                        <h3 class="font-headline-md text-primary mb-3">No Products Yet</h3>
                        <p class="text-on-surface-variant mb-8">This deal doesn't have any products assigned yet.</p>
                        <a href="{{ route('public.deals') }}" class="inline-flex items-center gap-2 border border-primary text-primary px-6 py-3 rounded-xl hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Deals
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Related Deals -->
        @if (isset($relatedDeals) && $relatedDeals->count() > 0)
            <section class="py-xl px-gutter bg-surface-container-low">
                <div class="max-w-container-max mx-auto">
                    <div class="text-center mb-lg">
                        <span class="font-label-md text-tertiary uppercase tracking-widest block mb-2">Don't Miss</span>
                        <h2 class="font-headline-lg text-headline-lg text-primary">More Exclusive Deals</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-md md:gap-lg">
                        @foreach ($relatedDeals as $rd)
                            <a href="{{ route('public.deals.show', $rd->slug) }}"
                                class="group bg-surface rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-surface-variant block">
                                <div class="relative aspect-video overflow-hidden">
                                    <img src="{{ $rd->image_url }}" alt="{{ $rd->title }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                                    @if ($rd->discount_percentage)
                                        <span class="absolute top-4 left-4 bg-tertiary-fixed text-on-tertiary-fixed text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                            {{ $rd->discount_percentage }}% Off
                                        </span>
                                    @endif
                                    @if ($rd->ends_at && $rd->ends_at->isFuture())
                                        <div class="absolute bottom-4 left-4 right-4 bg-black/50 backdrop-blur-sm rounded-lg py-2 text-center text-white text-xs">
                                            Ends in {{ $rd->ends_at->diffInDays(now()) }} days
                                        </div>
                                    @endif
                                </div>
                                <div class="p-md">
                                    <h3 class="font-headline-md text-primary mb-2 group-hover:underline">{{ $rd->title }}</h3>
                                    <p class="text-on-surface-variant text-sm line-clamp-2 mb-4">{{ $rd->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-outline">{{ $rd->products->count() }} products</span>
                                        <span class="flex items-center gap-1 text-primary font-label-md text-sm">
                                            View <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-xl">
                        <a href="{{ route('public.deals') }}"
                            class="inline-flex items-center gap-2 border border-primary text-primary px-8 py-4 rounded-xl font-label-md uppercase tracking-wider hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[18px]">loyalty</span>
                            View All Deals
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Share Modal -->
        <div id="share-modal" class="fixed inset-0 bg-black/50 z-[200] hidden items-center justify-center p-4">
            <div class="bg-surface rounded-[24px] shadow-2xl max-w-md w-full p-lg">
                <div class="flex items-center justify-between mb-lg">
                    <h3 class="font-headline-md text-primary">Share This Deal</h3>
                    <button onclick="closeShareModal()" class="material-symbols-outlined text-on-surface-variant hover:text-primary cursor-pointer">close</button>
                </div>
                <div class="grid grid-cols-4 gap-md mb-lg">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                        class="flex flex-col items-center gap-2 p-md bg-surface-container rounded-xl hover:bg-blue-50 transition-colors text-on-surface-variant hover:text-blue-600">
                        <i class="fab fa-facebook text-2xl"></i>
                        <span class="text-[10px] font-bold uppercase">Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($deal->title) }}" target="_blank"
                        class="flex flex-col items-center gap-2 p-md bg-surface-container rounded-xl hover:bg-sky-50 transition-colors text-on-surface-variant hover:text-sky-500">
                        <i class="fab fa-twitter text-2xl"></i>
                        <span class="text-[10px] font-bold uppercase">Twitter</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($deal->title . ' ' . url()->current()) }}" target="_blank"
                        class="flex flex-col items-center gap-2 p-md bg-surface-container rounded-xl hover:bg-green-50 transition-colors text-on-surface-variant hover:text-green-600">
                        <i class="fab fa-whatsapp text-2xl"></i>
                        <span class="text-[10px] font-bold uppercase">WhatsApp</span>
                    </a>
                    <button onclick="copyShareLink()"
                        class="flex flex-col items-center gap-2 p-md bg-surface-container rounded-xl hover:bg-surface-container-high transition-colors text-on-surface-variant">
                        <span class="material-symbols-outlined text-2xl">link</span>
                        <span class="text-[10px] font-bold uppercase">Copy</span>
                    </button>
                </div>
                <div class="flex items-center gap-2 bg-surface-container rounded-xl overflow-hidden px-4 py-3">
                    <input id="share-link" type="text" value="{{ url()->current() }}" readonly
                        class="flex-grow bg-transparent text-sm text-on-surface-variant focus:outline-none" />
                    <button onclick="copyShareLink()" class="text-primary font-label-md text-sm flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-[16px]">content_copy</span> Copy
                    </button>
                </div>
            </div>
        </div>

    </x-slot>

    @push('scripts')
        <script>
            // Countdown Timer
            @if ($deal->ends_at && $deal->ends_at->isFuture())
                const endTime = new Date('{{ $deal->ends_at->toIso8601String() }}').getTime();

                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = endTime - now;
                    if (distance <= 0) {
                        document.getElementById('deal-countdown').innerHTML = '<span class="text-sm opacity-70">Deal has ended</span>';
                        return;
                    }
                    const d = Math.floor(distance / 86400000);
                    const h = Math.floor((distance % 86400000) / 3600000);
                    const m = Math.floor((distance % 3600000) / 60000);
                    const s = Math.floor((distance % 60000) / 1000);
                    document.querySelector('.days').textContent = String(d).padStart(2, '0');
                    document.querySelector('.hours').textContent = String(h).padStart(2, '0');
                    document.querySelector('.minutes').textContent = String(m).padStart(2, '0');
                    document.querySelector('.seconds').textContent = String(s).padStart(2, '0');
                }
                updateCountdown();
                setInterval(updateCountdown, 1000);
            @endif

            // Featured carousel
            const featCarousel = document.getElementById('feat-carousel');
            const featNext = document.getElementById('feat-next');
            const featPrev = document.getElementById('feat-prev');
            if (featNext) featNext.addEventListener('click', () => featCarousel.scrollBy({ left: 260, behavior: 'smooth' }));
            if (featPrev) featPrev.addEventListener('click', () => featCarousel.scrollBy({ left: -260, behavior: 'smooth' }));

            // Reveal animations
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, i) => {
                        if (entry.isIntersecting) {
                            entry.target.style.transitionDelay = `${i * 0.04}s`;
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            entry.target.classList.remove('opacity-0', 'translate-y-8');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.05 });
                document.querySelectorAll('.reveal-item').forEach(el => observer.observe(el));
            });

            // Share modal
            function openShareModal() {
                document.getElementById('share-modal').classList.remove('hidden');
                document.getElementById('share-modal').classList.add('flex');
            }
            function closeShareModal() {
                document.getElementById('share-modal').classList.add('hidden');
                document.getElementById('share-modal').classList.remove('flex');
            }
            function copyShareLink() {
                navigator.clipboard.writeText('{{ url()->current() }}').then(() => {
                    const btn = document.getElementById('share-link');
                    btn.value = 'Copied!';
                    setTimeout(() => btn.value = '{{ url()->current() }}', 2000);
                });
            }
            document.getElementById('share-modal').addEventListener('click', (e) => {
                if (e.target.id === 'share-modal') closeShareModal();
            });
        </script>
    @endpush
</x-app-layout>
