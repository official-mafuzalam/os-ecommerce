<!-- Fashion Footer -->
<footer class="fashion-footer">
    <div class="container mx-auto px-4">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 py-12">
            <!-- Brand Column -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-white text-gray-900 flex items-center justify-center">
                        <i class="fas fa-crown text-lg"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white brand-logo">
                        {{ setting('site_name', 'Octosync Fashion') }}
                    </h3>
                </div>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Premium fashion destination offering curated collections of luxury clothing, accessories, and style
                    essentials for the modern individual.
                </p>
                <div class="flex gap-4">
                    <a href="{{ setting('facebook_url', '#') }}" class="social-icon hover:bg-white hover:text-gray-900">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ setting('instagram_url', '#') }}"
                        class="social-icon hover:bg-white hover:text-gray-900">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ setting('twitter_url', '#') }}" class="social-icon hover:bg-white hover:text-gray-900">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ setting('linkedin_url', '#') }}" class="social-icon hover:bg-white hover:text-gray-900">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="footer-heading mb-6">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('public.welcome') }}"
                            class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-home text-xs"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.products') }}"
                            class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-store text-xs"></i>
                            Shop All
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.deals') }}"
                            class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-tag text-xs"></i>
                            Deals & Offers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.about') }}"
                            class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-info-circle text-xs"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.contact') }}"
                            class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-headset text-xs"></i>
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="footer-heading mb-6">Contact Info</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-gray-300 text-sm"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-400">Address</span>
                            <p class="text-gray-300">{{ setting('site_address', 'Dhaka, Bangladesh') }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-phone-alt text-gray-300 text-sm"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-400">Phone</span>
                            <p class="text-gray-300 font-medium">{{ setting('site_phone', '+8801621833839') }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-envelope text-gray-300 text-sm"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-400">Email</span>
                            <p class="text-gray-300">{{ setting('site_email', 'support@octosyncsoftware.com') }}</p>
                        </div>
                    </li>
                </ul>

                <!-- Business Hours -->
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <h4 class="text-sm font-medium text-gray-300 mb-2">Business Hours</h4>
                    <p class="text-sm text-gray-400">Mon-Sat: 9:00 AM - 8:00 PM</p>
                    <p class="text-sm text-gray-400">Sunday: 10:00 AM - 6:00 PM</p>
                </div>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="footer-heading mb-6">Stay Updated</h3>
                <p class="text-gray-300 mb-4">
                    Subscribe to our newsletter for exclusive fashion updates, style tips, and special offers.
                </p>
                <form action="{{ route('public.subscribe') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" placeholder="Your email address" required
                            class="w-full pl-10 pr-4 py-3 bg-white/10 border border-gray-600 rounded-lg text-white placeholder-gray-400 
                                      focus:outline-none focus:border-white focus:ring-2 focus:ring-white/20">
                    </div>
                    <button type="submit"
                        class="w-full bg-white text-gray-900 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 
                                   transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Subscribe
                    </button>
                </form>

                <!-- Payment Methods -->
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <h4 class="text-sm font-medium text-gray-300 mb-3">We Accept</h4>
                    <div class="flex flex-wrap gap-2">
                        <div class="w-10 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fab fa-cc-visa text-gray-700"></i>
                        </div>
                        <div class="w-10 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fab fa-cc-mastercard text-gray-700"></i>
                        </div>
                        <div class="w-10 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fab fa-cc-amex text-gray-700"></i>
                        </div>
                        <div class="w-10 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-gray-700"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700 pt-8 pb-6">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <!-- Copyright -->
                <div class="text-center lg:text-left">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} {{ setting('site_name', 'Octosync Fashion') }}. All rights
                        reserved.
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Developed by
                        <a href="https://octosyncsoftware.com" target="_blank"
                            class="text-gray-300 hover:text-white transition-colors font-medium">
                            OctoSync Software Ltd
                        </a>
                    </p>
                </div>

                <!-- Legal Links -->
                <div class="flex flex-wrap justify-center gap-4 lg:gap-6">
                    <a href="{{ route('public.privacy-policy') }}"
                        class="text-gray-400 hover:text-white text-sm transition-colors">
                        Privacy Policy
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="{{ route('public.terms-of-service') }}"
                        class="text-gray-400 hover:text-white text-sm transition-colors">
                        Terms of Service
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="{{ route('public.return-policy') }}"
                        class="text-gray-400 hover:text-white text-sm transition-colors">
                        Return Policy
                    </a>
                </div>

                <!-- Back to Top -->
                <button onclick="scrollToTop()"
                    class="text-gray-400 hover:text-white transition-colors group flex items-center gap-2">
                    <span class="text-sm">Back to Top</span>
                    <i class="fas fa-arrow-up group-hover:-translate-y-1 transition-transform"></i>
                </button>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Action Buttons -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4">
    <!-- WhatsApp Button -->
    @if (setting('whatsapp_enabled', true))
        <div class="relative">
            <!-- Pulsing Animation -->
            <div class="absolute inset-0 animate-ping bg-green-500 rounded-full opacity-20"
                style="animation-duration: 3s;"></div>

            <!-- WhatsApp Button -->
            <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode(setting('whatsapp_message', 'Hello! I have a question about your fashion items.')) }}"
                target="_blank" rel="noopener noreferrer"
                class="relative w-14 h-14 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full shadow-xl 
                      hover:shadow-2xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
                <i class="fab fa-whatsapp text-2xl"></i>
                <span class="sr-only">Chat on WhatsApp</span>

                <!-- Tooltip -->
                <div
                    class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 opacity-0 invisible 
                            group-hover:opacity-100 group-hover:visible transition-all duration-300">
                    <div class="bg-gray-900 text-white text-sm px-3 py-2 rounded-lg whitespace-nowrap">
                        Chat with us
                    </div>
                    <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2">
                        <div class="w-2 h-2 bg-gray-900 rotate-45"></div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    <!-- Scroll to Top Button (Mobile) -->
    <button onclick="scrollToTop()"
        class="md:hidden w-14 h-14 bg-gray-900 text-white rounded-full shadow-xl hover:shadow-2xl 
                   transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
        <i class="fas fa-arrow-up"></i>
        <span class="sr-only">Scroll to Top</span>
    </button>
</div>

<script>
    // Scroll to top function
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Show scroll to top button when scrolling
    window.addEventListener('scroll', function() {
        const scrollTopBtn = document.querySelector('button[onclick="scrollToTop()"]');
        if (window.scrollY > 300) {
            scrollTopBtn?.classList.add('opacity-100', 'translate-y-0');
            scrollTopBtn?.classList.remove('opacity-0', 'translate-y-10');
        } else {
            scrollTopBtn?.classList.add('opacity-0', 'translate-y-10');
            scrollTopBtn?.classList.remove('opacity-100', 'translate-y-0');
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('#notification-success, #notification-error');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.remove();
            }, 5000); // 5 seconds
        });
    });

    // Add animation classes
    document.addEventListener('DOMContentLoaded', function() {
        // Add animations to footer sections
        const footerSections = document.querySelectorAll('.fashion-footer > div > div > div');
        footerSections.forEach((section, index) => {
            section.style.animationDelay = `${index * 0.2}s`;
            section.classList.add('animate-fade-in-up');
        });

        // Initialize tooltips
        const tooltipTriggers = document.querySelectorAll('[class*="group"]');
        tooltipTriggers.forEach(trigger => {
            trigger.addEventListener('mouseenter', function() {
                const tooltip = this.querySelector('[class*="group-hover:opacity-100"]');
                if (tooltip) {
                    tooltip.classList.add('opacity-100', 'visible');
                    tooltip.classList.remove('opacity-0', 'invisible');
                }
            });

            trigger.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('[class*="group-hover:opacity-100"]');
                if (tooltip) {
                    tooltip.classList.remove('opacity-100', 'visible');
                    tooltip.classList.add('opacity-0', 'invisible');
                }
            });
        });
    });
</script>

<style>
    .fashion-footer {
        background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .fashion-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    }

    .footer-heading {
        font-family: var(--font-elegant);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 2px;
        background: white;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .brand-logo {
        font-family: var(--font-elegant);
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom notification styles */
    .custom-notification {
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Chat widget animations */
    #chat-widget.animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .fashion-footer {
            padding: 3rem 0 2rem;
        }

        .footer-heading::after {
            width: 30px;
        }
    }
</style>
@stack('scripts')
</body>

</html>
