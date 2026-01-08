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
                                    'bg-red-100 text-red-800 border border-red-200' =>
                                        $order->status == 'cancelled',
                                ])>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <div>
                                    <p class="text-xs text-gray-500">Current Status</p>
                                    <p class="text-sm font-medium text-gray-900 capitalize">{{ $order->status }}</p>
                                </div>
                            </div>

                            @if ($order->status != 'cancelled' && $order->status != 'delivered')
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
                <div class="bg-white rounded-lg border border-gray-200 grid grid-cols-2 gap-4 p-4">
                    <!-- Shipping Address -->
                    @if ($order->shippingAddress)
                        <div class="bg-white rounded-lg border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h2 class="text-sm font-medium text-gray-900">Shipping</h2>
                            </div>
                            <div class="p-4">
                                <div class="space-y-1.5">
                                    <p class="text-sm text-gray-900">{{ $order->shippingAddress->full_address }}</p>
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>
                                            @if ($order->shippingAddress->delivery_area === 'outside_dhaka')
                                                Outside Dhaka
                                            @elseif($order->shippingAddress->delivery_area === 'inside_dhaka')
                                                Inside Dhaka
                                            @else
                                                {{ ucfirst(str_replace('_', ' ', $order->shippingAddress->delivery_area)) }}
                                            @endif
                                        </span>
                                        <span>{{ $order->shipping_cost }} TK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Customer Stats (Compact) -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Customer History</h2>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-3 gap-2 text-center">
                                <div class="p-2 bg-green-50 rounded border border-green-100">
                                    <p class="text-lg font-bold text-green-700">{{ $completedOrders }}</p>
                                    <p class="text-xs text-green-600">Completed</p>
                                </div>
                                <div class="p-2 bg-red-50 rounded border border-red-100">
                                    <p class="text-lg font-bold text-red-700">{{ $cancelledOrders }}</p>
                                    <p class="text-xs text-red-600">Cancelled</p>
                                </div>
                                <div class="p-2 bg-blue-50 rounded border border-blue-100">
                                    <p class="text-lg font-bold text-blue-700">{{ $totalOrders }}</p>
                                    <p class="text-xs text-blue-600">Total</p>
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
                            <div class="p-4 flex items-start space-x-3">
                                <div class="flex-shrink-0 w-16 h-16 rounded border border-gray-200 overflow-hidden">
                                    <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/64' }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                                <a href="{{ route('admin.products.show', $item->product->id) }}"
                                                    class="hover:text-blue-600">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} ×
                                                {{ number_format($item->unit_price, 2) }} TK</p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 whitespace-nowrap ml-2">
                                            {{ number_format($item->unit_price * $item->quantity, 2) }} TK
                                        </p>
                                    </div>

                                    @if ($item->attributes && $item->attributes->count() > 0)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-600 mb-1">Options:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($item->attributes as $attribute)
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                                        {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
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
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Payment</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-900 capitalize">{{ $order->payment_method }}</span>
                                    <span @class([
                                        'px-1.5 py-0.5 text-xs rounded',
                                        'bg-green-100 text-green-800' => $order->payment_status == 'paid',
                                        'bg-yellow-100 text-yellow-800' => $order->payment_status == 'pending',
                                        'bg-red-100 text-red-800' => !in_array($order->payment_status, [
                                            'paid',
                                            'pending',
                                        ]),
                                    ])>
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            @if ($order->payment_status != 'paid' && $order->status != 'cancelled')
                                <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded transition-colors">
                                        Mark as Paid
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="pt-2 border-t border-gray-200 space-y-1.5">
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Subtotal</span>
                                <span class="text-xs text-gray-900">{{ number_format($order->subtotal, 2) }} TK</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-gray-600">Delivery</span>
                                <span class="text-xs text-gray-900">{{ number_format($order->shipping_cost, 2) }}
                                    TK</span>
                            </div>
                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-600">Discount</span>
                                    <span
                                        class="text-xs text-red-600">-{{ number_format($order->discount_amount, 2) }}
                                        TK</span>
                                </div>
                            @endif
                            <div class="flex justify-between pt-1.5 border-t border-gray-200">
                                <span class="text-sm font-medium text-gray-900">Total</span>
                                <span
                                    class="text-sm font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }}
                                    TK</span>
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
                            <div>
                                <p class="text-xs text-gray-500">Name</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->shippingAddress->full_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Phone</p>
                                <p class="text-sm text-gray-900">{{ $order->customer_phone }}</p>
                            </div>
                            @if ($order->customer_email)
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm text-gray-900 truncate">{{ $order->customer_email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

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

        <!-- Order Notes (Conditional) -->
        @if ($order->notes)
            <div class="mt-4 bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-medium text-gray-900">Notes</h2>
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
            </div>
        @endif

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
                        <p class="text-gray-700">{{ $order->shippingAddress->full_name }}</p>
                        <p class="text-gray-700">{{ $order->customer_phone }}</p>
                        <p class="text-gray-700">{{ $order->shippingAddress->full_address }}</p>
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
                                <td class="py-2">{{ $item->product->name }}</td>
                                <td class="text-right py-2">{{ $item->quantity }}</td>
                                <td class="text-right py-2">{{ number_format($item->unit_price, 2) }} TK</td>
                                <td class="text-right py-2">
                                    {{ number_format($item->unit_price * $item->quantity, 2) }} TK</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-48">
                        <div class="flex justify-between py-1">
                            <span>Subtotal:</span>
                            <span>{{ number_format($order->subtotal, 2) }} TK</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>Delivery:</span>
                            <span>{{ number_format($order->shipping_cost, 2) }} TK</span>
                        </div>
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between py-1">
                                <span>Discount:</span>
                                <span class="text-red-600">-{{ number_format($order->discount_amount, 2) }} TK</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-t font-bold">
                            <span>Total:</span>
                            <span>{{ number_format($order->total_amount, 2) }} TK</span>
                        </div>
                    </div>
                </div>

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
                            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                            @media print { @page { margin: 20mm; } }
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
