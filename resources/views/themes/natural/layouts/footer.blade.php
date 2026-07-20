<footer class="bg-surface-container w-full mt-xl relative overflow-hidden">
    {{-- Decorative top border --}}
    <div
        class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-outline-variant/40 to-transparent">
    </div>

    {{-- Decorative background leaf --}}
    <div class="absolute top-8 right-8 opacity-5 pointer-events-none select-none">
        <span class="material-symbols-outlined text-[200px] text-primary">nest_eco_leaf</span>
    </div>

    <div class="max-w-container-max mx-auto px-margin-desktop">
        {{-- Main Footer Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter py-xl">

            {{-- Brand Column --}}
            <div>
                <div class="flex items-center gap-sm mb-md">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary text-xl">eco</span>
                    </div>
                    <span class="font-headline-md text-headline-md text-primary">
                        {{ setting('site_name', 'Prokiti Sudha') }}
                    </span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mb-lg leading-relaxed">
                    Premium natural wellness destination offering curated botanical essentials, organic nutrition,
                    and ancestral wisdom for the modern lifestyle.
                </p>
                <div class="flex gap-sm">
                    <a href="{{ setting('facebook_url', '#') }}"
                        class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="{{ setting('instagram_url', '#') }}"
                        class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="{{ setting('twitter_url', '#') }}"
                        class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="{{ setting('linkedin_url', '#') }}"
                        class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all duration-300 hover:-translate-y-1">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4
                    class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-md relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-8 after:h-0.5 after:bg-primary after:rounded-full">
                    Discover
                </h4>
                <ul class="space-y-sm mt-md">
                    <li>
                        <a href="{{ route('public.welcome') }}"
                            class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                            <span class="material-symbols-outlined text-base">home</span> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.products') }}"
                            class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                            <span class="material-symbols-outlined text-base">storefront</span> Shop All
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.deals') }}"
                            class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                            <span class="material-symbols-outlined text-base">local_offer</span> Deals &amp; Offers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.about') }}"
                            class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                            <span class="material-symbols-outlined text-base">info</span> About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.contact') }}"
                            class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                            <span class="material-symbols-outlined text-base">headset_mic</span> Contact Us
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Information --}}
            <div>
                <h4
                    class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-md relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-8 after:h-0.5 after:bg-primary after:rounded-full">
                    Contact Info
                </h4>
                <ul class="space-y-md mt-md">
                    <li class="flex items-start gap-sm">
                        <div
                            class="w-8 h-8 rounded-full bg-secondary-container flex-shrink-0 flex items-center justify-center">
                            <span
                                class="material-symbols-outlined text-on-secondary-container text-sm">location_on</span>
                        </div>
                        <div>
                            <span class="font-caption text-caption text-on-surface-variant block">Address</span>
                            <p class="font-body-md text-body-md text-on-surface">
                                {{ setting('site_address', 'Dhaka, Bangladesh') }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-sm">
                        <div
                            class="w-8 h-8 rounded-full bg-secondary-container flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-secondary-container text-sm">phone</span>
                        </div>
                        <div>
                            <span class="font-caption text-caption text-on-surface-variant block">Phone</span>
                            <p class="font-body-md text-body-md text-on-surface font-medium">
                                {{ setting('site_phone', '+8801621833839') }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-sm">
                        <div
                            class="w-8 h-8 rounded-full bg-secondary-container flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-secondary-container text-sm">mail</span>
                        </div>
                        <div>
                            <span class="font-caption text-caption text-on-surface-variant block">Email</span>
                            <p class="font-body-md text-body-md text-on-surface">
                                {{ setting('site_email', 'hello@prokitisudha.com') }}</p>
                        </div>
                    </li>
                </ul>
                {{-- Business Hours --}}
                <div class="mt-md pt-md border-t border-outline-variant/30">
                    <p
                        class="font-caption text-caption text-on-surface-variant font-bold uppercase tracking-wider mb-xs">
                        Business Hours</p>
                    <p class="font-caption text-caption text-on-surface-variant">Mon–Sat: 9:00 AM – 8:00 PM</p>
                    <p class="font-caption text-caption text-on-surface-variant">Sunday: 10:00 AM – 6:00 PM</p>
                </div>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4
                    class="font-label-md text-label-md text-on-surface font-bold uppercase tracking-wider mb-md relative inline-block after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-8 after:h-0.5 after:bg-primary after:rounded-full">
                    Stay Updated
                </h4>
                <p class="font-body-md text-body-md text-on-surface-variant mb-md mt-md">
                    Subscribe for exclusive wellness updates, seasonal harvests, and ancestral health guides.
                </p>
                <form action="{{ route('public.subscribe') }}" method="POST" class="space-y-sm">
                    @csrf
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-base">mail</span>
                        <input type="email" name="email" placeholder="Your email address" required
                            class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-md text-body-md text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300">
                    </div>
                    <button type="submit"
                        class="w-full bg-primary text-on-primary font-label-md text-label-md py-3 px-6 rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-xs active:scale-95">
                        <span class="material-symbols-outlined text-base">send</span>
                        Subscribe
                    </button>
                </form>

                {{-- Payment Methods --}}
                <div class="mt-md pt-md border-t border-outline-variant/30">
                    <p
                        class="font-caption text-caption text-on-surface-variant font-bold uppercase tracking-wider mb-sm">
                        We Accept</p>
                    <div class="flex flex-wrap gap-xs">
                        <div
                            class="w-10 h-6 bg-surface-container-lowest rounded border border-outline-variant flex items-center justify-center">
                            <i class="fab fa-cc-visa text-on-surface-variant text-sm"></i>
                        </div>
                        <div
                            class="w-10 h-6 bg-surface-container-lowest rounded border border-outline-variant flex items-center justify-center">
                            <i class="fab fa-cc-mastercard text-on-surface-variant text-sm"></i>
                        </div>
                        <div
                            class="w-10 h-6 bg-surface-container-lowest rounded border border-outline-variant flex items-center justify-center">
                            <i class="fab fa-cc-amex text-on-surface-variant text-sm"></i>
                        </div>
                        <div
                            class="w-10 h-6 bg-surface-container-lowest rounded border border-outline-variant flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-surface-variant text-xs">payments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="border-t border-outline-variant/30 py-md">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-md">
                {{-- Copyright --}}
                <div class="text-center lg:text-left">
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        &copy; {{ date('Y') }} {{ setting('site_name', 'Prokiti Sudha') }}. All rights reserved.
                    </p>
                    <p class="font-caption text-caption text-on-surface-variant/60 mt-xs">
                        Developed by
                        <a href="https://octosyncsoftware.com" target="_blank" rel="noopener noreferrer"
                            class="text-primary hover:underline transition-colors font-medium">
                            OctoSync Software Ltd
                        </a>
                    </p>
                </div>

                {{-- Legal Links --}}
                <div class="flex flex-wrap justify-center gap-md">
                    <a href="{{ route('public.privacy-policy') }}"
                        class="font-caption text-caption text-on-surface-variant hover:text-primary transition-colors duration-300">
                        Privacy Policy
                    </a>
                    <span class="text-outline-variant">•</span>
                    <a href="{{ route('public.terms-of-service') }}"
                        class="font-caption text-caption text-on-surface-variant hover:text-primary transition-colors duration-300">
                        Terms of Service
                    </a>
                    <span class="text-outline-variant">•</span>
                    <a href="{{ route('public.return-policy') }}"
                        class="font-caption text-caption text-on-surface-variant hover:text-primary transition-colors duration-300">
                        Return Policy
                    </a>
                </div>

                {{-- Back to Top --}}
                <button onclick="scrollToTop()"
                    class="group font-caption text-caption text-on-surface-variant hover:text-primary transition-colors duration-300 flex items-center gap-xs">
                    <span>Back to Top</span>
                    <span
                        class="material-symbols-outlined text-base group-hover:-translate-y-1 transition-transform duration-300">arrow_upward</span>
                </button>
            </div>
        </div>
    </div>
</footer>

{{-- Floating Action Buttons --}}
<div class="fixed bottom-6 right-6 z-50 flex flex-col gap-md">
    {{-- WhatsApp Button --}}
    @if (setting('whatsapp_enabled', true))
        <div class="relative group">
            {{-- Pulsing ring --}}
            <div class="absolute inset-0 animate-ping bg-green-500 rounded-full opacity-20"
                style="animation-duration: 3s;"></div>
            <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode(setting('whatsapp_message', 'Hello! I have a question about your natural products.')) }}"
                target="_blank" rel="noopener noreferrer"
                class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center">
                <i class="fab fa-whatsapp text-2xl"></i>
                <span class="sr-only">Chat on WhatsApp</span>
            </a>
            {{-- Tooltip --}}
            <div
                class="absolute right-full mr-3 top-1/2 -translate-y-1/2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 pointer-events-none">
                <div
                    class="bg-on-surface text-surface font-caption text-caption px-3 py-2 rounded-lg whitespace-nowrap shadow-lg">
                    Chat with us
                </div>
            </div>
        </div>
    @endif

    {{-- Scroll to Top (Mobile) --}}
    <button id="scroll-top-btn" onclick="scrollToTop()"
        class="md:hidden w-14 h-14 bg-primary text-on-primary rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center opacity-0 translate-y-10">
        <span class="material-symbols-outlined">arrow_upward</span>
        <span class="sr-only">Scroll to Top</span>
    </button>
</div>

<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    window.addEventListener('scroll', function() {
        const btn = document.getElementById('scroll-top-btn');
        if (!btn) return;
        if (window.scrollY > 300) {
            btn.classList.remove('opacity-0', 'translate-y-10');
            btn.classList.add('opacity-100', 'translate-y-0');
        } else {
            btn.classList.add('opacity-0', 'translate-y-10');
            btn.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss notifications
        document.querySelectorAll('#notification-success, #notification-error').forEach(el => {
            setTimeout(() => el?.remove(), 5000);
        });

        // Footer section fade-in animation
        const footerCols = document.querySelectorAll('footer .grid > div');
        footerCols.forEach((col, i) => {
            col.style.opacity = '0';
            col.style.transform = 'translateY(20px)';
            col.style.transition = `opacity 0.6s ease ${i * 0.15}s, transform 0.6s ease ${i * 0.15}s`;
        });

        const obs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        footerCols.forEach(col => obs.observe(col));
    });
</script>

@stack('scripts')
</body>

</html>
