<x-app-layout>
    @section('title', 'Return & Exchange Policy - ' . setting('site_title', 'OS E-commerce'))
    <x-slot name="main">
        <!-- Fashion Return Policy Page -->
        <div class="container mx-auto px-4 py-8 md:py-12">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div
                        class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 elegant-heading">Return & Exchange Policy</h1>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span>Last Updated: {{ date('F j, Y') }}</span>
                        <span class="text-gray-300">•</span>
                        <span>Free Returns Within 30 Days</span>
                    </div>
                </div>

                <!-- Quick Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-green-50 border border-green-100 rounded-xl p-6 text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">30-Day Returns</h3>
                        <p class="text-sm text-gray-600">Easy returns within 30 days of delivery</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Free Exchanges</h3>
                        <p class="text-sm text-gray-600">Free size/color exchanges</p>
                    </div>

                    <div class="bg-purple-50 border border-purple-100 rounded-xl p-6 text-center">
                        <div
                            class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Quality Guarantee</h3>
                        <p class="text-sm text-gray-600">100% satisfaction guarantee</p>
                    </div>
                </div>

                <!-- Table of Contents -->
                <div class="bg-gray-50 rounded-xl p-6 mb-12">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Policy Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="#return-eligibility"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">1</span>
                            </div>
                            <span>Return Eligibility</span>
                        </a>
                        <a href="#non-returnable"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">2</span>
                            </div>
                            <span>Non-Returnable Items</span>
                        </a>
                        <a href="#return-process"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">3</span>
                            </div>
                            <span>Return Process</span>
                        </a>
                        <a href="#refunds"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">4</span>
                            </div>
                            <span>Refunds</span>
                        </a>
                        <a href="#exchanges"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">5</span>
                            </div>
                            <span>Exchanges</span>
                        </a>
                        <a href="#shipping-costs"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">6</span>
                            </div>
                            <span>Shipping Costs</span>
                        </a>
                        <a href="#damaged-items"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">7</span>
                            </div>
                            <span>Damaged Items</span>
                        </a>
                        <a href="#contact"
                            class="flex items-center gap-3 text-gray-700 hover:text-gray-900 transition-colors group">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <span class="text-sm font-medium">8</span>
                            </div>
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>

                <!-- Policy Sections -->
                <div class="space-y-12">
                    <!-- Section 1 -->
                    <section id="return-eligibility" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Return Eligibility</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We offer a hassle-free return policy within <strong>30 days</strong> of your
                                        purchase date. To be eligible for a return, items must meet the following
                                        criteria:</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Original Condition</h4>
                                                <p class="text-sm text-gray-600">Unworn, unwashed, and undamaged</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Original Packaging</h4>
                                                <p class="text-sm text-gray-600">With all original tags attached</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Proof of Purchase</h4>
                                                <p class="text-sm text-gray-600">Order number or receipt required</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Time Frame</h4>
                                                <p class="text-sm text-gray-600">Within 30 days of delivery</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 2 -->
                    <section id="non-returnable" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Non-Returnable Items</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>For health, safety, and quality reasons, certain items cannot be returned. These
                                        include:</p>

                                    <div class="bg-gray-50 rounded-xl p-6 mt-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-times text-red-400 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Personalized Items</h4>
                                                    <p class="text-sm text-gray-600">Monogrammed or custom-made
                                                        products</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-times text-red-400 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Intimate Apparel</h4>
                                                    <p class="text-sm text-gray-600">Swimwear and undergarments (for
                                                        hygiene reasons)</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-times text-red-400 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Final Sale Items</h4>
                                                    <p class="text-sm text-gray-600">Items marked as "Final Sale" or
                                                        clearance</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-times text-red-400 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Gift Cards</h4>
                                                    <p class="text-sm text-gray-600">Non-refundable digital or physical
                                                        gift cards</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 3 -->
                    <section id="return-process" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-list-ol text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Return Process</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>Follow these simple steps to initiate a return:</p>

                                    <div class="space-y-6 mt-6">
                                        <!-- Step 1 -->
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                <span class="font-bold">1</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Contact Customer Service
                                                </h4>
                                                <p class="text-gray-600">Email us at <a
                                                        href="mailto:returns@{{ request() - > getHost() }}"
                                                        class="text-gray-900 hover:text-gray-700 font-medium">returns@{{ request() - > getHost() }}</a>
                                                    with your order number and reason for return.</p>
                                            </div>
                                        </div>

                                        <!-- Step 2 -->
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                <span class="font-bold">2</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Receive Return
                                                    Authorization</h4>
                                                <p class="text-gray-600">We'll send you a Return Authorization Number
                                                    (RAN) and shipping instructions within 24 hours.</p>
                                            </div>
                                        </div>

                                        <!-- Step 3 -->
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                <span class="font-bold">3</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Package Your Items</h4>
                                                <p class="text-gray-600">Pack items securely in original packaging with
                                                    all tags attached. Include the RAN inside the package.</p>
                                            </div>
                                        </div>

                                        <!-- Step 4 -->
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                                <span class="font-bold">4</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Ship Your Return</h4>
                                                <p class="text-gray-600">Ship using the provided prepaid label or your
                                                    preferred carrier. Keep the tracking number for reference.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 4 -->
                    <section id="refunds" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Refunds</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>Once we receive and inspect your return, we'll process your refund. Here's what
                                        to expect:</p>

                                    <div class="bg-gray-50 rounded-xl p-6 mt-6">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="text-center">
                                                <div
                                                    class="w-16 h-16 rounded-full bg-white border border-gray-200 flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-clock text-gray-600"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Processing Time</h4>
                                                <p class="text-sm text-gray-600">5-7 business days after we receive
                                                    your return</p>
                                            </div>

                                            <div class="text-center">
                                                <div
                                                    class="w-16 h-16 rounded-full bg-white border border-gray-200 flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-credit-card text-gray-600"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Payment Method</h4>
                                                <p class="text-sm text-gray-600">Refunded to your original payment
                                                    method</p>
                                            </div>

                                            <div class="text-center">
                                                <div
                                                    class="w-16 h-16 rounded-full bg-white border border-gray-200 flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-truck text-gray-600"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Shipping Costs</h4>
                                                <p class="text-sm text-gray-600">Original shipping costs are
                                                    non-refundable</p>
                                            </div>
                                        </div>

                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                                                <p class="text-sm text-gray-600">
                                                    Refund timing may vary depending on your payment method and bank
                                                    processing times. You'll receive an email confirmation once your
                                                    refund has been processed.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 5 -->
                    <section id="exchanges" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <i class="fas fa-sync-alt text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Exchanges</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>Need a different size or color? We offer free exchanges for eligible items.</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                                    <i class="fas fa-arrows-alt-h"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Size Exchanges</h4>
                                                    <p class="text-sm text-gray-600">Available for all regular-priced
                                                        items</p>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600">Exchange for a different size within 30
                                                days of delivery. Subject to stock availability.</p>
                                        </div>

                                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                                    <i class="fas fa-palette"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Color Exchanges</h4>
                                                    <p class="text-sm text-gray-600">Swap for a different color option
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600">Exchange for a different color within 30
                                                days. Must be same style and size.</p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-lightbulb text-blue-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Exchange Tip</h4>
                                                    <p class="text-sm text-gray-600">
                                                        For fastest exchange service, place a new order for the desired
                                                        item and return the original item for a refund.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 6 -->
                    <section id="shipping-costs" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                    <i class="fas fa-shipping-fast text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Shipping Costs</h2>
                                <div class="space-y-4 text-gray-700">
                                    <div class="space-y-6">
                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-check text-green-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Free Returns for Defective
                                                    Items</h4>
                                                <p class="text-gray-600">If you received a damaged or defective item,
                                                    we'll provide a prepaid return label at no cost to you.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-dollar-sign text-yellow-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Customer-Paid Returns</h4>
                                                <p class="text-gray-600">For change-of-mind returns, customers are
                                                    responsible for return shipping costs.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-sync text-blue-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Exchange Shipping</h4>
                                                <p class="text-gray-600">We cover one-way shipping for size/color
                                                    exchanges (outbound shipping only).</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-4">
                                            <i class="fas fa-ban text-red-500 mt-1"></i>
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-1">Non-Refundable Original
                                                    Shipping</h4>
                                                <p class="text-gray-600">Original shipping charges are non-refundable
                                                    unless the return is due to our error.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 7 -->
                    <section id="damaged-items" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Damaged or Defective Items</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>We take quality seriously. If you receive a damaged or defective item, here's
                                        what to do:</p>

                                    <div class="bg-red-50 border border-red-100 rounded-xl p-6 mt-6">
                                        <div class="space-y-4">
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Immediate Action
                                                        Required</h4>
                                                    <p class="text-sm text-gray-600">Contact us within <strong>7
                                                            days</strong> of receiving a damaged or defective item.</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-camera text-red-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Provide Evidence</h4>
                                                    <p class="text-sm text-gray-600">Send clear photos showing the
                                                        damage or defect.</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-truck-loading text-red-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Free Return &
                                                        Replacement</h4>
                                                    <p class="text-sm text-gray-600">We'll provide a prepaid return
                                                        label and ship a replacement at no cost.</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-gift text-red-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Compensation</h4>
                                                    <p class="text-sm text-gray-600">For major defects, we may offer
                                                        additional compensation or store credit.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 8 -->
                    <section id="contact" class="scroll-mt-20">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-xl bg-gray-900 text-white flex items-center justify-center">
                                    <i class="fas fa-headset text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Our Support Team</h2>
                                <div class="space-y-4 text-gray-700">
                                    <p>Our customer support team is here to help with any return or exchange questions.
                                    </p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div class="bg-gray-50 rounded-xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-envelope text-gray-600"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Email Support</h4>
                                                    <p class="text-sm text-gray-600">For return inquiries</p>
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
                                                    class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-phone-alt text-gray-600"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Phone Support</h4>
                                                    <p class="text-sm text-gray-600">Available Mon-Fri, 9am-6pm</p>
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
                                                    Contact Form
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-clock text-green-500 mt-1"></i>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">Response Time</h4>
                                                    <p class="text-sm text-gray-600">
                                                        We aim to respond to all return inquiries within 24 hours during
                                                        business days.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Policy Summary -->
                <div class="mt-16 pt-8 border-t border-gray-200">
                    <div class="bg-gray-50 rounded-xl p-8">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Need Help With a Return?</h3>
                            <p class="text-gray-600 mb-6">Start your return process with our easy online form</p>
                            <a href="{{ route('public.contact') }}?subject=Return Request"
                                class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-3">
                                <i class="fas fa-exchange-alt"></i>
                                Start Return Process
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="mt-12 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <p>This Return Policy was last updated on {{ date('F j, Y') }}</p>
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

            /* Section highlight animation */
            section:target {
                animation: highlightSection 2s ease;
            }

            @keyframes highlightSection {
                0% {
                    background-color: rgba(243, 244, 246, 1);
                }

                100% {
                    background-color: transparent;
                }
            }

            /* Custom bullet points */
            .custom-bullet {
                position: relative;
                padding-left: 1.5rem;
            }

            .custom-bullet::before {
                content: "•";
                position: absolute;
                left: 0;
                color: #6b7280;
                font-size: 1.5rem;
                line-height: 1;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth scroll for TOC links
                const tocLinks = document.querySelectorAll('a[href^="#"]');
                tocLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Highlight current section in TOC
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
                            tocLinks.forEach(link => {
                                if (link.getAttribute('href') === `#${id}`) {
                                    link.classList.add('text-gray-900', 'font-medium');
                                    link.classList.remove('text-gray-700');

                                    // Update number background
                                    const numberDiv = link.querySelector('div');
                                    if (numberDiv) {
                                        numberDiv.classList.add('bg-gray-900', 'text-white');
                                        numberDiv.classList.remove('bg-white',
                                            'border-gray-200');
                                    }
                                } else {
                                    link.classList.remove('text-gray-900', 'font-medium');
                                    link.classList.add('text-gray-700');

                                    // Reset number background
                                    const numberDiv = link.querySelector('div');
                                    if (numberDiv) {
                                        numberDiv.classList.remove('bg-gray-900', 'text-white');
                                        numberDiv.classList.add('bg-white', 'border-gray-200');
                                    }
                                }
                            });
                        }
                    });
                }, observerOptions);

                sections.forEach(section => {
                    observer.observe(section);
                });

                // Print policy button
                const printButton = document.createElement('button');
                printButton.innerHTML = '<i class="fas fa-print mr-2"></i> Print Policy';
                printButton.className = 'fashion-btn-outline px-6 py-2 ml-4';
                printButton.onclick = () => window.print();

                const headerInfo = document.querySelector('.flex.items-center.justify-center.gap-4');
                if (headerInfo) {
                    headerInfo.appendChild(printButton);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
