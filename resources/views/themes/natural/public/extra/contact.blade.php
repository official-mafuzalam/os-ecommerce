<x-app-layout>
    @section('title', 'Contact Us | ' . setting('site_name', 'Prokiti Sudha'))

    @push('styles')
        <style>
            .bento-card {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            }

            .bento-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 30px 60px -12px rgba(0, 69, 37, 0.08);
            }

            .map-overlay {
                background: linear-gradient(180deg, rgba(252, 249, 242, 0.4) 0%, rgba(252, 249, 242, 0.1) 100%);
                pointer-events: none;
            }

            .accordion-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out, padding 0.3s ease;
            }

            .accordion-item.active .accordion-content {
                max-height: 500px;
                padding-top: 16px;
            }

            .accordion-item.active .icon-rotate {
                transform: rotate(180deg);
            }
        </style>
    @endpush

    <x-slot name="main">
        <main class="pt-8 md:pt-16 pb-xl">
            <!-- Hero Section -->
            <section class="px-margin-desktop max-w-container-max mx-auto mb-xl">
                <div class="max-w-3xl">
                    <span class="font-label-md text-label-md text-secondary tracking-widest uppercase mb-base block">Get
                        In
                        Touch</span>
                    <h1 class="font-display-lg text-display-lg text-primary mb-md leading-tight">Connect with <br /><span
                            class="italic text-tertiary-container">Nature's Wisdom</span></h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        Whether you're seeking guidance on your wellness journey or have questions about our organic
                        blends,
                        our team is here to support your path to vitality.
                    </p>
                </div>
            </section>

            <!-- Main Contact Grid -->
            <section
                class="px-margin-desktop max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-xl items-start mb-xl">
                <!-- Left: Form -->
                <div
                    class="lg:col-span-7 bg-white p-lg rounded-[24px] shadow-sm border border-surface-container-highest">
                    <form class="space-y-md" id="contactForm" method="POST" action="">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="space-y-xs">
                                <label class="font-label-md text-label-md text-on-surface-variant" for="name">Full
                                    Name</label>
                                <input
                                    class="w-full bg-surface-container-low border-none rounded-xl p-md focus:ring-2 focus:ring-primary/20 transition-all outline-none text-on-surface placeholder:text-outline-variant"
                                    id="name" name="name" placeholder="E.g., Ariful Islam" type="text"
                                    required />
                            </div>
                            <div class="space-y-xs">
                                <label class="font-label-md text-label-md text-on-surface-variant" for="email">Email
                                    Address</label>
                                <input
                                    class="w-full bg-surface-container-low border-none rounded-xl p-md focus:ring-2 focus:ring-primary/20 transition-all outline-none text-on-surface placeholder:text-outline-variant"
                                    id="email" name="email" placeholder="hello@example.com" type="email"
                                    required />
                            </div>
                        </div>
                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface-variant"
                                for="subject">Subject</label>
                            <select
                                class="w-full bg-surface-container-low border-none rounded-xl p-md focus:ring-2 focus:ring-primary/20 transition-all outline-none text-on-surface appearance-none"
                                id="subject" name="subject" required>
                                <option value="">Select an inquiry type</option>
                                <option value="product">Product Consultation</option>
                                <option value="order">Order Status</option>
                                <option value="wholesale">Wholesale Inquiry</option>
                                <option value="general">General Support</option>
                            </select>
                        </div>
                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface-variant" for="message">Your
                                Message</label>
                            <textarea
                                class="w-full bg-surface-container-low border-none rounded-xl p-md focus:ring-2 focus:ring-primary/20 transition-all outline-none text-on-surface placeholder:text-outline-variant resize-none"
                                id="message" name="message" placeholder="How can we help you today?" rows="5" required></textarea>
                        </div>
                        <button
                            class="w-full md:w-auto px-xl py-base h-[56px] bg-primary text-white font-label-md text-label-md rounded-full hover:bg-primary-container transition-all duration-300 flex items-center justify-center gap-base"
                            type="submit">
                            Send Message
                            <span class="material-symbols-outlined text-[20px]">send</span>
                        </button>
                    </form>
                </div>
                <!-- Right: Details -->
                <div class="lg:col-span-5 space-y-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-md">
                        <!-- Contact Cards -->
                        <div
                            class="bento-card p-md bg-white rounded-[24px] border border-surface-container-highest flex gap-md items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">call</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Phone</p>
                                <a href="tel:{{ setting('site_phone', '+880 1XXX-XXXXXX') }}"
                                    class="font-body-md text-body-md text-on-surface font-semibold hover:text-primary transition-colors">
                                    {{ setting('site_phone', '+880 1XXX-XXXXXX') }}
                                </a>
                            </div>
                        </div>
                        <div
                            class="bento-card p-md bg-white rounded-[24px] border border-surface-container-highest flex gap-md items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Email</p>
                                <a href="mailto:{{ setting('site_email', 'hello@prokitisudha.com') }}"
                                    class="font-body-md text-body-md text-on-surface font-semibold hover:text-primary transition-colors">
                                    {{ setting('site_email', 'hello@prokitisudha.com') }}
                                </a>
                            </div>
                        </div>
                        <div
                            class="bento-card p-md bg-white rounded-[24px] border border-surface-container-highest flex gap-md items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Address</p>
                                <p class="font-body-md text-body-md text-on-surface font-semibold">
                                    {{ setting('site_address', 'Dhaka, Bangladesh') }}</p>
                            </div>
                        </div>
                        <div
                            class="bento-card p-md bg-white rounded-[24px] border border-surface-container-highest flex gap-md items-start">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">schedule</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Business Hours</p>
                                <p class="font-body-md text-body-md text-on-surface font-semibold">Sun - Thu, 9 AM - 6
                                    PM
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Button -->
                    @if (setting('whatsapp_number'))
                        <a class="group block w-full bg-secondary-fixed text-on-secondary-fixed p-lg rounded-[24px] text-center transition-all duration-300 hover:bg-secondary border border-transparent hover:text-white"
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}"
                            target="_blank">
                            <div class="flex items-center justify-center gap-base">
                                <span class="material-symbols-outlined">chat</span>
                                <span class="font-label-md text-label-md">Chat with us on WhatsApp</span>
                            </div>
                            <p class="text-caption mt-xs opacity-70 group-hover:opacity-100 transition-opacity">Typical
                                response time: < 15 mins</p>
                        </a>
                    @endif
                </div>
            </section>

            <!-- Map Section -->
            @if (setting('google_map_embed_code'))
                <section class="w-full h-[500px] relative mb-xl overflow-hidden group">
                    <div class="absolute inset-0 z-10 map-overlay"></div>
                    <div class="w-full h-full grayscale opacity-80 group-hover:grayscale-0 transition-all duration-700">
                        <iframe src="https://www.google.com/maps/embed?pb={{ setting('google_map_embed_code') }}"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <!-- Floating Marker Label -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 flex flex-col items-center pointer-events-none">
                        <div
                            class="bg-primary text-white px-md py-sm rounded-full shadow-lg font-label-md text-label-md mb-base flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">local_pharmacy</span>
                            Our Sanctuary
                        </div>
                        <div class="w-4 h-4 bg-primary rounded-full animate-ping absolute -bottom-1"></div>
                        <div class="w-3 h-3 bg-primary rounded-full relative"></div>
                    </div>
                </section>
            @else
                <section class="w-full h-[500px] relative mb-xl overflow-hidden group">
                    <div class="absolute inset-0 z-10 map-overlay"></div>
                    <div class="w-full h-full grayscale opacity-80 group-hover:grayscale-0 transition-all duration-700"
                        data-location="{{ setting('site_address', 'Dhaka, Bangladesh') }}">
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3R9Wn-9KrMsSPQ56QQq6R6huyTqpzEh12bqXQwTAAhGblbOxMI_aUZ-rTD-0vzIgRCP62sqdJoOIGCj9SDDpWHWa9j5LGKwJHzy5dmFIifswxa2Y7p-KQ1XA4z02QxWakLkrPtXFi9rctiyuWSTBl7RqnfXUQquBsh7VfCsdzexKiirC0qbnSdmfASA3pFWZP4eEYf0fEkoZwTYzHU_pwZJGlaN11zIlgCstb7IszqODwS0SjjnaECOXfoIjDDffBYWs1Xv9hBlxq" />
                    </div>
                    <!-- Floating Marker Label -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 flex flex-col items-center">
                        <div
                            class="bg-primary text-white px-md py-sm rounded-full shadow-lg font-label-md text-label-md mb-base flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">local_pharmacy</span>
                            Our Sanctuary
                        </div>
                        <div class="w-4 h-4 bg-primary rounded-full animate-ping absolute -bottom-1"></div>
                        <div class="w-3 h-3 bg-primary rounded-full relative"></div>
                    </div>
                </section>
            @endif

            <!-- FAQ Section -->
            <section class="px-margin-desktop max-w-container-max mx-auto mb-xl">
                <div class="text-center mb-lg">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-xs">Frequently Asked Questions</h2>
                    <p class="text-on-surface-variant max-w-xl mx-auto">Common questions about our traditional roots
                        and
                        modern wellness approach.</p>
                </div>
                <div class="max-w-3xl mx-auto space-y-base">
                    <!-- Accordion Items -->
                    <div
                        class="accordion-item bg-white rounded-2xl border border-surface-container-highest overflow-hidden">
                        <button
                            class="w-full px-lg py-md flex items-center justify-between text-left hover:bg-surface-container-low transition-colors"
                            onclick="toggleAccordion(this)">
                            <span class="font-label-md text-label-md text-on-surface">Are your products 100%
                                organic?</span>
                            <span
                                class="material-symbols-outlined text-outline-variant icon-rotate transition-transform">expand_more</span>
                        </button>
                        <div class="accordion-content px-lg text-on-surface-variant pb-md">
                            <p class="font-body-md text-body-md">Yes, every ingredient is sourced from certified
                                organic farms across Bangladesh and the region. We prioritize purity and ethical
                                harvesting to ensure maximum potency in every blend.</p>
                        </div>
                    </div>
                    <div
                        class="accordion-item bg-white rounded-2xl border border-surface-container-highest overflow-hidden">
                        <button
                            class="w-full px-lg py-md flex items-center justify-between text-left hover:bg-surface-container-low transition-colors"
                            onclick="toggleAccordion(this)">
                            <span class="font-label-md text-label-md text-on-surface">How long does shipping
                                take?</span>
                            <span
                                class="material-symbols-outlined text-outline-variant icon-rotate transition-transform">expand_more</span>
                        </button>
                        <div class="accordion-content px-lg text-on-surface-variant pb-md">
                            <p class="font-body-md text-body-md">For local orders within
                                {{ setting('site_address', 'Dhaka') }}, we typically deliver within 24-48 hours.
                                Nationwide shipping takes 3-5 business days. International shipping times vary by
                                region.</p>
                        </div>
                    </div>
                    <div
                        class="accordion-item bg-white rounded-2xl border border-surface-container-highest overflow-hidden">
                        <button
                            class="w-full px-lg py-md flex items-center justify-between text-left hover:bg-surface-container-low transition-colors"
                            onclick="toggleAccordion(this)">
                            <span class="font-label-md text-label-md text-on-surface">Can I request a personalized
                                wellness consultation?</span>
                            <span
                                class="material-symbols-outlined text-outline-variant icon-rotate transition-transform">expand_more</span>
                        </button>
                        <div class="accordion-content px-lg text-on-surface-variant pb-md">
                            <p class="font-body-md text-body-md">Absolutely. We offer virtual and in-person
                                consultations with our herbal wisdom experts. Please select "Product Consultation" in
                                the contact form above to book your session.</p>
                        </div>
                    </div>
                    <div
                        class="accordion-item bg-white rounded-2xl border border-surface-container-highest overflow-hidden">
                        <button
                            class="w-full px-lg py-md flex items-center justify-between text-left hover:bg-surface-container-low transition-colors"
                            onclick="toggleAccordion(this)">
                            <span class="font-label-md text-label-md text-on-surface">Are your products
                                lab-tested?</span>
                            <span
                                class="material-symbols-outlined text-outline-variant icon-rotate transition-transform">expand_more</span>
                        </button>
                        <div class="accordion-content px-lg text-on-surface-variant pb-md">
                            <p class="font-body-md text-body-md">Every batch undergoes rigorous third-party lab testing
                                for purity, heavy metals, and active compound concentration. We believe in transparency
                                and science-backed traditional medicine.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </x-slot>

    @push('scripts')
        <script>
            // Form Interactivity
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const btn = e.target.querySelector('button');
                    const originalText = btn.innerHTML;
                    btn.innerHTML =
                        '<span class="material-symbols-outlined animate-spin">progress_activity</span> Sending...';
                    btn.classList.add('opacity-70', 'pointer-events-none');

                    setTimeout(() => {
                        btn.innerHTML =
                            '<span class="material-symbols-outlined">check_circle</span> Message Sent';
                        btn.classList.remove('bg-primary');
                        btn.classList.add('bg-secondary');
                        contactForm.reset();

                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.classList.add('bg-primary');
                            btn.classList.remove('bg-secondary', 'opacity-70', 'pointer-events-none');
                        }, 3000);
                    }, 2000);
                });
            }

            // FAQ Accordion
            function toggleAccordion(button) {
                const item = button.parentElement;
                const isActive = item.classList.contains('active');

                // Close all others
                document.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                });

                // Open clicked
                if (!isActive) {
                    item.classList.add('active');
                }
            }
        </script>
    @endpush
</x-app-layout>
