<x-admin-layout>
    @section('title', 'Order Details')
    <x-slot name="main">
        <!-- Header with Breadcrumb -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Order Details</h1>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.orders.index') }}"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
                        </a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Edit Order
                        </a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                <i class="fas fa-file-invoice mr-2"></i> Invoice
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <div class="py-1">
                                    <button type="button" onclick="printInvoice()"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-print mr-2"></i> Print Invoice
                                    </button>
                                    <a href="{{ route('admin.orders.invoice.pdf', $order->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-download mr-2"></i> Download PDF
                                    </a>
                                    <a href="{{ route('admin.orders.invoice.email', $order->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-envelope mr-2"></i> Email Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Customer Order History
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-2 bg-green-50 rounded-lg border border-green-200 text-center">
                            <p class="text-2xl font-bold text-green-700">{{ $completedOrders }}</p>
                            <p class="text-sm text-green-600">Completed Orders</p>
                            <p class="text-xs text-green-500">{{ $completedPercent }}%</p>
                        </div>

                        <div class="p-2 bg-red-50 rounded-lg border border-red-200 text-center">
                            <p class="text-2xl font-bold text-red-700">{{ $cancelledOrders }}</p>
                            <p class="text-sm text-red-600">Cancelled Orders</p>
                            <p class="text-xs text-red-500">{{ $cancelledPercent }}%</p>
                        </div>

                        <div class="p-2 bg-blue-50 rounded-lg border border-blue-200 text-center">
                            <p class="text-2xl font-bold text-blue-700">{{ $totalOrders }}</p>
                            <p class="text-sm text-blue-600">Total Orders</p>
                        </div>
                    </div>
                </div>

                <!-- Order Status Card -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Order Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap items-center justify-between">
                            <div class="flex items-center">
                                <span @class([
                                    'px-2.5 py-0.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full',
                                    'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                    'bg-blue-100 text-blue-800' => $order->status == 'confirmed',
                                    'bg-indigo-100 text-indigo-800' => $order->status == 'processing',
                                    'bg-purple-100 text-purple-800' => $order->status == 'shipped',
                                    'bg-green-100 text-green-800' => $order->status == 'delivered',
                                    'bg-red-100 text-red-800' => $order->status == 'cancelled',
                                ])>
                                    <i
                                        class="fas
                                        @if ($order->status == 'pending') fa-clock
                                        @elseif($order->status == 'confirmed') fa-check-circle
                                        @elseif($order->status == 'processing') fa-cogs
                                        @elseif($order->status == 'shipped') fa-truck
                                        @elseif($order->status == 'delivered') fa-box-open
                                        @elseif($order->status == 'cancelled') fa-times-circle @endif mr-2"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <div>
                                    <p class="text-sm text-gray-600">Current Status</p>
                                    <p class="text-xl font-semibold text-gray-900 capitalize">{{ $order->status }}</p>
                                </div>
                            </div>

                            @if ($order->status != 'cancelled' && $order->status != 'delivered')
                                <div class="mt-4 sm:mt-0">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                                        class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                            class="border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Update Status</option>
                                            <option value="confirmed"
                                                {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                            <option value="processing"
                                                {{ $order->status == 'processing' ? 'selected' : '' }}>Process</option>
                                            <option value="shipped"
                                                {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered"
                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>Mark as Delivered
                                            </option>
                                            <option value="cancelled">Cancel Order</option>
                                        </select>
                                        <button type="submit"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        @if ($order->tracking_number)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm font-medium text-gray-700">Tracking Number</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $order->tracking_number }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Order Items ({{ $order->items->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <div class="p-6 flex items-start">
                                <div class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden border border-gray-200">
                                    <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/80' }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-6 flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="{{ route('admin.products.show', $item->product->id) }}"
                                                    class="hover:text-blue-600">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                            <p class="text-sm text-gray-500">Category:
                                                {{ $item->product->category->name }}</p>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ number_format($item->unit_price * $item->quantity, 2) }} TK
                                        </p>
                                    </div>

                                    <!-- Display Attributes if they exist -->
                                    @if ($item->attributes && $item->attributes->count() > 0)
                                        <div class="mt-3">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Options:</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($item->attributes as $attribute)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $attribute->name }}: {{ $attribute->pivot->value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</span>
                                            <span class="text-sm text-gray-600">Price:
                                                {{ number_format($item->unit_price, 2) }} TK each</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Notes -->
                @if ($order->notes)
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Order Notes</h2>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">{{ $order->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Number</span>
                                <span class="text-gray-900 font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Date</span>
                                <span class="text-gray-900">{{ $order->created_at->format('M j, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method</span>
                                <span class="text-gray-900 capitalize">{{ $order->payment_method }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status</span>
                                <span @class([
                                    'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
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
                            @if ($order->payment_status != 'paid' && $order->status != 'cancelled')
                                <div class="pt-2">
                                    <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="fas fa-check-circle mr-2"></i> Mark as Paid
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">{{ number_format($order->subtotal, 2) }} TK</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery Charge</span>
                                <span class="text-gray-900">{{ number_format($order->shipping_cost, 2) }} TK</span>
                            </div>
                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Discount</span>
                                    <span class="text-red-600">-{{ number_format($order->discount_amount, 2) }}
                                        TK</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-lg font-semibold pt-2 border-t border-gray-200">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900">{{ number_format($order->total_amount, 2) }} TK</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Customer Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-gray-900 font-medium">{{ $order->shippingAddress->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="text-gray-900">{{ $order->customer_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if ($order->shippingAddress)
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Shipping Address</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-600">Full Address</p>
                                    <p class="text-gray-900 font-medium">{{ $order->shippingAddress->full_address }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Delivery Area</p>
                                    <p class="text-gray-900 font-medium">
                                        @if ($order->shippingAddress->delivery_area === 'outside_dhaka')
                                            Outside Dhaka
                                        @elseif ($order->shippingAddress->delivery_area === 'inside_dhaka')
                                            Inside Dhaka
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $order->shippingAddress->delivery_area)) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Actions -->
                @if ($order->canBeCancelled())
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Danger Zone</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                                    <i class="fas fa-times-circle mr-2"></i> Cancel Order
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        <!-- Invoice Template (Hidden by default, shown when printing) -->
        <div id="invoice-template" class="hidden">
            <div class="bg-white p-8 max-w-4xl mx-auto">
                <!-- Invoice Header -->
                <div class="flex justify-between items-start mb-8">
                    <div class="flex items-start space-x-4">
                        <div>
                            @if (setting('site_logo'))
                                <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo"
                                    class="h-16 w-auto object-contain">
                            @endif
                            <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                            <p class="text-gray-600">Order #: {{ $order->order_number }}</p>
                            <p class="text-gray-600">Date: {{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-semibold">{{ setting('site_name') }}</h2>
                        <p class="text-gray-600">{{ setting('site_address') }}</p>
                        <p class="text-gray-600">Phone: {{ setting('site_phone') }}</p>
                        <p class="text-gray-600">Email: {{ setting('site_email') }}</p>
                    </div>
                </div>

                <!-- Bill To -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Bill To:</h3>
                        <p class="text-gray-900">{{ $order->customer_email }}</p>
                        <p class="text-gray-900">{{ $order->customer_phone }}</p>
                        @if ($order->shippingAddress)
                            <p class="text-gray-900">{{ $order->shippingAddress->full_name }}</p>
                            <p class="text-gray-900">{{ $order->shippingAddress->full_address }}</p>
                            <p class="text-gray-900">Delivery Area:
                                @if ($order->shippingAddress->delivery_area === 'outside_dhaka')
                                    Outside Dhaka
                                @elseif ($order->shippingAddress->delivery_area === 'inside_dhaka')
                                    Inside Dhaka
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->shippingAddress->delivery_area)) }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Invoice Details:</h3>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice Number:</span>
                            <span class="text-gray-900">INV-{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="text-gray-900">{{ $order->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Due Date:</span>
                            <span class="text-gray-900">{{ $order->created_at->addDays(15)->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="text-gray-900 capitalize">{{ $order->payment_status }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <table class="w-full mb-8">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="text-left py-2">Description</th>
                            <th class="text-right py-2">Quantity</th>
                            <th class="text-right py-2">Unit Price</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="py-3">{{ $item->product->name }}</td>
                                <td class="text-right py-3">{{ $item->quantity }}</td>
                                <td class="text-right py-3">{{ number_format($item->unit_price, 2) }} TK</td>
                                <td class="text-right py-3">
                                    {{ number_format($item->unit_price * $item->quantity, 2) }} TK</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-gray-900">{{ number_format($order->subtotal, 2) }} TK</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="text-gray-900">{{ number_format($order->shipping_cost, 2) }} TK</span>
                        </div>
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Discount:</span>
                                <span class="text-red-600">-{{ number_format($order->discount_amount, 2) }} TK</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-t border-gray-300 font-semibold text-lg">
                            <span>Total:</span>
                            <span>{{ number_format($order->total_amount, 2) }} TK</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                {{-- <div class="mt-12 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold mb-2">Payment Instructions:</h4>
                    <p class="text-sm text-gray-600">Please make payment within 15 days of receiving this invoice.</p>
                    <p class="text-sm text-gray-600">Bank Transfer: Account # 1234567890, Bank Name, Branch Name</p>
                </div> --}}

                <!-- Footer -->
                <div class="mt-12 text-center text-gray-600 text-sm">
                    <p>Thank you for your business!</p>
                    <p>{{ setting('site_name') }} • www.yourcompany.com • {{ setting('site_email') }}</p>
                </div>
            </div>
        </div>

        <!-- JavaScript for Invoice Printing -->
        <script>
            function printInvoice() {
                // Create a new window for printing
                const printWindow = window.open('', '_blank');

                // Get the invoice template HTML
                const invoiceContent = document.getElementById('invoice-template').innerHTML;

                // Write the print document
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Invoice - {{ $order->order_number }}</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                        <script src="https://cdn.tailwindcss.com"><\/script>
                        <style>
                            @media print {
                                body { margin: 0; padding: 0; }
                                .no-print { display: none !important; }
                                @page { margin: 20mm; }
                            }
                            body { font-family: Arial, sans-serif; }
                        </style>
                    </head>
                    <body>
                        ${invoiceContent}
                        <script>
                            window.onload = function() {
                                window.print();
                                setTimeout(function() {
                                    window.close();
                                }, 500);
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
