<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce') . ' | Checkout')

    @push('styles')
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }

            .payment-card-active {
                border: 1px solid #1f5d3a;
                background-color: #f0eee7;
                box-shadow: inset 0 0 0 1px #e9c267;
            }

            .glass-summary {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            .botanical-bg {
                background-image: url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M100 20C120 40 140 100 100 180C60 100 80 40 100 20Z' fill='%231f5d3a' fill-opacity='0.03'/%3E%3C/svg%3E");
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f0eee7;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #004525;
                border-radius: 10px;
            }
        </style>
    @endpush

    <x-slot name="main">
        @php
            $lang = setting('order_form_bangla') ? '1' : '0';
        @endphp

        <div class="pb-xl px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto botanical-bg">
            <div class="mb-lg">
                <h1 class="font-headline-lg text-headline-lg text-primary">
                    @if ($lang === '1')
                        চেকআউট
                    @else
                        Checkout
                    @endif
                </h1>
                <p class="font-body-md text-on-surface-variant opacity-80">
                    @if ($lang === '1')
                        প্রাকৃতিক সুস্থতার দিকে আপনার যাত্রা সম্পন্ন করুন।
                    @else
                        Refining your journey to natural vitality.
                    @endif
                </p>
            </div>

            <div class="flex flex-col lg:grid lg:grid-cols-12 gap-xl">
                <!-- Left Column: Checkout Steps -->
                <div class="lg:col-span-7 space-y-xl">

                    <!-- 1. Customer Information -->
                    <section class="space-y-md">
                        <div class="flex items-center gap-sm">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-container text-on-primary-container font-label-md">1</span>
                            <h2 class="font-headline-md text-[24px] text-primary">
                                @if ($lang === '1')
                                    বিলিং তথ্য
                                @else
                                    Customer Information
                                @endif
                            </h2>
                        </div>

                        <form action="{{ route('public.checkout.process') }}" method="POST" id="checkout-form">
                            @csrf

                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-gutter bg-surface-container-low p-md rounded-xl">
                                <!-- Full Name -->
                                <div class="space-y-xs">
                                    <label class="font-label-md text-label-md text-on-surface-variant">
                                        @if ($lang === '1')
                                            আপনার নাম *
                                        @else
                                            Full Name *
                                        @endif
                                    </label>
                                    <input type="text" name="full_name" required autocomplete="name"
                                        class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 py-2 placeholder:text-outline/50"
                                        placeholder="@if ($lang === '1') আপনার সম্পূর্ণ নাম লিখুন @else Enter your full name @endif" />
                                </div>

                                <!-- Phone -->
                                <div class="space-y-xs">
                                    <label class="font-label-md text-label-md text-on-surface-variant">
                                        @if ($lang === '1')
                                            ফোন নম্বর *
                                        @else
                                            Phone Number *
                                        @endif
                                    </label>
                                    <input type="tel" name="phone" required autocomplete="tel" pattern="[0-9]{11}"
                                        class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 py-2 placeholder:text-outline/50"
                                        placeholder="@if ($lang === '1') ০১XXXXXXXXX @else 01XXXXXXXXX @endif" />
                                </div>

                                <!-- Email (optional) -->
                                @if (setting('order_email_need'))
                                    <div class="md:col-span-2 space-y-xs">
                                        <label class="font-label-md text-label-md text-on-surface-variant">
                                            @if ($lang === '1')
                                                ইমেইল ঠিকানা
                                            @else
                                                Email Address
                                            @endif
                                        </label>
                                        <input type="email" name="email" autocomplete="email"
                                            class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 py-2 placeholder:text-outline/50"
                                            placeholder="your.email@example.com" />
                                    </div>
                                @endif
                            </div>

                            <!-- 2. Shipping Address -->
                            <div class="space-y-md mt-xl">
                                <div class="flex items-center gap-sm">
                                    <span
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-container text-on-primary-container font-label-md">2</span>
                                    <h2 class="font-headline-md text-[24px] text-primary">
                                        @if ($lang === '1')
                                            ডেলিভারি ঠিকানা
                                        @else
                                            Shipping Address
                                        @endif
                                    </h2>
                                </div>

                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-gutter bg-surface-container-low p-md rounded-xl">
                                    <!-- Address -->
                                    <div class="md:col-span-2 space-y-xs">
                                        <label class="font-label-md text-label-md text-on-surface-variant">
                                            @if ($lang === '1')
                                                বিস্তারিত ঠিকানা *
                                            @else
                                                Delivery Address *
                                            @endif
                                        </label>
                                        <textarea name="full_address" required rows="3" autocomplete="street-address"
                                            class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 py-2 placeholder:text-outline/50 resize-none"
                                            placeholder="@if ($lang === '1') বাড়ি/রোড নং, এলাকা, সিটি @else House/Road No, Area, City @endif"></textarea>
                                    </div>

                                    <!-- Delivery Area -->
                                    <div class="md:col-span-2 space-y-sm">
                                        <label class="font-label-md text-label-md text-on-surface-variant">
                                            @if ($lang === '1')
                                                ডেলিভারি এলাকা *
                                            @else
                                                Delivery Area *
                                            @endif
                                        </label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="delivery_area"
                                                    id="inside_dhaka" value="inside_dhaka" checked>
                                                <label for="inside_dhaka"
                                                    class="flex p-md border border-outline-variant rounded-xl cursor-pointer hover:border-primary/50 transition-all duration-300 bg-surface-container-low peer-checked:border-primary peer-checked:bg-primary/5">
                                                    <div>
                                                        <span class="block font-label-md text-on-surface">
                                                            @if ($lang === '1')
                                                                ঢাকার ভিতরে
                                                            @else
                                                                Inside Dhaka
                                                            @endif
                                                        </span>
                                                        <span
                                                            class="block font-caption text-caption text-on-surface-variant mt-1">
                                                            <span
                                                                id="inside_dhaka_price">{{ setting('delivery_charge_inside_dhaka') }}</span>
                                                            TK • 1-2 business days
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="relative">
                                                <input class="sr-only peer" type="radio" name="delivery_area"
                                                    id="outside_dhaka" value="outside_dhaka">
                                                <label for="outside_dhaka"
                                                    class="flex p-md border border-outline-variant rounded-xl cursor-pointer hover:border-primary/50 transition-all duration-300 bg-surface-container-low peer-checked:border-primary peer-checked:bg-primary/5">
                                                    <div>
                                                        <span class="block font-label-md text-on-surface">
                                                            @if ($lang === '1')
                                                                ঢাকার বাইরে
                                                            @else
                                                                Outside Dhaka
                                                            @endif
                                                        </span>
                                                        <span
                                                            class="block font-caption text-caption text-on-surface-variant mt-1">
                                                            <span
                                                                id="outside_dhaka_price">{{ setting('delivery_charge_outside_dhaka') }}</span>
                                                            TK • 3-5 business days
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes (Optional) -->
                            @if (setting('order_notes_need'))
                                <div class="space-y-xs mt-gutter">
                                    <label class="font-label-md text-label-md text-on-surface-variant">
                                        @if ($lang === '1')
                                            অতিরিক্ত নোট
                                        @else
                                            Additional Notes
                                        @endif
                                    </label>
                                    <textarea name="notes" rows="3"
                                        class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 py-2 placeholder:text-outline/50 resize-none"
                                        placeholder="@if ($lang === '1') গেটের রং, বিকল্প ফোন নম্বর, বিশেষ নির্দেশনা ইত্যাদি @else Gate color, alternative phone number, special instructions, etc. @endif"></textarea>
                                </div>
                            @endif

                            <!-- Submit -->
                            <div class="mt-xl">
                                <button type="submit" id="place-order-btn"
                                    class="w-full h-[56px] bg-primary text-white rounded-lg font-label-md text-lg hover:bg-primary-container transition-all duration-300 shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]"
                                        style="font-variation-settings:'FILL' 1;">lock</span>
                                    @if ($lang === '1')
                                        নিরাপদে অর্ডার দিন
                                    @else
                                        Place Order Securely
                                    @endif
                                </button>
                                <p class="font-caption text-caption text-on-surface-variant text-center mt-sm">
                                    <span class="material-symbols-outlined text-[12px] align-middle">lock</span>
                                    @if ($lang === '1')
                                        আপনার তথ্য নিরাপদে সংরক্ষণ করা হবে
                                    @else
                                        Your information is securely protected
                                    @endif
                                </p>
                            </div>
                        </form>
                    </section>

                    <!-- 3. Payment Method -->
                    <section class="space-y-md">
                        <div class="flex items-center gap-sm">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-container text-on-primary-container font-label-md">3</span>
                            <h2 class="font-headline-md text-[24px] text-primary">
                                @if ($lang === '1')
                                    পেমেন্ট পদ্ধতি
                                @else
                                    Payment Method
                                @endif
                            </h2>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-sm">
                            <div class="payment-card-active relative cursor-pointer p-md border border-outline-variant rounded-xl flex flex-col items-center gap-2 transition-all duration-300"
                                onclick="selectPayment(this)">
                                <span
                                    class="material-symbols-outlined text-primary text-[32px]">account_balance_wallet</span>
                                <span class="font-label-md text-[12px] uppercase tracking-wider">bKash</span>
                                <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-tertiary-fixed-dim"></div>
                            </div>
                            <div class="relative cursor-pointer p-md border border-outline-variant rounded-xl flex flex-col items-center gap-2 hover:border-primary/50 transition-all duration-300 bg-surface-container-low"
                                onclick="selectPayment(this)">
                                <span class="material-symbols-outlined text-primary text-[32px]">payments</span>
                                <span class="font-label-md text-[12px] uppercase tracking-wider">Nagad</span>
                            </div>
                            <div class="relative cursor-pointer p-md border border-outline-variant rounded-xl flex flex-col items-center gap-2 hover:border-primary/50 transition-all duration-300 bg-surface-container-low"
                                onclick="selectPayment(this)">
                                <span class="material-symbols-outlined text-primary text-[32px]">credit_card</span>
                                <span class="font-label-md text-[12px] uppercase tracking-wider">Card</span>
                            </div>
                            <div class="relative cursor-pointer p-md border border-outline-variant rounded-xl flex flex-col items-center gap-2 hover:border-primary/50 transition-all duration-300 bg-surface-container-low"
                                onclick="selectPayment(this)">
                                <span class="material-symbols-outlined text-primary text-[32px]">local_shipping</span>
                                <span class="font-label-md text-[12px] uppercase tracking-wider">C.O.D</span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-5">
                    <div
                        class="sticky top-28 glass-summary border border-white/40 p-md md:p-lg rounded-xl shadow-xl space-y-gutter">
                        <h3 class="font-headline-md text-[24px] text-primary">
                            @if ($lang === '1')
                                অর্ডার সামারি
                            @else
                                Order Summary
                            @endif
                        </h3>

                        <!-- Item List -->
                        <div class="space-y-md max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center gap-md">
                                    <div
                                        class="w-16 h-16 rounded-lg bg-surface-container-high flex-shrink-0 overflow-hidden">
                                        <img class="w-full h-full object-cover"
                                            src="{{ $item->product->images->where('is_primary', true)->first()
                                                ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                : 'https://placehold.co/400x400?text=No+Image' }}"
                                            alt="{{ $item->product->name }}" />
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-label-md text-on-surface line-clamp-2">
                                            {{ $item->product->name }}</p>
                                        @if ($item->attributes && $item->attributes->count() > 0)
                                            <div class="flex flex-wrap gap-xs mt-xs">
                                                @foreach ($item->attributes as $attribute)
                                                    <span
                                                        class="font-caption text-[10px] text-on-surface-variant bg-surface-container px-xs py-0.5 rounded-full">
                                                        {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <p class="font-caption text-on-surface-variant mt-xs">Qty:
                                            {{ $item->quantity }}</p>
                                    </div>
                                    <span
                                        class="font-label-md text-primary flex-shrink-0">৳{{ number_format($item->total_price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="h-[1px] bg-outline-variant/30"></div>

                        <!-- Promo Code -->
                        <div class="flex gap-2">
                            <input
                                class="flex-grow bg-surface-container-low border-0 border-b border-outline-variant focus:ring-0 focus:border-primary text-label-md px-2 py-2 placeholder:text-outline/50"
                                placeholder="Promo code" type="text" />
                            <button
                                class="font-label-md text-primary px-4 py-2 hover:bg-primary/5 rounded-lg transition-colors">Apply</button>
                        </div>

                        <!-- Totals -->
                        <div class="space-y-sm text-on-surface-variant">
                            <div class="flex justify-between font-label-md">
                                <span>
                                    @if ($lang === '1')
                                        মোট মূল্য
                                    @else
                                        Subtotal
                                    @endif
                                </span>
                                <span>৳{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-label-md">
                                <span>
                                    @if ($lang === '1')
                                        ডেলিভারি চার্জ
                                    @else
                                        Shipping
                                    @endif
                                </span>
                                <span
                                    id="delivery_charge">৳{{ number_format(setting('delivery_charge_inside_dhaka'), 2) }}</span>
                            </div>
                            @if ($cart->discount_amount > 0)
                                <div class="flex justify-between font-label-md text-secondary">
                                    <span>
                                        @if ($lang === '1')
                                            ডিসকাউন্ট
                                        @else
                                            Discount
                                        @endif
                                    </span>
                                    <span>-৳{{ number_format($cart->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div
                                class="flex justify-between font-bold text-lg text-on-surface pt-2 border-t border-outline-variant/30">
                                <span>
                                    @if ($lang === '1')
                                        সর্বমোট
                                    @else
                                        Total
                                    @endif
                                </span>
                                <span
                                    id="total_amount">৳{{ number_format($subtotal + setting('delivery_charge_inside_dhaka') - $cart->discount_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Complete Purchase Button -->
                        <button onclick="document.getElementById('checkout-form').submit()"
                            class="w-full h-[56px] bg-primary text-white rounded-lg font-label-md text-lg hover:bg-primary-container transition-all duration-300 shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                            @if ($lang === '1')
                                অর্ডার সম্পন্ন করুন
                            @else
                                Complete Purchase
                            @endif
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>

                        <!-- Order Confirmation Notice -->
                        <div class="p-md bg-surface-container rounded-lg border border-outline-variant/30">
                            <div class="flex items-start gap-sm">
                                <span class="material-symbols-outlined text-secondary text-[20px] mt-0.5"
                                    style="font-variation-settings:'FILL' 1;">check_circle</span>
                                <div>
                                    <p class="font-label-md text-on-surface mb-xs">
                                        @if ($lang === '1')
                                            আপনি এখনই অর্ডার নিশ্চিত করতে পারেন
                                        @else
                                            You're about to confirm your order
                                        @endif
                                    </p>
                                    <p class="font-caption text-caption text-on-surface-variant">
                                        @if ($lang === '1')
                                            অর্ডার নিশ্চিত হলে আমাদের প্রতিনিধি আপনার সাথে যোগাযোগ করবে
                                        @else
                                            Our representative will contact you after order confirmation
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-3 gap-2 pt-md border-t border-outline-variant/20">
                            <div class="flex flex-col items-center text-center gap-1">
                                <span
                                    class="material-symbols-outlined text-primary/60 text-[20px]">verified_user</span>
                                <span class="text-[10px] font-label-md uppercase text-on-surface-variant/80">Secure
                                    SSL</span>
                            </div>
                            <div class="flex flex-col items-center text-center gap-1">
                                <span class="material-symbols-outlined text-primary/60 text-[20px]">biotech</span>
                                <span class="text-[10px] font-label-md uppercase text-on-surface-variant/80">Lab
                                    Tested</span>
                            </div>
                            <div class="flex flex-col items-center text-center gap-1">
                                <span class="material-symbols-outlined text-primary/60 text-[20px]">eco</span>
                                <span
                                    class="text-[10px] font-label-md uppercase text-on-surface-variant/80">Organic</span>
                            </div>
                        </div>

                        <!-- Need Help -->
                        <div class="text-center pt-sm border-t border-outline-variant/20">
                            <p class="font-caption text-caption text-on-surface-variant mb-xs">
                                @if ($lang === '1')
                                    সাহায্য প্রয়োজন?
                                @else
                                    Need help with your order?
                                @endif
                            </p>
                            <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                class="inline-flex items-center gap-xs font-label-md text-primary hover:text-secondary transition-colors">
                                <span class="material-symbols-outlined text-[16px]">phone</span>
                                {{ setting('site_phone', '+8801621833839') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @push('scripts')
        <script>
            function selectPayment(element) {
                document.querySelectorAll('[onclick="selectPayment(this)"]').forEach(card => {
                    card.classList.remove('payment-card-active');
                    card.classList.add('bg-surface-container-low');
                    const dot = card.querySelector('.payment-dot');
                    if (dot) dot.remove();
                });
                element.classList.add('payment-card-active');
                element.classList.remove('bg-surface-container-low');
                const dot = document.createElement('div');
                dot.className = 'payment-dot absolute top-2 right-2 w-2 h-2 rounded-full bg-tertiary-fixed-dim';
                element.appendChild(dot);
            }

            function updateDelivery() {
                const selectedOption = document.querySelector('input[name="delivery_area"]:checked');
                if (!selectedOption) return;

                const insideDhakaPrice = parseFloat(document.getElementById('inside_dhaka_price').textContent);
                const outsideDhakaPrice = parseFloat(document.getElementById('outside_dhaka_price').textContent);
                const deliveryCharge = selectedOption.value === 'inside_dhaka' ? insideDhakaPrice : outsideDhakaPrice;

                const deliveryChargeElement = document.getElementById('delivery_charge');
                if (deliveryChargeElement) {
                    deliveryChargeElement.innerHTML = '৳' + deliveryCharge.toFixed(2);
                }

                const subtotal = parseFloat("{{ $subtotal }}");
                const discount = parseFloat("{{ $cart->discount_amount ?? 0 }}");
                const total = subtotal + deliveryCharge - discount;

                const totalAmountElement = document.getElementById('total_amount');
                if (totalAmountElement) {
                    totalAmountElement.innerHTML = '৳' + total.toFixed(2);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('input[name="delivery_area"]').forEach(option => {
                    option.addEventListener('change', updateDelivery);
                });
                updateDelivery();

                const checkoutForm = document.getElementById('checkout-form');
                if (checkoutForm) {
                    checkoutForm.addEventListener('submit', function(e) {
                        const fullName = checkoutForm.querySelector('input[name="full_name"]').value.trim();
                        const phone = checkoutForm.querySelector('input[name="phone"]').value.trim();
                        const address = checkoutForm.querySelector('textarea[name="full_address"]').value
                    .trim();

                        if (!fullName || !phone || !address) {
                            e.preventDefault();
                            alert('Please fill in all required fields.');
                            return;
                        }

                        const phoneRegex = /^01[3-9]\d{8}$/;
                        if (!phoneRegex.test(phone)) {
                            e.preventDefault();
                            alert(
                            'Please enter a valid Bangladeshi phone number (11 digits starting with 01).');
                            return;
                        }

                        const btn = document.getElementById('place-order-btn');
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = `
                                <div class="flex items-center justify-center gap-2">
                                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                                    <span>@if ($lang === '1') প্রসেসিং... @else Processing... @endif</span>
                                </div>
                            `;
                        }
                    });
                }

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
    @endpush
</x-app-layout>
