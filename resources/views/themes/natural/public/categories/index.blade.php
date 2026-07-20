<x-app-layout>
    @section('title', 'Shop by Category | OS Ecommerce')

    @push('styles')
        <style>
            .glass-nav {
                backdrop-filter: blur(12px);
                background: rgba(252, 249, 242, 0.7);
            }

            .category-card:hover .card-image {
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
        </style>
    @endpush

    <x-slot name="main">
        <!-- Hero Section -->
        <section class="relative pt-xl pb-lg px-gutter overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <!-- Decorative Gold Swirl/Pattern would go here -->
                <div
                    class="absolute top-1/4 -right-20 w-96 h-96 border border-tertiary rounded-full blur-3xl opacity-20">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 w-80 h-80 border border-primary rounded-full blur-3xl opacity-10">
                </div>
            </div>
            <div class="max-w-container-max mx-auto text-center relative z-10">
                <span class="font-label-md text-label-md text-tertiary uppercase tracking-widest mb-4 block">Our
                    Collections</span>
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-6">Shop by Category
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    Explore our carefully selected natural wellness collections, rooted in traditional wisdom and
                    crafted for modern purity.
                </p>
            </div>
        </section>

        <!-- Popular Categories Carousel (Featured) -->
        @if (isset($featuredCategories) && $featuredCategories->count() > 0)
            <section class="py-lg px-gutter max-w-container-max mx-auto">
                <div class="flex items-end justify-between mb-md">
                    <h2 class="font-headline-md text-headline-md text-primary">Trending Now</h2>
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
                    @foreach ($featuredCategories as $featured)
                        <div class="flex-none w-64 snap-start">
                            <a href="{{ route('public.products', ['category' => $featured->slug]) }}"
                                class="group cursor-pointer block">
                                <div
                                    class="aspect-[4/5] rounded-[24px] overflow-hidden mb-4 bg-surface-container shadow-sm group-hover:shadow-md transition-all duration-500">
                                    <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                                        style="background-image: url('{{ $featured->image ? Storage::url($featured->image) : 'https://placehold.co/400x500?text=No+Image' }}')">
                                    </div>
                                </div>
                                <h3 class="font-headline-md text-[20px] text-primary">{{ $featured->name }}</h3>
                                <p class="text-caption text-on-surface-variant uppercase tracking-tighter">Featured
                                    Collection</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Main Category Grid -->
        <section class="py-xl bg-surface-container-low px-gutter">
            <div class="max-w-container-max mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-xl gap-md">
                    <div class="max-w-xl">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Browse by Category</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">From ancient herbal remedies to
                            modern superfoods, find exactly what your wellness journey requires.</p>
                    </div>
                    <div class="flex items-center gap-sm">
                        <span class="text-label-md font-label-md text-on-surface-variant uppercase">Sort by:</span>
                        <select
                            class="bg-transparent border-b border-outline text-primary font-body-md focus:ring-0 focus:border-tertiary px-2 py-1">
                            <option>Relevance</option>
                            <option>Alphabetical</option>
                            <option>Most Popular</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md md:gap-lg">
                    @forelse($categories as $category)
                        <div
                            class="group bg-surface rounded-[24px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-surface-variant flex flex-col h-full opacity-0 translate-y-10 reveal-item">
                            <div class="relative h-64 overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                                    style="background-image: url('{{ $category->image ? Storage::url($category->image) : 'https://placehold.co/600x400?text=No+Image' }}')">
                                </div>
                                <div
                                    class="absolute top-4 left-4 bg-surface/90 backdrop-blur-md w-12 h-12 rounded-full flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">{{ $category->icon ?? 'category' }}</span>
                                </div>
                            </div>
                            <div class="p-md flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-headline-md text-[24px] text-primary">{{ $category->name }}</h3>
                                    <span
                                        class="text-caption text-tertiary-container font-bold bg-tertiary-fixed px-2 py-0.5 rounded-full">
                                        {{ $category->products_count ?? 0 }} Products
                                    </span>
                                </div>
                                @if ($category->description)
                                    <p class="text-body-md text-on-surface-variant mb-6 line-clamp-2">
                                        {{ $category->description }}</p>
                                @else
                                    <p class="text-body-md text-on-surface-variant mb-6 line-clamp-2">Discover our
                                        premium {{ strtolower($category->name) }} collection.</p>
                                @endif

                                <div class="mt-auto">
                                    <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                        class="w-full h-12 flex items-center justify-center gap-2 border border-primary text-primary rounded-xl font-label-md uppercase tracking-wider group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                        Explore <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <div
                                class="w-20 h-20 rounded-full bg-surface text-on-surface-variant flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-4xl">inventory_2</span>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-4">No Collections Available</h3>
                            <p class="text-on-surface-variant mb-8 max-w-md mx-auto">
                                Our collections are being updated. Please check back soon for our latest categories.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($categories->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </section>

        <!-- Featured Collection Banner -->
        <section class="py-xl px-gutter">
            <div
                class="max-w-container-max mx-auto relative rounded-[32px] overflow-hidden min-h-[500px] flex items-center">
                <div class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=2000&auto=format&fit=crop')">
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-transparent"></div>
                <div class="relative z-10 px-md md:px-xl py-lg max-w-2xl text-white">
                    <span
                        class="font-label-md text-label-md uppercase tracking-[0.2em] mb-4 block text-secondary-fixed">Nature's
                        Wisdom</span>
                    <h2 class="font-display-lg text-headline-lg md:text-display-lg mb-6 leading-tight">The Ancient
                        Secret of Longevity</h2>
                    <p class="font-body-lg text-body-lg mb-8 opacity-90">Discover our signature collection featuring
                        heirloom seeds and rare herbal formulations passed down through generations of natural
                        practitioners.</p>
                    <a href="{{ route('public.products') }}"
                        class="inline-flex bg-primary-container hover:bg-primary text-white px-8 py-4 rounded-xl font-label-md uppercase tracking-wider transition-all duration-300 items-center gap-3">
                        View Collection <span class="material-symbols-outlined">arrow_outward</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="bg-surface-container py-xl px-gutter relative overflow-hidden">
            <div class="max-w-3xl mx-auto text-center relative z-10">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-[40px] text-primary">volunteer_activism</span>
                </div>
                <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Join the Vitality Circle</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-md">Subscribe to receive seasonal
                    wellness guides, early access to new harvests, and 10% off your first order.</p>
                <form class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto">
                    <input
                        class="flex-grow bg-white border-0 border-b-2 border-outline-variant focus:border-tertiary focus:ring-0 px-4 py-4 text-body-md rounded-lg shadow-sm"
                        placeholder="Your Email Address" required="" type="email" />
                    <button
                        class="bg-primary text-white font-label-md uppercase tracking-widest px-8 py-4 rounded-xl hover:bg-primary-container transition-all shadow-md active:scale-95"
                        type="submit">
                        Subscribe
                    </button>
                </form>
                <p class="text-caption text-on-surface-variant mt-4 opacity-70">By subscribing, you agree to our Privacy
                    Policy and Terms of Service.</p>
            </div>
            <!-- Botanical decoration -->
            <div class="absolute -bottom-10 -right-10 w-64 h-64 opacity-5 pointer-events-none transform rotate-12">
                <span class="material-symbols-outlined text-[200px]">eco</span>
            </div>
        </section>
    </x-slot>

    @push('scripts')
        <script>
            // Simple scroll behavior for the Trending Carousel
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

            // Add intersection observer for reveal animations
            const observerOptions = {
                threshold: 0.1,
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
                el.style.transitionDelay = `${index * 0.1}s`;
                observer.observe(el);
            });
        </script>
    @endpush
</x-app-layout>
