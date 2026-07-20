<x-app-layout>
    @section('title', 'Special Offers | Apothecary Wellness')

    @push('styles')
        <style>
            .organic-shape {
                border-radius: 63% 37% 54% 46% / 45% 48% 52% 55%;
            }

            .pulse-soft {
                animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse-soft {
                0%, 100% { opacity: 1; }
                50% { opacity: .7; }
            }

            .transition-bezier {
                transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    @endpush

    <x-slot name="main">
        <!-- Flash Sale Countdown Banner -->
        <div class="sticky top-0 z-[60] bg-primary text-gold-accent py-3 shadow-md border-b border-gold-accent/20">
            <div class="max-w-container-max mx-auto px-margin-desktop flex flex-col md:flex-row justify-center items-center gap-2 md:gap-8">
                <span class="font-label-md text-label-md tracking-widest uppercase">Flash Sale Ends In:</span>
                <div class="font-headline-md text-headline-md flex items-center gap-2 pulse-soft tabular-nums" id="main-countdown">
                    <span class="countdown-unit">04h</span> :
                    <span class="countdown-unit">22m</span> :
                    <span class="countdown-unit">15s</span>
                </div>
            </div>
        </div>

        <div class="relative">
            <!-- Hero Section -->
            <section class="relative px-margin-desktop pt-xl pb-lg overflow-hidden">
                <div class="max-w-container-max mx-auto grid md:grid-cols-2 items-center gap-lg">
                    <div class="z-10">
                        <span class="text-gold-accent font-label-md tracking-widest uppercase mb-4 block">Limited Time Availability</span>
                        <h1 class="font-display-lg text-display-lg text-primary mb-6">Special Offers</h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-md mb-8">
                            Experience the restorative power of nature with our curated selection of wellness essentials,
                            now available at exceptional value.
                        </p>
                        <div class="flex gap-4">
                            <a href="#deals-grid" class="bg-primary text-white px-8 py-4 rounded-full font-label-md hover:bg-primary-container transition-bezier shadow-lg shadow-primary/10">Shop All Deals</a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="organic-shape bg-surface-container-high w-full aspect-square relative overflow-hidden">
                            <div class="absolute inset-0 bg-cover bg-center"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDx6u6aYzX-qFSZpbmqt97xWsdNknmi4E3Xelj49QxmI8Au49rp5tzvK6BVcfgJXxMzWC2TgqRUEDinC8qVSWiKTZ1WBts1O2oskU8StHwgoYgWMaFMtNzhoPRmiTIs1_EeXO3jKbXJjPW2NURtjNpSu611yc4j5LFAAlW1oMN8UaN1P2uK01q1CPN5xp63pdd_HZ6k_0xgNxq6jBK9N5-uFuNqWOuVTNiasT3McJo-0X7gU06syriYbOYV_yMWFlAHeAfulhHA49Tb')">
                            </div>
                        </div>
                        <!-- Decorative Element -->
                        <div class="absolute -bottom-8 -right-8 w-48 h-48 border-[1px] border-gold-accent/30 rounded-full animate-[spin_20s_linear_infinite]"></div>
                    </div>
                </div>
            </section>

            <!-- Deal Categories -->
            <section class="px-margin-desktop py-lg">
                <div class="max-w-container-max mx-auto">
                    <div class="flex overflow-x-auto gap-4 pb-4 hide-scrollbar">
                        <button class="whitespace-nowrap px-8 py-3 rounded-full bg-primary text-white font-label-md transition-bezier shadow-md">Today's Deals</button>
                        <button class="whitespace-nowrap px-8 py-3 rounded-full bg-white border border-outline/20 text-on-surface-variant font-label-md hover:border-primary/50 transition-bezier">Flash Sale</button>
                        <button class="whitespace-nowrap px-8 py-3 rounded-full bg-white border border-outline/20 text-on-surface-variant font-label-md hover:border-primary/50 transition-bezier">Bundle Offers</button>
                        <button class="whitespace-nowrap px-8 py-3 rounded-full bg-white border border-outline/20 text-on-surface-variant font-label-md hover:border-primary/50 transition-bezier">Seasonal Offers</button>
                    </div>
                </div>
            </section>

            <!-- Featured Deal Card (Bento/Hero Card) -->
            @if($activeDeals->count() > 0)
                @php $deal = $activeDeals->first(); @endphp
                <section class="px-margin-desktop py-lg">
                    <div class="max-w-container-max mx-auto">
                        <div class="bg-white rounded-premium overflow-hidden shadow-xl shadow-primary/5 grid md:grid-cols-5 h-auto md:h-[500px]">
                            <div class="md:col-span-3 h-full relative">
                                <div class="absolute inset-0 bg-cover bg-center"
                                    style="background-image: url('{{ $deal->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_R_Ej0-mTYe4DcpzHjgm7HCo4bHZmtY3kqbcGyWRSIKh5yZBorHUHrvxbfa9svHhbnLu-I3z7Uc7UvN5ozz_kHrsU5qblq7a8lbMJBqsATQJ1_MPI1vhc6DHgKsAd-YFC_B-GSl7eWQs0sSvfa9Thp6Y0cabbF_KCC6ZfS0zxJYeMLYgfMk_exoU3qr-MDdg7QZv2utktr11u5ifXVurIa95FPDvMAxM1OXKwEMYh7Dfxihq_4ILQ_kz4mv5n1d2UqFJePtaGMyIS' }}')">
                                </div>
                                <div class="absolute top-8 left-8 bg-gold-accent text-white px-4 py-1 rounded-full font-label-md">
                                    DEAL OF THE DAY
                                </div>
                            </div>
                            <div class="md:col-span-2 p-md md:p-lg flex flex-col justify-center bg-surface-container-low">
                                <h2 class="font-headline-lg text-headline-lg text-primary mb-4">{{ $deal->title }}</h2>
                                <p class="text-on-surface-variant mb-6">{{ $deal->description }}</p>
                                
                                @if ($deal->discount_percentage)
                                    <div class="mb-8">
                                        <span class="text-primary font-headline-md block mt-1 font-bold"><span class="text-error text-label-md font-normal ml-2">SAVE {{ $deal->discount_percentage }}%</span></span>
                                    </div>
                                @endif
                                
                                <div class="mb-8">
                                    <div class="flex justify-between text-label-md mb-2">
                                        <span class="text-on-surface-variant">Hurry, limited stock!</span>
                                        <span class="text-primary font-bold">Selling Fast</span>
                                    </div>
                                    <div class="w-full h-2 bg-surface-variant rounded-full overflow-hidden">
                                        <div class="w-[85%] h-full bg-primary pulse-soft"></div>
                                    </div>
                                </div>
                                <a href="{{ route('public.deals.show', ['deal' => $deal->id]) }}" class="w-full text-center block bg-primary text-white py-4 rounded-full font-label-md hover:bg-primary-container transition-bezier shadow-lg shadow-primary/20">
                                    {{ $deal->button_text ?? 'View Deal' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Product Grid -->
            <section id="deals-grid" class="px-margin-desktop py-xl">
                <div class="max-w-container-max mx-auto">
                    <div class="flex justify-between items-end mb-lg">
                        <div>
                            <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Today's Deals</h2>
                            <p class="text-on-surface-variant font-body-md">Hand-picked wellness essentials for your daily ritual.</p>
                        </div>
                        <a class="text-primary font-label-md flex items-center gap-2 hover:underline" href="{{ route('public.products') }}?sort=discount">
                            View All <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                    
                    @if($allDealProducts->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-lg">
                            @foreach($allDealProducts as $product)
                                <div class="group bg-white p-4 rounded-premium transition-bezier hover:shadow-2xl hover:shadow-primary/10 flex flex-col h-full">
                                    <div class="relative aspect-square rounded-xl overflow-hidden mb-4 bg-surface-container-high">
                                        <a href="{{ route('public.products.show', $product->slug) }}">
                                            <div class="absolute inset-0 bg-cover bg-center group-hover:scale-110 transition-transform duration-700"
                                                style="background-image: url('{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://placehold.co/400x400?text=No+Image' }}')">
                                            </div>
                                        </a>
                                        @if ($product->discount > 0)
                                            <div class="absolute top-3 left-3 bg-gold-accent text-white px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase">
                                                SAVE {{ number_format(($product->discount / $product->price) * 100) }}%
                                            </div>
                                        @endif
                                        <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-md flex items-center justify-center text-primary hover:bg-white transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">favorite_border</span>
                                        </button>
                                    </div>
                                    <h3 class="font-body-lg text-on-surface mb-1 truncate flex-grow">
                                        <a href="{{ route('public.products.show', $product->slug) }}" class="hover:text-primary transition-colors">{{ $product->name }}</a>
                                    </h3>
                                    
                                    <div class="flex items-end gap-2 mb-4">
                                        @if ($product->discount > 0)
                                            <span class="text-primary font-bold text-body-lg">{{ number_format($product->price - $product->discount, 2) }} TK</span>
                                            <span class="text-on-surface-variant line-through text-label-md">{{ number_format($product->price, 2) }} TK</span>
                                        @else
                                            <span class="text-primary font-bold text-body-lg">{{ number_format($product->price, 2) }} TK</span>
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        <div class="h-1 bg-surface-variant rounded-full overflow-hidden mb-1">
                                            <div class="h-full {{ $product->stock_quantity <= 10 ? 'bg-error w-1/4' : 'bg-primary w-3/4' }}"></div>
                                        </div>
                                        @if ($product->stock_quantity > 0)
                                            @if ($product->stock_quantity <= 10)
                                                <span class="text-error text-[10px] font-bold uppercase">ONLY {{ $product->stock_quantity }} LEFT</span>
                                            @else
                                                <span class="text-on-surface-variant text-[10px] font-bold uppercase">IN STOCK</span>
                                            @endif
                                        @else
                                            <span class="text-error text-[10px] font-bold uppercase">OUT OF STOCK</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" {{ $product->stock_quantity == 0 ? 'disabled' : '' }} class="w-full border-2 border-primary text-primary py-2 rounded-full font-label-md hover:bg-primary hover:text-white transition-bezier {{ $product->stock_quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if ($allDealProducts->hasPages())
                            <div class="mt-8">
                                {{ $allDealProducts->links() }}
                            </div>
                        @endif
                    @else
                        <div class="bg-white rounded-2xl shadow-sm border border-surface-container-highest p-12 text-center">
                            <div class="w-24 h-24 rounded-full bg-surface-container-low flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-4xl text-outline-variant">loyalty</span>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-4">No Active Deals</h3>
                            <p class="text-on-surface-variant">There are currently no active deals. Check back soon for exclusive discounts!</p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Promo Banner -->
            <section class="px-margin-desktop py-lg">
                <div class="max-w-container-max mx-auto relative h-64 md:h-80 rounded-premium overflow-hidden bg-primary flex items-center">
                    <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC5fb4Pre0DfR5NA9iM07t_8D3wEfNXwFMKnETiHJ2wDqUq7eqjcjES8ietoEjJsRd7NilcZhgb3mLZ-zHqEvE7290xgFrARJIC8xZPaSrRujydOho5lTysYkrKKFna8PyAsAdZLVlHzFt6lCT36GrP9YDfeBJCZLJcKlOZv4uCB1AV5OkB-RbFmfpXu48enBawtgVAE4gTDaOlRURcet8pvsgtsEnLsU3s8HZjcaFdKXzFE-7h0RtMqixPtkJ_51WIi8Q6VQeF39VT')">
                    </div>
                    <div class="relative z-10 p-md md:p-xl text-white max-w-2xl">
                        <h2 class="font-headline-lg text-headline-lg mb-4">Wellness Bundles - Save up to 30%</h2>
                        <p class="font-body-md text-surface-variant mb-6">Curated kits designed for your specific health
                            journey. Maximum efficacy, exceptional value.</p>
                        <a href="{{ route('public.categories') }}" class="inline-block bg-gold-accent text-primary px-8 py-3 rounded-full font-label-md hover:brightness-110 transition-bezier shadow-lg">Discover Bundles</a>
                    </div>
                </div>
            </section>

            <!-- Coupon Section -->
            <section class="px-margin-desktop py-xl">
                <div class="max-w-container-max mx-auto">
                    <h2 class="font-headline-lg text-headline-lg text-primary text-center mb-lg">Exclusive Promo Codes</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                        <!-- Coupon 1 -->
                        <div class="bg-white border-2 border-dashed border-gold-accent/40 rounded-premium p-lg text-center hover:border-gold-accent transition-colors group">
                            <span class="text-on-surface-variant font-label-md uppercase tracking-widest mb-2 block">Site-wide Discount</span>
                            <h3 class="font-headline-md text-primary mb-6">10% OFF</h3>
                            <div class="flex items-center justify-between bg-surface-container-low px-4 py-3 rounded-xl border border-outline/10 group-hover:border-gold-accent/20 transition-colors">
                                <span class="font-bold text-primary tracking-widest">VITALITY10</span>
                                <button class="text-primary font-label-md hover:underline flex items-center gap-1" onclick="copyCode('VITALITY10', this)">
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span> Copy
                                </button>
                            </div>
                        </div>
                        <!-- Coupon 2 -->
                        <div class="bg-white border-2 border-dashed border-gold-accent/40 rounded-premium p-lg text-center hover:border-gold-accent transition-colors group">
                            <span class="text-on-surface-variant font-label-md uppercase tracking-widest mb-2 block">First Bundle Order</span>
                            <h3 class="font-headline-md text-primary mb-6">$15 OFF</h3>
                            <div class="flex items-center justify-between bg-surface-container-low px-4 py-3 rounded-xl border border-outline/10 group-hover:border-gold-accent/20 transition-colors">
                                <span class="font-bold text-primary tracking-widest">BUNDLE15</span>
                                <button class="text-primary font-label-md hover:underline flex items-center gap-1" onclick="copyCode('BUNDLE15', this)">
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span> Copy
                                </button>
                            </div>
                        </div>
                        <!-- Coupon 3 -->
                        <div class="bg-white border-2 border-dashed border-gold-accent/40 rounded-premium p-lg text-center hover:border-gold-accent transition-colors group">
                            <span class="text-on-surface-variant font-label-md uppercase tracking-widest mb-2 block">Eco-Collection Bonus</span>
                            <h3 class="font-headline-md text-primary mb-6">FREE GIFT</h3>
                            <div class="flex items-center justify-between bg-surface-container-low px-4 py-3 rounded-xl border border-outline/10 group-hover:border-gold-accent/20 transition-colors">
                                <span class="font-bold text-primary tracking-widest">PUREGIFT</span>
                                <button class="text-primary font-label-md hover:underline flex items-center gap-1" onclick="copyCode('PUREGIFT', this)">
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Newsletter Section -->
            <section class="px-margin-desktop py-xl bg-surface-container-high rounded-t-[80px]">
                <div class="max-w-3xl mx-auto text-center py-lg">
                    <span class="text-gold-accent font-label-md tracking-widest uppercase mb-4 block">Inner Circle Access</span>
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-6">Join the Vitality Circle</h2>
                    <p class="font-body-lg text-on-surface-variant mb-10">Be the first to receive exclusive seasonal offers, wellness guides, and early access to limited edition drops.</p>
                    <form class="flex flex-col sm:flex-row gap-4" action="{{ route('public.subscribe') }}" method="POST">
                        @csrf
                        <input class="flex-grow bg-white border-none rounded-full px-8 py-4 text-body-md focus:ring-1 focus:ring-primary shadow-sm"
                            name="email" placeholder="Enter your email" required type="email" />
                        <button type="submit" class="bg-primary text-white px-10 py-4 rounded-full font-label-md hover:bg-primary-container transition-bezier shadow-lg shadow-primary/10">Subscribe</button>
                    </form>
                    <p class="mt-4 text-caption text-on-surface-variant/60 italic">Respecting your inbox as much as your wellness.</p>
                </div>
            </section>
        </div>
    </x-slot>

    @push('scripts')
        <script>
            // Copy Code Functionality
            function copyCode(code, btn) {
                navigator.clipboard.writeText(code).then(() => {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">check</span> Copied!';
                    btn.classList.add('text-secondary');
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('text-secondary');
                    }, 2000);
                });
            }

            // Live Countdown Logic
            function updateCountdowns() {
                const now = new Date();
                // Simulating a midnight expiry or fixed duration
                const target = new Date();
                target.setHours(23, 59, 59, 999);

                const diff = target - now;

                const h = Math.floor(diff / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                const display =
                    `${h.toString().padStart(2, '0')}h : ${m.toString().padStart(2, '0')}m : ${s.toString().padStart(2, '0')}s`;

                const mainTimer = document.getElementById('main-countdown');
                if (mainTimer) mainTimer.innerHTML = display;
            }

            setInterval(updateCountdowns, 1000);
            updateCountdowns();

            // Smooth category transition logic
            const categoryButtons = document.querySelectorAll('.hide-scrollbar button');
            categoryButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryButtons.forEach(b => {
                        b.classList.remove('bg-primary', 'text-white', 'shadow-md');
                        b.classList.add('bg-white', 'border', 'border-outline/20', 'text-on-surface-variant');
                    });
                    btn.classList.remove('bg-white', 'border', 'border-outline/20', 'text-on-surface-variant');
                    btn.classList.add('bg-primary', 'text-white', 'shadow-md');
                });
            });
        </script>
    @endpush
</x-app-layout>
