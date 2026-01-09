<x-admin-layout>
    @section('title', 'Customer Details')
    <x-slot name="main">
        <!-- Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.customers.index') }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Customers">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $customer->full_name }}</h1>
                        <p class="text-xs text-gray-500">
                            Customer since {{ $customer->created_at->format('M j, Y') }}
                            @if ($customerSegment)
                                • <span class="font-medium text-blue-600">{{ $customerSegment }} Customer</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.customers.edit', $customer->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Edit Customer
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Customer Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Total Orders</p>
                                <p class="text-lg font-bold text-gray-900">{{ $totalOrders }}</p>
                            </div>
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Total Spent</p>
                                <p class="text-lg font-bold text-gray-900">৳{{ number_format($totalSpent, 2) }}</p>
                            </div>
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Avg Order Value</p>
                                <p class="text-lg font-bold text-gray-900">৳{{ number_format($avgOrderValue, 2) }}</p>
                            </div>
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Customer Type</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ $customer->type }}</p>
                            </div>
                            @if ($customer->type === 'registered')
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Status Stats -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Order Status Overview</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            <div class="text-center">
                                <div class="text-lg font-bold text-yellow-600">{{ $pendingOrders }}</div>
                                <div class="text-xs text-gray-500">Pending</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-blue-600">{{ $processingOrders }}</div>
                                <div class="text-xs text-gray-500">Processing</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-purple-600">{{ $shippedOrders }}</div>
                                <div class="text-xs text-gray-500">Shipped</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">{{ $deliveredOrders }}</div>
                                <div class="text-xs text-gray-500">Delivered</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-red-600">{{ $cancelledOrders }}</div>
                                <div class="text-xs text-gray-500">Cancelled</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-sm font-medium text-gray-900">Recent Orders</h2>
                        <a href="{{ route('admin.orders.index') }}?search={{ $customer->phone }}"
                            class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            View All Orders
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <div class="p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-sm font-medium text-gray-900 hover:text-blue-600 hover:underline">
                                            Order #{{ $order->order_number }}
                                        </a>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $order->created_at->format('M j, Y h:i A') }}
                                        </p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span @class([
                                                'px-2 py-1 text-xs rounded',
                                                'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                                'bg-blue-100 text-blue-800' => $order->status == 'confirmed',
                                                'bg-purple-100 text-purple-800' => $order->status == 'processing',
                                                'bg-green-100 text-green-800' => $order->status == 'shipped',
                                                'bg-green-200 text-green-800' => $order->status == 'delivered',
                                                'bg-red-100 text-red-800' => in_array($order->status, [
                                                    'cancelled',
                                                    'returned',
                                                ]),
                                            ])>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">
                                                {{ $order->payment_method_name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            ৳{{ number_format($order->total_amount, 2) }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $order->items_count ?? $order->items->count() }} items</p>
                                    </div>
                                </div>

                                <!-- Order Items Summary -->
                                @if ($order->items && $order->items->count() > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <p class="text-xs text-gray-500 mb-2">Items:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($order->items->take(3) as $item)
                                                <span class="text-xs text-gray-600 bg-gray-50 px-2 py-1 rounded">
                                                    {{ $item->product_name ?? $item->product->name }}
                                                    ({{ $item->quantity }})
                                                </span>
                                            @endforeach
                                            @if ($order->items->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $order->items->count() - 3 }}
                                                    more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-gray-500">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <div>No orders found</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Purchased Products -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Purchased Products</h2>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Product</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Quantity</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Total Amount</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Avg
                                            Price</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($purchasedProducts as $product)
                                        <tr>
                                            <td class="px-3 py-2">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    @if ($product->category_name)
                                                        {{ $product->category_name }} •
                                                    @endif
                                                    @if ($product->brand_name)
                                                        {{ $product->brand_name }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $product->total_quantity }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                ৳{{ number_format($product->total_amount, 2) }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                ৳{{ number_format($product->avg_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">
                                                No products purchased yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Customer Information -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Customer Information</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 rounded-lg bg-blue-100 flex items-center justify-center">
                                <span class="text-xl font-bold text-blue-600">
                                    {{ substr($customer->full_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $customer->full_name }}</h3>
                                <p class="text-xs text-gray-500">
                                    {{ $customer->type === 'registered' ? 'Registered Customer' : 'Guest Customer' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <p class="text-xs font-medium text-gray-500">Email</p>
                                <p class="text-sm text-gray-900">{{ $customer->email ?? 'No email' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Phone</p>
                                <p class="text-sm text-gray-900">{{ $customer->phone }}</p>
                            </div>
                            @if ($customer->date_of_birth)
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Date of Birth</p>
                                    <p class="text-sm text-gray-900">{{ $customer->date_of_birth->format('M j, Y') }}
                                    </p>
                                </div>
                            @endif
                            @if ($customer->gender)
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Gender</p>
                                    <p class="text-sm text-gray-900 capitalize">{{ $customer->gender }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs font-medium text-gray-500">Member Since</p>
                                <p class="text-sm text-gray-900">{{ $customer->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500">Status</span>
                                @if ($customer->is_active)
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500">Marketing</span>
                                @if ($customer->accepts_marketing)
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-800">
                                        Subscribed
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-800">
                                        Not Subscribed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Addresses -->
                @if ($customer->addresses && $customer->addresses->count() > 0)
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Saved Addresses</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach ($customer->addresses as $address)
                                <div class="p-3 bg-gray-50 rounded border border-gray-100">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $address->full_name }}
                                                </p>
                                                @if ($address->is_default_shipping)
                                                    <span
                                                        class="px-1.5 py-0.5 text-xs bg-green-100 text-green-800 rounded">Shipping</span>
                                                @endif
                                                @if ($address->is_default_billing)
                                                    <span
                                                        class="px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">Billing</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-600">{{ $address->address_line_1 }}</p>
                                            @if ($address->address_line_2)
                                                <p class="text-xs text-gray-600">{{ $address->address_line_2 }}</p>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-1">
                                                @if ($address->area)
                                                    {{ $address->area }},
                                                @endif
                                                @if ($address->city)
                                                    {{ $address->city }},
                                                @endif
                                                @if ($address->postal_code)
                                                    {{ $address->postal_code }}
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Phone: {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Purchase Categories -->
                @if ($purchaseCategories && $purchaseCategories->count() > 0)
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Purchase Categories</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach ($purchaseCategories->take(5) as $category)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-900">{{ $category->name }}</span>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $category->order_count }}
                                            orders</p>
                                        <p class="text-xs text-gray-500">
                                            ৳{{ number_format($category->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @if ($purchaseCategories->count() > 5)
                                <div class="pt-2 border-t border-gray-200 text-center">
                                    <p class="text-xs text-gray-500">+{{ $purchaseCategories->count() - 5 }} more
                                        categories</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Purchase Brands -->
                @if ($purchaseBrands && $purchaseBrands->count() > 0)
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Preferred Brands</h2>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach ($purchaseBrands->take(5) as $brand)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-900">{{ $brand->name }}</span>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $brand->order_count }} orders
                                        </p>
                                        <p class="text-xs text-gray-500">৳{{ number_format($brand->total_amount, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            @if ($purchaseBrands->count() > 5)
                                <div class="pt-2 border-t border-gray-200 text-center">
                                    <p class="text-xs text-gray-500">+{{ $purchaseBrands->count() - 5 }} more brands
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Lifetime Value -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h2 class="text-sm font-medium text-gray-900">Customer Value</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Lifetime Value</span>
                            <span
                                class="text-sm font-semibold text-green-600">৳{{ number_format($totalSpent, 2) }}</span>
                        </div>
                        @if ($lifetimeValue['first_order_date'])
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">First Order</span>
                                <span
                                    class="text-sm text-gray-900">{{ $lifetimeValue['first_order_date']->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Last Order</span>
                                <span
                                    class="text-sm text-gray-900">{{ $lifetimeValue['last_order_date']->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Days Active</span>
                                <span class="text-sm text-gray-900">{{ $lifetimeValue['days_active'] }} days</span>
                            </div>
                            @if ($lifetimeValue['predicted_ltv'] > 0)
                                <div class="pt-2 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Predicted LTV</span>
                                        <span
                                            class="text-sm font-semibold text-blue-600">৳{{ number_format($lifetimeValue['predicted_ltv'], 2) }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Based on 3-year retention</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="p-4 space-y-2">
                        <a href="{{ route('admin.customers.edit', $customer->id) }}"
                            class="block w-full py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors text-center">
                            Edit Customer
                        </a>
                        <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="w-full py-2 text-sm font-medium text-white {{ $customer->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} rounded transition-colors">
                                {{ $customer->is_active ? 'Deactivate Customer' : 'Activate Customer' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.customers.activity', $customer->id) }}"
                            class="block w-full py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors text-center">
                            View Activity
                        </a>
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors">
                                Delete Customer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
