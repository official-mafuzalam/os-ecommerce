<x-app-layout>
    @section('title', 'Contact Us - ' . setting('site_title', 'OS E-commerce'))
    <x-slot name="main">
        <!-- Fashion Contact Hero -->
        <div class="relative overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover"
                    src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2000&q=80"
                    alt="Fashion Customer Service">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-transparent"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative py-24 md:py-32">
                <div class="container mx-auto px-4">
                    <div class="max-w-2xl">
                        <div class="mb-6">
                            <span
                                class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium">
                                We're Here For You
                            </span>
                        </div>
                        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 elegant-heading leading-tight">
                            Let's Connect
                        </h1>
                        <p class="text-xl text-white/90 mb-8">
                            Our fashion consultants are ready to help you find the perfect style and answer any
                            questions
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 
                                      transition-colors inline-flex items-center gap-3">
                                <i class="fas fa-phone-alt"></i>
                                Call Us Now
                            </a>
                            <a href="#contact-form"
                                class="bg-transparent border-2 border-white text-white font-semibold px-6 py-3 rounded-lg 
                                      hover:bg-white/10 transition-colors inline-flex items-center gap-3">
                                <i class="fas fa-envelope"></i>
                                Send Message
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Content -->
        <div class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Contact Information -->
                    <div>
                        <div class="mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                                Get in Touch
                            </h2>
                            <p class="text-lg text-gray-600">
                                Reach out to our fashion experts for style advice, order assistance, or any questions
                                about our collections
                            </p>
                        </div>

                        <!-- Contact Cards -->
                        <div class="space-y-6">
                            <!-- Address -->
                            <div
                                class="flex items-start gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Visit Our Studio</h3>
                                    <p class="text-gray-600">{{ setting('site_address', 'Mirpur 2, Dhaka 1216') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">By appointment only</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div
                                class="flex items-start gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone-alt text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Call Us</h3>
                                    <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                        class="text-lg font-semibold text-gray-900 hover:text-gray-700 transition-colors">
                                        {{ setting('site_phone', '+8801621833839') }}
                                    </a>
                                    <p class="text-sm text-gray-500 mt-1">Saturday-Thursday: 9AM-6PM</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div
                                class="flex items-start gap-4 p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Email Us</h3>
                                    <a href="mailto:{{ setting('site_email', 'support@octosyncsoftware.com') }}"
                                        class="text-lg font-semibold text-gray-900 hover:text-gray-700 transition-colors">
                                        {{ setting('site_email', 'support@octosyncsoftware.com') }}
                                    </a>
                                    <p class="text-sm text-gray-500 mt-1">Response within 24 hours</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-10">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Follow Our Style</h3>
                            <div class="flex gap-3">
                                @if (setting('facebook_url'))
                                    <a href="{{ setting('facebook_url') }}" target="_blank"
                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 hover:bg-blue-600 hover:text-white 
                                              flex items-center justify-center transition-colors">
                                        <i class="fab fa-facebook-f text-lg"></i>
                                    </a>
                                @endif
                                @if (setting('instagram_url'))
                                    <a href="{{ setting('instagram_url') }}" target="_blank"
                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 hover:bg-pink-600 hover:text-white 
                                              flex items-center justify-center transition-colors">
                                        <i class="fab fa-instagram text-lg"></i>
                                    </a>
                                @endif
                                @if (setting('twitter_url'))
                                    <a href="{{ setting('twitter_url') }}" target="_blank"
                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 hover:bg-blue-400 hover:text-white 
                                              flex items-center justify-center transition-colors">
                                        <i class="fab fa-twitter text-lg"></i>
                                    </a>
                                @endif
                                @if (setting('linkedin_url'))
                                    <a href="{{ setting('linkedin_url') }}" target="_blank"
                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 hover:bg-blue-700 hover:text-white 
                                              flex items-center justify-center transition-colors">
                                        <i class="fab fa-linkedin-in text-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div>
                        <div class="bg-gray-50 rounded-2xl p-8 md:p-10" id="contact-form">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h3>

                            <form class="space-y-6">
                                @csrf

                                <!-- Name Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name *
                                        </label>
                                        <input type="text" id="first_name" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name *
                                        </label>
                                        <input type="text" id="last_name" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" id="email" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            placeholder="your.email@example.com">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" id="phone"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            placeholder="+880 1XXX XXXXXX">
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                        Subject *
                                    </label>
                                    <select id="subject" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition bg-white">
                                        <option value="">Select a subject</option>
                                        <option value="style_advice">Style Advice</option>
                                        <option value="product_inquiry">Product Inquiry</option>
                                        <option value="order_support">Order Support</option>
                                        <option value="returns_exchanges">Returns & Exchanges</option>
                                        <option value="size_guide">Size Guide Assistance</option>
                                        <option value="corporate">Corporate & Partnerships</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                        Your Message *
                                    </label>
                                    <textarea id="message" rows="5" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"
                                        placeholder="Tell us how we can help you..."></textarea>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="w-full fashion-btn py-3 text-lg">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Send Message
                                </button>

                                <p class="text-sm text-gray-500 text-center mt-4">
                                    We typically respond within 24 hours
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Quick answers to common questions about shopping with us
                    </p>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="space-y-4">
                        <!-- FAQ 1 -->
                        <div class="group">
                            <button
                                class="w-full p-6 bg-white rounded-xl shadow-sm border border-gray-100 
                                         hover:border-gray-200 text-left transition-all duration-300"
                                onclick="toggleFAQ(1)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        What's your return and exchange policy?
                                    </h3>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 group-[.active]:rotate-180 transition-transform"></i>
                                </div>
                                <div class="faq-content mt-4 text-gray-600 hidden">
                                    <p class="mb-2">We offer a 30-day return policy for all unworn items in original
                                        condition with tags attached.</p>
                                    <ul class="space-y-1 text-sm">
                                        <li>• Returns are free within Bangladesh</li>
                                        <li>• Exchanges are available for size or color</li>
                                        <li>• Contact us within 7 days of delivery for any quality issues</li>
                                    </ul>
                                </div>
                            </button>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="group">
                            <button
                                class="w-full p-6 bg-white rounded-xl shadow-sm border border-gray-100 
                                         hover:border-gray-200 text-left transition-all duration-300"
                                onclick="toggleFAQ(2)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        How long does shipping take within Bangladesh?
                                    </h3>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 group-[.active]:rotate-180 transition-transform"></i>
                                </div>
                                <div class="faq-content mt-4 text-gray-600 hidden">
                                    <div class="space-y-3">
                                        <div>
                                            <span class="font-medium text-gray-900">Inside Dhaka:</span>
                                            <span class="text-gray-600 ml-2">1-2 business days</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900">Outside Dhaka:</span>
                                            <span class="text-gray-600 ml-2">3-5 business days</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900">Express Shipping:</span>
                                            <span class="text-gray-600 ml-2">Available at checkout (1 business
                                                day)</span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="group">
                            <button
                                class="w-full p-6 bg-white rounded-xl shadow-sm border border-gray-100 
                                         hover:border-gray-200 text-left transition-all duration-300"
                                onclick="toggleFAQ(3)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Do you offer international shipping?
                                    </h3>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 group-[.active]:rotate-180 transition-transform"></i>
                                </div>
                                <div class="faq-content mt-4 text-gray-600 hidden">
                                    <p class="mb-3">Yes, we ship to select international destinations. Shipping rates
                                        and delivery times vary by country.</p>
                                    <p class="text-sm text-gray-500">Please contact us for specific international
                                        shipping inquiries.</p>
                                </div>
                            </button>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="group">
                            <button
                                class="w-full p-6 bg-white rounded-xl shadow-sm border border-gray-100 
                                         hover:border-gray-200 text-left transition-all duration-300"
                                onclick="toggleFAQ(4)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        How do I know what size to order?
                                    </h3>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 group-[.active]:rotate-180 transition-transform"></i>
                                </div>
                                <div class="faq-content mt-4 text-gray-600 hidden">
                                    <p class="mb-3">Each product page includes a detailed size guide. For
                                        personalized fitting advice:</p>
                                    <ul class="space-y-2 text-sm">
                                        <li>• Check the size chart on the product page</li>
                                        <li>• Contact us for specific measurements</li>
                                        <li>• Include your usual size and measurements in your message</li>
                                        <li>• Our style consultants can provide personalized recommendations</li>
                                    </ul>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Business Hours -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-gradient-to-r from-gray-900 to-black rounded-2xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-6 text-center">Our Business Hours</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-lg font-semibold mb-2">Saturday - Thursday</div>
                                <div class="text-2xl font-bold">9:00 AM - 6:00 PM</div>
                                <p class="text-sm text-white/70 mt-1">Customer Support & Orders</p>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-semibold mb-2">Friday</div>
                                <div class="text-2xl font-bold">10:00 AM - 4:00 PM</div>
                                <p class="text-sm text-white/70 mt-1">Limited Support Available</p>
                            </div>
                        </div>
                        <p class="text-center mt-6 text-white/80">
                            We observe all national holidays. Response times may be longer during holidays.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Visit Our Studio</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Schedule an appointment to visit our Octosync Ecommerce and experience our collections in person
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-96">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116833.97303520302!2d90.3372882621096!3d23.78081863555724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91cd1fe921603f7%3A0x80cf27fdb71760a!2sOctosync%20Software%20Ltd!5e0!3m2!1sen!2sbd!4v1767770431563!5m2!1sen!2sbd"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="p-6 border-t border-gray-100">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ setting('site_name', 'Octosync Ecommerce') }}</h3>
                                <p class="text-gray-600">{{ setting('site_address', 'Mirpur 2, Dhaka 1216') }}</p>
                            </div>
                            <a href="https://maps.google.com/?q={{ urlencode(setting('site_address', 'Mirpur 2, Dhaka 1216')) }}"
                                target="_blank"
                                class="fashion-btn-outline inline-flex items-center justify-center gap-2 px-6 py-2">
                                <i class="fas fa-directions"></i>
                                Get Directions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* FAQ toggle animation */
            .faq-content {
                transition: all 0.3s ease;
            }

            /* Smooth scroll for anchor links */
            html {
                scroll-behavior: smooth;
            }

            /* Contact card hover effects */
            .transition-colors {
                transition-property: background-color, border-color, color;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 200ms;
            }
        </style>

        <script>
            // FAQ Toggle Functionality
            function toggleFAQ(faqNumber) {
                const button = event.currentTarget;
                const content = button.querySelector('.faq-content');
                const icon = button.querySelector('i');

                // Toggle active class
                button.classList.toggle('active');

                // Toggle content visibility
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    content.style.maxHeight = content.scrollHeight + 'px';
                } else {
                    content.style.maxHeight = '0';
                    setTimeout(() => {
                        content.classList.add('hidden');
                    }, 300);
                }
            }

            // Form submission
            document.addEventListener('DOMContentLoaded', function() {
                const contactForm = document.querySelector('form');
                if (contactForm) {
                    contactForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Basic validation
                        const requiredFields = contactForm.querySelectorAll('[required]');
                        let isValid = true;

                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                field.classList.add('border-red-500');
                                isValid = false;
                            } else {
                                field.classList.remove('border-red-500');
                            }
                        });

                        if (isValid) {
                            // Show loading state
                            const submitButton = contactForm.querySelector('button[type="submit"]');
                            const originalText = submitButton.innerHTML;
                            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
                            submitButton.disabled = true;

                            // Simulate API call (replace with actual form submission)
                            setTimeout(() => {
                                alert(
                                    'Thank you for your message! We\'ll get back to you within 24 hours.'
                                );
                                contactForm.reset();
                                submitButton.innerHTML = originalText;
                                submitButton.disabled = false;
                            }, 1500);
                        }
                    });

                    // Remove red border on input
                    const inputs = contactForm.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.addEventListener('input', function() {
                            this.classList.remove('border-red-500');
                        });
                    });
                }

                // Phone number formatting
                const phoneInput = document.getElementById('phone');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 0 && !value.startsWith('880')) {
                            value = '880' + value;
                        }
                        if (value.length > 13) {
                            value = value.substring(0, 13);
                        }

                        // Format: +880 1XXX XXXXXX
                        if (value.length > 3) {
                            value = '+880 ' + value.substring(3);
                        }
                        if (value.length > 8) {
                            value = value.substring(0, 8) + ' ' + value.substring(8);
                        }

                        e.target.value = value;
                    });
                }

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const targetId = this.getAttribute('href');
                        if (targetId !== '#') {
                            e.preventDefault();
                            const targetElement = document.querySelector(targetId);
                            if (targetElement) {
                                targetElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }
                    });
                });

                // Add animation to contact cards
                const contactCards = document.querySelectorAll('.bg-gray-50.rounded-2xl');
                contactCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.transform = 'translateY(0)';
                        card.style.opacity = '1';
                    }, index * 100);
                    card.style.transform = 'translateY(20px)';
                    card.style.opacity = '0';
                    card.style.transition = 'all 0.5s ease-out';
                });
            });
        </script>
    </x-slot>
</x-app-layout>
