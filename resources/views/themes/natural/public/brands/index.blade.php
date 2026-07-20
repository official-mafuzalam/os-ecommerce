<x-app-layout>
    @section('title', 'Shop by Brand | ' . setting('site_name', 'OS Ecommerce'))

    @push('styles')
        <style>
            .glass-nav {
                backdrop-filter: blur(12px);
                background: rgba(252, 249, 242, 0.7);
            }

            .brand-card:hover .card-image {
                transform: scale(1.05);
            }

            .custom-scrollbar::-webkit-scrollbar {
                height: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f0eee7;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #4c3800;
                border-radius: 10px;
            }
            
            .reveal-item {
                transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            }
        </style>
    @endpush

    <x-slot name="main">
        <!-- Hero Section -->
        <section class="relative pt-xl pb-lg px-gutter overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <div class="absolute top-1/4 -right-20 w-96 h-96 border border-tertiary rounded-full blur-3xl opacity-20"></div>
                <div class="absolute -bottom-20 -left-20 w-80 h-80 border border-primary rounded-full blur-3xl opacity-10"></div>
            </div>
            <div class="max-w-container-max mx-auto text-center relative z-10">
                <span class="font-label-md text-label-md text-tertiary uppercase tracking-widest mb-4 block">Our Partners</span>
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-6">Shop by Brand</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    Discover carefully selected wellness brands committed to quality, purity, and natural nutrition.
                </p>
            </div>
        </section>

        <!-- Featured Brands Carousel (Trending Now) -->
        @if (isset($featuredBrands) && $featuredBrands->count() > 0)
            <section class="py-lg px-gutter max-w-container-max mx-auto">
                <div class="flex items-end justify-between mb-md">
                    <h2 class="font-headline-md text-headline-md text-primary">Featured Partners</h2>
                    <div class="flex gap-xs">
                        <button
                            class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center text-on-surface-variant hover:border-tertiary hover:text-tertiary transition-all"
                            id="trending-prev">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button
                            class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center text-on-surface-variant hover:border-tertiary hover:text-tertiary transition-all"
                            id="trending-next">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="flex gap-md overflow-x-auto pb-6 custom-scrollbar snap-x" id="trending-carousel">
                    @foreach ($featuredBrands as $featured)
                        <div class="flex-none w-64 snap-start">
                            <a href="{{ route('public.products', ['brand' => $featured->slug]) }}"
                                class="group cursor-pointer block">
                                <div class="aspect-[4/5] rounded-[24px] overflow-hidden mb-4 bg-surface-container shadow-sm group-hover:shadow-md transition-all duration-500">
                                    <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                                        style="background-image: url('{{ $featured->logo ? Storage::url($featured->logo) : 'https://placehold.co/400x500?text=' . urlencode($featured->name) }}')">
                                    </div>
                                </div>
                                <h3 class="font-headline-md text-[20px] text-primary">{{ $featured->name }}</h3>
                                <p class="text-caption text-on-surface-variant uppercase tracking-tighter">{{ $featured->products_count ?? 0 }} Products</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Main Brand Grid & Filters -->
        <section class="py-xl bg-surface-container-low px-gutter">
            <div class="max-w-container-max mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-xl gap-md">
                    <div class="max-w-xl">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Directory of Excellence</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Search or filter our trusted wellness partners who supply our premium ecosystem.</p>
                    </div>
                    
                    <!-- Search Input -->
                    <div class="w-full max-w-xs relative">
                        <input id="brand-search"
                            class="w-full pl-10 pr-4 py-2 bg-surface border border-outline rounded-xl focus:ring-1 focus:ring-primary focus:border-primary transition-all font-body-md placeholder:text-outline-variant text-sm"
                            placeholder="Search brands..." type="text" />
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-base">search</span>
                    </div>
                </div>

                <!-- Alphabet Filter -->
                @if ($brands->count() > 0)
                    <div class="flex flex-wrap justify-center gap-xs mb-xl">
                        <button data-letter="all"
                            class="letter-btn px-4 py-2 rounded-full font-label-md text-xs bg-primary text-white shadow-sm transition-all">All</button>
                        @foreach (range('A', 'Z') as $letter)
                            <button data-letter="{{ $letter }}"
                                class="letter-btn px-3 py-2 rounded-full font-label-md text-xs text-on-surface-variant hover:bg-primary-fixed hover:text-on-primary-fixed transition-all cursor-pointer">
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md md:gap-lg" id="brands-grid">
                    @forelse($brands as $brand)
                        <div class="brand-card group bg-surface rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-surface-variant flex flex-col h-full opacity-0 translate-y-10 reveal-item"
                             data-name="{{ strtolower($brand->name) }}">
                            <div class="relative h-48 bg-surface-container-high overflow-hidden flex items-center justify-center p-md">
                                @if ($brand->logo)
                                    <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                         class="max-h-24 max-w-full object-contain transition-transform duration-700 group-hover:scale-110" />
                                @else
                                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-700">
                                        <span class="font-headline-md text-xl font-bold">{{ substr($brand->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-md flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-headline-md text-[20px] text-primary truncate max-w-[70%]">{{ $brand->name }}</h3>
                                    <span class="text-caption text-tertiary-container font-bold bg-tertiary-fixed px-2 py-0.5 rounded-full text-xs whitespace-nowrap">
                                        {{ $brand->products_count ?? 0 }} Products
                                    </span>
                                </div>
                                @if ($brand->description)
                                    <p class="text-body-md text-on-surface-variant mb-6 line-clamp-2">
                                        {{ $brand->description }}</p>
                                @else
                                    <p class="text-body-md text-on-surface-variant mb-6 line-clamp-2">Premium wellness partner supplying certified organic goods.</p>
                                @endif

                                <div class="mt-auto">
                                    <a href="{{ route('public.products', ['brand' => $brand->slug]) }}"
                                        class="w-full h-12 flex items-center justify-center gap-2 border border-primary text-primary rounded-xl font-label-md uppercase tracking-wider group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                        Explore <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <div class="w-20 h-20 rounded-full bg-surface text-on-surface-variant flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-4xl">spa</span>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-4">No Brands Available</h3>
                            <p class="text-on-surface-variant mb-8 max-w-md mx-auto">
                                Our brands catalog is being updated. Please check back soon.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($brands->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $brands->links() }}
                    </div>
                @endif
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="bg-surface-container py-xl px-gutter relative overflow-hidden">
            <div class="max-w-3xl mx-auto text-center relative z-10">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-[40px] text-primary">volunteer_activism</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Join the Vitality Circle</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-md">Subscribe to receive seasonal wellness guides, early access to new harvests, and 10% off your first order.</p>
                <form class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto" action="{{ route('public.subscribe') }}" method="POST">
                    @csrf
                    <input name="email"
                        class="flex-grow bg-white border-0 border-b-2 border-outline-variant focus:border-tertiary focus:ring-0 px-4 py-4 text-body-md rounded-lg shadow-sm"
                        placeholder="Your Email Address" required="" type="email" />
                    <button
                        class="bg-primary text-white font-label-md uppercase tracking-widest px-8 py-4 rounded-xl hover:bg-primary-container transition-all shadow-md active:scale-95"
                        type="submit">
                        Subscribe
                    </button>
                </form>
            </div>
            <!-- Botanical decoration -->
            <div class="absolute -bottom-10 -right-10 w-64 h-64 opacity-5 pointer-events-none transform rotate-12">
                <span class="material-symbols-outlined text-[200px]">eco</span>
            </div>
        </section>
    </x-slot>

    @push('scripts')
        <script>
            // Simple scroll behavior for the Carousel
            const carousel = document.getElementById('trending-carousel');
            const nextBtn = document.getElementById('trending-next');
            const prevBtn = document.getElementById('trending-prev');

            if (nextBtn && carousel) {
                nextBtn.addEventListener('click', () => {
                    carousel.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                });
            }
            if (prevBtn && carousel) {
                prevBtn.addEventListener('click', () => {
                    carousel.scrollBy({
                        left: -300,
                        behavior: 'smooth'
                    });
                });
            }

            // Interactive Search & Alphabetical Filter logic
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('brand-search');
                const letterBtns = document.querySelectorAll('.letter-btn');
                const brandCards = document.querySelectorAll('.brand-card');

                function filterBrands() {
                    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                    const activeBtn = document.querySelector('.letter-btn.bg-primary');
                    const letter = activeBtn ? activeBtn.dataset.letter.toLowerCase() : 'all';

                    brandCards.forEach(card => {
                        const name = card.dataset.name || '';
                        const matchesSearch = name.includes(query);
                        const matchesLetter = (letter === 'all' || name.startsWith(letter));

                        if (matchesSearch && matchesLetter) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }

                if (searchInput) {
                    searchInput.addEventListener('input', filterBrands);
                }

                letterBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        letterBtns.forEach(b => {
                            b.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                            b.classList.add('text-on-surface-variant');
                        });
                        btn.classList.add('bg-primary', 'text-white', 'shadow-sm');
                        btn.classList.remove('text-on-surface-variant');
                        filterBrands();
                    });
                });

                // Intersection Observer for scroll animations
                const observerOptions = {
                    threshold: 0.05,
                    rootMargin: "0px 0px -50px 0px"
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            entry.target.classList.remove('opacity-0', 'translate-y-10');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.reveal-item').forEach((el, index) => {
                    el.style.transitionDelay = `${index * 0.05}s`;
                    observer.observe(el);
                });
            });
        </script>
    @endpush
</x-app-layout>
