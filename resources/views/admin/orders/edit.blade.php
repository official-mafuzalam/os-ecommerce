<x-admin-layout>
    @section('title', 'Edit Order')
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Order">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Edit Order #{{ $order->order_number }}</h1>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M j, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="order-form">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Status & Details -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Status & Details</h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Order Status</label>
                                    <select name="status"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        @foreach ($statusOptions as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $order->status == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        @foreach ($paymentStatusOptions as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $order->payment_status == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="pt-3 border-t border-gray-100">
                                <h3 class="text-xs font-medium text-gray-900 mb-3">Shipping Information</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" name="shipping_address[full_name]"
                                            value="{{ old('shipping_address.full_name', $order->shippingAddress->full_name ?? '') }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="shipping_address[phone]"
                                            value="{{ old('shipping_address.phone', $order->shippingAddress->phone ?? '') }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Address Line 1</label>
                                    <input type="text" name="shipping_address[address_line_1]"
                                        value="{{ old('shipping_address.address_line_1', $order->shippingAddress->address_line_1 ?? '') }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="mt-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Address Line 2
                                        (Optional)</label>
                                    <input type="text" name="shipping_address[address_line_2]"
                                        value="{{ old('shipping_address.address_line_2', $order->shippingAddress->address_line_2 ?? '') }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" name="shipping_address[city]"
                                            value="{{ old('shipping_address.city', $order->shippingAddress->city ?? '') }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Area</label>
                                        <input type="text" name="shipping_address[area]"
                                            value="{{ old('shipping_address.area', $order->shippingAddress->area ?? '') }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input type="text" name="shipping_address[postal_code]"
                                            value="{{ old('shipping_address.postal_code', $order->shippingAddress->postal_code ?? '') }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Details -->
                            <div class="pt-3 border-t border-gray-100">
                                <h3 class="text-xs font-medium text-gray-900 mb-3">Shipping Details</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Shipping
                                            Method</label>
                                        <select name="shipping_method"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            <option value="standard"
                                                {{ $order->shipping_method == 'standard' ? 'selected' : '' }}>Standard
                                            </option>
                                            <option value="express"
                                                {{ $order->shipping_method == 'express' ? 'selected' : '' }}>Express
                                            </option>
                                            <option value="same_day"
                                                {{ $order->shipping_method == 'same_day' ? 'selected' : '' }}>Same Day
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Tracking
                                            Number</label>
                                        <input type="text" name="tracking_number"
                                            value="{{ old('tracking_number', $order->tracking_number) }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Courier Name</label>
                                        <input type="text" name="courier_name"
                                            value="{{ old('courier_name', $order->courier_name) }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Estimated Delivery
                                        Date</label>
                                    <input type="date" name="estimated_delivery_date"
                                        value="{{ old('estimated_delivery_date', optional($order->estimated_delivery_date)->format('Y-m-d')) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="pt-3 border-t border-gray-100">
                                <h3 class="text-xs font-medium text-gray-900 mb-3">Customer Information</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" value="{{ $order->customer_email }}" disabled
                                            class="w-full text-sm rounded border-gray-300 bg-gray-50 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="customer_phone"
                                            value="{{ old('customer_phone', $order->customer_phone) }}"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="pt-3 border-t border-gray-100">
                                <h3 class="text-xs font-medium text-gray-900 mb-3">Notes</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Customer
                                            Notes</label>
                                        <textarea name="customer_notes" rows="2"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('customer_notes', $order->customer_notes) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Admin Notes</label>
                                        <textarea name="admin_notes" rows="2"
                                            class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-900">Order Items</h2>
                            <span class="text-xs text-gray-500">{{ $order->items->count() }} items</span>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <div class="p-4">
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="flex-shrink-0 w-12 h-12 rounded border border-gray-200 overflow-hidden">
                                            @php
                                                $productImage = $item->product->images
                                                    ->where('is_primary', true)
                                                    ->first();
                                                $imageUrl = $productImage
                                                    ? Storage::url($productImage->image_path)
                                                    : 'https://via.placeholder.com/48';
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ $item->product_name ?? $item->product->name }}
                                            </h3>
                                            <p class="text-xs text-gray-500">SKU:
                                                {{ $item->product_sku ?? $item->product->sku }}</p>

                                            <!-- Variant Options -->
                                            @if ($item->variant_options && is_array($item->variant_options))
                                                <div class="mt-2">
                                                    <p class="text-xs font-medium text-gray-600 mb-1">Options:</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($item->variant_options as $option)
                                                            @if (is_array($option))
                                                                <span
                                                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                                                    {{ $option['name'] ?? 'Option' }}:
                                                                    {{ $option['value'] ?? '' }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-gray-600 mb-1">Quantity</label>
                                            <input type="number" name="items[{{ $item->id }}][quantity]"
                                                value="{{ old('items.' . $item->id . '.quantity', $item->quantity) }}"
                                                min="1" data-item-id="{{ $item->id }}"
                                                class="item-quantity w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price
                                                (৳)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $item->id }}][unit_price]"
                                                value="{{ old('items.' . $item->id . '.unit_price', $item->unit_price) }}"
                                                min="0" data-item-id="{{ $item->id }}"
                                                class="item-price w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Total
                                                (৳)</label>
                                            <div class="text-sm font-semibold text-gray-900 item-total"
                                                data-item-id="{{ $item->id }}">
                                                {{ number_format($item->total_price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-4">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Summary</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Subtotal (৳)</label>
                                <input type="number" step="0.01" name="subtotal"
                                    value="{{ old('subtotal', $order->subtotal) }}" id="subtotal" min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Shipping Cost (৳)</label>
                                <input type="number" step="0.01" name="shipping_cost"
                                    value="{{ old('shipping_cost', $order->shipping_cost) }}" id="shipping"
                                    min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Tax Amount (৳)</label>
                                <input type="number" step="0.01" name="tax_amount"
                                    value="{{ old('tax_amount', $order->tax_amount) }}" id="tax"
                                    min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Discount (৳)</label>
                                <input type="number" step="0.01" name="discount_amount"
                                    value="{{ old('discount_amount', $order->discount_amount) }}" id="discount"
                                    min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Discount Code</label>
                                <input type="text" name="discount_code"
                                    value="{{ old('discount_code', $order->discount_code) }}"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="pt-2 border-t border-gray-200">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Total Amount (৳)</label>
                                <input type="number" step="0.01" name="total_amount"
                                    value="{{ old('total_amount', $order->total_amount) }}" id="total"
                                    min="0" readonly
                                    class="w-full text-sm font-semibold rounded border-gray-300 bg-gray-50">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    @if ($order->payments && $order->payments->count() > 0)
                        <div class="bg-white rounded-lg border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h2 class="text-sm font-medium text-gray-900">Payment Information</h2>
                            </div>
                            <div class="p-4">
                                @foreach ($order->payments as $payment)
                                    <div class="mb-3 last:mb-0 p-3 bg-gray-50 rounded border border-gray-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    Payment #{{ $payment->payment_number }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $payment->created_at->format('M j, Y h:i A') }}
                                                </p>
                                            </div>
                                            <span @class([
                                                'px-2 py-1 text-xs rounded',
                                                'bg-green-100 text-green-800' => $payment->status == 'completed',
                                                'bg-yellow-100 text-yellow-800' => $payment->status == 'pending',
                                                'bg-red-100 text-red-800' => $payment->status == 'failed',
                                            ])>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <p>Method: {{ $payment->payment_method_name }}</p>
                                            <p>Amount: ৳{{ number_format($payment->amount, 2) }}</p>
                                            @if ($payment->transaction_id)
                                                <p class="text-xs">Transaction ID: {{ $payment->transaction_id }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Billing Address (Optional) -->
                    @if ($order->billingAddress && $order->billingAddress->id != $order->shippingAddress->id)
                        <div class="bg-white rounded-lg border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h2 class="text-sm font-medium text-gray-900">Billing Address</h2>
                            </div>
                            <div class="p-4">
                                <div class="space-y-2 text-sm">
                                    <p class="font-medium">{{ $order->billingAddress->full_name }}</p>
                                    <p class="text-gray-600">{{ $order->billingAddress->address_line_1 }}</p>
                                    @if ($order->billingAddress->address_line_2)
                                        <p class="text-gray-600">{{ $order->billingAddress->address_line_2 }}</p>
                                    @endif
                                    <div class="text-gray-600">
                                        @if ($order->billingAddress->area)
                                            {{ $order->billingAddress->area }},
                                        @endif
                                        @if ($order->billingAddress->city)
                                            {{ $order->billingAddress->city }},
                                        @endif
                                        @if ($order->billingAddress->postal_code)
                                            {{ $order->billingAddress->postal_code }}
                                        @endif
                                    </div>
                                    <p class="text-gray-600">Phone: {{ $order->billingAddress->phone }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="p-4 space-y-2">
                            <button type="submit"
                                class="w-full py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="block w-full py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors text-center">
                                Cancel
                            </a>
                            @if ($order->canBeCancelled())
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                                    class="pt-2 border-t border-gray-100">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit"
                                        class="w-full py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors"
                                        onclick="return confirm('Cancel this order? This action cannot be undone.')">
                                        Cancel Order
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize calculation
                calculateItemTotals();
                calculateOrderTotal();

                // Event listeners for item calculations
                document.querySelectorAll('.item-quantity, .item-price').forEach(input => {
                    input.addEventListener('input', function() {
                        calculateItemTotal(this.dataset.itemId);
                        calculateSubtotal();
                    });
                });

                // Event listeners for order total calculation
                ['subtotal', 'shipping', 'tax', 'discount'].forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', calculateOrderTotal);
                    }
                });

                // Auto-calculate subtotal when items change
                function calculateSubtotal() {
                    let subtotal = 0;
                    document.querySelectorAll('.item-total').forEach(el => {
                        subtotal += parseFloat(el.textContent.replace(/,/g, '')) || 0;
                    });
                    document.getElementById('subtotal').value = subtotal.toFixed(2);
                    calculateOrderTotal();
                }

                // Calculate individual item total
                function calculateItemTotal(itemId) {
                    const quantity = parseFloat(document.querySelector(`.item-quantity[data-item-id="${itemId}"]`)
                        .value) || 0;
                    const price = parseFloat(document.querySelector(`.item-price[data-item-id="${itemId}"]`).value) ||
                        0;
                    const total = quantity * price;

                    const totalEl = document.querySelector(`.item-total[data-item-id="${itemId}"]`);
                    if (totalEl) {
                        totalEl.textContent = total.toFixed(2);
                    }
                }

                // Calculate all item totals
                function calculateItemTotals() {
                    const itemIds = new Set();
                    document.querySelectorAll('[data-item-id]').forEach(el => {
                        itemIds.add(el.dataset.itemId);
                    });

                    itemIds.forEach(itemId => {
                        calculateItemTotal(itemId);
                    });
                }

                // Calculate order total
                function calculateOrderTotal() {
                    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
                    const shipping = parseFloat(document.getElementById('shipping').value) || 0;
                    const tax = parseFloat(document.getElementById('tax')?.value) || 0;
                    const discount = parseFloat(document.getElementById('discount').value) || 0;
                    const total = subtotal + shipping + tax - discount;

                    const totalInput = document.getElementById('total');
                    if (totalInput) {
                        totalInput.value = total.toFixed(2);
                    }
                }

                // Form validation
                const orderForm = document.getElementById('order-form');
                if (orderForm) {
                    orderForm.addEventListener('submit', function(e) {
                        const total = parseFloat(document.getElementById('total').value) || 0;
                        if (total < 0) {
                            e.preventDefault();
                            alert('Total amount cannot be negative');
                            return false;
                        }

                        // Validate item quantities and prices
                        let isValid = true;
                        const quantityInputs = document.querySelectorAll('.item-quantity');
                        const priceInputs = document.querySelectorAll('.item-price');

                        quantityInputs.forEach(input => {
                            if (parseInt(input.value) < 1) {
                                isValid = false;
                                input.classList.add('border-red-500');
                            } else {
                                input.classList.remove('border-red-500');
                            }
                        });

                        priceInputs.forEach(input => {
                            if (parseFloat(input.value) < 0) {
                                isValid = false;
                                input.classList.add('border-red-500');
                            } else {
                                input.classList.remove('border-red-500');
                            }
                        });

                        if (!isValid) {
                            e.preventDefault();
                            alert('Please check item quantities and prices');
                            return false;
                        }
                    });
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
