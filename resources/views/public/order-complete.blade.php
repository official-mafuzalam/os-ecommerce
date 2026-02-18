<x-app-layout>
    @section('title', 'Order Confirmed')
    <x-slot name="main">
        <!-- Fashion Order Confirmation -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <div class="max-w-4xl mx-auto">
                <!-- Confirmation Header -->
                <div class="text-center mb-12">
                    <div
                        class="w-32 h-32 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-check text-5xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 elegant-heading">Order Confirmed!</h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Thank you for your purchase. Your order is being processed and we'll send you updates soon.
                    </p>
                </div>

                <!-- Order Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <!-- Order Header -->
                    <div class="bg-gray-900 text-white px-6 md:px-8 py-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold mb-1">Order #{{ $order->order_number }}</h2>
                                <p class="text-gray-300">{{ now()->format('F j, Y • g:i A') }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <span class="text-sm font-medium">Status: </span>
                                <span class="font-bold text-green-300">Confirmed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="p-6 md:p-8">
                        <!-- Summary Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Order Summary</h3>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Items Total</span>
                                        <span class="font-medium">{{ number_format($order->subtotal) }} TK</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-medium">{{ number_format($order->shipping_cost) }} TK</span>
                                    </div>
                                    <div class="flex justify-between pt-3 border-t border-gray-200">
                                        <span class="text-lg font-bold">Total Amount</span>
                                        <span
                                            class="text-xl font-bold text-gray-900">{{ number_format($order->total_amount) }}
                                            TK</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Shipping Details</h3>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm text-gray-500 block">Recipient</span>
                                        <span
                                            class="font-medium">{{ $order->shippingAddress->full_name ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 block">Phone</span>
                                        <span class="font-medium">{{ $order->customer_phone ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 block">Address</span>
                                        <span
                                            class="text-sm">{{ $order->shippingAddress->full_address ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Delivery Info</h3>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                            <span class="text-sm font-medium text-gray-600">Estimated Delivery</span>
                                        </div>
                                        <span class="text-lg font-bold text-gray-900">
                                            {{ now()->addDays(2)->format('l, F j') }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas fa-clock text-gray-400 text-sm"></i>
                                            <span class="text-sm font-medium text-gray-600">Shipping Method</span>
                                        </div>
                                        <span class="font-medium">
                                            {{ $order->delivery_area == 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Order Items</h3>
                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div
                                        class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <!-- Product Image -->
                                        <div
                                            class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ $item->product->images->where('is_primary', true)->first()
                                                ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                : 'https://placehold.co/400x400?text=No+Image' }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-grow">
                                            <div
                                                class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-1">
                                                        {{ $item->product->name }}</h4>
                                                    @if ($item->attributes && $item->attributes->count() > 0)
                                                        <div class="flex flex-wrap gap-1 mt-1">
                                                            @foreach ($item->attributes as $attribute)
                                                                <span
                                                                    class="text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                                                                    {{ $attribute->name }}:
                                                                    {{ $attribute->pivot->value }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-6">
                                                    <div class="text-right">
                                                        <span class="text-sm text-gray-600">Quantity</span>
                                                        <p class="font-medium">{{ $item->quantity }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-sm text-gray-600">Price</span>
                                                        <p class="font-bold text-gray-900">
                                                            {{ number_format($item->price * $item->quantity) }} TK</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="bg-green-50 rounded-xl p-6 border border-green-200 mb-8">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                        <i class="fas fa-credit-card text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Payment Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm text-gray-600 block">Payment Method</span>
                                            <span class="font-medium">Cash on Delivery</span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600 block">Payment Status</span>
                                            <span class="font-medium text-green-600">Pending</span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600 block">Payment Due</span>
                                            <span
                                                class="font-bold text-gray-900">{{ number_format($order->total_amount) }}
                                                TK</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <i class="fas fa-info-circle text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3">What Happens Next?</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                                    <span class="text-sm font-bold">1</span>
                                                </div>
                                                <h4 class="font-semibold text-gray-900">Order Processing</h4>
                                            </div>
                                            <p class="text-sm text-gray-600">We'll prepare your items for shipment
                                                within 24 hours.</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                                    <span class="text-sm font-bold">2</span>
                                                </div>
                                                <h4 class="font-semibold text-gray-900">Shipping</h4>
                                            </div>
                                            <p class="text-sm text-gray-600">Your order will be dispatched and tracking
                                                details shared.</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                                    <span class="text-sm font-bold">3</span>
                                                </div>
                                                <h4 class="font-semibold text-gray-900">Delivery</h4>
                                            </div>
                                            <p class="text-sm text-gray-600">Our delivery partner will contact you
                                                before arrival.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                    <a href="{{ route('public.products') }}"
                        class="fashion-btn-outline flex items-center justify-center gap-3 py-4 text-lg">
                        <i class="fas fa-shopping-bag"></i>
                        Continue Shopping
                    </a>
                    <a href="{{ route('public.parcel.tracking') }}"
                        class="fashion-btn flex items-center justify-center gap-3 py-4 text-lg">
                        <i class="fas fa-map-marker-alt"></i>
                        Track Your Order
                    </a>
                </div>

                <!-- Support & Help -->
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Need Assistance?</h3>
                        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                            Our customer support team is here to help you with any questions about your order.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <a href="mailto:{{ setting('site_email', 'support@example.com') }}"
                                class="group bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-900 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-envelope text-lg"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Email Support</h4>
                                <p class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                    {{ setting('site_email', 'support@example.com') }}
                                </p>
                            </a>
                            <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                class="group bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-900 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-phone-alt text-lg"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Call Us</h4>
                                <p class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                    {{ setting('site_phone', '+8801621833839') }}
                                </p>
                            </a>
                            <a href="{{ route('public.contact') }}"
                                class="group bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-900 transition-colors">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-headset text-lg"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Live Chat</h4>
                                <p class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                    Available 9AM-11PM
                                </p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Confirmation Email -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        A confirmation email has been sent to
                        <span class="font-medium text-gray-900">{{ $order->customer_email }}</span>.
                        Please check your inbox (and spam folder).
                    </p>
                </div>
            </div>
        </div>

        <!-- Confetti Animation (Optional) -->
        <style>
            .confetti {
                position: fixed;
                width: 10px;
                height: 10px;
                background-color: #f59e0b;
                opacity: 0;
                animation: confetti-fall 3s linear forwards;
                z-index: 9999;
            }

            @keyframes confetti-fall {
                0% {
                    transform: translateY(-100px) rotate(0deg);
                    opacity: 1;
                }

                100% {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Create confetti effect
                function createConfetti() {
                    const colors = ['#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ef4444'];
                    for (let i = 0; i < 50; i++) {
                        const confetti = document.createElement('div');
                        confetti.className = 'confetti';
                        confetti.style.left = Math.random() * 100 + 'vw';
                        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                        confetti.style.animationDelay = Math.random() * 2 + 's';
                        confetti.style.width = Math.random() * 10 + 5 + 'px';
                        confetti.style.height = Math.random() * 10 + 5 + 'px';
                        document.body.appendChild(confetti);

                        // Remove after animation
                        setTimeout(() => {
                            confetti.remove();
                        }, 4000);
                    }
                }

                // Trigger confetti on page load
                setTimeout(createConfetti, 500);

                // Print order functionality
                function printOrder() {
                    window.print();
                }

                // Add print button functionality
                const printBtn = document.createElement('button');
                printBtn.innerHTML = '<i class="fas fa-print mr-2"></i>Print Receipt';
                printBtn.className =
                    'fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-700 transition-colors z-50 hidden md:flex items-center gap-2';
                printBtn.onclick = printOrder;
                document.body.appendChild(printBtn);

                // Add social share functionality
                const shareBtn = document.createElement('button');
                shareBtn.innerHTML = '<i class="fas fa-share-alt mr-2"></i>Share';
                shareBtn.className =
                    'fixed bottom-4 left-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-700 transition-colors z-50 hidden md:flex items-center gap-2';
                shareBtn.onclick = async function() {
                    try {
                        await navigator.share({
                            title: 'Order Confirmed!',
                            text: `I just ordered from ${window.location.hostname}. Order #${'{{ $order->order_number }}'}`,
                            url: window.location.href,
                        });
                    } catch (err) {
                        // Fallback to clipboard copy
                        navigator.clipboard.writeText(window.location.href);
                        alert('Link copied to clipboard!');
                    }
                };
                document.body.appendChild(shareBtn);

                // Animate order number
                const orderNumber = document.querySelector('h2.text-2xl');
                if (orderNumber) {
                    orderNumber.style.opacity = '0';
                    orderNumber.style.transform = 'translateY(20px)';
                    orderNumber.style.transition = 'all 0.6s ease-out';

                    setTimeout(() => {
                        orderNumber.style.opacity = '1';
                        orderNumber.style.transform = 'translateY(0)';
                    }, 300);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
