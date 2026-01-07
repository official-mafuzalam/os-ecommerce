<x-app-layout>
    @section('title', 'Terms of Service')
    <x-slot name="main">
        <!-- Fashion Terms of Service Page -->
        <div class="container mx-auto px-4 py-8 md:py-12">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div
                        class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-contract text-2xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 elegant-heading">Terms of Service</h1>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span>Last Updated: {{ date('F j, Y') }}</span>
                        <span class="text-gray-300">•</span>
                        <span>Effective Immediately</span>
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-12">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-blue-600 text-xl mt-1"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Important Notice</h3>
                            <p class="text-gray-700 mb-3">
                                Please read these Terms of Service carefully before using our website. By accessing or
                                using {{ setting('site_name', config('app.name')) }}, you acknowledge that you have
                                read, understood, and agree to be bound by these terms.
                            </p>
                            <p class="text-sm text-gray-600">
                                If you do not agree with these terms, please do not use our website or services.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Table of Contents -->
                <div class="bg-gray-50 rounded-xl p-6 mb-12">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Navigation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <a href="#agreement"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">1</span>
                            </div>
                            <span class="text-gray-700 font-medium">Agreement to Terms</span>
                        </a>
                        <a href="#eligibility"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">2</span>
                            </div>
                            <span class="text-gray-700 font-medium">User Eligibility</span>
                        </a>
                        <a href="#account"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">3</span>
                            </div>
                            <span class="text-gray-700 font-medium">Account Creation</span>
                        </a>
                        <a href="#products"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">4</span>
                            </div>
                            <span class="text-gray-700 font-medium">Product Information</span>
                        </a>
                        <a href="#orders"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">5</span>
                            </div>
                            <span class="text-gray-700 font-medium">Orders & Payments</span>
                        </a>
                        <a href="#returns"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">6</span>
                            </div>
                            <span class="text-gray-700 font-medium">Returns & Refunds</span>
                        </a>
                        <a href="#intellectual"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">7</span>
                            </div>
                            <span class="text-gray-700 font-medium">Intellectual Property</span>
                        </a>
                        <a href="#conduct"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">8</span>
                            </div>
                            <span class="text-gray-700 font-medium">User Conduct</span>
                        </a>
                        <a href="#liability"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">9</span>
                            </div>
                            <span class="text-gray-700 font-medium">Limitation of Liability</span>
                        </a>
                        <a href="#termination"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">10</span>
                            </div>
                            <span class="text-gray-700 font-medium">Termination</span>
                        </a>
                        <a href="#governing"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">11</span>
                            </div>
                            <span class="text-gray-700 font-medium">Governing Law</span>
                        </a>
                        <a href="#changes"
                            class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0">
                                <span class="font-semibold">12</span>
                            </div>
                            <span class="text-gray-700 font-medium">Changes to Terms</span>
                        </a>
                    </div>
                </div>

                <!-- Terms Sections -->
                <div class="space-y-12">
                    <!-- Section 1 -->
                    <section id="agreement" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-900 text-white flex items-center justify-center">
                                <span class="text-xl font-bold">1</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Agreement to Terms</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>
                                        By accessing or using our website <strong>{{ config('app.url') }}</strong> (the
                                        "Site"), you acknowledge that you have read, understood, and agree to be bound
                                        by these Terms of Service ("Terms"). These Terms constitute a legally binding
                                        agreement between you and {{ setting('site_name', config('app.name')) }} ("we,"
                                        "us," or "our").
                                    </p>
                                    <p>
                                        If you are using the Site on behalf of an organization, you represent and
                                        warrant that you have the authority to bind that organization to these Terms.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 2 -->
                    <section id="eligibility" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">2</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">User Eligibility</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>To use our Site and services, you must:</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Age Requirement</h4>
                                                <p class="text-sm text-gray-600">Be at least 18 years old or the age of
                                                    majority in your jurisdiction</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Legal Capacity</h4>
                                                <p class="text-sm text-gray-600">Have the legal capacity to enter into
                                                    binding contracts</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Accurate Information</h4>
                                                <p class="text-sm text-gray-600">Provide accurate and complete
                                                    information</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Residency</h4>
                                                <p class="text-sm text-gray-600">Reside in a country where we offer our
                                                    services</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 3 -->
                    <section id="account" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">3</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Account Creation & Security</h2>
                                <div class="space-y-4 text-gray-700">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Account Responsibilities</h4>
                                            <ul class="space-y-2 text-sm text-gray-600">
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-user-check text-gray-400 mt-1"></i>
                                                    <span>Provide accurate and complete registration information</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-lock text-gray-400 mt-1"></i>
                                                    <span>Maintain the security of your password</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-shield-alt text-gray-400 mt-1"></i>
                                                    <span>Notify us immediately of unauthorized account use</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-user-slash text-gray-400 mt-1"></i>
                                                    <span>You are responsible for all activities under your
                                                        account</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Prohibited Activities</h4>
                                            <ul class="space-y-2 text-sm text-gray-600">
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-ban text-red-400 mt-1"></i>
                                                    <span>Creating multiple accounts for fraudulent purposes</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-ban text-red-400 mt-1"></i>
                                                    <span>Sharing or transferring your account to others</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-ban text-red-400 mt-1"></i>
                                                    <span>Using false or misleading information</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-ban text-red-400 mt-1"></i>
                                                    <span>Attempting to access others' accounts</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 4 -->
                    <section id="products" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">4</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Information & Pricing</h2>
                                <div class="space-y-4 text-gray-700">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="bg-gray-50 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center">
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900">Product Accuracy</h4>
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                We strive for accuracy in product descriptions, images, and
                                                specifications. However, we do not warrant that product information is
                                                entirely accurate, complete, or error-free.
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center">
                                                    <i class="fas fa-tag"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900">Pricing Policy</h4>
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                All prices are in {{ setting('currency', 'BDT') }} and are subject to
                                                change without notice. We reserve the right to modify or discontinue
                                                products or services at any time.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-100 rounded-lg">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Color & Display Disclaimer
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    Product colors may appear slightly different on various devices and
                                                    monitors. We make every effort to display colors accurately but
                                                    cannot guarantee exact color matching.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 5 -->
                    <section id="orders" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">5</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Orders, Payments & Shipping</h2>
                                <div class="space-y-6 text-gray-700">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="text-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-shopping-cart text-gray-600"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Order Confirmation</h4>
                                            <p class="text-sm text-gray-600">Orders are confirmed via email. We reserve
                                                the right to cancel orders for any reason.</p>
                                        </div>
                                        <div class="text-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-credit-card text-gray-600"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Payment Methods</h4>
                                            <p class="text-sm text-gray-600">We accept various payment methods as
                                                displayed during checkout.</p>
                                        </div>
                                        <div class="text-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-truck text-gray-600"></i>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-2">Shipping Policy</h4>
                                            <p class="text-sm text-gray-600">Shipping times and costs vary based on
                                                location and delivery method.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 6 -->
                    <section id="returns" class="scroll-mt-20">
                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="flex-shrink-0 w-14 h-14 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                                <span class="text-xl font-bold">6</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Returns & Refunds</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>Our return and refund policy is designed to ensure customer satisfaction while
                                        maintaining fair business practices:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="bg-green-50 border border-green-100 rounded-xl p-6">
                                            <h4 class="font-semibold text-gray-900 mb-3">Return Eligibility</h4>
                                            <ul class="space-y-2 text-sm text-gray-600">
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-check text-green-500"></i>
                                                    <span>Items must be returned within
                                                        {{ setting('return_period', 30) }} days</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-check text-green-500"></i>
                                                    <span>Products must be in original condition</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-check text-green-500"></i>
                                                    <span>All tags and packaging must be intact</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="bg-red-50 border border-red-100 rounded-xl p-6">
                                            <h4 class="font-semibold text-gray-900 mb-3">Non-Returnable Items</h4>
                                            <ul class="space-y-2 text-sm text-gray-600">
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-times text-red-500"></i>
                                                    <span>Personalized or custom-made items</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-times text-red-500"></i>
                                                    <span>Gift cards and downloadable products</span>
                                                </li>
                                                <li class="flex items-center gap-2">
                                                    <i class="fas fa-times text-red-500"></i>
                                                    <span>Items marked as "final sale"</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <p class="text-sm text-gray-600">
                                            For complete details on our return and refund process, please visit our <a
                                                href="{{ route('public.return-policy') }}"
                                                class="text-gray-900 hover:text-gray-700 font-medium underline">Return
                                                Policy</a> page.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Continue with remaining sections in similar format -->
                    <!-- Section 7-12 would follow the same pattern -->

                    <!-- Quick Summary of Remaining Sections -->
                    <div class="bg-gray-50 rounded-xl p-6 mt-12">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Terms</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">7</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">Intellectual Property</h4>
                                    <p class="text-sm text-gray-600">All content on our Site is protected by copyright
                                        and trademark laws.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">8</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">User Conduct</h4>
                                    <p class="text-sm text-gray-600">Users must not engage in prohibited activities
                                        while using our services.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">9</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">Limitation of Liability</h4>
                                    <p class="text-sm text-gray-600">Our liability is limited as permitted by
                                        applicable law.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">10</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">Termination</h4>
                                    <p class="text-sm text-gray-600">We may terminate accounts for violations of these
                                        Terms.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">11</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">Governing Law</h4>
                                    <p class="text-sm text-gray-600">These Terms are governed by the laws of
                                        Bangladesh.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-200 text-gray-700 flex items-center justify-center flex-shrink-0">
                                    <span class="font-semibold">12</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-1">Changes to Terms</h4>
                                    <p class="text-sm text-gray-600">We may update these Terms periodically.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acceptance Section -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Acceptance of Terms</h3>
                        <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
                            By continuing to use our website and services, you acknowledge that you have read,
                            understood, and agree to be bound by these Terms of Service.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('public.welcome') }}"
                                class="fashion-btn-outline px-6 py-3 inline-flex items-center justify-center gap-2">
                                <i class="fas fa-store"></i>
                                Return to Shopping
                            </a>
                            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="fashion-btn px-6 py-3 inline-flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-up"></i>
                                Back to Top
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        These Terms of Service were last updated on <strong>{{ date('F j, Y') }}</strong>.
                        For previous versions, please contact our support team.
                    </p>
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

            /* Print styles */
            @media print {
                .no-print {
                    display: none !important;
                }

                body {
                    font-size: 12pt;
                }

                .container {
                    max-width: 100% !important;
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

                // Add print button
                const printButton = document.createElement('button');
                printButton.innerHTML = '<i class="fas fa-print mr-2"></i> Print Terms';
                printButton.className = 'fashion-btn-outline px-6 py-2 no-print';
                printButton.onclick = () => window.print();

                const headerActions = document.querySelector('.flex.items-center.justify-center.gap-4');
                if (headerActions) {
                    headerActions.appendChild(printButton);
                }

                // Add expand/collapse for quick navigation on mobile
                if (window.innerWidth < 768) {
                    const toc = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
                    if (toc) {
                        const showMoreButton = document.createElement('button');
                        showMoreButton.innerHTML = '<i class="fas fa-chevron-down mr-2"></i> Show All Sections';
                        showMoreButton.className = 'w-full mt-4 p-3 bg-gray-100 text-gray-700 rounded-lg font-medium';

                        showMoreButton.addEventListener('click', function() {
                            const hiddenItems = toc.querySelectorAll('.hidden');
                            hiddenItems.forEach(item => item.classList.remove('hidden'));
                            this.remove();
                        });

                        // Hide items beyond first 6 on mobile
                        const tocItems = toc.querySelectorAll('a');
                        tocItems.forEach((item, index) => {
                            if (index >= 6) {
                                item.classList.add('hidden');
                            }
                        });

                        if (tocItems.length > 6) {
                            toc.parentNode.appendChild(showMoreButton);
                        }
                    }
                }

                // Track acceptance (optional - for analytics)
                const acceptButton = document.querySelector('button[onclick*="scrollTo"]');
                if (acceptButton) {
                    acceptButton.addEventListener('click', function() {
                        // You can add analytics tracking here
                        console.log('User accepted Terms of Service');
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>
