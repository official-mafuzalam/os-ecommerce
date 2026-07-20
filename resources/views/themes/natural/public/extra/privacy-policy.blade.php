<x-app-layout>
    @section('title', 'Privacy Policy - ' . setting('site_title', 'OS E-commerce'))
    <x-slot name="main">
        <!-- Fashion Privacy Policy Page -->
        <div class="container mx-auto px-4 py-8 md:py-12">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div
                        class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 elegant-heading">Privacy Policy</h1>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span>Last Updated: {{ date('F j, Y') }}</span>
                        <span class="text-gray-300">•</span>
                        <span>Version 2.0</span>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="mb-10">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        At {{ setting('site_name', config('app.name')) }}, we are committed to protecting your privacy
                        and ensuring the security of your personal information. This Privacy Policy outlines how we
                        collect, use, disclose, and safeguard your information when you visit our website and use our
                        services.
                    </p>
                </div>

                <!-- Table of Contents -->
                <div class="bg-gray-50 rounded-xl p-6 mb-12">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Table of Contents</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <a href="#information-collection"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>1. Information We Collect</span>
                        </a>
                        <a href="#information-use"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>2. How We Use Your Information</span>
                        </a>
                        <a href="#information-sharing"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>3. Information Sharing</span>
                        </a>
                        <a href="#data-security"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>4. Data Security</span>
                        </a>
                        <a href="#cookies"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>5. Cookies & Tracking</span>
                        </a>
                        <a href="#your-rights"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>6. Your Rights</span>
                        </a>
                        <a href="#policy-changes"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>7. Policy Changes</span>
                        </a>
                        <a href="#contact-us"
                            class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                            <span>8. Contact Us</span>
                        </a>
                    </div>
                </div>

                <!-- Policy Sections -->
                <div class="space-y-12">
                    <!-- Section 1 -->
                    <section id="information-collection" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">1</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Information We Collect</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We collect several types of information from and about users of our website,
                                        including:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h4 class="font-semibold text-gray-900 mb-2">Personal Information</h4>
                                            <ul class="space-y-1 text-sm text-gray-600">
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-user text-gray-400 text-xs"></i>
                                                    <span>Name and contact details</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                                    <span>Email address</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-phone text-gray-400 text-xs"></i>
                                                    <span>Phone number</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                                    <span>Shipping address</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h4 class="font-semibold text-gray-900 mb-2">Transaction Information</h4>
                                            <ul class="space-y-1 text-sm text-gray-600">
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-shopping-cart text-gray-400 text-xs"></i>
                                                    <span>Order history</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-credit-card text-gray-400 text-xs"></i>
                                                    <span>Payment information</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-box text-gray-400 text-xs"></i>
                                                    <span>Product preferences</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 2 -->
                    <section id="information-use" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">2</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">How We Use Your Information</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We use the information we collect for various purposes, including:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <i class="fas fa-shipping-fast"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-1">Order Processing</h4>
                                                <p class="text-sm text-gray-600">To process and fulfill your orders,
                                                    send order confirmations, and provide shipping updates.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                                                <i class="fas fa-comments"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-1">Customer Service</h4>
                                                <p class="text-sm text-gray-600">To respond to your inquiries, provide
                                                    support, and improve our services.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-1">Website Improvement</h4>
                                                <p class="text-sm text-gray-600">To analyze how customers use our
                                                    website and improve user experience.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                                <i class="fas fa-bullhorn"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-1">Marketing Communications
                                                </h4>
                                                <p class="text-sm text-gray-600">To send promotional emails about new
                                                    products, special offers, or other updates.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 3 -->
                    <section id="information-sharing" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">3</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Information Sharing</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We respect your privacy and do not sell, trade, or rent your personal information
                                        to third parties. However, we may share your information with:</p>

                                    <div class="space-y-4 mt-4">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Service Providers</h4>
                                                <p class="text-sm text-gray-600">Trusted third parties who assist us in
                                                    operating our website, conducting our business, or servicing you.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Legal Requirements</h4>
                                                <p class="text-sm text-gray-600">When required by law or to protect our
                                                    rights, property, or safety.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Business Transfers</h4>
                                                <p class="text-sm text-gray-600">In connection with a merger,
                                                    acquisition, or sale of assets, with notice to affected users.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 4 -->
                    <section id="data-security" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">4</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Data Security</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We implement appropriate technical and organizational measures to protect your
                                        personal information against unauthorized access, alteration, disclosure, or
                                        destruction.</p>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-lock text-gray-600 text-xl"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">SSL Encryption</h4>
                                            <p class="text-sm text-gray-600">256-bit SSL encryption for all data
                                                transmission</p>
                                        </div>

                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-shield-alt text-gray-600 text-xl"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Secure Servers</h4>
                                            <p class="text-sm text-gray-600">Regular security audits and monitoring</p>
                                        </div>

                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-user-shield text-gray-600 text-xl"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Access Control</h4>
                                            <p class="text-sm text-gray-600">Strict access controls and authentication
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 5 -->
                    <section id="cookies" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">5</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Cookies & Tracking Technologies</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We use cookies and similar tracking technologies to track activity on our website
                                        and hold certain information to enhance your user experience.</p>

                                    <div class="bg-gray-50 rounded-xl p-6 mt-4">
                                        <div class="space-y-4">
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-2">Essential Cookies</h4>
                                                <p class="text-sm text-gray-600">Required for the website to function
                                                    properly, such as maintaining your shopping cart.</p>
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-2">Analytics Cookies</h4>
                                                <p class="text-sm text-gray-600">Help us understand how visitors
                                                    interact with our website to improve user experience.</p>
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-2">Marketing Cookies</h4>
                                                <p class="text-sm text-gray-600">Used to track visitors across websites
                                                    to display relevant advertisements.</p>
                                            </div>
                                        </div>

                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <p class="text-sm text-gray-600">
                                                You can control cookies through your browser settings. However,
                                                disabling cookies may affect your experience on our website.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 6 -->
                    <section id="your-rights" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">6</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Your Rights</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>You have certain rights regarding your personal information, including:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-eye text-gray-400 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Access</h4>
                                                <p class="text-sm text-gray-600">Request access to your personal
                                                    information</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-edit text-gray-400 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Correction</h4>
                                                <p class="text-sm text-gray-600">Request correction of inaccurate
                                                    information</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-trash-alt text-gray-400 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Deletion</h4>
                                                <p class="text-sm text-gray-600">Request deletion of your personal
                                                    information</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-ban text-gray-400 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Opt-Out</h4>
                                                <p class="text-sm text-gray-600">Opt-out of marketing communications
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <p class="text-sm text-gray-600">
                                            To exercise any of these rights, please contact us using the information
                                            provided in the "Contact Us" section below.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 7 -->
                    <section id="policy-changes" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">7</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Policy Changes</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We may update our Privacy Policy from time to time. We will notify you of any
                                        changes by posting the new Privacy Policy on this page and updating the "Last
                                        Updated" date.</p>

                                    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 mt-4">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Notification of Changes</h4>
                                                <p class="text-sm text-gray-600">
                                                    We encourage you to review this Privacy Policy periodically for any
                                                    changes. Your continued use of our website after we post any
                                                    modifications constitutes your acceptance of the updated policy.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 8 -->
                    <section id="contact-us" class="scroll-mt-20">
                        <div class="flex items-start gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">8</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">Contact Us</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>If you have any questions or concerns about this Privacy Policy or our data
                                        practices, please contact us:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="bg-gray-50 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Email</h4>
                                                    <p class="text-sm text-gray-600">For privacy-related inquiries</p>
                                                </div>
                                            </div>
                                            <a href="mailto:{{ setting('site_email') }}"
                                                class="text-gray-900 hover:text-gray-700 font-medium">
                                                {{ setting('site_email') }}
                                            </a>
                                        </div>

                                        <div class="bg-gray-50 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                    <i class="fas fa-headset"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Support</h4>
                                                    <p class="text-sm text-gray-600">For general inquiries</p>
                                                </div>
                                            </div>
                                            @if (setting('site_phone'))
                                                <a href="tel:{{ setting('site_phone') }}"
                                                    class="text-gray-900 hover:text-gray-700 font-medium">
                                                    {{ setting('site_phone') }}
                                                </a>
                                            @else
                                                <a href="{{ route('public.contact') }}"
                                                    class="text-gray-900 hover:text-gray-700 font-medium">
                                                    Contact Support
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Last Updated Note -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">
                                This Privacy Policy was last updated on {{ date('F j, Y') }}
                            </p>
                        </div>
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                            class="text-gray-700 hover:text-gray-900 font-medium flex items-center gap-2 transition-colors">
                            <i class="fas fa-arrow-up"></i>
                            Back to Top
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .scroll-mt-20 {
                scroll-margin-top: 5rem;
            }

            /* Smooth scrolling */
            html {
                scroll-behavior: smooth;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Highlight active section in TOC */
            section:target {
                animation: highlight 2s ease;
            }

            @keyframes highlight {
                0% {
                    background-color: rgba(243, 244, 246, 1);
                }

                100% {
                    background-color: transparent;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth scroll for table of contents links
                const tocLinks = document.querySelectorAll('a[href^="#"]');
                tocLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            // Add highlight class
                            targetElement.classList.add('bg-gray-50');

                            // Smooth scroll
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });

                            // Remove highlight after animation
                            setTimeout(() => {
                                targetElement.classList.remove('bg-gray-50');
                            }, 2000);
                        }
                    });
                });

                // Add active state to TOC links when scrolling
                const sections = document.querySelectorAll('section[id]');
                const observerOptions = {
                    root: null,
                    rootMargin: '-20% 0px -70% 0px',
                    threshold: 0
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const id = entry.target.getAttribute('id');
                            const tocLink = document.querySelector(`a[href="#${id}"]`);
                            if (tocLink) {
                                // Remove active from all
                                tocLinks.forEach(link => {
                                    link.classList.remove('text-gray-900', 'font-medium');
                                    link.classList.add('text-gray-700');
                                });

                                // Add active to current
                                tocLink.classList.add('text-gray-900', 'font-medium');
                                tocLink.classList.remove('text-gray-700');
                            }
                        }
                    });
                }, observerOptions);

                sections.forEach(section => {
                    observer.observe(section);
                });

                // Print button functionality
                const printButton = document.createElement('button');
                printButton.innerHTML = '<i class="fas fa-print mr-2"></i> Print Policy';
                printButton.className = 'fashion-btn-outline px-6 py-2';
                printButton.onclick = () => window.print();

                const headerActions = document.querySelector('.flex.items-center.justify-center.gap-4');
                if (headerActions) {
                    headerActions.appendChild(printButton);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
