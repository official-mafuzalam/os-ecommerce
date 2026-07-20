<x-app-layout>
    @section('title', setting('site_name', 'Prokiti Sudha') . ' | Nature\'s Purest Essence')
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
                    <button
                        class="bg-primary text-white px-xl py-base h-[56px] rounded-full font-label-md text-label-md hover:bg-primary-container transition-all duration-300 active:scale-95 shadow-lg shadow-primary/10">
                        Explore the Collection
                    </button>
                </div>
                <div class="lg:col-span-6 relative mt-xl lg:mt-0">
                    <div class="relative w-full aspect-square max-w-[600px] mx-auto">
                        <!-- Decorative Botanical Background -->
                        <div
                            class="absolute -top-10 -right-10 w-full h-full bg-secondary-container/20 rounded-full blur-3xl -z-10">
                        </div>
                        <!-- Main Hero Image with Organic Masking -->
                        <div class="w-full h-full overflow-hidden organic-shape shadow-2xl">
                            <img class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700"
                                data-alt="A top-down premium photography shot of a golden turmeric latte served in a minimalist, hand-crafted ceramic bowl. The scene is styled with fresh, vibrant green botanical leaves and scattered raw turmeric roots on a warm, cream-colored textured stone surface. The lighting is soft and ethereal, capturing the creamy texture of the latte and the golden glow of the turmeric in a luxurious, editorial aesthetic."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbWrds_KT3YCmlhSGLOzs3P5DEqXoY3DXYYjCwVc7KXFIVSSa91lOgJmaWb-io8ZR3F6fxvGq9iS6URaCLHyzKRA-4-XJA4RYn4JqVp5ireOIdv3FnbwKAGJ4Y-kGPb_byr6IXNOwJbcfrCdPPzKW-43y1c2nEajwwTZM_2bN3e992xgrzGGYFMqADfBKkYO-OpQ6Zno9ndkvUUL1kmBOUIpzFN9StLFsUahOgs5_UAu3ulPNVWoMpWb3sDdEYPYm9gRjK5eWYNx8b" />
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
        <!-- Featured Superfoods Bento Grid -->
        <section class="py-xl px-margin-desktop max-w-container-max mx-auto">
            <div class="flex justify-between items-end mb-xl">
                <div class="max-w-[480px]">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Featured Superfoods</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Carefully selected adaptogens and
                        minerals from the heart of nature, processed with artisanal precision to preserve their vital
                        force.</p>
                </div>
                <a class="hidden md:flex items-center gap-xs font-label-md text-primary hover:gap-base transition-all"
                    href="#">
                    View All <span class="material-symbols-outlined">arrow_right_alt</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <!-- Card 1: Moringa -->
                <div class="group bg-white rounded-2xl overflow-hidden hover-lift p-base">
                    <div class="relative aspect-[4/5] rounded-xl overflow-hidden mb-md">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            data-alt="Close-up macro photography of bright green Moringa powder being scooped with a minimalist wooden spoon. The background is a clean, warm cream studio setting with soft directional light that highlights the fine texture of the organic powder. The overall mood is fresh, energetic, and clinical yet artisanal."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAn8pFTMfbVFajLE94dRv8cfnqPdMk0DR8AXGMZr6OjjG4Otwg-VIpsFiHuJiSCjGPds47Io6gcqLx3Ddr1edkYEK7CdRhF-GFEWkE2OkMRnsGoaFB7760qbEXmVwXSPNEXHGIDY1CEqJFAsJF3K8FzBwbdRt9LS-QYrgAPAlmWfEJp7AN2GxpFVq3R5o9NlfD2xYvfcx8AyV1Dvts3K2SK3sgSUYAzYajNfMW3ekeUjmfarEAWSzcpxaocvyWCmvqUl0Ec_Z8aMl1x" />
                        <div
                            class="absolute top-md right-md bg-secondary text-white px-sm py-xs rounded-full font-label-md text-caption">
                            Revitalizing</div>
                    </div>
                    <div class="px-sm pb-md">
                        <h3 class="font-headline-md text-[24px] text-primary mb-xs">Moringa</h3>
                        <p class="font-body-md text-on-surface-variant text-sm mb-md leading-relaxed">The miracle leaf
                            of Bengal, packed with 90+ nutrients for sustained energy.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-label-md text-primary">$32.00</span>
                            <button
                                class="material-symbols-outlined text-primary border border-primary/20 rounded-full p-xs hover:bg-primary hover:text-white transition-colors">add</button>
                        </div>
                    </div>
                </div>
                <!-- Card 2: Turmeric -->
                <div class="group bg-white rounded-2xl overflow-hidden hover-lift p-base mt-lg md:mt-0">
                    <div class="relative aspect-[4/5] rounded-xl overflow-hidden mb-md">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            data-alt="Minimalist product shot of a premium glass jar containing golden Turmeric Curcumin capsules, set against a soft beige background. A few raw, earthy turmeric roots lie artistically beside the jar. The lighting is high-key and sophisticated, emphasizing the purity and pharmaceutical grade of the wellness supplement."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAWgSeTghzOCbW5llEm2ywZfVzTuC7qOXz6BlA0OF6gg3padckbjM3xp7ZkBgbrpYRXk9mkQ9dupbDaHcLUpNJTWSV1iF0SptIqigTZVT5DXu_gCX3qmVq3cuKbJdpWz0SKfgxoKO63qrir1woOkF6cwrD9e39nb2IJG52BQzIbQRef3olIP1Rsrdqe8FP9t5cK_tpxaeYoatHg4DwUVkk5Nv9XjHJ360E0fbq8ymvmpBGyJWEHji3eGPEQrDwLqd0SO3Op9iCpclK" />
                        <div
                            class="absolute top-md right-md bg-tertiary text-white px-sm py-xs rounded-full font-label-md text-caption">
                            Anti-Inflammatory</div>
                    </div>
                    <div class="px-sm pb-md">
                        <h3 class="font-headline-md text-[24px] text-primary mb-xs">Turmeric</h3>
                        <p class="font-body-md text-on-surface-variant text-sm mb-md leading-relaxed">High-curcumin
                            heritage variety sourced from organic mountain farms.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-label-md text-primary">$28.00</span>
                            <button
                                class="material-symbols-outlined text-primary border border-primary/20 rounded-full p-xs hover:bg-primary hover:text-white transition-colors">add</button>
                        </div>
                    </div>
                </div>
                <!-- Card 3: Ashwagandha -->
                <div class="group bg-white rounded-2xl overflow-hidden hover-lift p-base mt-lg md:mt-0">
                    <div class="relative aspect-[4/5] rounded-xl overflow-hidden mb-md">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            data-alt="Serene lifestyle photography of a glass of warm milk with Ashwagandha extract on a rustic wooden table next to a window. Soft morning sunlight filters through, creating long shadows and a calm, restorative atmosphere. The focus is sharp on the botanical details of the dried roots beside the glass."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA46Ju5_E1WsODKjQETJ8fKhsszX5u-10kUZPJOL_yWiXC6mgRp4h1ClTr0lzUlmFdyjkuDTMfmp4PCb-PrF8wzYzMhXjt1SQUg6Dhk-ES_NekmDkOqcyxGn5SzdFB3qc8HZaXYK9e4CN36calLGsvYrMPmvUFXnEBuoxsg3rBe-3nhIHMhiO5D9zh-fQFwDcEuZm3OPJ-_Pn9Cy1MIx-nZ3uuQ0s7o8KGG06ZtXIQIG-nqCKIDLnD6ElCrMk07doqLkascU1BKSRbX" />
                        <div
                            class="absolute top-md right-md bg-secondary text-white px-sm py-xs rounded-full font-label-md text-caption">
                            Balance</div>
                    </div>
                    <div class="px-sm pb-md">
                        <h3 class="font-headline-md text-[24px] text-primary mb-xs">Ashwagandha</h3>
                        <p class="font-body-md text-on-surface-variant text-sm mb-md leading-relaxed">Potent adaptogenic
                            root to help your body manage stress and find calm.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-label-md text-primary">$45.00</span>
                            <button
                                class="material-symbols-outlined text-primary border border-primary/20 rounded-full p-xs hover:bg-primary hover:text-white transition-colors">add</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Our Botanical Philosophy -->
        <section class="bg-surface-container-low py-xl overflow-hidden">
            <div class="px-margin-desktop max-w-container-max mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
                    <div class="order-2 lg:order-1">
                        <div class="relative inline-block">
                            <img class="w-full max-w-[500px] h-auto drop-shadow-sm"
                                data-alt="An elegant, minimalist botanical line art illustration of a Banyan leaf and traditional mortar and pestle, rendered in a sophisticated gold metallic finish. The illustration is placed on a clean white space with subtle shadows, conveying a sense of heritage, wisdom, and artisanal health practices."
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
                            Prokiti Sudha is more than a brand; it is a bridge between the lush, fertile lands of
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
                        <button
                            class="border-2 border-primary text-primary px-lg py-base rounded-full font-label-md text-label-md hover:bg-primary hover:text-white transition-all duration-300">
                            Learn Our Story
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <!-- The Vitality Journal (Blog) -->
        <section class="py-xl px-margin-desktop max-w-container-max mx-auto">
            <div class="text-center mb-xl">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-md">The Vitality Journal</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-[600px] mx-auto">Rituals, recipes,
                    and insights for an intentional life.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
                <!-- Blog Post 1 -->
                <article class="group cursor-pointer">
                    <div class="overflow-hidden rounded-2xl mb-md aspect-[16/9]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            data-alt="High-end editorial lifestyle photography of a person’s hands holding a warm ceramic mug in a cozy, sunlit room filled with indoor plants. The atmosphere is peaceful and mindful. The lighting is soft and golden, highlighting the steam rising from the cup. The color palette is composed of soft greens, warm creams, and earthy wood tones."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBVjtaIBp1zPvFORvd5xUbpD8C7Sznvvso9P_d4yCx1hSKc3mgTyVGz8Ns8NDVoIJJQuxK9rZUUBsWEZZFdZTIlI5IuqcUfhprDurKdSlPplFLVPyLoVTqQ6_3WxzkTMzlzpHlh-TKWcvq_s7z0iR_ZPm7lRmt-VOq_3ASDr6YXAWUM17sjXj6Jq7jDjYb4dE_gnR-kI9uNQRhxEtBNUB6hUuEVWdyW8T8QE7rCKdWFJJp-kLuGW0W5ofBsbeEc8o7c1jiaODN9vEG" />
                    </div>
                    <span class="font-label-md text-caption text-secondary mb-xs block">Rituals</span>
                    <h3
                        class="font-headline-md text-[20px] text-primary mb-sm leading-snug group-hover:text-secondary transition-colors">
                        The Art of the Morning Elixir: Starting Your Day with Intention</h3>
                    <p class="font-body-md text-on-surface-variant text-sm line-clamp-2">How a 5-minute morning ritual
                        can reset your nervous system and prepare you for a day of focus...</p>
                </article>
                <!-- Blog Post 2 -->
                <article class="group cursor-pointer">
                    <div class="overflow-hidden rounded-2xl mb-md aspect-[16/9]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            data-alt="A beautifully arranged flat lay of raw ingredients like turmeric roots, black peppercorns, ginger, and honey on a dark, artisanal slate board. The lighting is moody and dramatic, focusing on the textures and vibrant colors of the natural ingredients. The style is reminiscent of a high-end gourmet culinary magazine."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0DGs2WsEHq12GDOsaD0HXWbnWoqL0bJuVe10j_BQVzsbB0MNJwwwxvi4G-eW65xLm9ojUYQnivtxd4QWPlUi52TSToaKRNJqYCC9L_2us9O2BRp5OTonFShe06GNXbB196v-J32qHaCRQS1XfFYxEaKyo2XF4zpULK_XMfiKkh2XvhFLwZDN01R95yhlf_iTOpduTpsxRTXphfPgSmsbrafLPiwG5ZyP9iJYaZYH0H69WPQbJhDAowwfsMqxdiJ3Hy2cAQ7rFN-Ce" />
                    </div>
                    <span class="font-label-md text-caption text-secondary mb-xs block">Science</span>
                    <h3
                        class="font-headline-md text-[20px] text-primary mb-sm leading-snug group-hover:text-secondary transition-colors">
                        Understanding Bioavailability: Why Black Pepper Matters</h3>
                    <p class="font-body-md text-on-surface-variant text-sm line-clamp-2">Exploring the synergistic
                        relationship between curcumin and piperine for maximum absorption...</p>
                </article>
                <!-- Blog Post 3 -->
                <article class="group cursor-pointer">
                    <div class="overflow-hidden rounded-2xl mb-md aspect-[16/9]">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            data-alt="A wide-angle landscape shot of a lush, mist-covered organic farm in the hills of Bangladesh during sunrise. The terraced fields are a vibrant green, with dew drops visible on the leaves in the foreground. The sky is a soft palette of orange and pink. The overall feeling is one of purity, peace, and natural abundance."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7b8VQ9DGPNwz1Mm9KPRtWVii_SbgyN5abBGy-BPJ-jKj2YWxjPewZT7FqseoadMhjHwWnBvp0KYaedaEH-3M2aJz1zy7J6Q3xW_b5l5tQQYwUmyn7k75hmGXueNp-bQGQzMwwDDRg9c7tJWYEcFIVY76-op7pgv0N6kfBXY_NYu1p8j4PjldxIRtThdOxnftyFrYkLcoaS-qvRqW6zxz982gNUt4Q1FMtjI-NLD-UwN2YZgwRv-VZqFrNQSrd2JNL5PS89jtCxCsT" />
                    </div>
                    <span class="font-label-md text-caption text-secondary mb-xs block">Heritage</span>
                    <h3
                        class="font-headline-md text-[20px] text-primary mb-sm leading-snug group-hover:text-secondary transition-colors">
                        Sourcing from the Source: Our Journey to the Sylhet Tea Gardens</h3>
                    <p class="font-body-md text-on-surface-variant text-sm line-clamp-2">A behind-the-scenes look at
                        our commitment to sustainable farming and community development...</p>
                </article>
            </div>
        </section>
        <!-- Newsletter / CTA -->
        <section class="py-xl px-margin-desktop">
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
                    <form class="flex flex-col md:flex-row gap-base max-w-md mx-auto">
                        <input
                            class="flex-grow bg-white/10 border-white/20 text-white placeholder:text-white/50 rounded-full px-md py-base focus:ring-2 focus:ring-tertiary-fixed-dim focus:border-transparent transition-all outline-none"
                            placeholder="Your email address" type="email" />
                        <button
                            class="bg-tertiary-fixed-dim text-primary font-label-md px-lg py-base rounded-full hover:bg-white transition-colors duration-300">Subscribe</button>
                    </form>
                </div>
            </div>
        </section>
        </main>
        @push('scripts')
            <script>
                // Simple scroll effect for header
                window.addEventListener('scroll', () => {
                    const nav = document.querySelector('nav');
                    if (window.scrollY > 50) {
                        nav.classList.add('h-16', 'shadow-md');
                        nav.classList.remove('h-20', 'shadow-sm');
                    } else {
                        nav.classList.add('h-20', 'shadow-sm');
                        nav.classList.remove('h-16', 'shadow-md');
                    }
                });

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
    </x-slot>
</x-app-layout>
