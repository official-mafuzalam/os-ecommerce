<x-app-layout>
    <x-slot name="main">
        <!-- Fashion Order Tracking -->
        <div class="container mx-auto px-4 py-8 md:py-12 max-w-6xl">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <!-- Header -->
                <div class="text-center mb-10">
                    <div
                        class="w-20 h-20 rounded-full bg-gray-900 text-white flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shipping-fast text-2xl"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 elegant-heading">Track Your Order</h1>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Enter your tracking number below to get real-time updates on your order's journey
                    </p>
                </div>

                <!-- Tracking Form -->
                <form action="{{ route('public.parcel.tracking.submit') }}" method="POST" class="mb-12">
                    @csrf
                    <div class="max-w-xl mx-auto">
                        <div class="mb-6">
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Tracking Number *
                            </label>
                            <div class="relative">
                                <i
                                    class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="tracking_number" name="tracking_number"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                    placeholder="e.g., TRK123456789"
                                    value="{{ old('tracking_number', request('tracking_number')) }}" required
                                    autocomplete="off">
                            </div>
                            @error('tracking_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                class="fashion-btn px-8 py-3 flex items-center justify-center gap-3 mx-auto">
                                <i class="fas fa-search"></i>
                                Track Order
                            </button>
                            <p class="text-xs text-gray-500 mt-3">
                                Your tracking number can be found in your order confirmation email
                            </p>
                        </div>
                    </div>
                </form>

                @if (isset($order))
                    <!-- Tracking Results -->
                    <div class="border-t border-gray-200 pt-10">
                        <!-- Order Summary -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <span class="text-sm text-gray-600 block mb-1">Order Number</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 block mb-1">Tracking Number</span>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ $order->tracking_number }}</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 block mb-1">Order Date</span>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 block mb-1">Current Status</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium 
                                        @if ($order->status == 'delivered') bg-green-100 text-green-800 border border-green-200
                                        @elseif($order->status == 'shipped') bg-blue-100 text-blue-800 border border-blue-200
                                        @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800 border border-red-200
                                        @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Details -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                            <!-- Shipping Information -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-gray-600"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Shipping Details</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <span class="text-sm text-gray-600 block">Shipping Address</span>
                                        <span class="text-gray-900">{{ $order->shipping_address }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm text-gray-600 block">Carrier</span>
                                            <span
                                                class="text-gray-900">{{ $order->carrier ?? 'Standard Shipping' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600 block">Estimated Delivery</span>
                                            <span class="text-gray-900">
                                                @if ($order->estimated_delivery)
                                                    {{ $order->estimated_delivery->format('M d, Y') }}
                                                @else
                                                    To be confirmed
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-box text-gray-600"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Order Summary</h3>
                                </div>
                                <div class="space-y-4">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ $item->product->images->where('is_primary', true)->first()
                                                    ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                    : 'https://placehold.co/400x400?text=No+Image' }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-grow">
                                                <h4 class="font-medium text-gray-900 text-sm">
                                                    {{ $item->product->name }}</h4>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-sm text-gray-600">Qty:
                                                        {{ $item->quantity }}</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ number_format($item->price, 2) }}
                                                        TK</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Tracking Timeline -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-history text-gray-600"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Tracking History</h3>
                            </div>

                            <!-- Progress Bar -->
                            @php
                                $statusOrder = ['ordered', 'confirmed', 'processing', 'shipped', 'delivered'];
                                $currentIndex = array_search($order->status, $statusOrder);
                                $progress = (($currentIndex + 1) / count($statusOrder)) * 100;
                            @endphp
                            <div class="mb-8">
                                <div class="flex justify-between mb-2">
                                    @foreach ($statusOrder as $index => $status)
                                        <span
                                            class="text-xs font-medium 
                                            @if ($index <= $currentIndex) text-gray-900 @else text-gray-400 @endif">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-900 rounded-full transition-all duration-500"
                                        style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <!-- Timeline Details -->
                            <div class="relative pl-8">
                                <!-- Vertical Line -->
                                <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                                @php
                                    $trackingEvents = [
                                        [
                                            'status' => 'ordered',
                                            'label' => 'Order Placed',
                                            'description' => 'Your order has been received',
                                            'date' => $order->created_at,
                                            'icon' => 'fas fa-shopping-cart',
                                        ],
                                        [
                                            'status' => 'confirmed',
                                            'label' => 'Order Confirmed',
                                            'description' => 'Order confirmed and payment verified',
                                            'date' => $order->created_at->addHours(2),
                                            'icon' => 'fas fa-check-circle',
                                        ],
                                        [
                                            'status' => 'processing',
                                            'label' => 'Processing',
                                            'description' => 'Preparing your items for shipment',
                                            'date' => $order->created_at->addDay(),
                                            'icon' => 'fas fa-box-open',
                                        ],
                                    ];

                                    if ($order->status == 'shipped' || $order->status == 'delivered') {
                                        $trackingEvents[] = [
                                            'status' => 'shipped',
                                            'label' => 'Shipped',
                                            'description' => 'Your order is on the way',
                                            'date' => $order->created_at->addDays(2),
                                            'icon' => 'fas fa-shipping-fast',
                                        ];
                                    }

                                    if ($order->status == 'delivered') {
                                        $trackingEvents[] = [
                                            'status' => 'delivered',
                                            'label' => 'Delivered',
                                            'description' => 'Order successfully delivered',
                                            'date' => $order->created_at->addDays(4),
                                            'icon' => 'fas fa-home',
                                        ];
                                    }
                                @endphp

                                <div class="space-y-8">
                                    @foreach ($trackingEvents as $index => $event)
                                        <div class="relative">
                                            <!-- Timeline Dot -->
                                            <div
                                                class="absolute -left-9 top-0 w-6 h-6 rounded-full border-4 border-white 
                                                @if ($index <= $currentIndex) bg-gray-900 @else bg-gray-300 @endif
                                                shadow flex items-center justify-center">
                                                @if ($index <= $currentIndex)
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                @endif
                                            </div>

                                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                <div class="flex items-start justify-between">
                                                    <div>
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <i
                                                                class="{{ $event['icon'] }} 
                                                                @if ($index <= $currentIndex) text-gray-900 @else text-gray-400 @endif"></i>
                                                            <h4 class="font-semibold text-gray-900">
                                                                {{ $event['label'] }}</h4>
                                                        </div>
                                                        <p class="text-sm text-gray-600">{{ $event['description'] }}
                                                        </p>
                                                    </div>
                                                    <span class="text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $event['date']->format('M d, Y • h:i A') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(session('error'))
                    <!-- Error Message -->
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Order Not Found</h3>
                            <p class="text-gray-600 mb-4">{{ session('error') }}</p>
                            <div class="space-y-3">
                                <p class="text-sm text-gray-600">Please check:</p>
                                <ul class="text-sm text-gray-600 text-left max-w-md mx-auto space-y-2">
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        <span>The tracking number is correct</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        <span>Your order has been processed</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        <span>Allow 24 hours for tracking to activate</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Help Section -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Need Help With Your Order?</h2>
                        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                            Our customer support team is available to assist you with any questions about your order or
                            delivery.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('public.contact') }}"
                                class="fashion-btn-outline px-6 py-3 inline-flex items-center justify-center gap-2">
                                <i class="fas fa-headset"></i>
                                Contact Support
                            </a>
                            <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                class="fashion-btn px-6 py-3 inline-flex items-center justify-center gap-2">
                                <i class="fas fa-phone-alt"></i>
                                Call: {{ setting('site_phone', '+8801621833839') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="mt-8 bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Common Questions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-2">When will my tracking number work?</h4>
                            <p class="text-sm text-gray-600">Tracking numbers are activated within 24 hours of order
                                processing.</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-2">What if my package is delayed?</h4>
                            <p class="text-sm text-gray-600">Contact our support team for assistance with delayed
                                deliveries.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Timeline animations */
            .animate-progress {
                animation: progressBar 1.5s ease-in-out;
            }

            @keyframes progressBar {
                from {
                    width: 0%;
                }

                to {
                    width: var(--progress-width);
                }
            }

            /* Fade in animations */
            .fade-in {
                animation: fadeIn 0.6s ease-out forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-focus tracking input
                const trackingInput = document.getElementById('tracking_number');
                if (trackingInput) {
                    trackingInput.focus();

                    // Select all text on click for easy copy/paste
                    trackingInput.addEventListener('click', function() {
                        this.select();
                    });
                }

                // Animate progress bar
                const progressBar = document.querySelector('.bg-gray-900.rounded-full');
                if (progressBar) {
                    setTimeout(() => {
                        progressBar.style.transition = 'width 1s ease-in-out';
                    }, 300);
                }

                // Fade in tracking results
                const trackingResults = document.querySelector('.border-t.border-gray-200.pt-10');
                if (trackingResults) {
                    trackingResults.classList.add('fade-in');
                }

                // Copy tracking number
                const copyTrackingBtn = document.createElement('button');
                copyTrackingBtn.innerHTML = '<i class="far fa-copy"></i>';
                copyTrackingBtn.className = 'text-gray-400 hover:text-gray-600 transition-colors ml-2';
                copyTrackingBtn.title = 'Copy tracking number';
                copyTrackingBtn.onclick = function(e) {
                    e.preventDefault();
                    const trackingNumber = '{{ $order->tracking_number ?? '' }}';
                    navigator.clipboard.writeText(trackingNumber).then(() => {
                        const originalHTML = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-check"></i>';
                        this.classList.add('text-green-500');
                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                            this.classList.remove('text-green-500');
                        }, 2000);
                    });
                };

                const trackingNumberElement = document.querySelector('span:contains("' +
                    '{{ $order->tracking_number ?? '' }}' + '")');
                if (trackingNumberElement) {
                    trackingNumberElement.parentNode.appendChild(copyTrackingBtn);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
