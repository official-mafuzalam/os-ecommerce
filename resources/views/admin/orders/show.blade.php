<x-admin-layout>
    @section('title', 'Order Details')
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.orders.index') }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Orders">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h1>
                        <p class="text-xs text-gray-500">Placed on {{ $order->created_at->format('M j, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Invoice
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-10 py-1">
                            <button onclick="printInvoice()"
                                class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print
                            </button>
                            <a href="{{ route('admin.orders.invoice.pdf', $order->id) }}"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Edit Order
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Order Status -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-900">Order Status</h2>
                            @if ($order->tracking_number)
                                <span class="text-xs text-gray-500">Tracking: {{ $order->tracking_number }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center space-x-3">
                                <span @class([
                                    'px-2 py-1 text-xs font-medium rounded-md',
                                    'bg-yellow-100 text-yellow-800 border border-yellow-200' =>
                                        $order->status == 'pending',
                                    'bg-blue-100 text-blue-800 border border-blue-200' =>
                                        $order->status == 'confirmed',
                                    'bg-indigo-100 text-indigo-800 border border-indigo-200' =>
                                        $order->status == 'processing',
                                    'bg-purple-100 text-purple-800 border border-purple-200' =>
                                        $order->status == 'shipped',
                                    'bg-green-100 text-green-800 border border-green-200' =>
                                        $order->status == 'delivered',
                                    'bg-red-100 text-red-800 border border-red-200' => in_array(
                                        $order->status,
                                        ['cancelled', 'returned', 'refunded']),
                                ])>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <div>
                                    <p class="text-xs text-gray-500">Current Status</p>
                                    <p class="text-sm font-medium text-gray-900 capitalize">{{ $order->status }}</p>
                                </div>
                            </div>

                            @if (!in_array($order->status, ['cancelled', 'delivered', 'returned', 'refunded']))
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                                    class="flex items-center space-x-2">
                                    @csrf @method('PATCH')
                                    <select name="status"
                                        class="text-xs rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Update Status</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing"
                                            {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered"
                                            {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="returned">Returned</option>
                                        <option value="refunded">Refunded</option>
                                        <option value="cancelled">Cancel</option>
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                                        Update
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Shipping & Customer Info -->
                <div class="bg-white rounded-lg border border-gray-200 grid grid-cols-2 gap-4 p-4">
                    <!-- Shipping Address -->
                    @if ($order->shippingAddress)
                        <div>
                            <h3 class="text-xs font-medium text-gray-900 mb-2">Shipping Address</h3>
                            <div class="space-y-1 text-sm">
                                <p class="font-medium">{{ $order->shippingAddress->full_name }}</p>
                                <p class="text-gray-600">{{ $order->shippingAddress->address_line_1 }}</p>
                                @if ($order->shippingAddress->address_line_2)
                                    <p class="text-gray-600">{{ $order->shippingAddress->address_line_2 }}</p>
                                @endif
                                <div class="text-gray-600">
                                    @if ($order->shippingAddress->area)
                                        {{ $order->shippingAddress->area }},
                                    @endif
                                    @if ($order->shippingAddress->city)
                                        {{ $order->shippingAddress->city }},
                                    @endif
                                    @if ($order->shippingAddress->postal_code)
                                        {{ $order->shippingAddress->postal_code }}
                                    @endif
                                </div>
                                <p class="text-gray-600">{{ $order->shippingAddress->country }}</p>
                                <p class="text-gray-600">Phone: {{ $order->shippingAddress->phone }}</p>
                                @if ($order->shippingAddress->email)
                                    <p class="text-gray-600">Email: {{ $order->shippingAddress->email }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Billing Address -->
                    @if ($order->billingAddress && $order->billingAddress->id != $order->shippingAddress->id)
                        <div>
                            <h3 class="text-xs font-medium text-gray-900 mb-2">Billing Address</h3>
                            <div class="space-y-1 text-sm">
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
                                <p class="text-gray-600">{{ $order->billingAddress->country }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Customer Stats -->
                        <div>
                            <h3 class="text-xs font-medium text-gray-900 mb-2">Customer History</h3>
                            <div class="grid grid-cols-3 gap-2 text-center">
                                <div class="p-2 bg-green-50 rounded border border-green-100">
                                    <p class="text-lg font-bold text-green-700">{{ $completedCustomerOrders }}</p>
                                    <p class="text-xs text-green-600">Completed</p>
                                </div>
                                <div class="p-2 bg-red-50 rounded border border-red-100">
                                    <p class="text-lg font-bold text-red-700">{{ $cancelledCustomerOrders }}</p>
                                    <p class="text-xs text-red-600">Cancelled</p>
                                </div>
                                <div class="p-2 bg-blue-50 rounded border border-blue-100">
                                    <p class="text-lg font-bold text-blue-700">{{ $totalCustomerOrders }}</p>
                                    <p class="text-xs text-blue-600">Total</p>
                                </div>
                            </div>
                            @if ($totalSpent > 0)
                                <div class="mt-3 p-2 bg-gray-50 rounded border border-gray-100">
                                    <p class="text-xs text-gray-600">Total Spent</p>
                                    <p class="text-sm font-bold text-gray-900">৳{{ number_format($totalSpent, 2) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-sm font-medium text-gray-900">Order Items</h2>
                        <span class="text-xs text-gray-500">{{ $order->items->count() }} items</span>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <div class="p-4 flex items-start space-x-3">
                                <div class="flex-shrink-0 w-16 h-16 rounded border border-gray-200 overflow-hidden">
                                    @php
                                        $productImage = $item->product->images->where('is_primary', true)->first();
                                        $imageUrl = $productImage
                                            ? Storage::url($productImage->image_path)
                                            : 'https://via.placeholder.com/64';
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.products.show', $item->product->id) }}"
                                                    class="hover:text-blue-600">
                                                    {{ $item->product_name ?? $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-xs text-gray-500">SKU:
                                                {{ $item->product_sku ?? $item->product->sku }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} ×
                                                ৳{{ number_format($item->unit_price, 2) }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 whitespace-nowrap ml-2">
                                            ৳{{ number_format($item->total_price, 2) }}
                                        </p>
                                    </div>

                                    @if ($item->variant_options && is_array($item->variant_options))
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-600 mb-1">Options:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($item->variant_options as $option)
                                                    @if (is_array($option))
                                                        <span
                                                            class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                                            {{ $option['name'] ?? 'Option' }}:
                                                            {{ $option['value'] ?? '' }}
                                                        </span>
                                                    @elseif(is_string($option))
                                                        <span
                                                            class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                                            {{ $option }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
                                    <div class="flex justify-between items-start">
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
                                            'bg-blue-100 text-blue-800' => $payment->status == 'processing',
                                            'bg-red-100 text-red-800' => $payment->status == 'failed',
                                        ])>
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="text-gray-600">Method:</span>
                                            <span class="font-medium ml-1">{{ $payment->payment_method_name }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Amount:</span>
                                            <span
                                                class="font-medium ml-1">৳{{ number_format($payment->amount, 2) }}</span>
                                        </div>
                                        @if ($payment->transaction_id)
                                            <div class="col-span-2">
                                                <span class="text-gray-600">Transaction ID:</span>
                                                <span class="font-medium ml-1">{{ $payment->transaction_id }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Summary</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Payment Method</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-900">{{ $order->payment_method_name }}</span>
                                    <span @class([
                                        'px-1.5 py-0.5 text-xs rounded',
                                        'bg-green-100 text-green-800' => $order->payment_status == 'paid',
                                        'bg-yellow-100 text-yellow-800' => $order->payment_status == 'pending',
                                        'bg-blue-100 text-blue-800' => $order->payment_status == 'authorized',
                                        'bg-orange-100 text-orange-800' =>
                                            $order->payment_status == 'partially_paid',
                                        'bg-red-100 text-red-800' => in_array($order->payment_status, [
                                            'failed',
                                            'refunded',
                                        ]),
                                    ])>
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </div>
                            </div>

                            @if ($order->payment_status != 'paid' && !in_array($order->status, ['cancelled', 'refunded']))
                                <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded transition-colors">
                                        Mark as Paid
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Shipping Info -->
                        @if ($order->shipping_method || $order->courier_name)
                            <div class="pt-2 border-t border-gray-200 space-y-1.5">
                                @if ($order->shipping_method)
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Shipping Method</span>
                                        <span
                                            class="text-xs text-gray-900 capitalize">{{ str_replace('_', ' ', $order->shipping_method) }}</span>
                                    </div>
                                @endif
                                @if ($order->courier_name)
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Courier</span>
                                        <span class="text-xs text-gray-900">{{ $order->courier_name }}</span>
                                    </div>
                                @endif
                                @if ($order->estimated_delivery_date)
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Est. Delivery</span>
                                        <span
                                            class="text-xs text-gray-900">{{ $order->estimated_delivery_date->format('M j, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Price Breakdown -->
                        <div class="pt-2 border-t border-gray-200 space-y-1.5">
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Subtotal</span>
                                <span class="text-xs text-gray-900">৳{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Shipping</span>
                                <span
                                    class="text-xs text-gray-900">৳{{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            @if ($order->tax_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-600">Tax</span>
                                    <span
                                        class="text-xs text-gray-900">৳{{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-600">Discount</span>
                                    <span
                                        class="text-xs text-red-600">-৳{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between pt-1.5 border-t border-gray-200">
                                <span class="text-sm font-medium text-gray-900">Total</span>
                                <span
                                    class="text-sm font-semibold text-gray-900">৳{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Customer</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            @if ($order->customer)
                                <div>
                                    <p class="text-xs text-gray-500">Name</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->customer->full_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $order->customer->type === 'registered' ? 'Registered Customer' : 'Guest Customer' }}
                                    </p>
                                </div>
                            @elseif($order->shippingAddress)
                                <div>
                                    <p class="text-xs text-gray-500">Name</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $order->shippingAddress->full_name }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs text-gray-500">Phone</p>
                                <p class="text-sm text-gray-900">{{ $order->shippingAddress->phone }}</p>
                            </div>
                            @if ($order->customer_email)
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm text-gray-900 truncate">{{ $order->shippingAddress->email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                @if ($order->customer_notes || $order->admin_notes)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Notes</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            @if ($order->customer_notes)
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Customer Note:</p>
                                    <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded">
                                        {{ $order->customer_notes }}</p>
                                </div>
                            @endif
                            @if ($order->admin_notes)
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Admin Note:</p>
                                    <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded">{{ $order->admin_notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Danger Zone -->
                @if ($order->canBeCancelled())
                    <div class="bg-white rounded-lg border border-red-200">
                        <div class="px-4 py-3 border-b border-red-200 bg-red-50">
                            <h2 class="text-sm font-medium text-red-700">Danger Zone</h2>
                        </div>
                        <div class="grid grid-cols-2 p-4 gap-2">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="w-full py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors"
                                    onclick="return confirm('Cancel this order?')">
                                    Cancel Order
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors"
                                    onclick="return confirm('Delete this order permanently? This action cannot be undone.')">
                                    Delete Order
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Hidden Invoice Template -->
        <div id="invoice-template" class="hidden">
            <div class="bg-white p-6 max-w-3xl mx-auto text-sm">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        @if (setting('site_logo'))
                            <img src="{{ Storage::url(setting('site_logo')) }}" alt="Logo"
                                class="h-12 w-auto mb-2">
                        @endif
                        <h1 class="text-xl font-bold text-gray-900">INVOICE</h1>
                        <p class="text-gray-600">#{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">{{ setting('site_name') }}</p>
                        <p class="text-gray-600">{{ setting('site_address') }}</p>
                        <p class="text-gray-600">{{ setting('site_phone') }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-medium mb-1">Bill To:</p>
                        <p class="text-gray-700">{{ $order->shippingAddress->full_name ?? 'N/A' }}</p>
                        <p class="text-gray-700">{{ $order->shippingAddress->phone }}</p>
                        @if ($order->shippingAddress)
                            <p class="text-gray-700">{{ $order->shippingAddress->address_line_1 }}</p>
                            @if ($order->shippingAddress->address_line_2)
                                <p class="text-gray-700">{{ $order->shippingAddress->address_line_2 }}</p>
                            @endif
                            <p class="text-gray-700">
                                @if ($order->shippingAddress->area)
                                    {{ $order->shippingAddress->area }},
                                @endif
                                @if ($order->shippingAddress->city)
                                    {{ $order->shippingAddress->city }},
                                @endif
                                @if ($order->shippingAddress->postal_code)
                                    {{ $order->shippingAddress->postal_code }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium mb-1">Invoice Details:</p>
                        <div class="flex justify-between">
                            <span>Date:</span>
                            <span>{{ $order->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            <span class="capitalize">{{ $order->payment_status }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Order Status:</span>
                            <span class="capitalize">{{ $order->status }}</span>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <table class="w-full mb-6">
                    <thead class="border-b">
                        <tr>
                            <th class="text-left py-2">Item</th>
                            <th class="text-right py-2">Qty</th>
                            <th class="text-right py-2">Price</th>
                            <th class="text-right py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b">
                                <td class="py-2">
                                    {{ $item->product_name }}
                                    @if ($item->variant_options && is_array($item->variant_options))
                                        <div class="text-xs text-gray-500 mt-1">
                                            @foreach ($item->variant_options as $option)
                                                @if (is_array($option))
                                                    {{ $option['name'] ?? '' }}: {{ $option['value'] ?? '' }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-right py-2">{{ $item->quantity }}</td>
                                <td class="text-right py-2">৳{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-right py-2">৳{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-48">
                        <div class="flex justify-between py-1">
                            <span>Subtotal:</span>
                            <span>৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>Shipping:</span>
                            <span>৳{{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        @if ($order->tax_amount > 0)
                            <div class="flex justify-between py-1">
                                <span>Tax:</span>
                                <span>৳{{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                        @endif
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between py-1">
                                <span>Discount:</span>
                                <span class="text-red-600">-৳{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-t font-bold">
                            <span>Total:</span>
                            <span>৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                @if ($order->payments && $order->payments->count() > 0)
                    <div class="mt-6 pt-4 border-t">
                        <p class="font-medium mb-2">Payment Information:</p>
                        @foreach ($order->payments as $payment)
                            <div class="text-sm mb-2 last:mb-0">
                                <span class="text-gray-600">Payment #{{ $payment->payment_number }}:</span>
                                <span class="font-medium ml-1">{{ $payment->payment_method_name }} -
                                    ৳{{ number_format($payment->amount, 2) }}</span>
                                <span class="ml-2 text-xs capitalize">{{ $payment->status }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Footer -->
                <div class="mt-8 text-center text-gray-500 text-xs">
                    <p>Thank you for your business!</p>
                </div>
            </div>
        </div>

        <script>
            function printInvoice() {
                const printWindow = window.open('', '_blank');
                const content = document.getElementById('invoice-template').innerHTML;

                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Invoice - {{ $order->order_number }}</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #374151; }
                            @media print { @page { margin: 20mm; } }
                            .border-b { border-bottom: 1px solid #e5e7eb; }
                            .border-t { border-top: 1px solid #e5e7eb; }
                            .border { border: 1px solid #e5e7eb; }
                            .rounded { border-radius: 0.375rem; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { padding: 0.5rem; text-align: left; }
                            th { font-weight: 600; }
                            .text-right { text-align: right; }
                            .text-left { text-align: left; }
                            .font-bold { font-weight: 700; }
                            .font-medium { font-weight: 500; }
                            .font-semibold { font-weight: 600; }
                            .text-gray-900 { color: #111827; }
                            .text-gray-700 { color: #374151; }
                            .text-gray-600 { color: #4b5563; }
                            .text-gray-500 { color: #6b7280; }
                            .text-red-600 { color: #dc2626; }
                            .bg-gray-50 { background-color: #f9fafb; }
                        </style>
                    </head>
                    <body>${content}</body>
                    </html>
                `);

                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => printWindow.print(), 250);
            }
        </script>
    </x-slot>
</x-admin-layout>
