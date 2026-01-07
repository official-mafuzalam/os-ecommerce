<x-admin-layout>
    @section('title', 'Sales Report')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Sales Report</h1>
                        <p class="mt-1 text-sm text-gray-500">Analyze sales performance</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export
                                <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                <div class="py-1">
                                    <button type="button" onclick="printReport()"
                                        class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        Print
                                    </button>
                                    <a href="{{ route('admin.reports.sales', array_merge(request()->all(), ['export' => 'pdf'])) }}"
                                        class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Filter Card -->
            <div class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.reports.sales') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <label for="start_date" class="block text-xs font-medium text-gray-700 mb-1">
                                    Start Date
                                </label>
                                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-xs font-medium text-gray-700 mb-1">
                                    End Date
                                </label>
                                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-100">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Sales</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($totalSales, 2) }} TK</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Avg Order Value</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($avgOrderValue, 2) }} TK
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-100">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date Range</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $startDate }} - {{ $endDate }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Header -->
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-medium text-gray-900">Sales Report</h2>
                    <p class="text-sm text-gray-500">{{ $startDate }} to {{ $endDate }} •
                        {{ $orders->total() }} records</p>
                </div>
            </div>

            <!-- Orders Table Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
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
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shipping
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Discount
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $order->order_number }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div class="truncate max-w-[150px]">{{ $order->customer_email }}</div>
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $order->items->count() }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($order->subtotal, 2) }} TK
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($order->shipping_cost, 2) }} TK
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($order->discount_amount, 2) }} TK
                                    </td>

                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ number_format($order->total_amount, 2) }} TK
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500">
                                        No orders found for the selected date range.
                                    </td>
                                </tr>
                            @endforelse

                            <!-- Totals Row -->
                            @if ($orders->isNotEmpty())
                                <tr class="bg-gray-50 font-semibold border-t">
                                    <td colspan="3" class="px-4 py-3 text-sm text-gray-900 text-right">
                                        TOTALS:
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $orders->sum(fn($order) => $order->items->count()) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($orders->sum('subtotal'), 2) }} TK
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($orders->sum('shipping_cost'), 2) }} TK
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($orders->sum('discount_amount'), 2) }} TK
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ number_format($orders->sum('total_amount'), 2) }} TK
                                    </td>
                                </tr>
                            @endif
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

        <!-- Hidden Print Template -->
        <div id="print-template" class="hidden">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">SALES REPORT</h1>
                        <p class="text-gray-600">Period: {{ $startDate }} to {{ $endDate }}</p>
                        <p class="text-gray-600">Generated: {{ now()->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-lg font-semibold">{{ config('app.name') }}</h2>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="p-3 border rounded text-center">
                        <p class="text-xl font-bold text-blue-700">{{ number_format($totalSales, 2) }} TK</p>
                        <p class="text-sm text-gray-600">Total Sales</p>
                    </div>
                    <div class="p-3 border rounded text-center">
                        <p class="text-xl font-bold text-green-700">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-600">Total Orders</p>
                    </div>
                    <div class="p-3 border rounded text-center">
                        <p class="text-xl font-bold text-purple-700">{{ number_format($avgOrderValue, 2) }} TK</p>
                        <p class="text-sm text-gray-600">Avg Order</p>
                    </div>
                    <div class="p-3 border rounded text-center">
                        <p class="text-lg font-bold text-gray-700">{{ $orders->total() }}</p>
                        <p class="text-sm text-gray-600">Records</p>
                    </div>
                </div>

                <table class="w-full border-collapse mb-6">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="text-left py-2 text-sm font-medium">Order #</th>
                            <th class="text-left py-2 text-sm font-medium">Date</th>
                            <th class="text-left py-2 text-sm font-medium">Customer</th>
                            <th class="text-right py-2 text-sm font-medium">Items</th>
                            <th class="text-right py-2 text-sm font-medium">Subtotal</th>
                            <th class="text-right py-2 text-sm font-medium">Shipping</th>
                            <th class="text-right py-2 text-sm font-medium">Discount</th>
                            <th class="text-right py-2 text-sm font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200">
                                <td class="py-2 text-sm">{{ $order->order_number }}</td>
                                <td class="py-2 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-2 text-sm">{{ $order->customer_email }}</td>
                                <td class="py-2 text-sm text-right">{{ $order->items->count() }}</td>
                                <td class="py-2 text-sm text-right">{{ number_format($order->subtotal, 2) }} TK</td>
                                <td class="py-2 text-sm text-right">{{ number_format($order->shipping_cost, 2) }} TK
                                </td>
                                <td class="py-2 text-sm text-right">{{ number_format($order->discount_amount, 2) }} TK
                                </td>
                                <td class="py-2 text-sm text-right">{{ number_format($order->total_amount, 2) }} TK
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-300 font-semibold">
                            <td colspan="3" class="py-2 text-sm text-right">TOTALS:</td>
                            <td class="py-2 text-sm text-right">
                                {{ $orders->sum(fn($order) => $order->items->count()) }}</td>
                            <td class="py-2 text-sm text-right">{{ number_format($orders->sum('subtotal'), 2) }} TK
                            </td>
                            <td class="py-2 text-sm text-right">{{ number_format($orders->sum('shipping_cost'), 2) }}
                                TK</td>
                            <td class="py-2 text-sm text-right">
                                {{ number_format($orders->sum('discount_amount'), 2) }} TK</td>
                            <td class="py-2 text-sm text-right">{{ number_format($orders->sum('total_amount'), 2) }}
                                TK</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <script>
            function printReport() {
                const printWindow = window.open('', '_blank');
                const printContent = document.getElementById('print-template').innerHTML;

                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Sales Report - {{ $startDate }} to {{ $endDate }}</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <style>
                            @media print {
                                @page { margin: 15mm; }
                                body { font-family: Arial, sans-serif; font-size: 12px; }
                                table { width: 100%; border-collapse: collapse; font-size: 11px; }
                                th, td { padding: 6px 4px; text-align: left; }
                                th { background-color: #f9fafb; font-weight: 600; }
                                .border-b { border-bottom: 1px solid #e5e7eb; }
                                .border-t-2 { border-top: 2px solid #374151; }
                                .text-right { text-align: right; }
                                .text-center { text-align: center; }
                                .font-bold { font-weight: 700; }
                                .text-sm { font-size: 11px; }
                                .text-lg { font-size: 14px; }
                                .text-xl { font-size: 16px; }
                                .text-2xl { font-size: 18px; }
                                .p-3 { padding: 8px; }
                                .mb-6 { margin-bottom: 24px; }
                                .grid { display: grid; }
                                .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
                                .gap-4 { gap: 16px; }
                                .rounded { border-radius: 4px; }
                                .border { border: 1px solid #e5e7eb; }
                            }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                        <script>
                            window.onload = function() {
                                window.print();
                                setTimeout(() => window.close(), 500);
                            }
                        <\/script>
                    </body>
                    </html>
                `);

                printWindow.document.close();
            }
        </script>
    </x-slot>
</x-admin-layout>
