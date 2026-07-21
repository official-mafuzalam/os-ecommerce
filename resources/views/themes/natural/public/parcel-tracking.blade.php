<x-app-layout>
    @section('title', 'Track Your Order | OS Ecommerce')

    @push('styles')
        <link
            href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
            rel="stylesheet" />
        <style>
            /* Custom overrides for specific brand fonts requested */
            .font-cormorant {
                font-family: 'Cormorant Garamond', serif;
            }

            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }

            @keyframes pulse-gold {
                0% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(232, 192, 102, 0.7);
                }

                70% {
                    transform: scale(1.05);
                    box-shadow: 0 0 0 10px rgba(232, 192, 102, 0);
                }

                100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(232, 192, 102, 0);
                }
            }

            .animate-pulse-gold {
                animation: pulse-gold 2s infinite;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .timeline-line {
                background: linear-gradient(90deg, #2d6a46 0%, #2d6a46 75%, #e5e2db 75%, #e5e2db 100%);
            }
        </style>
    @endpush

    <x-slot name="main">
        <div class="pb-xl">
            <!-- Hero Section -->
            <section class="max-w-container-max mx-auto px-margin-desktop mt-2 mb-xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-lg items-center">
                    <div class="space-y-6">
                        <h1 class="font-display-lg text-display-lg text-primary leading-tight">Track Your Order</h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-md">
                            Stay updated with your order from confirmation to delivery. Enter your details
                            below to see exactly where your natural wellness products are.
                        </p>
                    </div>
                    <div class="relative flex justify-center lg:justify-end">
                        <div
                            class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-secondary-container/30 blur-3xl rounded-full">
                        </div>
                        <div class="w-full max-w-md aspect-square rounded-3xl overflow-hidden shadow-2xl relative">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzbfkMAdMCN1j4im9Lgk0sm_yuIqWg0_YxM1X4cX0mkBOPgj94kcur2oP5mAUWiFvXdFjSRO6ziJ1CAHu8zum7lOaZMgMgKKaVAtPcp3el27OKnYBYeXZD_pFFtJYL2YAZYYpkFMpkx4Puk3prpKSqQSQ7khIQ7I-R9a4MbYDrwDmecfyX_9_cLRSp2WXSz6qiDKsx--u6Nc0-KcjDf_LOfCxxXkqTpEUnKEk7v7sKz7m4tlIyZP6VCzYXfNhDKfXkYUNh9CT17wvo" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tracking Search Card -->
            <section class="max-w-container-max mx-auto px-margin-desktop -mt-16 relative z-10">
                <div class="bg-surface-container-lowest p-8 md:p-12 rounded-3xl shadow-xl border border-outline-variant/20 max-w-4xl mx-auto transform transition-all duration-700 hover:shadow-2xl search-card"
                    style="opacity: 0; transform: translateY(20px);">
                    <form action="{{ route('public.parcel.tracking.submit') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <div class="md:col-span-2 space-y-2">
                                <label class="font-label-md text-on-surface-variant">Tracking Number / Order
                                    Number</label>
                                <input id="tracking_number" name="tracking_number"
                                    value="{{ old('tracking_number', request('tracking_number')) }}" required
                                    class="w-full h-14 bg-surface-container rounded-xl border-none focus:ring-2 focus:ring-primary px-6 font-poppins text-on-surface placeholder:text-outline"
                                    placeholder="e.g. TRK123456789" type="text" autocomplete="off" />
                                @error('tracking_number')
                                    <p class="mt-2 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full h-14 bg-primary text-white rounded-xl font-label-md hover:bg-primary-container transition-all active:scale-95 flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">my_location</span>
                                    Track Order
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-6 flex justify-center">
                        <button
                            class="text-secondary font-label-md flex items-center gap-2 hover:underline decoration-2 transition-all">
                            <span class="material-symbols-outlined">smartphone</span>
                            Track with Phone Number
                        </button>
                    </div>
                </div>
            </section>

            @if (session('error'))
                <section class="max-w-container-max mx-auto px-margin-desktop mt-xl">
                    <div class="bg-[#ffdad6] border border-[#ba1a1a]/20 rounded-3xl p-8 text-center max-w-4xl mx-auto">
                        <div
                            class="w-16 h-16 rounded-full bg-[#ba1a1a]/10 text-[#ba1a1a] flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl">error</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#ba1a1a] mb-2">Order Not Found</h3>
                        <p class="text-[#ba1a1a]/80 mb-4">{{ session('error') }}</p>
                    </div>
                </section>
            @endif

            @if (isset($order))
                <!-- Tracking Result & Timeline -->
                <section class="max-w-container-max mx-auto px-margin-desktop mt-xl">
                    <div class="bg-surface-container-low rounded-3xl p-8 md:p-12">
                        <!-- Status Header -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                            <div class="space-y-2">
                                <span class="font-label-md text-on-surface-variant uppercase tracking-widest">Current
                                    Status</span>
                                <div class="flex items-center gap-4">
                                    <h2 class="font-headline-md text-headline-md text-primary font-bold">
                                        {{ ucfirst($order->status) }}</h2>
                                    @if (!in_array($order->status, ['delivered', 'cancelled']))
                                        <div
                                            class="bg-primary/10 px-4 py-1.5 rounded-full flex items-center gap-2 animate-pulse-gold">
                                            <span class="w-2.5 h-2.5 bg-primary rounded-full"></span>
                                            <span class="font-label-md text-primary">Active</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-label-md text-on-surface-variant">Estimated Delivery</p>
                                <p class="font-headline-sm text-headline-sm text-secondary font-bold">
                                    {{ $order->estimated_delivery ? $order->estimated_delivery->format('M d, Y') : 'To be confirmed' }}
                                </p>
                            </div>
                        </div>

                        <!-- Modern Horizontal Timeline -->
                        @php
                            $statusOrder = ['ordered', 'confirmed', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statusOrder);
                            if ($currentIndex === false && $order->status === 'cancelled') {
                                $currentIndex = -1; // hide progress
                            }
                            $progress = $currentIndex >= 0 ? ($currentIndex / (count($statusOrder) - 1)) * 100 : 0;

                            $trackingEvents = [
                                'ordered' => [
                                    'label' => 'Order Placed',
                                    'description' => 'Your order has been received',
                                    'date' => $order->created_at,
                                    'icon' => 'shopping_cart',
                                ],
                                'confirmed' => [
                                    'label' => 'Confirmed',
                                    'description' => 'Payment verified',
                                    'date' => $order->created_at->addHours(2),
                                    'icon' => 'check_circle',
                                ],
                                'processing' => [
                                    'label' => 'Processing',
                                    'description' => 'Preparing items',
                                    'date' => $order->created_at->addDay(),
                                    'icon' => 'inventory_2',
                                ],
                                'shipped' => [
                                    'label' => 'Shipped',
                                    'description' => 'On the way',
                                    'date' => $order->created_at->addDays(2),
                                    'icon' => 'local_shipping',
                                ],
                                'delivered' => [
                                    'label' => 'Delivered',
                                    'description' => 'Successfully delivered',
                                    'date' => $order->created_at->addDays(4),
                                    'icon' => 'task_alt',
                                ],
                            ];
                        @endphp

                        @if ($order->status !== 'cancelled')
                            <div class="relative py-8 overflow-x-auto">
                                <div class="flex flex-row justify-between items-start min-w-[800px] relative z-10">
                                    <!-- Progress Line -->
                                    <div
                                        class="absolute top-[28px] left-[10%] right-[10%] h-1 bg-surface-variant rounded-full overflow-hidden z-0">
                                        <div class="h-full bg-primary transition-all duration-1000"
                                            style="width: {{ $progress }}%"></div>
                                    </div>

                                    @foreach ($statusOrder as $index => $status)
                                        @php
                                            $isActive = $index === $currentIndex;
                                            $isPast = $index < $currentIndex;
                                            $isFuture = $index > $currentIndex;
                                            $event = $trackingEvents[$status];
                                        @endphp
                                        <div
                                            class="flex flex-col items-center text-center w-1/5 {{ $isFuture ? 'opacity-40' : '' }} relative z-10">
                                            @if ($isActive)
                                                <div
                                                    class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center mb-3 shadow-xl ring-4 ring-white flex-shrink-0">
                                                    <span class="material-symbols-outlined">{{ $event['icon'] }}</span>
                                                </div>
                                                <h4 class="font-label-md text-primary font-bold whitespace-nowrap">
                                                    {{ $event['label'] }}</h4>
                                                @if (!$isFuture)
                                                    <p
                                                        class="text-[11px] text-on-surface-variant mt-1 leading-tight px-2">
                                                        {{ $event['description'] }}</p>
                                                    <p class="text-[11px] text-on-surface-variant font-bold mt-0.5">
                                                        {{ $event['date']->format('M d, h:i A') }}</p>
                                                @endif
                                            @elseif($isPast)
                                                <div
                                                    class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center mb-4 shadow-lg ring-4 ring-surface-container-low flex-shrink-0">
                                                    <span class="material-symbols-outlined">check</span>
                                                </div>
                                                <h4 class="font-label-md text-primary whitespace-nowrap">
                                                    {{ $event['label'] }}</h4>
                                                <p class="text-[11px] text-on-surface-variant mt-1 leading-tight px-2">
                                                    {{ $event['description'] }}</p>
                                                <p class="text-[11px] text-on-surface-variant font-bold mt-0.5">
                                                    {{ $event['date']->format('M d, h:i A') }}</p>
                                            @else
                                                <div
                                                    class="w-12 h-12 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center mb-4 ring-4 ring-surface-container-low flex-shrink-0">
                                                    <span class="material-symbols-outlined">{{ $event['icon'] }}</span>
                                                </div>
                                                <h4 class="font-label-md text-on-surface-variant whitespace-nowrap">
                                                    {{ $event['label'] }}</h4>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Details Cards -->
                <section class="max-w-container-max mx-auto px-margin-desktop mt-lg">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
                        <!-- Courier Information Card -->
                        <div
                            class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/30 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="font-headline-sm text-headline-sm text-primary">Order Information</h3>
                                <span class="material-symbols-outlined text-secondary">receipt_long</span>
                            </div>
                            <div class="flex items-center gap-6 mb-8">
                                <div>
                                    <p class="font-headline-sm text-headline-sm font-bold">Order
                                        #{{ $order->order_number }}</p>
                                    <div class="font-label-md text-on-surface-variant flex items-center gap-2">
                                        Tracking: <span id="tracking_display">{{ $order->tracking_number }}</span>
                                        <button id="copy_tracking"
                                            class="hover:text-primary transition-colors flex items-center justify-center"
                                            title="Copy tracking number">
                                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4 border-t border-outline-variant/20 pt-6">
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Order Date</span>
                                    <span class="font-bold">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Carrier</span>
                                    <span class="font-bold">{{ $order->carrier ?? 'Standard Shipping' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div
                            class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/30 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="font-headline-sm text-headline-sm text-primary">Shipping Details</h3>
                                <span class="material-symbols-outlined text-secondary">home_pin</span>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <p class="font-label-md text-on-surface-variant mb-1">Delivery Address</p>
                                    <p class="font-body-md text-on-surface">
                                        {{ optional($order->shippingAddress)->full_address ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Order Summary -->
                <section class="max-w-container-max mx-auto px-margin-desktop mt-lg">
                    <div class="bg-surface-container-highest rounded-3xl p-8 md:p-12 overflow-hidden relative">
                        <div class="absolute -right-16 -top-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-8 relative z-10">Items</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                            <div class="lg:col-span-2 space-y-4 relative z-10">
                                @foreach ($order->items as $item)
                                    <div class="flex gap-6 items-center p-4 bg-white/50 rounded-2xl">
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-surface flex-shrink-0">
                                            <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://placehold.co/400x400?text=No+Image' }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover" />
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="font-body-lg font-bold text-primary">{{ $item->product->name }}
                                            </h4>
                                            <p class="mt-1 font-label-md text-secondary">Qty: {{ $item->quantity }}
                                            </p>
                                        </div>
                                        <p class="font-headline-sm text-headline-sm font-bold">
                                            ৳{{ number_format($item->unit_price, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div
                                class="bg-primary p-8 rounded-3xl text-white shadow-xl relative overflow-hidden h-fit">
                                <div class="absolute top-0 right-0 p-4 opacity-10">
                                    <span class="material-symbols-outlined text-[120px]">receipt_long</span>
                                </div>
                                <h4 class="font-headline-sm mb-6 pb-4 border-b border-white/20">Total</h4>
                                <div class="space-y-4 font-label-md">
                                    <div class="pt-2 flex justify-between items-center">
                                        <span class="text-lg">Grand Total</span>
                                        <span
                                            class="text-2xl font-bold">৳{{ number_format($order->items->sum(function ($item) {return $item->unit_price * $item->quantity;}),2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            @if (isset($recommendedProducts) && $recommendedProducts->count() > 0)
                <!-- Recommended Products -->
                <section class="max-w-container-max mx-auto px-margin-desktop mt-xl">
                    <div class="flex items-end justify-between mb-10">
                        <div>
                            <h2 class="font-headline-md text-headline-md text-primary">You May Also Like</h2>
                        </div>
                        <a class="font-label-md text-primary hover:underline"
                            href="{{ route('public.products') }}">View All Shop</a>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-gutter">
                        @foreach ($recommendedProducts as $product)
                            @include('themes.natural.public.products.partial.product-card', [
                                'product' => $product,
                            ])
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Need Help Section -->
            <section class="max-w-container-max mx-auto px-margin-desktop mt-xl text-center">
                <h2 class="font-headline-md text-headline-md text-primary mb-4">Need Help with your Order?</h2>
                <p class="text-on-surface-variant mb-12 max-w-xl mx-auto">Our dedicated support team is here to assist
                    you
                    with any questions regarding your parcel or products.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    <a class="group p-8 rounded-3xl border border-outline-variant/30 hover:bg-primary transition-all duration-300"
                        href="{{ route('public.contact') }}">
                        <span
                            class="material-symbols-outlined text-4xl text-primary group-hover:text-white mb-4 transition-colors">forum</span>
                        <h4 class="font-headline-sm group-hover:text-white transition-colors">Support Ticket</h4>
                        <p class="text-on-surface-variant group-hover:text-white/80 transition-colors mt-2">Send us a
                            message</p>
                    </a>
                    <a class="group p-8 rounded-3xl border border-outline-variant/30 hover:bg-primary transition-all duration-300"
                        href="tel:{{ setting('site_phone', '+8801621833839') }}">
                        <span
                            class="material-symbols-outlined text-4xl text-primary group-hover:text-white mb-4 transition-colors">call</span>
                        <h4 class="font-headline-sm group-hover:text-white transition-colors">Call Us</h4>
                        <p class="text-on-surface-variant group-hover:text-white/80 transition-colors mt-2">
                            {{ setting('site_phone', '+8801621833839') }}</p>
                    </a>
                    <a class="group p-8 rounded-3xl border border-outline-variant/30 hover:bg-primary transition-all duration-300"
                        href="mailto:{{ setting('site_email', 'hello@prokitisudha.com') }}">
                        <span
                            class="material-symbols-outlined text-4xl text-primary group-hover:text-white mb-4 transition-colors">email</span>
                        <h4 class="font-headline-sm group-hover:text-white transition-colors">Email</h4>
                        <p class="text-on-surface-variant group-hover:text-white/80 transition-colors mt-2">
                            {{ setting('site_email', 'hello@prokitisudha.com') }}</p>
                    </a>
                </div>
            </section>

            <!-- FAQ Accordion -->
            <section class="max-w-3xl mx-auto px-margin-desktop mt-xl">
                <h2 class="font-headline-md text-headline-md text-primary text-center mb-10">Frequently Asked Questions
                </h2>
                <div class="space-y-4">
                    <details
                        class="group bg-surface-container-low rounded-2xl overflow-hidden border border-outline-variant/10">
                        <summary
                            class="flex justify-between items-center p-6 cursor-pointer list-none font-label-md text-primary">
                            <span>Where is my parcel right now?</span>
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-6 pb-6 text-on-surface-variant font-body-md">
                            Your parcel's location is updated in real-time by our logistics partners. If it's "Out for
                            Delivery," it means a rider is currently on the way to your location.
                        </div>
                    </details>
                    <details
                        class="group bg-surface-container-low rounded-2xl overflow-hidden border border-outline-variant/10">
                        <summary
                            class="flex justify-between items-center p-6 cursor-pointer list-none font-label-md text-primary">
                            <span>How long does delivery usually take?</span>
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-6 pb-6 text-on-surface-variant font-body-md">
                            Inside Dhaka, we deliver within 24-48 hours. Outside Dhaka, it typically takes 3-5 business
                            days
                            depending on your location.
                        </div>
                    </details>
                </div>
            </section>
        </div>
    </x-slot>

    @push('scripts')
        <script>
            // Micro-interactions and subtle effects
            document.addEventListener('DOMContentLoaded', () => {
                // Auto-focus tracking input
                const trackingInput = document.getElementById('tracking_number');
                if (trackingInput) {
                    trackingInput.focus();
                    trackingInput.addEventListener('click', function() {
                        this.select();
                    });
                }

                // Copy tracking number logic
                const copyBtn = document.getElementById('copy_tracking');
                if (copyBtn) {
                    copyBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const trackingNumber = document.getElementById('tracking_display').innerText;
                        navigator.clipboard.writeText(trackingNumber).then(() => {
                            const icon = this.querySelector('.material-symbols-outlined');
                            const originalIcon = icon.innerText;
                            icon.innerText = 'check';
                            icon.classList.add('text-green-600');
                            setTimeout(() => {
                                icon.innerText = originalIcon;
                                icon.classList.remove('text-green-600');
                            }, 2000);
                        });
                    });
                }

                const searchCard = document.querySelector('.search-card');
                if (searchCard) {
                    setTimeout(() => {
                        searchCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                        searchCard.style.opacity = '1';
                        searchCard.style.transform = 'translateY(0)';
                    }, 100);
                }

                // Accordion focus state handling
                const details = document.querySelectorAll('details');
                details.forEach(targetDetail => {
                    targetDetail.addEventListener('click', () => {
                        details.forEach(detail => {
                            if (detail !== targetDetail) {
                                detail.removeAttribute('open');
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
