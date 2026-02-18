<x-app-layout>
    @section('title', 'Cart - ' . config('app.name'))
    <x-slot name="main">
        <!-- Fashion Cart Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">

            <div class="flex items-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 elegant-heading">Your Shopping Bag</h1>
                <span class="ml-4 bg-gray-900 text-white text-sm font-medium px-3 py-1 rounded-full">
                    {{ $cartItems->count() }} items
                </span>
            </div>

            @if ($cartItems->count() > 0)
                <div class="grid lg:grid-cols-12 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Cart Header -->
                            <div class="px-6 md:px-8 py-5 border-b border-gray-100 bg-gray-50/50">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-6">
                                        <h2 class="text-lg font-semibold text-gray-900">Product</h2>
                                    </div>
                                    <div class="col-span-3 text-center">
                                        <h2 class="text-lg font-semibold text-gray-900">Quantity</h2>
                                    </div>
                                    <div class="col-span-3 text-right">
                                        <h2 class="text-lg font-semibold text-gray-900">Total</h2>
                                    </div>
                                </div>
                            </div>

                            <!-- Cart Items -->
                            <div class="divide-y divide-gray-100">
                                @foreach ($cartItems as $item)
                                    <div class="p-6 md:p-8 hover:bg-gray-50/50 transition-colors"
                                        id="cart-item-{{ $item->id }}">
                                        <div class="grid grid-cols-12 gap-6 items-center">
                                            <!-- Product Image & Info -->
                                            <div class="col-span-6">
                                                <div class="flex items-start gap-4 md:gap-6">
                                                    <!-- Product Image -->
                                                    <div
                                                        class="relative flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-xl overflow-hidden 
                                                                border border-gray-200 bg-gray-100">
                                                        <img src="{{ $item->product->images->where('is_primary', true)->first()
                                                            ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path)
                                                            : 'https://placehold.co/400x400?text=No+Image' }}"
                                                            alt="{{ $item->product->name }}"
                                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                                        @if ($item->quantity > $item->product->stock_quantity)
                                                            <div
                                                                class="absolute inset-0 bg-red-500/10 backdrop-blur-sm flex items-center justify-center">
                                                                <span
                                                                    class="text-xs font-semibold text-red-600 bg-white/90 px-2 py-1 rounded">
                                                                    Limited Stock
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Product Details -->
                                                    <div class="flex-grow">
                                                        <h3
                                                            class="text-base md:text-lg font-medium text-gray-900 mb-1 hover:text-gray-700 transition-colors">
                                                            <a
                                                                href="{{ route('public.products.show', $item->product->slug) }}">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h3>

                                                        <!-- Display Attributes -->
                                                        @if ($item->attributes && $item->attributes->count() > 0)
                                                            <div class="mt-2">
                                                                <div class="flex flex-wrap gap-1">
                                                                    @foreach ($item->attributes as $attribute)
                                                                        <span
                                                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                                                   bg-gray-100 text-gray-700 border border-gray-200">
                                                                            {{ $attribute->name }}:
                                                                            {{ $attribute->pivot->value }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Product Info -->
                                                        <div class="mt-3 flex flex-wrap items-center gap-2">
                                                            <span class="text-xs font-medium text-gray-500">SKU:
                                                                {{ $item->product->sku }}</span>
                                                            <span class="text-gray-400">•</span>
                                                            <span
                                                                class="text-xs font-medium {{ $item->product->stock_quantity > 0
                                                                    ? 'text-green-600 bg-green-50 border border-green-100'
                                                                    : 'text-red-600 bg-red-50 border border-red-100' }} 
                                                                px-2 py-0.5 rounded-full">
                                                                Stock: {{ $item->product->stock_quantity }}
                                                            </span>
                                                        </div>

                                                        <!-- Unit Price -->
                                                        <div class="mt-2">
                                                            <span class="text-sm text-gray-600">Unit Price: </span>
                                                            <span class="text-sm font-medium text-gray-900">
                                                                {{ number_format($item->unit_price, 2) }} TK
                                                            </span>
                                                            @if ($item->product->discount > 0)
                                                                <span class="text-xs text-red-600 ml-2 line-through">
                                                                    {{ number_format($item->product->price, 2) }} TK
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quantity Selector -->
                                            <div class="col-span-3">
                                                <div class="flex flex-col items-center">
                                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors 
                                                                       {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fas fa-minus text-sm"></i>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $item->id }}"
                                                            value="{{ $item->quantity }}" min="1"
                                                            max="{{ $item->product->stock_quantity }}"
                                                            class="w-12 text-center border-0 focus:ring-0 bg-transparent text-sm font-medium"
                                                            onchange="updateQuantity('{{ $item->id }}', this.value)"
                                                            onblur="validateQuantity('{{ $item->id }}')">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors 
                                                                       {{ $item->quantity >= $item->product->stock_quantity ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fas fa-plus text-sm"></i>
                                                        </button>
                                                    </div>
                                                    @if ($item->product->stock_quantity < $item->quantity)
                                                        <p class="text-xs text-red-600 mt-2 text-center">
                                                            Only {{ $item->product->stock_quantity }} available
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Total Price & Actions -->
                                            <div class="col-span-3">
                                                <div class="flex flex-col items-end">
                                                    <div class="mb-2">
                                                        <span class="text-lg font-semibold text-gray-900">
                                                            {{ number_format($item->total_price, 2) }} TK
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <button onclick="saveForLater('{{ $item->id }}')"
                                                            class="text-gray-600 hover:text-gray-900 text-xs font-medium inline-flex items-center 
                                                                       gap-1 transition-colors"
                                                            title="Save for Later">
                                                            <i class="far fa-bookmark"></i>
                                                        </button>
                                                        <button onclick="removeItem('{{ $item->id }}')"
                                                            class="text-red-600 hover:text-red-800 text-xs font-medium inline-flex items-center 
                                                                       gap-1 transition-colors">
                                                            <i class="fas fa-trash-alt"></i>
                                                            <span>Remove</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Cart Actions -->
                            <div
                                class="px-6 md:px-8 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center">
                                <a href="{{ route('public.products') }}"
                                    class="text-gray-700 hover:text-gray-900 font-medium inline-flex items-center gap-2 transition-colors">
                                    <i class="fas fa-arrow-left text-sm"></i>
                                    Continue Shopping
                                </a>
                                <button onclick="clearCart()"
                                    class="text-red-600 hover:text-red-800 font-medium inline-flex items-center gap-2 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                    Clear Entire Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-4">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">Order Summary
                            </h2>

                            <!-- Summary Details -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900 font-semibold">{{ number_format($cart->subtotal, 2) }}
                                        TK</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Items ({{ $cart->total_quantity }})</span>
                                    <span class="text-gray-900">{{ $cart->total_quantity }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-green-600 text-sm font-medium">On checkout page</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">Included</span>
                                </div>

                                <!-- Progress Bar for Free Shipping -->
                                {{-- @php
                                    $freeShippingThreshold = 1000;
                                    $progressPercentage = min(($cart->subtotal / $freeShippingThreshold) * 100, 100);
                                @endphp
                                @if ($cart->subtotal < $freeShippingThreshold)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="mb-2">
                                            <span class="text-sm text-gray-600">
                                                Spend {{ number_format($freeShippingThreshold - $cart->subtotal, 2) }}
                                                TK more for free shipping!
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full"
                                                style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center gap-2 text-green-600">
                                            <i class="fas fa-check-circle"></i>
                                            <span class="text-sm font-medium">You've unlocked free shipping!</span>
                                        </div>
                                    </div>
                                @endif --}}

                                <!-- Total -->
                                <div class="border-t border-gray-200 pt-4 mt-2">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-gray-900">Total</span>
                                        <span class="text-gray-900">{{ number_format($cart->subtotal, 2) }} TK</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Including all applicable taxes</p>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <div class="mt-8">
                                <a href="{{ route('public.checkout') }}"
                                    class="w-full fashion-btn flex items-center justify-center gap-3 py-4 text-base">
                                    <i class="fas fa-lock"></i>
                                    Proceed to Checkout
                                </a>
                            </div>

                            <!-- Security & Payment Info -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-shield-alt text-gray-400"></i>
                                        <span class="text-xs text-gray-600">Secure SSL Encryption</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-credit-card text-gray-400"></i>
                                        <span class="text-xs text-gray-600">Multiple Payment Options</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-truck text-gray-400"></i>
                                        <span class="text-xs text-gray-600">Fast Delivery</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coupon & Gift Cards -->
                <div class="mt-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Have a Coupon or Gift Card?</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" placeholder="Enter coupon code or gift card number"
                                class="flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            <button type="button" class="fashion-btn-outline px-6 py-3 whitespace-nowrap">
                                Apply Code
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 md:p-16 text-center max-w-2xl mx-auto">
                    <div
                        class="mx-auto w-32 h-32 flex items-center justify-center bg-gray-100 text-gray-400 rounded-full mb-8">
                        <i class="fas fa-shopping-bag text-5xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Your fashion bag is empty</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Looks like you haven't added any stylish items to your cart yet. Start exploring our collection!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.products') }}"
                            class="fashion-btn inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-store"></i>
                            Browse Collection
                        </a>
                        <a href="{{ route('public.deals') }}"
                            class="fashion-btn-outline inline-flex items-center justify-center gap-3 px-8 py-3">
                            <i class="fas fa-tag"></i>
                            View Deals
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- JavaScript for Cart Operations -->
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
                    alert(`Only ${max} items available in stock.`);
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
                const max = parseInt(input.max);

                if (quantity > max) {
                    quantity = max;
                    alert(`Only ${max} items available in stock.`);
                }

                // Show loading overlay for the specific item
                const itemElement = document.getElementById(`cart-item-${itemId}`);
                const originalContent = itemElement.innerHTML;

                itemElement.style.opacity = '0.5';
                itemElement.style.pointerEvents = 'none';
                itemElement.querySelector('input').value = quantity;

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
                            // Update the quantity input
                            input.value = data.new_quantity;

                            // Show success feedback
                            showToast('Quantity updated successfully', 'success');

                            // Reload page to update totals
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
                            // Animate removal
                            itemElement.style.transition = 'all 0.3s ease';
                            itemElement.style.height = itemElement.offsetHeight + 'px';
                            itemElement.style.opacity = '0';
                            itemElement.style.transform = 'translateX(-100%)';

                            setTimeout(() => {
                                itemElement.remove();
                                showToast('Item removed from cart', 'success');
                                // Reload to update totals
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

                // Show loading overlay
                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-50';
                overlay.innerHTML = `
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900 mx-auto mb-4"></div>
                        <p class="text-gray-700 font-medium">Clearing cart...</p>
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

            function saveForLater(itemId) {
                fetch(`/cart/save-for-later/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Item saved for later', 'success');
                            setTimeout(() => window.location.reload(), 500);
                        } else {
                            showToast(data.message || 'Failed to save item', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('An error occurred. Please try again.', 'error');
                    });
            }

            function showToast(message, type = 'info') {
                // Remove existing toast
                const existingToast = document.getElementById('cart-toast');
                if (existingToast) existingToast.remove();

                // Create new toast
                const toast = document.createElement('div');
                toast.id = 'cart-toast';
                toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium 
                                   animate-fade-in-up ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(toast);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Add fade-in animation for cart items
            document.addEventListener('DOMContentLoaded', function() {
                const cartItems = document.querySelectorAll('[id^="cart-item-"]');
                cartItems.forEach((item, index) => {
                    item.style.animationDelay = `${index * 0.1}s`;
                    item.classList.add('animate-fade-in-up');
                });
            });
        </script>

        <style>
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
    </x-slot>
</x-app-layout>
