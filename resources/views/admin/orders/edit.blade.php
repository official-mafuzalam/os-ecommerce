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
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing"
                                            {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="pending"
                                            {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="paid"
                                            {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed"
                                            {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded"
                                            {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $order->shippingAddress->full_name) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" name="customer_phone"
                                        value="{{ old('customer_phone', $order->customer_phone) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Shipping Address</label>
                                <textarea name="full_address" rows="2"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('full_address', $order->shippingAddress->full_address) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Tracking Number</label>
                                    <input type="text" name="tracking_number"
                                        value="{{ old('tracking_number', $order->tracking_number) }}"
                                        class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" value="{{ $order->customer_email }}" disabled
                                        class="w-full text-sm rounded border-gray-300 bg-gray-50 cursor-not-allowed">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Order Notes</label>
                                <textarea name="notes" rows="2"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $order->notes) }}</textarea>
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
                                            <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/48' }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}
                                            </h3>
                                            <p class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</p>

                                            <!-- Attribute Options -->
                                            @if ($item->attributes && $item->attributes->count() > 0)
                                                <div class="mt-2">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach ($item->attributes as $attribute)
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">
                                                                    {{ $attribute->name }}
                                                                </label>
                                                                <input type="text"
                                                                    name="items[{{ $item->id }}][attributes][{{ $attribute->id }}]"
                                                                    value="{{ old('items.' . $item->id . '.attributes.' . $attribute->id, $attribute->pivot->value) }}"
                                                                    class="w-full text-xs rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                                                    placeholder="{{ $attribute->name }} value">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Quantity</label>
                                            <input type="number" name="items[{{ $item->id }}][quantity]"
                                                value="{{ old('items.' . $item->id . '.quantity', $item->quantity) }}"
                                                min="1" data-item-id="{{ $item->id }}"
                                                class="item-quantity w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price
                                                (TK)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $item->id }}][unit_price]"
                                                value="{{ old('items.' . $item->id . '.unit_price', $item->unit_price) }}"
                                                min="0" data-item-id="{{ $item->id }}"
                                                class="item-price w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Total
                                                (TK)</label>
                                            <div class="text-sm font-semibold text-gray-900 item-total"
                                                data-item-id="{{ $item->id }}">
                                                {{ number_format($item->unit_price * $item->quantity, 2) }}
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
                                <label class="block text-xs font-medium text-gray-700 mb-1">Subtotal (TK)</label>
                                <input type="number" step="0.01" name="subtotal"
                                    value="{{ old('subtotal', $order->subtotal) }}" id="subtotal" min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Shipping Cost (TK)</label>
                                <input type="number" step="0.01" name="shipping_cost"
                                    value="{{ old('shipping_cost', $order->shipping_cost) }}" id="shipping"
                                    min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Discount (TK)</label>
                                <input type="number" step="0.01" name="discount_amount"
                                    value="{{ old('discount_amount', $order->discount_amount) }}" id="discount"
                                    min="0"
                                    class="w-full text-sm rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="pt-2 border-t border-gray-200">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Total Amount (TK)</label>
                                <input type="number" step="0.01" name="total_amount"
                                    value="{{ old('total_amount', $order->total_amount) }}" id="total"
                                    min="0" readonly
                                    class="w-full text-sm font-semibold rounded border-gray-300 bg-gray-50">
                            </div>
                        </div>
                    </div>

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
                ['subtotal', 'shipping', 'discount'].forEach(id => {
                    document.getElementById(id).addEventListener('input', calculateOrderTotal);
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
                    const discount = parseFloat(document.getElementById('discount').value) || 0;
                    const total = subtotal + shipping - discount;

                    document.getElementById('total').value = total.toFixed(2);
                }

                // Form validation
                document.getElementById('order-form').addEventListener('submit', function(e) {
                    const total = parseFloat(document.getElementById('total').value) || 0;
                    if (total < 0) {
                        e.preventDefault();
                        alert('Total amount cannot be negative');
                        return false;
                    }

                    // Validate item quantities and prices
                    let isValid = true;
                    document.querySelectorAll('.item-quantity').forEach(input => {
                        if (parseInt(input.value) < 1) {
                            isValid = false;
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                    });

                    document.querySelectorAll('.item-price').forEach(input => {
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
            });
        </script>
    </x-slot>
</x-admin-layout>
