<x-app-layout>
    @section('title', 'Cart - ' . config('app.name'))
    <x-slot name="main">
        <!-- Cart Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Shopping Cart</h1>
                <span class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    {{ $cartItems->count() }} items
                </span>
            </div>

            @if ($cartItems->count() > 0)
                <div class="grid lg:grid-cols-12 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Cart Items</h2>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @foreach ($cartItems as $item)
                                    <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4"
                                        id="cart-item-{{ $item->id }}">
                                        <!-- Product Image -->
                                        <div
                                            class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://placehold.co/400x400?text=No+Image' }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-grow">
                                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                                                <div>
                                                    <h3
                                                        class="text-lg font-medium text-gray-900 hover:text-blue-600 transition-colors">
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
                                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                                        {{ $attribute->name }}:
                                                                        {{ $attribute->pivot->value }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                                        <span
                                                            class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">SKU:
                                                            {{ $item->product->sku }}</span>
                                                        <span
                                                            class="text-xs font-medium {{ $item->product->stock_quantity > 0 ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }} px-2 py-1 rounded">
                                                            Stock: {{ $item->product->stock_quantity }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="text-xl font-semibold text-gray-900 whitespace-nowrap">
                                                    {{ number_format($item->total_price, 2) }} TK
                                                </p>
                                            </div>

                                            <!-- Quantity Selector -->
                                            <div
                                                class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $item->id }}"
                                                            value="{{ $item->quantity }}" min="1"
                                                            max="{{ $item->product->stock_quantity }}"
                                                            class="w-12 text-center border-0 focus:ring-0 bg-transparent"
                                                            onchange="updateQuantity('{{ $item->id }}', this.value)">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                                            class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors {{ $item->quantity >= $item->product->stock_quantity ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <button onclick="removeItem('{{ $item->id }}')"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center transition-colors">
                                                    <i class="fas fa-trash mr-2"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6">
                            <button onclick="clearCart()"
                                class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center transition-colors">
                                <i class="fas fa-trash mr-2"></i> Clear Entire Cart
                            </button>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">Order
                                Summary</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal ({{ $cart->total_quantity }} items)</span>
                                    <span class="text-gray-900 font-medium">{{ number_format($cart->subtotal, 2) }}
                                        TK</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">Calculated at checkout</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">0 TK</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 mt-2">
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span class="text-gray-900">Total</span>
                                        <span class="text-gray-900">{{ number_format($cart->subtotal, 2) }} TK</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <a href="{{ route('public.checkout') }}"
                                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg text-center font-medium hover:bg-blue-700 transition-colors inline-flex items-center justify-center">
                                    <i class="fas fa-lock mr-2"></i> Proceed to Checkout
                                </a>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('public.products') }}"
                                    class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center max-w-2xl mx-auto">
                    <div
                        class="mx-auto w-24 h-24 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full mb-6">
                        <i class="fas fa-shopping-cart text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-medium text-gray-900 mb-3">Your cart is empty</h3>
                    <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('public.products') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors inline-flex items-center">
                        <i class="fas fa-store mr-2"></i> Browse Products
                    </a>
                </div>
            @endif
        </div>

        <!-- JavaScript for Cart Operations -->
        <script>
            function updateQuantity(itemId, quantity) {
                if (quantity < 1) quantity = 1;
                if (quantity > document.getElementById(`quantity-${itemId}`).max) {
                    quantity = document.getElementById(`quantity-${itemId}`).max;
                }

                // Show loading state
                const itemElement = document.getElementById(`cart-item-${itemId}`);
                const originalContent = itemElement.innerHTML;
                itemElement.innerHTML = `
                    <div class="w-full py-8 flex justify-center items-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    </div>
                `;

                fetch(`/cart/update/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: parseInt(quantity)
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            itemElement.innerHTML = originalContent;
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        itemElement.innerHTML = originalContent;
                        alert('An error occurred while updating the quantity.');
                    });
            }

            function removeItem(itemId) {
                if (!confirm('Are you sure you want to remove this item from your cart?')) return;

                // Show loading state
                const itemElement = document.getElementById(`cart-item-${itemId}`);
                const originalContent = itemElement.innerHTML;
                itemElement.innerHTML = `
                    <div class="w-full py-8 flex justify-center items-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    </div>
                `;

                fetch(`/cart/remove/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Fade out animation before reload
                            itemElement.style.opacity = '0';
                            itemElement.style.transition = 'opacity 0.3s';
                            setTimeout(() => window.location.reload(), 300);
                        } else {
                            itemElement.innerHTML = originalContent;
                            alert('Failed to remove item.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        itemElement.innerHTML = originalContent;
                        alert('An error occurred while removing the item.');
                    });
            }

            function clearCart() {
                if (!confirm('Are you sure you want to clear your entire cart?')) return;

                // Show loading overlay
                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50';
                overlay.innerHTML = '<div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>';
                document.body.appendChild(overlay);

                fetch('/cart/clear', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            document.body.removeChild(overlay);
                            alert('Failed to clear cart.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        document.body.removeChild(overlay);
                        alert('An error occurred while clearing the cart.');
                    });
            }
        </script>

        @if (session()->has('fb_event_id'))
            <script>
                fbq('track', 'AddToCart', {
                    content_ids: ['{{ $product->sku ?? '' }}'],
                    content_type: 'product',
                    value: {{ $product->price ?? 0 }},
                    currency: "USD"
                }, {
                    eventID: "{{ session('fb_event_id') }}"
                });
            </script>
        @endif

    </x-slot>
</x-app-layout>
