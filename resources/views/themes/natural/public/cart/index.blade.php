<x-app-layout>
    @section('title', setting('site_name', 'OS Ecommerce') . ' | Your Cart')

    @push('styles')
        <style>
            .glass-panel {
                background: rgba(255, 255, 255, 0.6);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .cart-item {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .cart-item:hover {
                box-shadow: 0 20px 40px -12px rgba(0, 69, 37, 0.08);
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.5s ease-out forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
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
    @endpush

    <x-slot name="main">
        <div class="pb-xl px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto min-h-screen">
            <!-- Header Section -->
            <header class="mb-xl text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-end gap-sm">
                    <h1 class="font-cormorant text-[56px] leading-tight text-primary italic mb-0">Your Selection</h1>
                    @if ($cartItems->count() > 0)
                        <span
                            class="mb-2 ml-0 md:ml-4 inline-flex items-center bg-primary text-on-primary font-label-md text-[11px] px-sm py-1 rounded-full h-fit">
                            {{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }}
                        </span>
                    @endif
                </div>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[540px] mt-sm">A curated path to
                    vitality.
                    Review your organic essentials before proceeding to a secure checkout.</p>
            </header>

            @if ($cartItems->count() > 0)
                <!-- Layout Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl relative">
                    <!-- Items List -->
                    <div class="lg:col-span-7 xl:col-span-8 space-y-md">

                        @foreach ($cartItems as $item)
                            <!-- Cart Item -->
                            <div class="cart-item flex flex-col md:flex-row gap-gutter p-md bg-white/40 rounded-[24px] border border-outline-variant/30 hover:shadow-lg transition-all duration-500 group"
                                id="cart-item-{{ $item->id }}">
                                <!-- Product Image -->
                                <div
                                    class="w-full md:w-32 h-40 md:h-32 rounded-xl overflow-hidden bg-surface-container flex-shrink-0 relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                        alt="{{ $item->product->name }}"
                                        src="{{ $item->product->images->where('is_primary', true)->first()
                                            ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                            : 'https://placehold.co/400x400?text=No+Image' }}" />
                                    @if ($item->quantity > $item->product->stock_quantity)
                                        <div
                                            class="absolute inset-0 bg-error/10 backdrop-blur-sm flex items-center justify-center">
                                            <span
                                                class="text-[10px] font-label-md text-error bg-white/90 px-sm py-1 rounded-full">
                                                Limited Stock
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-grow flex flex-col justify-between py-2">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-grow pr-4">
                                            {{-- Category / Collection label --}}
                                            @if ($item->product->category)
                                                <span
                                                    class="font-label-md text-label-md text-secondary uppercase tracking-widest mb-1 block">
                                                    {{ $item->product->category->name }}
                                                </span>
                                            @endif

                                            <a href="{{ route('public.products.show', $item->product->slug) }}"
                                                class="font-cormorant text-[24px] text-primary leading-snug hover:text-secondary transition-colors">
                                                {{ $item->product->name }}
                                            </a>

                                            {{-- Attributes / Variants --}}
                                            @if ($item->attributes && $item->attributes->count() > 0)
                                                <div class="flex flex-wrap gap-xs mt-xs">
                                                    @foreach ($item->attributes as $attribute)
                                                        <span
                                                            class="inline-flex items-center px-sm py-1 rounded-full font-label-md text-[10px] bg-surface-container text-on-surface-variant border border-outline-variant">
                                                            {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- SKU & Stock --}}
                                            <div class="flex flex-wrap items-center gap-2 mt-xs">
                                                <p class="font-caption text-caption text-on-surface-variant italic">
                                                    SKU: {{ $item->product->sku }}
                                                </p>
                                                <span class="text-outline-variant">•</span>
                                                <span
                                                    class="font-caption text-caption px-sm py-0.5 rounded-full
                                                    {{ $item->product->stock_quantity > 0
                                                        ? 'text-secondary bg-secondary-container/40 border border-secondary-fixed-dim'
                                                        : 'text-error bg-error-container border border-error' }}">
                                                    Stock: {{ $item->product->stock_quantity }}
                                                </span>
                                            </div>

                                            {{-- Unit price --}}
                                            <div class="mt-xs">
                                                <span class="font-caption text-caption text-on-surface-variant">Unit
                                                    Price: </span>
                                                <span class="font-label-md text-on-surface">
                                                    ৳ {{ number_format($item->product->final_price, 2) }}
                                                </span>
                                                @if ($item->product->discount > 0)
                                                    <span
                                                        class="font-caption text-caption text-error line-through ml-2">
                                                        ৳ {{ number_format($item->product->price, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Remove Button --}}
                                        <button onclick="removeItem('{{ $item->id }}')"
                                            class="text-on-surface-variant hover:text-error transition-colors flex-shrink-0">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>

                                    <div class="flex justify-between items-center mt-4">
                                        {{-- Quantity Stepper --}}
                                        <div class="flex flex-col">
                                            <div
                                                class="flex items-center border border-outline-variant rounded-full px-3 py-1">
                                                <button type="button"
                                                    onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                                    class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors
                                                        {{ $item->quantity <= 1 ? 'opacity-40 cursor-not-allowed' : '' }}">
                                                    <span class="material-symbols-outlined text-[18px]">remove</span>
                                                </button>
                                                <input type="number" id="quantity-{{ $item->id }}"
                                                    value="{{ $item->quantity }}" min="1"
                                                    max="{{ $item->product->stock_quantity }}"
                                                    class="w-10 text-center font-label-md bg-transparent border-0 focus:ring-0 p-0"
                                                    onchange="updateQuantity('{{ $item->id }}', this.value)"
                                                    onblur="validateQuantity('{{ $item->id }}')">
                                                <button type="button"
                                                    onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                                    class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors
                                                        {{ $item->quantity >= $item->product->stock_quantity ? 'opacity-40 cursor-not-allowed' : '' }}">
                                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                                </button>
                                            </div>
                                            @if ($item->product->stock_quantity < $item->quantity)
                                                <p class="font-caption text-caption text-error mt-1 text-center">
                                                    Only {{ $item->product->stock_quantity }} available
                                                </p>
                                            @endif
                                        </div>

                                        {{-- Line Total --}}
                                        <p class="font-label-md text-label-md text-primary">
                                            ৳ {{ number_format($item->total_price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Cart Actions Row -->
                        <div class="flex justify-between items-center pt-sm">
                            <a href="{{ route('public.products') }}"
                                class="inline-flex items-center gap-xs font-label-md text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                Continue Shopping
                            </a>
                            <button onclick="clearCart()"
                                class="inline-flex items-center gap-xs font-label-md text-error hover:text-on-error-container transition-colors">
                                <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                                Clear Entire Cart
                            </button>
                        </div>

                        <!-- Promo Code -->
                        <div class="p-md bg-white/40 rounded-[24px] border border-outline-variant/30">
                            <h3 class="font-label-md text-label-md text-primary uppercase tracking-widest mb-md">Promo
                                Code</h3>
                            <div class="flex gap-2">
                                <input
                                    class="flex-grow bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-primary px-0 font-body-md"
                                    placeholder="Enter coupon code" type="text" />
                                <button
                                    class="font-label-md text-primary uppercase tracking-widest hover:text-secondary transition-colors">Apply</button>
                            </div>
                        </div>

                        <!-- Upsell / Continue Shopping -->
                        <div
                            class="mt-sm p-xl border-2 border-dashed border-outline-variant/30 rounded-[24px] flex flex-col items-center text-center">
                            <span class="material-symbols-outlined text-secondary-fixed-dim text-4xl mb-4">eco</span>
                            <p class="font-label-md text-on-surface-variant">Looking for more vitality?</p>
                            <a class="font-cormorant text-[28px] text-primary underline underline-offset-8 mt-2 hover:text-secondary transition-colors"
                                href="{{ route('public.products') }}">Browse the Apothecary</a>
                        </div>
                    </div>

                    <!-- Summary Sidebar -->
                    <aside class="lg:col-span-5 xl:col-span-4">
                        <div class="glass-panel sticky top-32 p-xl rounded-[24px] shadow-xl overflow-hidden relative">
                            <!-- Subtle background decoration -->
                            <div
                                class="absolute -top-10 -right-10 w-40 h-40 bg-secondary-fixed/20 rounded-full blur-3xl -z-10">
                            </div>

                            <h2 class="font-cormorant text-[32px] text-primary mb-xl">Order Summary</h2>

                            <div class="space-y-6 mb-xl">
                                <div class="flex justify-between items-center">
                                    <span class="font-body-md text-on-surface-variant">Subtotal</span>
                                    <span class="font-label-md text-on-surface">৳
                                        {{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-body-md text-on-surface-variant">Items
                                        ({{ $cart->total_quantity }})</span>
                                    <span class="font-label-md text-on-surface">{{ $cart->total_quantity }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-body-md text-on-surface-variant">Shipping</span>
                                    <span class="font-label-md text-secondary uppercase tracking-wider">On checkout
                                        page</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-body-md text-on-surface-variant">Tax</span>
                                    <span class="font-label-md text-on-surface">Included</span>
                                </div>
                                <div class="pt-6 border-t border-outline-variant/30 flex justify-between items-center">
                                    <span class="font-cormorant text-[24px] text-primary">Total</span>
                                    <span class="font-cormorant text-[24px] text-primary">৳
                                        {{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('public.checkout') }}"
                                class="w-full bg-primary text-white font-label-md h-14 rounded-[16px] hover:bg-primary-container active:scale-[0.98] transition-all flex items-center justify-center gap-2 mb-gutter shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined"
                                    style="font-variation-settings: 'FILL' 1;">lock</span>
                                Proceed to Checkout
                            </a>

                            <!-- Trust Badges -->
                            <div class="grid grid-cols-2 gap-4 mt-gutter">
                                <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl">
                                    <span class="material-symbols-outlined text-primary">verified_user</span>
                                    <span
                                        class="text-[10px] font-label-md leading-tight text-on-surface-variant uppercase tracking-tighter">Secure
                                        SSL Encryption</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl">
                                    <span class="material-symbols-outlined text-primary">biotech</span>
                                    <span
                                        class="text-[10px] font-label-md leading-tight text-on-surface-variant uppercase tracking-tighter">100%
                                        Lab Tested</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl">
                                    <span class="material-symbols-outlined text-primary">payments</span>
                                    <span
                                        class="text-[10px] font-label-md leading-tight text-on-surface-variant uppercase tracking-tighter">Multiple
                                        Payment Options</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl">
                                    <span class="material-symbols-outlined text-primary">local_shipping</span>
                                    <span
                                        class="text-[10px] font-label-md leading-tight text-on-surface-variant uppercase tracking-tighter">Fast
                                        Delivery</span>
                                </div>
                            </div>

                            <p class="text-center font-caption text-on-surface-variant mt-xl px-4">
                                Free shipping on all wellness bundles. 30-day purity guarantee.
                            </p>
                        </div>
                    </aside>
                </div>
            @else
                <!-- Empty Cart State -->
                <div
                    class="p-xl border-2 border-dashed border-outline-variant/30 rounded-[24px] flex flex-col items-center text-center py-24 max-w-2xl mx-auto">
                    <span class="material-symbols-outlined text-secondary-fixed-dim text-6xl mb-6">shopping_bag</span>
                    <h3 class="font-cormorant text-[36px] text-primary mb-2">Your cart is empty</h3>
                    <p class="font-body-md text-on-surface-variant mb-8 max-w-md">
                        Explore our collection of organic wellness essentials and find your path to vitality.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.products') }}"
                            class="bg-primary text-on-primary font-label-md px-xl py-sm rounded-[16px] hover:bg-primary-container active:scale-[0.98] transition-all inline-flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">storefront</span>
                            Browse the Apothecary
                        </a>
                        @if (Route::has('public.deals'))
                            <a href="{{ route('public.deals') }}"
                                class="border border-primary text-primary font-label-md px-xl py-sm rounded-[16px] hover:bg-primary-fixed/20 active:scale-[0.98] transition-all inline-flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[18px]">sell</span>
                                View Deals
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    @push('scripts')
        <script>
            function validateQuantity(itemId) {
                const input = document.getElementById(`quantity-${itemId}`);
                let quantity = parseInt(input.value);
                const max = parseInt(input.max);

                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                }
                if (quantity > max) {
                    quantity = max;
                    showToast(`Only ${max} items available in stock.`, 'error');
                }

                input.value = quantity;
                return quantity;
            }

            function updateQuantity(itemId, quantity) {
                quantity = parseInt(quantity);

                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                }

                const input = document.getElementById(`quantity-${itemId}`);
                if (!input) return;
                const max = parseInt(input.max);

                if (quantity > max) {
                    quantity = max;
                    showToast(`Only ${max} items available in stock.`, 'error');
                }

                const itemElement = document.getElementById(`cart-item-${itemId}`);
                const originalContent = itemElement.innerHTML;

                itemElement.style.opacity = '0.5';
                itemElement.style.pointerEvents = 'none';
                input.value = quantity;

                fetch(`/cart/update/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';

                        if (data.success) {
                            input.value = data.new_quantity;
                            showToast('Quantity updated successfully', 'success');
                            setTimeout(() => window.location.reload(), 500);
                        } else {
                            showToast(data.message || 'Failed to update quantity', 'error');
                            itemElement.innerHTML = originalContent;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';
                        showToast('An error occurred. Please try again.', 'error');
                    });
            }

            function removeItem(itemId) {
                if (!confirm('Remove this item from your cart?')) return;

                const itemElement = document.getElementById(`cart-item-${itemId}`);
                itemElement.style.opacity = '0.5';
                itemElement.style.pointerEvents = 'none';

                fetch(`/cart/remove/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            itemElement.style.transition = 'all 0.3s ease';
                            itemElement.style.height = itemElement.offsetHeight + 'px';
                            itemElement.style.opacity = '0';
                            itemElement.style.transform = 'translateX(-100%)';

                            setTimeout(() => {
                                itemElement.remove();
                                showToast('Item removed from cart', 'success');
                                setTimeout(() => window.location.reload(), 300);
                            }, 300);
                        } else {
                            itemElement.style.opacity = '1';
                            itemElement.style.pointerEvents = 'auto';
                            showToast('Failed to remove item', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';
                        showToast('An error occurred. Please try again.', 'error');
                    });
            }

            function clearCart() {
                if (!confirm('Are you sure you want to clear your entire cart?')) return;

                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-surface/80 backdrop-blur-sm flex items-center justify-center z-50';
                overlay.innerHTML = `
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                        <p class="font-label-md text-on-surface-variant">Clearing cart...</p>
                    </div>
                `;
                document.body.appendChild(overlay);

                fetch('/cart/clear', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.body.removeChild(overlay);
                        if (data.success) {
                            showToast('Cart cleared successfully', 'success');
                            setTimeout(() => window.location.reload(), 500);
                        } else {
                            showToast('Failed to clear cart', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        document.body.removeChild(overlay);
                        showToast('An error occurred. Please try again.', 'error');
                    });
            }

            function showToast(message, type = 'info') {
                const existingToast = document.getElementById('cart-toast');
                if (existingToast) existingToast.remove();

                const toast = document.createElement('div');
                toast.id = 'cart-toast';
                toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-[16px] shadow-lg font-label-md text-white animate-fade-in-up
                                   ${type === 'success' ? 'bg-secondary' : 'bg-error'}`;
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">${type === 'success' ? 'check_circle' : 'error'}</span>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.transition = 'opacity 0.3s ease';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Staggered fade-in for cart items on load
            document.addEventListener('DOMContentLoaded', function() {
                const cartItems = document.querySelectorAll('[id^="cart-item-"]');
                cartItems.forEach((item, index) => {
                    item.style.animationDelay = `${index * 0.1}s`;
                    item.classList.add('animate-fade-in-up');
                });
            });
        </script>
    @endpush
</x-app-layout>
