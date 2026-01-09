<x-admin-layout>
    @section('title', 'Customers Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage and view all customer information</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.customers.export') }}" target="_blank"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Customers -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a5 5 0 00-7.742-.742m0 0a5 5 0 00-7.742 7.742" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Registered Customers -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Registered</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $registeredCustomers }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Guest Customers -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Guest Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $guestCustomers }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Customers -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeCustomers }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Top Customers by Orders -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">Top Customers by Orders</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            @foreach ($topCustomersByOrders as $customer)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600">
                                                {{ substr($customer->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $customer->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">{{ $customer->orders_count }}
                                            orders</p>
                                        <p class="text-xs text-gray-500">
                                            @if ($customer->orders_sum_total_amount)
                                                ৳{{ number_format($customer->orders_sum_total_amount, 2) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top Customers by Spending -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">Top Customers by Spending</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            @foreach ($topCustomersBySpending as $customer)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-medium text-green-600">
                                                {{ substr($customer->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $customer->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $customer->phone }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            ৳{{ number_format($customer->orders_sum_total_amount, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $customer->orders_count ?? 0 }} orders</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.customers.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Name, Email, Phone"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Customer Type</label>
                                <select name="type"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Types</option>
                                    <option value="registered"
                                        {{ request('type') == 'registered' ? 'selected' : '' }}>Registered</option>
                                    <option value="guest" {{ request('type') == 'guest' ? 'selected' : '' }}>Guest
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                <select name="is_active"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.customers.index') }}"
                                    class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-center">
                                    Reset
                                </a>
                                <button type="submit"
                                    class="flex-1 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Apply Filters
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="flex items-end gap-2">
                                <select name="sort_by"
                                    class="w-1/2 text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="created_at"
                                        {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Sort
                                        by Date</option>
                                    <option value="full_name"
                                        {{ request('sort_by') == 'full_name' ? 'selected' : '' }}>Sort by Name</option>
                                    <option value="orders_count"
                                        {{ request('sort_by') == 'orders_count' ? 'selected' : '' }}>Sort by Orders
                                    </option>
                                </select>
                                <select name="sort_order"
                                    class="w-1/2 text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="desc"
                                        {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending
                                    </option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                        Ascending</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table Header -->
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-sm font-medium text-gray-900">All Customers</h2>
                    <span class="text-xs text-gray-500">{{ $customers->total() }} customers</span>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Orders
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Spent
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customers as $customer)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ substr($customer->full_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                                                        class="hover:text-blue-600 hover:underline">
                                                        {{ $customer->full_name }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                    @if ($customer->type === 'registered')
                                                        <span
                                                            class="px-1.5 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">Registered</span>
                                                    @else
                                                        <span
                                                            class="px-1.5 py-0.5 bg-gray-100 text-gray-800 text-xs rounded">Guest</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $customer->email ?? 'No email' }}</div>
                                        <div class="text-xs text-gray-500">{{ $customer->phone }}</div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $customer->orders_count ?? 0 }}</div>
                                        <div class="text-xs text-gray-500">
                                            @if ($customer->last_order)
                                                Last: {{ $customer->last_order->created_at->format('M j, Y') }}
                                            @else
                                                No orders
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            @php
                                                $totalSpent = $customer->orders()->sum('total_amount');
                                            @endphp
                                            ৳{{ number_format($totalSpent, 2) }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @if ($customer->orders_count > 0)
                                                ৳{{ number_format($totalSpent / $customer->orders_count, 2) }} avg
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($customer->is_active)
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.customers.show', $customer->id) }}"
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
                                            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="Edit Customer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.customers.toggle-status', $customer->id) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded transition-colors"
                                                    title="{{ $customer->is_active ? 'Deactivate' : 'Activate' }}">
                                                    @if ($customer->is_active)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a5 5 0 00-7.742-.742m0 0a5 5 0 00-7.742 7.742" />
                                            </svg>
                                            <div>No customers found</div>
                                            <a href="{{ route('admin.customers.index') }}"
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
                @if ($customers->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $customers->firstItem() }}</span> to
                            <span class="font-medium">{{ $customers->lastItem() }}</span> of
                            <span class="font-medium">{{ $customers->total() }}</span> customers
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($customers->onFirstPage())
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $customers->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($customers->hasMorePages())
                                <a href="{{ $customers->nextPageUrl() }}"
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
