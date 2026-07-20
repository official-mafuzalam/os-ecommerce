<x-app-layout>
    @section('title', 'Order Confirmed | Prokiti Sudha')

    @push('styles')
        <style>
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            .fade-in {
                animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                opacity: 0;
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

            .stagger-1 {
                animation-delay: 0.1s;
            }

            .stagger-2 {
                animation-delay: 0.2s;
            }

            .stagger-3 {
                animation-delay: 0.3s;
            }

            .timeline-pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(0, 69, 37, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(0, 69, 37, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(0, 69, 37, 0);
                }
            }

            canvas#confetti {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 100;
            }

            .botanical-bg {
                background-image: url('data:image/svg+xml,<svg width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M200 40C200 40 160 120 80 120C120 120 160 160 160 240C160 160 200 120 280 120C200 120 200 40 200 40Z" fill="%23004525" fill-opacity="0.03"/></svg>');
                background-repeat: no-repeat;
                background-position: top right;
            }
        </style>
    @endpush

    <x-slot name="main">
        <canvas id="confetti"></canvas>
        <main class="max-w-container-max mx-auto px-gutter py-md pt-24 botanical-bg min-h-screen">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-xs text-caption text-on-surface-variant/60 mb-lg">
                <a class="hover:text-primary" href="{{ route('public.welcome') }}">Home</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <a class="hover:text-primary" href="{{ route('public.checkout') }}">Checkout</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-primary font-medium">Order Confirmed</span>
            </nav>
            <div class="grid grid-cols-12 gap-md items-start">
                <!-- Hero Success Card -->
                <section class="col-span-12 fade-in">
                    <div
                        class="bg-surface-container-low p-xl rounded-xl text-center relative overflow-hidden shadow-sm border border-outline-variant/20">
                        <div class="relative z-10">
                            <div
                                class="w-20 h-20 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-md timeline-pulse">
                                <span class="material-symbols-outlined text-[40px]"
                                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                            <h1 class="font-display-lg text-headline-lg md:text-display-lg mb-sm text-primary">🎉 Order
                                Confirmed!</h1>
                            <p class="font-body-lg text-on-surface-variant max-w-[600px] mx-auto">
                                Thank you for your order. Your wellness journey with Prokiti Sudha has officially begun.
                                We've sent a confirmation email to {{ $order->customer_email }}.
                            </p>
                        </div>
                        <!-- Decorative Package Illustration -->
                        <div class="absolute -bottom-10 -right-10 opacity-10 pointer-events-none transform rotate-12">
                            <span class="material-symbols-outlined text-[200px]">package_2</span>
                        </div>
                        <div
                            class="absolute -top-10 -left-10 opacity-10 pointer-events-none transform -rotate-12 text-secondary">
                            <span class="material-symbols-outlined text-[180px]">eco</span>
                        </div>
                    </div>
                </section>
                <!-- Left Column: Details -->
                <div class="col-span-12 lg:col-span-8 flex flex-col gap-md">
                    <!-- Timeline -->
                    <div
                        class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 fade-in stagger-1">
                        <h3 class="font-label-md text-primary mb-lg uppercase">Tracking Timeline</h3>
                        <div class="relative flex justify-between items-start pt-2">
                            <!-- Connecting Line -->
                            <div class="absolute top-6 left-0 w-full h-[2px] bg-surface-variant z-0">
                                <div class="h-full bg-primary transition-all duration-1000 ease-out" id="progress-bar"
                                    style="width: 20%;"></div>
                            </div>
                            <!-- Steps -->
                            <div class="relative z-10 flex flex-col items-center gap-xs">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs ring-4 ring-surface">
                                    1</div>
                                <span class="font-label-md text-[11px] text-primary">Confirmed</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-xs opacity-50">
                                <div
                                    class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold text-xs ring-4 ring-surface">
                                    2</div>
                                <span class="font-label-md text-[11px]">Processing</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-xs opacity-50">
                                <div
                                    class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold text-xs ring-4 ring-surface">
                                    3</div>
                                <span class="font-label-md text-[11px]">Packed</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-xs opacity-50">
                                <div
                                    class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold text-xs ring-4 ring-surface">
                                    4</div>
                                <span class="font-label-md text-[11px]">Shipped</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-xs opacity-50">
                                <div
                                    class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold text-xs ring-4 ring-surface">
                                    5</div>
                                <span class="font-label-md text-[11px]">Delivered</span>
                            </div>
                        </div>
                    </div>
                    <!-- Order Summary Details -->
                    <div
                        class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 fade-in stagger-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                            <div>
                                <h3 class="font-label-md text-primary mb-md uppercase">Order Information</h3>
                                <div class="space-y-sm text-body-md">
                                    <div class="flex justify-between border-b border-surface-variant pb-xs">
                                        <span class="text-on-surface-variant">Order Number</span>
                                        <span class="font-semibold">#{{ $order->order_number }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-variant pb-xs">
                                        <span class="text-on-surface-variant">Order Date</span>
                                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-variant pb-xs">
                                        <span class="text-on-surface-variant">Payment Method</span>
                                        <span class="flex items-center gap-xs">Cash on Delivery <span
                                                class="bg-surface-variant text-on-surface-variant text-[10px] px-1.5 rounded uppercase font-bold">Pending</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">Est. Delivery</span>
                                        <span class="text-secondary font-medium">{{ now()->addDays(2)->format('M d') }}
                                            - {{ now()->addDays(4)->format('M d') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-label-md text-primary mb-md uppercase">Shipping Address</h3>
                                <div class="p-md bg-surface rounded-lg border border-surface-variant/50">
                                    <p class="font-semibold mb-xs">{{ $order->shippingAddress->full_name ?? 'N/A' }}</p>
                                    <p class="text-on-surface-variant text-sm leading-relaxed">
                                        {{ $order->shippingAddress->full_address ?? 'N/A' }}<br />
                                        Bangladesh<br />
                                        {{ $order->customer_phone ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons (Desktop) -->
                    <div class="hidden lg:flex gap-md mt-md fade-in stagger-3">
                        <a class="flex-1 bg-primary text-white h-[56px] rounded-lg flex items-center justify-center font-label-md hover:opacity-90 transition-all active:scale-95 shadow-md"
                            href="{{ route('public.products') }}">Continue Shopping</a>
                        <a class="flex-1 border border-primary text-primary h-[56px] rounded-lg flex items-center justify-center font-label-md hover:bg-primary/5 transition-all active:scale-95"
                            href="{{ route('public.parcel.tracking') }}">Track My Order</a>
                        <button onclick="window.print()"
                            class="w-[56px] h-[56px] border border-outline text-on-surface-variant rounded-lg flex items-center justify-center hover:bg-surface-variant transition-all">
                            <span class="material-symbols-outlined">print</span>
                        </button>
                    </div>
                </div>
                <!-- Right Column: Order Items & Payment -->
                <aside class="col-span-12 lg:col-span-4 flex flex-col gap-md fade-in stagger-2">
                    <!-- Items -->
                    <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10">
                        <h3 class="font-label-md text-primary mb-md uppercase">Your Wellness Selection</h3>
                        <div class="space-y-md">
                            @foreach ($order->items as $item)
                                <div class="flex gap-md group">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-surface-variant shrink-0">
                                        <img class="w-full h-full object-cover" alt="{{ $item->product->name }}"
                                            src="{{ $item->product->images->where('is_primary', true)->first()
                                                ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                : 'https://placehold.co/400x400?text=No+Image' }}" />
                                    </div>
                                    <div class="flex-1 py-1">
                                        <h4 class="font-semibold text-primary">{{ $item->product->name }}</h4>
                                        <p class="text-caption text-on-surface-variant">Qty: {{ $item->quantity }}
                                            @if ($item->attributes && $item->attributes->count() > 0)
                                                |
                                                @foreach ($item->attributes as $attribute)
                                                    {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                @endforeach
                                            @endif
                                        </p>
                                        <div class="mt-xs font-semibold">
                                            ৳{{ number_format($item->price * $item->quantity) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-lg pt-md border-t border-surface-variant space-y-xs">
                            <div class="flex justify-between text-on-surface-variant">
                                <span>Subtotal</span>
                                <span>৳{{ number_format($order->subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-on-surface-variant">
                                <span>Shipping</span>
                                <span>৳{{ number_format($order->shipping_cost) }}</span>
                            </div>
                            <div class="flex justify-between text-headline-md font-bold text-primary pt-sm">
                                <span>Total</span>
                                <span>৳{{ number_format($order->total_amount) }}</span>
                            </div>
                        </div>
                        <div class="mt-md p-sm bg-primary-container/10 rounded-lg flex items-center gap-md">
                            <span class="material-symbols-outlined text-primary"
                                style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                            <span class="text-caption font-semibold text-primary uppercase tracking-wider">
                                Shipping via
                                {{ $order->delivery_area == 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}
                                delivery
                            </span>
                        </div>
                    </div>
                    <!-- Mobile Buttons -->
                    <div class="flex lg:hidden flex-col gap-sm">
                        <a class="w-full bg-primary text-white h-[56px] rounded-lg flex items-center justify-center font-label-md shadow-md"
                            href="{{ route('public.products') }}">Continue Shopping</a>
                        <a class="w-full border border-primary text-primary h-[56px] rounded-lg flex items-center justify-center font-label-md"
                            href="{{ route('public.parcel.tracking') }}">Track Order</a>
                    </div>
                    <!-- Trust Badges -->
                    <div
                        class="bg-surface-container/50 p-md rounded-xl border border-outline-variant/10 grid grid-cols-3 gap-xs text-center">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-primary mb-xs">verified</span>
                            <span class="text-[10px] font-semibold uppercase opacity-60">Pure Quality</span>
                        </div>
                        <div class="flex flex-col items-center border-x border-outline-variant/30">
                            <span class="material-symbols-outlined text-primary mb-xs">local_shipping</span>
                            <span class="text-[10px] font-semibold uppercase opacity-60">Safe Delivery</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-primary mb-xs">support_agent</span>
                            <span class="text-[10px] font-semibold uppercase opacity-60">Live Support</span>
                        </div>
                    </div>
                </aside>
            </div>
            <!-- What's Next Section -->
            <section class="mt-xl fade-in stagger-3 mb-xl">
                <h2 class="font-display-lg text-headline-md text-primary mb-lg text-center">What happens next?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <div
                        class="bg-white p-lg rounded-xl border border-surface-variant hover:shadow-lg transition-shadow duration-300">
                        <div
                            class="w-12 h-12 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-md">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                        <h4 class="font-semibold mb-xs">Preparation</h4>
                        <p class="text-on-surface-variant text-sm">We are meticulously selecting and packing your
                            natural
                            wellness products for freshness.</p>
                    </div>
                    <div
                        class="bg-white p-lg rounded-xl border border-surface-variant hover:shadow-lg transition-shadow duration-300">
                        <div
                            class="w-12 h-12 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-md">
                            <span class="material-symbols-outlined">notifications_active</span>
                        </div>
                        <h4 class="font-semibold mb-xs">Updates</h4>
                        <p class="text-on-surface-variant text-sm">You'll receive SMS notifications as your order moves
                            through our delivery network.</p>
                    </div>
                    <div
                        class="bg-white p-lg rounded-xl border border-surface-variant hover:shadow-lg transition-shadow duration-300">
                        <div
                            class="w-12 h-12 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-md">
                            <span class="material-symbols-outlined">help_center</span>
                        </div>
                        <h4 class="font-semibold mb-xs">Support</h4>
                        <p class="text-on-surface-variant text-sm">Have questions? Our wellness concierge is available
                            to help with any issues.</p>
                    </div>
                </div>
            </section>
        </main>
    </x-slot>

    @push('scripts')
        <script>
            // Confetti Effect
            const canvas = document.getElementById('confetti');
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const confettiCount = 150;
            const confettis = [];
            const colors = ['#004525', '#4a671b', '#e8c066', '#b1f1c3'];

            class Confetti {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height - canvas.height;
                    this.size = Math.random() * 8 + 4;
                    this.color = colors[Math.floor(Math.random() * colors.length)];
                    this.speed = Math.random() * 3 + 2;
                    this.angle = Math.random() * 360;
                    this.spin = Math.random() * 10 - 5;
                }

                update() {
                    this.y += this.speed;
                    this.angle += this.spin;
                    if (this.y > canvas.height) {
                        this.y = -20;
                        this.x = Math.random() * canvas.width;
                    }
                }

                draw() {
                    ctx.save();
                    ctx.translate(this.x, this.y);
                    ctx.rotate(this.angle * Math.PI / 180);
                    ctx.fillStyle = this.color;
                    ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size);
                    ctx.restore();
                }
            }

            function initConfetti() {
                for (let i = 0; i < confettiCount; i++) {
                    confettis.push(new Confetti());
                }
            }

            function animateConfetti() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                confettis.forEach(c => {
                    c.update();
                    c.draw();
                });
                requestAnimationFrame(animateConfetti);
            }

            // Only run confetti once or for a short duration
            initConfetti();
            animateConfetti();

            // Stop after 4 seconds
            setTimeout(() => {
                canvas.style.transition = 'opacity 2s ease';
                canvas.style.opacity = '0';
                setTimeout(() => {
                    canvas.remove();
                }, 2000);
            }, 3000);

            // Timeline progress bar animation
            window.addEventListener('load', () => {
                const progressBar = document.getElementById('progress-bar');
                setTimeout(() => {
                    progressBar.style.width = '20%'; // Active state for "Confirmed"
                }, 500);
            });
        </script>
    @endpush
</x-app-layout>
