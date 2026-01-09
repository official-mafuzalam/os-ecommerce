<x-admin-layout>
    @section('title', 'Orders Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Orders</h1>
                <p class="mt-1 text-sm text-gray-500">Manage and track all customer orders</p>
            </div>

            <!-- Order Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-8 gap-2 mb-4">
                @php
                    $stats = [
                        [
                            'label' => 'Total',
                            'count' => $totalOrders,
                            'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                            'color' => 'bg-blue-500',
                        ],
                        [
                            'label' => 'Pending',
                            'count' => $pendingOrders,
                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'bg-yellow-500',
                        ],
                        [
                            'label' => 'Confirmed',
                            'count' => $confirmedOrders,
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'bg-indigo-500',
                        ],
                        [
                            'label' => 'Processing',
                            'count' => $processingOrders,
                            'icon' =>
                                'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                            'color' => 'bg-purple-500',
                        ],
                        [
                            'label' => 'Shipped',
                            'count' => $shippedOrders,
                            'icon' =>
                                'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                            'color' => 'bg-blue-600',
                        ],
                        [
                            'label' => 'Delivered',
                            'count' => $deliveredOrders,
                            'icon' => 'M5 13l4 4L19 7',
                            'color' => 'bg-green-600',
                        ],
                        [
                            'label' => 'Cancelled',
                            'count' => $cancelledOrders,
                            'icon' => 'M6 18L18 6M6 6l12 12',
                            'color' => 'bg-red-500',
                        ],
                        [
                            'label' => 'Refunded',
                            'count' => $refundedOrders,
                            'icon' =>
                                'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'bg-gray-500',
                        ],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="bg-white border border-gray-200 rounded-lg p-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 flex items-center justify-center rounded-lg {{ str_replace('500', '100', $stat['color']) }}">
                                <svg class="w-4 h-4 {{ $stat['color'] }}" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $stat['icon'] }}" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                                <p class="text-base font-semibold text-gray-900">{{ $stat['count'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Filters Card -->
            <div class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                <select name="status"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Statuses</option>
                                    @foreach ($statuses as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Payment Status</label>
                                <select name="payment_status"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Payment Status</option>
                                    @foreach ($paymentStatuses as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ request('payment_status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                                <select name="category_id"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Brand</label>
                                <select name="brand_id"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Brands</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Product</label>
                                <select name="product_id"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Products</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ Str::limit($product->name, 25) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Payment Method</label>
                                <select name="payment_method"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Methods</option>
                                    @foreach ($paymentMethods as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ request('payment_method') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Order #, Customer, Phone, Email"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.orders.index') }}"
                                    class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-center">
                                    Reset
                                </a>
                                <button type="submit"
                                    class="flex-1 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Ordered</p>
                            <p class="text-lg font-semibold text-gray-900">৳{{ number_format($totalAmount, 2) }}</p>
                        </div>
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Completed</p>
                            <p class="text-lg font-semibold text-gray-900">
                                ৳{{ number_format($totalCompletedAmount, 2) }}</p>
                        </div>
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Cancelled</p>
                            <p class="text-lg font-semibold text-gray-900">
                                ৳{{ number_format($totalCancelledAmount, 2) }}</p>
                        </div>
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Payment Statistics -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-900">Payment Status</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                            <p class="text-lg font-bold text-green-700">{{ $paidOrders }}</p>
                            <p class="text-xs text-green-600">Paid Orders</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                            <p class="text-lg font-bold text-yellow-700">{{ $pendingPaymentOrders }}</p>
                            <p class="text-xs text-yellow-600">Pending Payment</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-gray-900">Customer Stats</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <p class="text-lg font-bold text-blue-700">{{ $totalOrders }}</p>
                            <p class="text-xs text-blue-600">Total Orders</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-lg border border-indigo-100">
                            <p class="text-lg font-bold text-indigo-700">{{ $orders->sum('items_count') ?? 0 }}</p>
                            <p class="text-xs text-indigo-600">Total Items</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table Header -->
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-sm font-medium text-gray-900">All Orders</h2>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500">{{ $orders->total() }} orders</span>
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-gray-500">Sort by:</label>
                            <select onchange="this.form.submit()" name="sort_by"
                                class="text-xs rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="created_at"
                                    {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Date
                                </option>
                                <option value="total_amount"
                                    {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Amount</option>
                                <option value="order_number"
                                    {{ request('sort_by') == 'order_number' ? 'selected' : '' }}>Order #</option>
                            </select>
                            <select onchange="this.form.submit()" name="sort_order"
                                class="text-xs rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="desc"
                                    {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Desc</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Asc
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order #
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Payment
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="hover:text-blue-600 hover:underline">
                                                {{ $order->order_number }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ $order->shipping_method ?? 'Standard' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($order->customer)
                                            <div class="text-sm text-gray-900">{{ $order->customer->full_name }}</div>
                                        @elseif($order->shippingAddress)
                                            <div class="text-sm text-gray-900">
                                                {{ $order->shippingAddress->full_name }}</div>
                                        @else
                                            <div class="text-sm text-gray-900">Guest</div>
                                        @endif
                                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                        @if ($order->customer_email)
                                            <div class="text-xs text-gray-400 truncate max-w-[150px]">
                                                {{ $order->customer_email }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $order->created_at->format('M j, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span @class([
                                            'px-2 py-1 text-xs font-medium rounded-md inline-block',
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
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-xs text-gray-500 mb-1">{{ $order->payment_method_name }}
                                        </div>
                                        <span @class([
                                            'px-2 py-0.5 text-xs rounded inline-block',
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
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            ৳{{ number_format($order->total_amount, 2) }}
                                        </div>
                                        @if ($order->items_count > 0)
                                            <div class="text-xs text-gray-500">{{ $order->items_count }} items</div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="Edit Order">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @if ($order->canBeCancelled())
                                                <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit"
                                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                        onclick="return confirm('Cancel this order?')"
                                                        title="Cancel Order">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.orders.invoice.pdf', $order->id) }}"
                                                class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded transition-colors"
                                                title="Download Invoice">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <div>No orders found</div>
                                            <a href="{{ route('admin.orders.index') }}"
                                                class="text-blue-600 hover:text-blue-800 hover:underline text-sm">
                                                Clear filters
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to
                            <span class="font-medium">{{ $orders->lastItem() }}</span> of
                            <span class="font-medium">{{ $orders->total() }}</span> orders
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($orders->onFirstPage())
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Next
                                </a>
                            @else
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-admin-layout>
