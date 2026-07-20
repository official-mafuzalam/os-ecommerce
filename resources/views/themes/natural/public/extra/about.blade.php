<x-app-layout>
    @section('title', 'About Us - ' . setting('site_name', 'OS Ecommerce'))

    @push('styles')
        <style>
            .glass-panel {
                backdrop-filter: blur(12px);
                background: rgba(255, 255, 255, 0.7);
            }

            .botanical-overlay {
                mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
                opacity: 0.08;
                pointer-events: none;
            }

            .timeline-line::before {
                content: '';
                position: absolute;
                left: 50%;
                top: 0;
                bottom: 0;
                width: 1px;
                background: linear-gradient(to bottom, transparent, #707971 20%, #707971 80%, transparent);
                transform: translateX(-50%);
            }
        </style>
    @endpush

    <x-slot name="main">
        <!-- Section 1: Hero Section -->
        <section class="relative h-[870px] w-full flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="w-full h-full bg-cover bg-center scale-105"
                    data-alt="A cinematic, wide-angle shot of a lush, mist-covered organic tea garden at sunrise in rural Bangladesh. The morning light filters through vibrant green leaves, creating a soft, golden ethereal glow. The composition is clean and minimalist, emphasizing the vast, serene natural landscape. Deep forest greens and warm sunlight tones dominate the palette, evoking a sense of pure, premium wellness and tranquility."
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBEZbVvFWgURHBN71_sMDAVjGh-vki1q0TEv3-X9mR1oV3_TKxovSCwLCgZCs0Z0M8y4E03hLC8qMTCD7jfr3iX-PAmV9RPrYmlbJz3SFJCxwKumwyURgF_GGkrRZZ8tKcywX7bU5csXFe8e_9jZAhzQQVD5jZiO8jBlSSL031XYrrzhDws4hO7w_BD_gTcl_FggUvXP-Y0a-qNmbE0yz_ppFxHru9htwqfgCL4atyHI5ZG2M-oaNfOPeatS8aAt8IR1m-C6rWq5u8y')">
                </div>
                <div class="absolute inset-0 bg-black/30"></div>
            </div>
            <div class="relative z-10 text-center px-margin-mobile">
                <h1
                    class="font-display-lg text-display-lg-mobile md:text-display-lg text-surface-container-lowest drop-shadow-lg max-w-4xl mx-auto">
                    Rooted in Nature, <br /> <span class="italic">Crafted for Vitality</span>
                </h1>
                <p class="font-body-lg text-body-lg text-surface-container-lowest mt-md max-w-xl mx-auto opacity-90">
                    A journey of honoring ancestral wisdom and bringing the purest gifts of the earth to your modern
                    lifestyle.
                </p>
            </div>
        </section>
        <!-- Section 2: Brand Story -->
        <section class="py-xl max-w-container-max mx-auto px-margin-desktop overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-xl items-center">
                <div class="md:col-span-5 relative group">
                    <div class="aspect-[4/5] rounded-[32px] overflow-hidden shadow-xl">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="An elegant, vintage-inspired portrait of a traditional apothecary shelf filled with amber glass bottles, hand-tied bundles of dried medicinal herbs, and polished brass mortars. The lighting is moody and artisanal, highlighting the textures of wood and parchment. The aesthetic is luxurious and deeply rooted in historical wellness traditions, using a color palette of deep greens and rich wood tones."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfQHaxrHMgyp2AKx6Zum-4h7jB5-X3rP8sSgKPr1W47GZn_a89MCeiZT4GtLBR0CztTw6HZyCc4VJeYZbvrdOGGn1DI8mvxCY3AGe_Q9BdIOgy5yys3ixQuQVz6uOXIfZQiQkeUWMeaYg-mamG0S_csMUUVfOyiFBrietE8DGGhcRhV4yo75wZwlAuoNGTO9Tcs5sBJv8N4Oi_ewts_4YdmYTZkPiAjLXE2qfgIk0BGnCb8RO8M9Q6nRY1gYsxdsrqvZNvkRkSxEmD" />
                    </div>
                    <div
                        class="absolute -bottom-base -right-base md:-bottom-md md:-right-md w-32 h-32 md:w-48 md:h-48 border border-tertiary-fixed-dim rounded-full botanical-overlay">
                    </div>
                </div>
                <div class="md:col-span-7">
                    <span class="font-label-md text-label-md text-tertiary tracking-widest block mb-base uppercase">Our
                        Heritage</span>
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-md">The Essence of OS Ecommerce</h2>
                    <div class="space-y-md font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        <p>
                            OS Ecommerce was born from a singular realization: the profound healing power of our
                            ancestors' traditions was being lost in the noise of the modern world. Our name, meaning
                            "The Nectar of Nature," reflects our dedication to preserving the purity and potency of
                            botanical wisdom.
                        </p>
                        <p>
                            Founded in the heart of Bangladesh, we began as a small collective of herbalists and
                            researchers driven by a passion for ethical sourcing and traditional extraction methods. We
                            believe that true wellness isn't found in synthetic alternatives, but in the intelligent
                            synergy of natural elements that have supported human vitality for millennia.
                        </p>
                        <p class="font-serif italic text-lg text-primary">
                            "We don't just create products; we curate the bridge between the forest and your home."
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 3: Mission & Vision -->
        <section class="bg-surface-container py-xl relative">
            <div
                class="max-w-container-max mx-auto px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-gutter relative z-10">
                <!-- Mission Card -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-[24px] shadow-sm flex flex-col items-center text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div
                        class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container mb-md">
                        <span class="material-symbols-outlined text-4xl" data-icon="eco">eco</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-primary mb-sm">Our Mission</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        To empower individuals with high-grade, bio-active natural supplements that restore balance and
                        vitality through sustainable and ethical practices.
                    </p>
                </div>
                <!-- Vision Card -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-[24px] shadow-sm flex flex-col items-center text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div
                        class="w-16 h-16 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed mb-md">
                        <span class="material-symbols-outlined text-4xl" data-icon="landscape">landscape</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-primary mb-sm">Our Vision</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        To become the global gold standard for natural wellness, where ancient wisdom meets modern
                        science to create a more vibrant, healthy planet.
                    </p>
                </div>
            </div>
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[200px] text-primary"
                    data-icon="nest_eco_leaf">nest_eco_leaf</span>
            </div>
        </section>
        <!-- Section 4: Our Values -->
        <section class="py-xl max-w-container-max mx-auto px-margin-desktop">
            <div class="text-center mb-xl">
                <h2 class="font-headline-lg text-headline-lg text-primary">Living Our Values</h2>
                <div class="w-20 h-1 bg-tertiary-fixed-dim mx-auto mt-base rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
                <!-- Value 1: Purity -->
                <div class="text-center p-md group">
                    <div class="text-primary mb-base transition-transform duration-300 group-hover:scale-110">
                        <span class="material-symbols-outlined text-4xl" data-icon="verified">verified</span>
                    </div>
                    <h4 class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-xs">
                        Purity</h4>
                    <p class="font-caption text-caption text-on-surface-variant">100% organic, lab-tested ingredients
                        free from any synthetics.</p>
                </div>
                <!-- Value 2: Integrity -->
                <div class="text-center p-md group">
                    <div class="text-primary mb-base transition-transform duration-300 group-hover:scale-110">
                        <span class="material-symbols-outlined text-4xl" data-icon="balance">balance</span>
                    </div>
                    <h4 class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-xs">
                        Integrity</h4>
                    <p class="font-caption text-caption text-on-surface-variant">Honesty in every bottle, from sourcing
                        origins to therapeutic claims.</p>
                </div>
                <!-- Value 3: Community -->
                <div class="text-center p-md group">
                    <div class="text-primary mb-base transition-transform duration-300 group-hover:scale-110">
                        <span class="material-symbols-outlined text-4xl" data-icon="groups">groups</span>
                    </div>
                    <h4 class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-xs">
                        Community</h4>
                    <p class="font-caption text-caption text-on-surface-variant">Supporting local farmers and
                        cooperatives with fair wages.</p>
                </div>
                <!-- Value 4: Sustainability -->
                <div class="text-center p-md group">
                    <div class="text-primary mb-base transition-transform duration-300 group-hover:scale-110">
                        <span class="material-symbols-outlined text-4xl" data-icon="forest">forest</span>
                    </div>
                    <h4 class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-xs">
                        Sustainability</h4>
                    <p class="font-caption text-caption text-on-surface-variant">Zero-waste packaging and regenerative
                        farming methods.</p>
                </div>
            </div>
        </section>
        <!-- Section 5: Quality Commitment & Natural Ingredients -->
        <section class="py-xl bg-surface-container-lowest">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center mb-xl">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Our Purity Promise</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-md">
                            We don't just follow standards; we set them. Each ingredient in our collection is
                            meticulously vetted for potency and purity.
                        </p>
                        <ul class="space-y-sm">
                            <li class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary"
                                    data-icon="check_circle">check_circle</span>
                                <span class="font-body-md">Cold-pressed extraction to retain nutrients</span>
                            </li>
                            <li class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary"
                                    data-icon="check_circle">check_circle</span>
                                <span class="font-body-md">Third-party laboratory certification for every batch</span>
                            </li>
                            <li class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary"
                                    data-icon="check_circle">check_circle</span>
                                <span class="font-body-md">Direct farm-to-bottle traceability</span>
                            </li>
                        </ul>
                    </div>
                    <div class="relative rounded-[24px] overflow-hidden shadow-2xl">
                        <img class="w-full h-full object-cover"
                            data-alt="A clean, minimalist high-key photograph of fresh green Moringa leaves, raw golden honeycomb, and bright green Neem twigs arranged on a light cream marble surface. The lighting is bright and airy, emphasizing the natural colors and textures of the ingredients. The composition is artistic and premium, looking like an editorial piece for a luxury wellness magazine, dominated by shades of cream, green, and gold."
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC38lok6QvA1uayNfKtVQaQ1ASh3EB0f2y74g9srJzr3DNTZpYJjAXFMIyiqqoku_ElMKm1l4gNdTwGd_nshZrBEYWyjNwtJCRcZQd9UZQap0X3izCOVVIwB_L5rnQKTyVXr7Y3TTtlCPb2Z-XiJip1qct9WKR9XdBo5l5brMnwUt0GV6rj234vDXO1OFQdmLIBdlp3GrAFNfKqlxhRQrP4I3MW9GLYgJUVlt69_tUAiE57s2spUuNrrJ6BNIIwgl6qVNYX2d2v4Bn5" />
                    </div>
                </div>
                <!-- Ingredient Bento Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mt-lg">
                    <!-- Moringa -->
                    <div class="bg-surface-container p-lg rounded-[24px] flex flex-col items-center text-center">
                        <div class="w-32 h-32 mb-md rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                data-alt="Macro close-up of vibrant green Moringa oleifera leaves with soft water droplets, shot in a minimalist botanical style. The lighting is soft and diffused, highlighting the delicate veins of the leaves. Colors are rich forest greens against a soft warm cream background."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDh5t_kzdIk5yMpeL9pGAO5x_PW_RIhZAaE3OcVYoGtitX8u_ovwN50WOmo3HsFMnvuRUW7enk_D2KLkbdWR86F6BxKaExYW_QYFTMQ1K-IvektiIUWcQVY_GlW9YLccWjqAxo7OwKpN4WSNegFAlJ69LIW8ACYWfQ9JPiNbBa7Ku81JQG-RkJFgWnBGDQg3dHBqNyvv-hPQArJX_RhCroy6d0mR7pekcC-Ls9W3M6m6PWCz9M8K92JEHyZvC4p4TVIW722tXz1pDIJ" />
                        </div>
                        <h5 class="font-headline-md text-headline-md text-primary mb-xs">Moringa</h5>
                        <p class="font-caption text-caption">The miracle tree, rich in 90+ nutrients.</p>
                    </div>
                    <!-- Honey -->
                    <div class="bg-surface-container p-lg rounded-[24px] flex flex-col items-center text-center">
                        <div class="w-32 h-32 mb-md rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                data-alt="Golden, viscous raw honey dripping slowly from a wooden dipper, illuminated by warm sunlight. The lighting creates a glowing, translucent effect. The style is premium and tactile, emphasizing the purity and organic texture of the honey."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeG4WynZ2xL0glCcEBsg-KRO8Ik2QgS0R2ZW9E_omqLyAGDgLtEaiar4sH4K2qr4-uuS9PfbYIUQ9yxEzgJIJxrKPoJA2X7TXjHd_80wZHp6dW_rzs1B5GN5z7zxDLNBRHsz0C2F9Ekf2fKsuzeaWfZoqJPvFH6X8674FucgmUa9QpKBr6erV1jKrnSJYsJ1-w-pVkchEpMzrwqblBGXrMlwysKgfqxoELEN_Zd5CR2EA6fTV_v3ITzXct4kYewRV1OT7CPlGyNLTI" />
                        </div>
                        <h5 class="font-headline-md text-headline-md text-primary mb-xs">Raw Honey</h5>
                        <p class="font-caption text-caption">Directly harvested, enzyme-rich nectar.</p>
                    </div>
                    <!-- Neem -->
                    <div class="bg-surface-container p-lg rounded-[24px] flex flex-col items-center text-center">
                        <div class="w-32 h-32 mb-md rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                data-alt="Artistic arrangement of fresh Neem leaves and twigs on a rustic wooden tray. The aesthetic is apothecary-chic, with soft shadows and a focused depth of field. The palette is a mix of deep olives and warm earth tones."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpNznk5T5rKLa6qIpEBabhKeeyvLLS5fDWevKfo-uYtW4suahAoFPTbU0xm-0s2V5AA4R5ZZAGdfJ3z3g6cB2zrX_q2iNTcrdHPnbcd4BSoMs1kd5SyuqGtPhF-55T1NVj0Xyv8A-UhUZmXL03lu7081pcaeeWOePX1Hg3mVEUGpLBRTQG5wlZHhPoh4r6NUOxVCx9bYnml2WJEh6uCFFUsLLpINJJstWsJXPRXAtPKTiITLahX7fCc-YTz1oH7aHq4vPpg9gm5EaE" />
                        </div>
                        <h5 class="font-headline-md text-headline-md text-primary mb-xs">Neem</h5>
                        <p class="font-caption text-caption">Nature's ultimate purifier for skin and blood.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 6: Timeline (Our Milestones) -->
        <section class="py-xl max-w-container-max mx-auto px-margin-desktop overflow-hidden">
            <div class="text-center mb-xl">
                <h2 class="font-headline-lg text-headline-lg text-primary">Our Milestones</h2>
            </div>
            <div class="relative timeline-line">
                <!-- 2020 -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-xl relative z-10">
                    <div class="md:w-[45%] text-center md:text-right">
                        <h4 class="font-headline-md text-headline-md text-primary">2020</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">The Vision Begins: OS Ecommerce
                            founded in a small lab with 3 botanists.</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-primary flex items-center justify-center my-base md:my-0 shadow-lg border-4 border-surface">
                        <span class="material-symbols-outlined text-surface text-xl"
                            data-icon="history_edu">history_edu</span>
                    </div>
                    <div class="md:w-[45%]"></div>
                </div>
                <!-- 2021 -->
                <div class="flex flex-col md:flex-row-reverse items-center justify-between mb-xl relative z-10">
                    <div class="md:w-[45%] text-center md:text-left">
                        <h4 class="font-headline-md text-headline-md text-primary">2021</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">First Harvest: Partnered with 10
                            organic farms for sustainable sourcing.</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center my-base md:my-0 shadow-lg border-4 border-surface">
                        <span class="material-symbols-outlined text-surface text-xl"
                            data-icon="agriculture">agriculture</span>
                    </div>
                    <div class="md:w-[45%]"></div>
                </div>
                <!-- 2022 -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-xl relative z-10">
                    <div class="md:w-[45%] text-center md:text-right">
                        <h4 class="font-headline-md text-headline-md text-primary">2022</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">Expansion: Launched our signature
                            Moringa collection globally.</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-primary flex items-center justify-center my-base md:my-0 shadow-lg border-4 border-surface">
                        <span class="material-symbols-outlined text-surface text-xl" data-icon="public">public</span>
                    </div>
                    <div class="md:w-[45%]"></div>
                </div>
                <!-- 2024 -->
                <div class="flex flex-col md:flex-row-reverse items-center justify-between relative z-10">
                    <div class="md:w-[45%] text-center md:text-left">
                        <h4 class="font-headline-md text-headline-md text-primary">2024</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">Modern Wellness: Introducing
                            AI-driven health guides for personalized vitality.</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center my-base md:my-0 shadow-lg border-4 border-surface">
                        <span class="material-symbols-outlined text-surface text-xl" data-icon="bolt">bolt</span>
                    </div>
                    <div class="md:w-[45%]"></div>
                </div>
            </div>
        </section>
        <!-- Section 7: Meet the Founder/Brand -->
        <section class="py-xl bg-surface-container-high">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl items-center">
                    <div class="lg:col-span-4">
                        <div class="aspect-square rounded-full overflow-hidden border-8 border-surface shadow-2xl">
                            <img class="w-full h-full object-cover"
                                data-alt="A professional and warm portrait of a mid-40s female founder with an approachable and wise expression. She is wearing elegant, minimalist linen clothing in a soft cream tone. The background is a blurred conservatory with many green plants. The lighting is soft and natural. The overall mood is one of trust, experience, and serenity."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzLsmWXX9Oq9irBoKKIt-l3VGT5o_8DjViUTwkrnSYhx586w2Q6YSRNIQIrVnJH-V62lgwcYnyfSc5gvEl80VCY8Ug4OaFLf4-jXG-jY76r83PrUQmKG_dZKfZtgWaOYk391KPGnrSPyUIuhXZceFODw32eEhcnyDga1S3Rh_jXdaQJ-BBilyqhO65YegVUaL1bn5ooOeWCGhpqTcsOqzAOcoONMWCRGkwyFajwifEQRt5WeilGOdNBGvrVw9VIhMGRZP8XGGpx2SF" />
                        </div>
                    </div>
                    <div class="lg:col-span-8">
                        <span class="material-symbols-outlined text-6xl text-primary/20 mb-md"
                            data-icon="format_quote">format_quote</span>
                        <blockquote class="font-headline-md text-headline-md italic text-primary leading-tight mb-md">
                            "We believe that everyone deserves the pure, untainted strength that nature provides.
                            OS Ecommerce isn't just a business; it's our promise to return to a life of vitality, where
                            every breath and every choice is rooted in purity."
                        </blockquote>
                        <div class="mt-md">
                            <p class="font-label-md text-label-md text-primary font-bold uppercase tracking-[0.2em]">
                                Tahmida Jaman</p>
                            <p class="font-caption text-caption text-on-surface-variant">Founder &amp; Chief Botanical
                                Officer</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 8: Call to Action -->
        <section class="py-xl relative overflow-hidden bg-primary text-surface-container-lowest">
            <div class="absolute inset-0 opacity-10">

            </div>
            <div class="max-w-container-max mx-auto px-margin-desktop text-center relative z-10">
                <h2 class="font-display-lg text-display-lg-mobile md:text-headline-lg mb-md">Begin Your Journey to
                    Vitality</h2>
                <p class="font-body-lg text-body-lg mb-lg max-w-2xl mx-auto opacity-80">
                    Join the Vitality Circle and receive exclusive access to our newest harvests, health guides, and
                    ancestral wisdom.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-md">
                    <button
                        class="bg-surface-container-lowest text-primary px-xl py-4 rounded-full font-label-md text-label-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        Shop the Collections
                    </button>
                    <button
                        class="border border-surface-container-lowest/40 text-surface-container-lowest px-xl py-4 rounded-full font-label-md text-label-md hover:bg-surface-container-lowest/10 transition-all duration-300 active:scale-95">
                        Join the Circle
                    </button>
                </div>
            </div>
        </section>
    </x-slot>

    @push('scripts')
        <script>
            // Simple scroll animation for revealing sections
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section').forEach(section => {
                section.classList.add('transition-all', 'duration-700', 'ease-out', 'opacity-0', 'translate-y-8');
                observer.observe(section);
            });
        </script>
    @endpush
</x-app-layout>
