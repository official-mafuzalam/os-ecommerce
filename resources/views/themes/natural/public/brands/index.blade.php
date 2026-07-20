<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce') . ' | Our Brands')

    @push('styles')
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
                vertical-align: middle;
            }

            .brand-card-hover {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .brand-card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 69, 37, 0.08);
            }

            .glass-effect {
                backdrop-filter: blur(12px);
                background-color: rgba(252, 249, 242, 0.7);
            }

            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #c0c9bf;
                border-radius: 10px;
            }
        </style>
    @endpush

    <x-slot name="main">
        <div class="pb-xl">
            <!-- Hero Section -->
            <section class="bg-[#F8F5EE] py-xl px-margin-mobile md:px-margin-desktop overflow-hidden relative">
                <div class="max-w-container-max mx-auto relative z-10">
                    <!-- Breadcrumb -->
                    <nav aria-label="Breadcrumb" class="flex mb-md">
                        <ol class="flex items-center space-x-2 text-on-surface-variant font-label-md text-label-md">
                            <li><a class="hover:text-primary transition-colors"
                                    href="{{ route('public.welcome') }}">Home</a>
                            </li>
                            <li><span class="material-symbols-outlined text-sm">chevron_right</span></li>
                            <li class="text-primary font-bold">Brands</li>
                        </ol>
                    </nav>
                    <div class="max-w-3xl">
                        <h1 class="font-display-lg text-display-lg mb-sm text-primary">Our Trusted Brands</h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                            Discover carefully selected wellness brands committed to quality, purity, and natural
                            nutrition.
                            Every partner in our ecosystem is chosen for their artisanal precision and ethical
                            standards.
                        </p>
                    </div>
                </div>
                <!-- Decorative botanical element -->
                <div class="absolute -right-20 -bottom-20 opacity-10 pointer-events-none">
                    <span class="material-symbols-outlined text-[300px] text-primary">eco</span>
                </div>
            </section>

            <!-- Search & Alphabet Filter -->
            <section class="py-lg px-margin-mobile md:px-margin-desktop border-b border-surface-variant">
                <div class="max-w-container-max mx-auto flex flex-col items-center">
                    <div class="w-full max-w-xl relative group mb-lg">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                        <input id="brand-search"
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-lowest border-none rounded-xl shadow-sm ring-1 ring-outline-variant focus:ring-2 focus:ring-primary transition-all font-body-md placeholder:text-outline-variant"
                            placeholder="Search brands by name..." type="text" />
                    </div>
                    @if ($brands->count() > 0)
                        <div class="flex flex-wrap justify-center gap-sm md:gap-md">
                            <button data-letter="all"
                                class="letter-btn w-10 h-10 rounded-full flex items-center justify-center font-label-md bg-primary text-white shadow-md">All</button>
                            @foreach (range('A', 'Z') as $letter)
                                <button data-letter="{{ $letter }}"
                                    class="letter-btn w-10 h-10 rounded-full flex items-center justify-center font-label-md text-on-surface-variant hover:bg-primary-fixed hover:text-on-primary-fixed transition-all cursor-pointer
                                    {{ $brands->where('name', 'LIKE', $letter . '%')->count() === 0 ? 'opacity-30 cursor-default' : '' }}">
                                    {{ $letter }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Featured Brands Section -->
            @if ($featuredBrands->count() > 0)
                <section class="py-xl px-margin-mobile md:px-margin-desktop">
                    <div class="max-w-container-max mx-auto">
                        <div class="flex justify-between items-end mb-lg">
                            <div>
                                <span
                                    class="font-label-md text-label-md text-tertiary uppercase tracking-widest block mb-xs">Curation</span>
                                <h2 class="font-headline-lg text-headline-lg text-primary">Featured Partners</h2>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                            @foreach ($featuredBrands->take(3) as $brand)
                                <a href="{{ route('public.products', ['brand' => $brand->slug]) }}"
                                    class="group relative overflow-hidden rounded-[24px] bg-surface-container-low p-base block">
                                    <div
                                        class="aspect-[4/5] rounded-[20px] overflow-hidden mb-md relative bg-surface-container-high flex items-center justify-center">
                                        @if ($brand->logo)
                                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}" />
                                        @else
                                            <span
                                                class="material-symbols-outlined text-[80px] text-primary/20">spa</span>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-md">
                                            <span class="text-white font-label-md flex items-center gap-xs">
                                                View Collection <span
                                                    class="material-symbols-outlined">arrow_outward</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="px-sm pb-sm">
                                        <h3 class="font-headline-md text-headline-md text-primary mb-xs">
                                            {{ $brand->name }}</h3>
                                        @if ($brand->description)
                                            <p
                                                class="font-body-md text-body-md text-on-surface-variant mb-md line-clamp-2">
                                                {{ $brand->description }}</p>
                                        @endif
                                        <div
                                            class="flex justify-between items-center border-t border-outline-variant pt-sm">
                                            <span
                                                class="font-label-md text-label-md text-tertiary">{{ $brand->products_count }}
                                                Products</span>
                                            <span
                                                class="px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-full text-[10px] font-bold tracking-tighter uppercase">Featured</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Brand Directory Grid -->
            <section class="py-xl px-margin-mobile md:px-margin-desktop bg-surface-container-lowest">
                <div class="max-w-container-max mx-auto">
                    <div class="mb-lg">
                        <h2 class="font-headline-lg text-headline-lg text-primary text-center">Directory of Excellence
                        </h2>
                    </div>

                    @forelse ($brands as $brand)
                        <div class="brand-card-item" data-name="{{ strtolower($brand->name) }}">
                        @empty
                    @endforelse

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter" id="brands-grid">
                        @forelse ($brands as $brand)
                            <div class="brand-card-item brand-card-hover bg-surface border border-outline-variant/30 p-md rounded-[24px] transition-all duration-300 flex flex-col h-full"
                                data-name="{{ strtolower($brand->name) }}">
                                <div
                                    class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-md overflow-hidden flex-shrink-0">
                                    @if ($brand->logo)
                                        <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                            class="max-h-12 max-w-full object-contain" />
                                    @else
                                        <span
                                            class="font-headline-md text-[24px] text-primary">{{ substr($brand->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <h4 class="font-headline-md text-[24px] text-primary mb-xs">{{ $brand->name }}</h4>
                                @if ($brand->description)
                                    <p
                                        class="font-body-md text-body-md text-on-surface-variant mb-lg flex-grow line-clamp-2">
                                        {{ $brand->description }}</p>
                                @else
                                    <p
                                        class="font-body-md text-body-md text-on-surface-variant mb-lg flex-grow opacity-50">
                                        Wellness partner</p>
                                @endif
                                <div class="flex flex-col gap-sm mt-auto">
                                    <span class="font-label-md text-label-md text-outline">{{ $brand->products_count }}
                                        Products</span>
                                    <a href="{{ route('public.products', ['brand' => $brand->slug]) }}"
                                        class="w-full h-12 border border-primary text-primary rounded-xl font-label-md hover:bg-primary hover:text-white transition-all active:scale-95 flex items-center justify-center">
                                        View Products
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-xl">
                                <span
                                    class="material-symbols-outlined text-[80px] text-outline/30 block mb-md">spa</span>
                                <h3 class="font-headline-md text-headline-md text-primary mb-sm">No Brands Available
                                </h3>
                                <p class="font-body-md text-on-surface-variant mb-lg">Our brand catalog is being
                                    updated. Check back soon.</p>
                                <a href="{{ route('public.products') }}"
                                    class="inline-flex items-center gap-xs font-label-md text-primary border border-primary px-md py-sm rounded-xl hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[18px]">store</span>
                                    Browse All Products
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($brands->hasPages())
                        <div class="mt-xl flex justify-center">
                            {{ $brands->links() }}
                        </div>
                    @endif
                </div>
            </section>

            <!-- Newsletter Section -->
            <section
                class="py-xl px-margin-mobile md:px-margin-desktop bg-primary text-on-primary relative overflow-hidden">
                <div class="max-w-container-max mx-auto text-center relative z-10">
                    <span class="font-label-md tracking-widest uppercase mb-md block">Community</span>
                    <h2 class="font-display-lg text-display-lg mb-md">Join the Vitality Circle</h2>
                    <p class="max-w-xl mx-auto font-body-lg text-body-lg opacity-80 mb-xl">
                        Be the first to discover new brand arrivals, exclusive seasonal harvests, and ancient wellness
                        wisdom delivered to your inbox.
                    </p>
                    <form class="flex flex-col md:flex-row gap-base max-w-lg mx-auto"
                        action="{{ route('public.subscribe') }}" method="POST">
                        @csrf
                        <input name="email" type="email"
                            class="flex-grow h-14 px-6 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:ring-2 focus:ring-tertiary-fixed outline-none text-white placeholder:text-white/50 transition-all"
                            placeholder="Your email address" />
                        <button type="submit"
                            class="h-14 px-8 bg-tertiary-fixed text-on-tertiary-fixed font-bold rounded-xl hover:bg-tertiary-fixed-dim transition-all active:scale-95">
                            Subscribe
                        </button>
                    </form>
                </div>
                <!-- Decorative circles -->
                <div class="absolute -top-40 -left-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            </section>

        </div>
    </x-slot>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const letterBtns = document.querySelectorAll('.letter-btn');
                const brandCards = document.querySelectorAll('.brand-card-item');
                const searchInput = document.getElementById('brand-search');

                // Letter filter
                letterBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const letter = btn.dataset.letter;

                        letterBtns.forEach(b => {
                            b.classList.remove('bg-primary', 'text-white', 'shadow-md');
                            b.classList.add('text-on-surface-variant');
                        });
                        btn.classList.add('bg-primary', 'text-white', 'shadow-md');
                        btn.classList.remove('text-on-surface-variant');

                        brandCards.forEach(card => {
                            const name = card.dataset.name || '';
                            if (letter === 'all') {
                                card.style.display = '';
                            } else {
                                card.style.display = name.startsWith(letter.toLowerCase()) ?
                                    '' : 'none';
                            }
                        });

                        if (searchInput) searchInput.value = '';
                    });
                });

                // Search filter
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase();

                        // Reset letter filter
                        letterBtns.forEach(b => {
                            b.classList.remove('bg-primary', 'text-white', 'shadow-md');
                            b.classList.add('text-on-surface-variant');
                        });
                        const allBtn = document.querySelector('[data-letter="all"]');
                        if (allBtn) {
                            allBtn.classList.add('bg-primary', 'text-white', 'shadow-md');
                            allBtn.classList.remove('text-on-surface-variant');
                        }

                        brandCards.forEach(card => {
                            const name = card.dataset.name || '';
                            card.style.display = name.includes(query) ? '' : 'none';
                        });
                    });
                }

                // Stagger animation on cards
                brandCards.forEach((card, i) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, i * 50);
                });
            });
        </script>
    @endpush
</x-app-layout>
