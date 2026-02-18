<x-app-layout>
    @section('title', 'Checkout')
    <x-slot name="main">
        @php
            $lang = setting('order_form_bangla') ? '1' : '0';
        @endphp

        <!-- Fashion Checkout Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">

            <div class="grid lg:grid-cols-12 gap-8">
                {{-- Billing Form --}}
                <div class="lg:col-span-7">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
                        <!-- Header -->
                        <div class="flex items-center mb-8">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center mr-4">
                                <i class="fas fa-user text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    @if ($lang === '1')
                                        বিলিং তথ্য
                                    @else
                                        Customer Information
                                    @endif
                                </h2>
                                <p class="text-gray-600 mt-1">
                                    @if ($lang === '1')
                                        আপনার অর্ডার সম্পূর্ণ করতে নিচের তথ্যগুলো পূরণ করুন
                                    @else
                                        Fill in your details to complete your order
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <form action="{{ route('public.checkout.process') }}" method="POST" id="checkout-form"
                            class="space-y-6">
                            @csrf

                            <!-- Name & Phone -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @if ($lang === '1')
                                            আপনার নাম *
                                        @else
                                            Full Name *
                                        @endif
                                    </label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" name="full_name" required
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            placeholder="@if ($lang === '1') আপনার সম্পূর্ণ নাম লিখুন @else Enter your full name @endif"
                                            autocomplete="name">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @if ($lang === '1')
                                            ফোন নম্বর *
                                        @else
                                            Phone Number *
                                        @endif
                                    </label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="tel" name="phone" required
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            placeholder="@if ($lang === '1') ০১XXXXXXXXX @else 01XXXXXXXXX @endif"
                                            pattern="[0-9]{11}" autocomplete="tel">
                                    </div>
                                </div>
                            </div>

                            <!-- Email (Optional) -->
                            @if (setting('order_email_need'))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @if ($lang === '1')
                                            ইমেইল ঠিকানা
                                        @else
                                            Email Address
                                        @endif
                                    </label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="email" name="email"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            placeholder="@if ($lang === '1') your.email@example.com @else your.email@example.com @endif"
                                            autocomplete="email">
                                    </div>
                                </div>
                            @endif

                            <!-- Delivery Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    @if ($lang === '1')
                                        ডেলিভারি ঠিকানা *
                                    @else
                                        Delivery Address *
                                    @endif
                                </label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                    <textarea name="full_address" required rows="4"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"
                                        placeholder="@if ($lang === '1') বাড়ি/রোড নং, এলাকা, সিটি @else House/Road No, Area, City @endif"
                                        autocomplete="street-address"></textarea>
                                </div>
                            </div>

                            <!-- Delivery Area -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    @if ($lang === '1')
                                        ডেলিভারি এলাকা *
                                    @else
                                        Delivery Area *
                                    @endif
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="relative">
                                        <input class="sr-only peer" type="radio" name="delivery_area"
                                            id="inside_dhaka" value="inside_dhaka" checked>
                                        <label for="inside_dhaka"
                                            class="flex p-4 border-4 border-gray-200 rounded-xl cursor-pointer 
                                                   hover:border-gray-900 transition-all duration-200
                                                   peer-checked:border-gray-900 peer-checked:bg-gray-50">
                                            <div class="flex items-center gap-4">
                                                {{-- <div
                                                    class="w-6 h-6 border-4 border-gray-300 rounded-full flex items-center justify-center
                                                         peer-checked:border-gray-900 peer-checked:bg-gray-900">
                                                    <div
                                                        class="w-3 h-3 bg-gray-900 rounded-full hidden peer-checked:block">
                                                    </div>
                                                </div> --}}
                                                <div>
                                                    <span class="block font-semibold text-gray-900">
                                                        @if ($lang === '1')
                                                            ঢাকার ভিতরে
                                                        @else
                                                            Inside Dhaka
                                                        @endif
                                                    </span>
                                                    <span class="block text-sm text-gray-600 mt-1">
                                                        <span
                                                            id="inside_dhaka_price">{{ setting('delivery_charge_inside_dhaka') }}</span>
                                                        TK
                                                        • 1-2 business days
                                                    </span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input class="sr-only peer" type="radio" name="delivery_area"
                                            id="outside_dhaka" value="outside_dhaka">
                                        <label for="outside_dhaka"
                                            class="flex p-4 border-4 border-gray-200 rounded-xl cursor-pointer 
                                                   hover:border-gray-900 transition-all duration-200
                                                   peer-checked:border-gray-900 peer-checked:bg-gray-50">
                                            <div class="flex items-center gap-4">
                                                {{-- <div
                                                    class="w-6 h-6 border-4 border-gray-300 rounded-full flex items-center justify-center
                                                         peer-checked:border-gray-900 peer-checked:bg-gray-900">
                                                    <div
                                                        class="w-3 h-3 bg-gray-900 rounded-full hidden peer-checked:block">
                                                    </div>
                                                </div> --}}
                                                <div>
                                                    <span class="block font-semibold text-gray-900">
                                                        @if ($lang === '1')
                                                            ঢাকার বাইরে
                                                        @else
                                                            Outside Dhaka
                                                        @endif
                                                    </span>
                                                    <span class="block text-sm text-gray-600 mt-1">
                                                        <span
                                                            id="outside_dhaka_price">{{ setting('delivery_charge_outside_dhaka') }}</span>
                                                        TK
                                                        • 3-5 business days
                                                    </span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes (Optional) -->
                            @if (setting('order_notes_need'))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        @if ($lang === '1')
                                            অতিরিক্ত নোট
                                        @else
                                            Additional Notes
                                        @endif
                                    </label>
                                    <div class="relative">
                                        <i class="fas fa-sticky-note absolute left-3 top-3 text-gray-400"></i>
                                        <textarea name="notes" rows="3"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"
                                            placeholder="@if ($lang === '1') গেটের রং, বিকল্প ফোন নম্বর, বিশেষ নির্দেশনা ইত্যাদি @else Gate color, alternative phone number, special instructions, etc. @endif"></textarea>
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" id="place-order-btn"
                                    class="w-full fashion-btn text-lg py-4 flex items-center justify-center gap-3">
                                    <i class="fas fa-lock"></i>
                                    @if ($lang === '1')
                                        নিরাপদে অর্ডার দিন
                                    @else
                                        Place Order Securely
                                    @endif
                                </button>
                                <p class="text-xs text-gray-500 text-center mt-3">
                                    <i class="fas fa-lock mr-1"></i>
                                    @if ($lang === '1')
                                        আপনার তথ্য নিরাপদে সংরক্ষণ করা হবে
                                    @else
                                        Your information is securely protected
                                    @endif
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Methods -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center mr-3">
                                <i class="fas fa-credit-card text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                @if ($lang === '1')
                                    পেমেন্ট অপশন
                                @else
                                    Payment Options
                                @endif
                            </h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-money-bill-wave text-green-500"></i>
                                    <span class="font-medium">Cash on Delivery</span>
                                </div>
                                <span class="text-sm text-gray-600">Available</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 border border-gray-200 rounded-lg opacity-50">
                                <div class="flex items-center gap-3">
                                    <i class="fab fa-cc-visa text-blue-500"></i>
                                    <span class="font-medium">Credit/Debit Card</span>
                                </div>
                                <span class="text-sm text-gray-600">Coming Soon</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 sticky top-6">
                        <!-- Header -->
                        <div class="flex items-center mb-8">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center mr-4">
                                <i class="fas fa-shopping-bag text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    @if ($lang === '1')
                                        অর্ডার সামারি
                                    @else
                                        Order Summary
                                    @endif
                                </h2>
                                <p class="text-gray-600 mt-1">
                                    {{ $cartItems->count() }} @if ($lang === '1') টি আইটেম
                                    @else
                                        items @endif
                                </p>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="max-h-96 overflow-y-auto pr-2 mb-6">
                            <div class="space-y-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex gap-4 p-3 bg-gray-50 rounded-lg">
                                        <!-- Product Image -->
                                        <div
                                            class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ $item->product->images->where('is_primary', true)->first()
                                                ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                : 'https://placehold.co/400x400?text=No+Image' }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-grow">
                                            <h4 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2">
                                                {{ $item->product->name }}
                                            </h4>

                                            <!-- Attributes -->
                                            @if ($item->attributes && $item->attributes->count() > 0)
                                                <div class="mt-1">
                                                    @foreach ($item->attributes as $attribute)
                                                        <span
                                                            class="inline-block text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded mr-1 mb-1">
                                                            {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Price & Quantity -->
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-sm text-gray-600">
                                                    Qty: {{ $item->quantity }}
                                                </span>
                                                <span class="font-semibold text-gray-900">
                                                    {{ number_format($item->total_price, 2) }} TK
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-3 border-t border-gray-200 pt-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">
                                    @if ($lang === '1')
                                        মোট মূল্য
                                    @else
                                        Subtotal
                                    @endif
                                </span>
                                <span class="font-medium text-gray-900">{{ number_format($subtotal, 2) }} TK</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">
                                    @if ($lang === '1')
                                        ডেলিভারি চার্জ
                                    @else
                                        Delivery Charge
                                    @endif
                                </span>
                                <span id="delivery_charge" class="font-medium text-gray-900">
                                    {{ number_format(setting('delivery_charge_inside_dhaka'), 2) }} TK
                                </span>
                            </div>

                            <!-- Discount (if any) -->
                            @if ($cart->discount_amount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>
                                        @if ($lang === '1')
                                            ডিসকাউন্ট
                                        @else
                                            Discount
                                        @endif
                                    </span>
                                    <span class="font-medium">-{{ number_format($cart->discount_amount, 2) }}
                                        TK</span>
                                </div>
                            @endif

                            <!-- Total -->
                            <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-200 mt-2">
                                <span class="text-gray-900">
                                    @if ($lang === '1')
                                        সর্বমোট
                                    @else
                                        Total
                                    @endif
                                </span>
                                <span id="total_amount" class="text-gray-900">
                                    {{ number_format($subtotal + setting('delivery_charge_inside_dhaka') - $cart->discount_amount, 2) }}
                                    TK
                                </span>
                            </div>
                        </div>

                        <!-- Order Confirmation -->
                        <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-gray-700 mb-1">
                                        @if ($lang === '1')
                                            আপনি এখনই অর্ডার নিশ্চিত করতে পারেন
                                        @else
                                            You're about to confirm your order
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        @if ($lang === '1')
                                            অর্ডার নিশ্চিত হলে আমাদের প্রতিনিধি আপনার সাথে যোগাযোগ করবে
                                        @else
                                            Our representative will contact you after order confirmation
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Need Help -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-3">
                                    @if ($lang === '1')
                                        সাহায্য প্রয়োজন?
                                    @else
                                        Need help with your order?
                                    @endif
                                </p>
                                <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                    class="inline-flex items-center gap-2 text-gray-700 hover:text-gray-900 font-medium transition-colors">
                                    <i class="fas fa-phone-alt"></i>
                                    {{ setting('site_phone', '+8801621833839') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateDelivery() {
                const selectedOption = document.querySelector('input[name="delivery_area"]:checked');

                // Get the actual prices from the spans
                const insideDhakaPrice = parseFloat(document.getElementById('inside_dhaka_price').textContent);
                const outsideDhakaPrice = parseFloat(document.getElementById('outside_dhaka_price').textContent);

                // Determine the delivery charge based on selection
                const deliveryCharge = selectedOption.value === 'inside_dhaka' ? insideDhakaPrice : outsideDhakaPrice;

                // Update the delivery charge display
                const deliveryChargeElement = document.getElementById('delivery_charge');
                if (deliveryChargeElement) {
                    deliveryChargeElement.innerHTML = deliveryCharge.toFixed(2) + ' TK';
                }

                // Calculate and update total
                const subtotal = parseFloat("{{ $subtotal }}");
                const discount = parseFloat("{{ $cart->discount_amount ?? 0 }}");
                const total = subtotal + deliveryCharge - discount;

                const totalAmountElement = document.getElementById('total_amount');
                if (totalAmountElement) {
                    totalAmountElement.innerHTML = total.toFixed(2) + ' TK';
                }
            }

            // Form validation and submission
            document.addEventListener('DOMContentLoaded', function() {
                // Set up delivery option change listeners
                document.querySelectorAll('input[name="delivery_area"]').forEach(option => {
                    option.addEventListener('change', updateDelivery);
                });

                // Run once on load to ensure correct value
                updateDelivery();

                // Form submission handler
                const checkoutForm = document.getElementById('checkout-form');
                if (checkoutForm) {
                    checkoutForm.addEventListener('submit', function(e) {
                        // Basic validation
                        const fullName = checkoutForm.querySelector('input[name="full_name"]').value.trim();
                        const phone = checkoutForm.querySelector('input[name="phone"]').value.trim();
                        const address = checkoutForm.querySelector('textarea[name="full_address"]').value
                    .trim();

                        if (!fullName || !phone || !address) {
                            e.preventDefault();
                            alert('Please fill in all required fields.');
                            return;
                        }

                        // Phone validation
                        const phoneRegex = /^01[3-9]\d{8}$/;
                        if (!phoneRegex.test(phone)) {
                            e.preventDefault();
                            alert(
                            'Please enter a valid Bangladeshi phone number (11 digits starting with 01).');
                            return;
                        }

                        // Show loading state
                        const btn = document.getElementById('place-order-btn');
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = `
                                <div class="flex items-center justify-center gap-3">
                                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                                    <span>@if ($lang === '1') প্রসেসিং... @else Processing... @endif</span>
                                </div>
                            `;
                        }

                        // Add slight delay to show loading state
                        setTimeout(() => {
                            // Form will submit normally
                        }, 500);
                    });
                }

                // Auto-format phone number
                const phoneInput = document.querySelector('input[name="phone"]');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 0 && !value.startsWith('01')) {
                            value = '01' + value;
                        }
                        if (value.length > 11) {
                            value = value.substring(0, 11);
                        }
                        e.target.value = value;
                    });
                }
            });
        </script>

        <style>
            /* Custom scrollbar for order items */
            .max-h-96::-webkit-scrollbar {
                width: 4px;
            }

            .max-h-96::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 2px;
            }

            .max-h-96::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 2px;
            }

            .max-h-96::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Smooth transitions */
            .transition-all {
                transition-property: all;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 200ms;
            }
        </style>
    </x-slot>
</x-app-layout>
