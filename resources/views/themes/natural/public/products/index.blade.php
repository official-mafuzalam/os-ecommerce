<x-app-layout>
    @section('title', setting('site_name', 'Prokiti Sudha') . ' | Shop All Collections')

    @push('styles')
        <style>
            .product-card {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .product-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 30px 60px -12px rgba(0, 69, 37, 0.08);
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f0eee7;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #004525;
                border-radius: 10px;
            }
        </style>
    @endpush

    <x-slot name="main">
        <main class="pt-32 pb-xl px-margin-desktop max-w-container-max mx-auto">
            <!-- Hero Title Section -->
            <header class="mb-xl text-center md:text-left">
                <h1 class="font-cormorant text-[56px] leading-tight text-primary italic mb-sm">Shop All Collections</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[600px]">Artisan-crafted wellness
                    solutions, ethically sourced from the heart of nature to revitalize your spirit.</p>
            </header>
            <div class="flex flex-col md:flex-row gap-xl">
                <!-- Sidebar Filters -->
                <aside class="w-full md:w-64 flex-shrink-0 space-y-xl">
                    <div>
                        <h3 class="font-label-md text-label-md text-primary uppercase tracking-widest mb-md">Category</h3>
                        <ul class="space-y-sm">
                            <li class="flex items-center gap-sm cursor-pointer group">
                                <span
                                    class="w-4 h-4 rounded-full border border-primary group-hover:bg-primary-fixed transition-colors"></span>
                                <span class="font-body-md text-on-surface-variant group-hover:text-primary">Powders</span>
                            </li>
                            <li class="flex items-center gap-sm cursor-pointer group">
                                <span
                                    class="w-4 h-4 rounded-full border border-primary group-hover:bg-primary-fixed transition-colors"></span>
                                <span class="font-body-md text-on-surface-variant group-hover:text-primary">Capsules</span>
                            </li>
                            <li class="flex items-center gap-sm cursor-pointer group">
                                <span
                                    class="w-4 h-4 rounded-full border border-primary bg-primary transition-colors"></span>
                                <span class="font-body-md text-primary font-bold">Blends</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-label-md text-label-md text-primary uppercase tracking-widest mb-md">Benefit</h3>
                        <div class="flex flex-wrap gap-xs">
                            <button
                                class="px-md py-xs rounded-full border border-outline-variant text-caption font-label-md hover:border-primary hover:text-primary transition-colors">Immunity</button>
                            <button
                                class="px-md py-xs rounded-full bg-primary text-on-primary text-caption font-label-md">Energy</button>
                            <button
                                class="px-md py-xs rounded-full border border-outline-variant text-caption font-label-md hover:border-primary hover:text-primary transition-colors">Sleep</button>
                            <button
                                class="px-md py-xs rounded-full border border-outline-variant text-caption font-label-md hover:border-primary hover:text-primary transition-colors">Detox</button>
                        </div>
                    </div>
                    <div class="hidden md:block pt-lg border-t border-surface-variant">
                        <p class="font-caption text-caption text-on-surface-variant italic leading-relaxed">
                            "Nature does not hurry, yet everything is accomplished."
                        </p>
                    </div>
                </aside>
                <!-- Product Grid -->
                <section class="flex-grow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                    <!-- Product Card 1 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="A minimalist and premium product photograph of a dark amber glass jar with a smooth, light-toned wooden lid."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaIKFYe03LjvmZCNW0i09IfZtdf2_Zft7vz8hspZ1pF6PKkKrWAfgQFhf2rOL6gITDIitFf7xDGvqaMdEmNz8LQZfhXSjei_hPYYGkUVuQjsNEs136qoAa4ssAY0IMOszOCJOFMeYA406ECkHUmICqBQDgey5GsibxntIdpM3sF0MNYLg_z-4FaygpDdc_sLy7x-or72eYYivskUe1-EWqnhVPZNj4PiyJSsBjLN0J03lQTot6LXo9At4R4aqRlL_pCMa7SuN94rTA" />
                            <span
                                class="absolute top-sm right-sm bg-tertiary-fixed text-on-tertiary-fixed px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter">Premium
                                Grade</span>
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Organic Turmeric Gold</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Pure root extract for vitality
                            and inflammation support.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 1,250</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 2 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="High-end editorial photograph of a minimalist clear glass bottle with a bamboo dropper top."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4jWTZcO4H0ryWitlKUj74HKaF81wMbbrs_k_KfXHimobJ7G5L7GRbeGwPJo3QfgDrtst9INLXHscXra6xIW9oEURpssTIWACdI5vPEqb0IQfsGDFuo5KX2JzggToMcEtqsDsGtZWzPBtoiNa8FLhjhW3cSnToIOUtqWxNfNe1GKDmLVMIXLIMKrtVRW6h3SF9TZNlmnnAjpTDJfNwTC4OHPQqKUv8-P0njEcU3_2QvIUe3u_GdowsryEjwMK5PTsKKWgyoWh62e7u" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Moringa Vitality Elixir</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Concentrated chlorophyll and
                            essential nutrients.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 850</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 3 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="A sophisticated scene showing a matte white ceramic bowl filled with dark, glossy Ashwagandha capsules."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXrLHdyRQiP6Y9ZXHC-4NAY0RypM8OswApfPYZd9f5qtPDZb0eoDZVtcgFX5EHeKHqULFban2Wyc6AFI6ggB7DJmBxXEX2akKGRG1G5bvD7MkB5juiM2j0KjEBG0APvFHByxF6oKZIinORlNC4Lc4x7ZO6O49myoGZ1UpelaDKT7RhGG7B4H2EDE08v6W6AjVYY92Z1MSLwtLJO27fMtPLLIXQEtefmr8KW0i6K3ba6z65D2jpayQJdHtQ-jsNQP2sbj0YIgTU8DU2" />
                            <span
                                class="absolute top-sm right-sm bg-secondary-fixed text-on-secondary-fixed px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter">Bestseller</span>
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Zen Root Capsules</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Premium Ashwagandha for stress
                            management.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 1,400</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 4 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="A macro photograph of an elegant glass jar filled with dark roasted coffee-like herbal powder."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxLnwCXouucOX9NsnimOyqDx9VnftvsL7jUSTPuZZywTwD81s7OfiWRlLr-fnErLqQG-Z84WiyhhXJVWAtMLUBjG8VsRQjtqqiYgldh0gffxNjNz_4K8Z8gRZZkNnm1cc6s36ZdAVyVuv7665lwwG7ZLG8TuEMyghfdTp5aYotMKjDMEghpXNGPXp7fOReZKQLIfdqsH58GirBeYiCp-ur1wDGRtzGI1cBI1EW0ih4vdh2-xrQ3OyRrmJ98Ykb_o9Ymyx-29egMMo1" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Sunrise Morning Blend</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Adaptogenic mushroom coffee
                            alternative.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 1,800</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 5 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="Artistic composition of several dried botanical elements arranged around a minimalist glass canister."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrJJV9RdSvCpi2bsvhIDx393QjZq3044mA81McMCpHKHyNCISH22eX-POaa4OdFLAUjfJPGOaJPFfnc-jtu0Rm2ydHFFwtqbLng8iWFJ70uLpz8ri9p9eVyP7c9mszfCLp6qxedU6k5Sy_hHjsUXGvcGmhh1RsIzhxX3fV3V6czEVwSSW8rDNTxUn2uQMO0pvNCvaAbPbDoJVL5hClI6fBXLJeCGZjnvKX_0gm8xeDc6_Syt4a2CFDwkPBbsFymUe8aMLSiu3q9PFK" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Immunity Shield</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">A potent mix of traditional
                            ayurvedic herbs.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 1,100</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 6 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="Close-up of a small, elegant round glass jar with a dark wooden screw-top lid containing lavender capsules."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuj-XT2SVfZjlaoOTTbBad1pYTq3vPfERDA8xlZ6XZYSthehQ62ycIK8zxg2fgulVBgo9EPMx-p8I1kgfI6CQrSZdrTRZ8YLBMMhqlkLp9ObRA84GbGzg3jiPiHjPuZZ87IyeKWAPxXaueVxcQKanBmiVapIrd20HNO_pi50bqnDOo52wH2-G0J3VMTdTscjb6_g_Om4Gd5WnPF_Zg66SPCCAgFTnRVQGaru3Rhiis5GPj7sAJ227sk_FLMWgYUMevSWSyPKGZ6Rwl" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Moonlight Slumber</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Natural magnesium and floral
                            sleep aid.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 950</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 7 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="Minimalist design showing a tall, slender glass bottle containing a bright orange-red oil."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD_M8AAUgdicMWE8N7okRAdNTjv_hN9lHPRjQKMEf7MjaiqCdfumfnb5A4HMHOGM5vADjK6l9i19mU5nfmUVOAP3rTJjZA-PSOLI5q6aYf6-OnxSR0_82qbJwRGbOU5QXAYezmrn906t6i3mFJr91dCCP7QVDW5T-NxJnUjtSmcS31l8WuX0oeJHOn6kqT76A2zTsJVjoRSc3YxvvQ6Gn-kXAu72srlMNzVqaTzoexw9ddiwehnP-Ma14EO6LPF7huVcOjba-HJ0Y5O" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">Sea Buckthorn Oil</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">Antioxidant rich nectar for skin
                            and gut health.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 2,200</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                    <!-- Product Card 8 -->
                    <div class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group">
                        <div class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                            <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                data-alt="A clean product shot of three identical glass jars with wooden lids arranged in a staggered line."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCTkNN71O4eV6Ug9HduZmO3O0vHW9wsymhWPBwOxTYA2Z7_K3xt8tmBqKMxg44lYAUjXtCBU9XfJK1nc3LFnAxHaflg4laS2bCcnGMxyTHXquR_ZvId6JT_VVoCOpKvJcw0sPJPSyddQB1bmQKxl67PmubgibJyyYaKc4p19sJ2_BrmlaZR4vjj5VU-CEGLjz-a4kcGv-5tkrdOdd6Xi46u1PyVuq0Zh3CFz5Jqqq7V-Z3B0wteZVDLrzCBxcDAV_7cXqQjEPYLAVdt" />
                        </div>
                        <h2 class="font-cormorant text-headline-md text-on-surface mb-xs">The Triple Harmony Kit</h2>
                        <p class="font-caption text-caption text-on-surface-variant mb-md">A curated set for comprehensive
                            daily wellness.</p>
                        <div class="mt-auto flex justify-between items-end">
                            <span class="font-label-md text-primary text-lg">৳ 3,200</span>
                            <button
                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                <span class="font-label-md">Add</span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </x-slot>

    @push('scripts')
        <script>
            // Micro-interactions for product cards
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    const btn = card.querySelector('button');
                    btn.classList.add('shadow-lg');
                });
                card.addEventListener('mouseleave', () => {
                    const btn = card.querySelector('button');
                    btn.classList.remove('shadow-lg');
                });
            });

            // Toggle mobile category logic
            const filterBtns = document.querySelectorAll('button[class*="rounded-full"]');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.classList.contains('bg-primary')) {
                        btn.classList.remove('bg-primary', 'text-on-primary');
                        btn.classList.add('border', 'border-outline-variant', 'text-on-surface-variant');
                    } else {
                        btn.classList.add('bg-primary', 'text-on-primary');
                        btn.classList.remove('border', 'border-outline-variant', 'text-on-surface-variant');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
