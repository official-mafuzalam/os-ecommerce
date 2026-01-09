<x-admin-layout>
    @section('title', 'Customer Activity')
    <x-slot name="main">
        <!-- Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Customer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Activity Log - {{ $customer->full_name }}</h1>
                        <p class="text-xs text-gray-500">Track customer activities and interactions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white border border-gray-200 rounded-lg">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-medium text-gray-900">Recent Activities</h2>
            </div>
            <div class="p-4">
                @if ($activities && $activities->count() > 0)
                    <div class="space-y-4">
                        @foreach ($activities as $activity)
                            <div class="flex items-start space-x-3">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    @switch($activity['type'])
                                        @case('order')
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                        @break

                                        @default
                                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                    @endswitch
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</h3>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $activity['description'] }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                            {{ $activity['date']->diffForHumans() }}
                                        </span>
                                    </div>

                                    <!-- Order Details -->
                                    @if ($activity['type'] == 'order' && isset($activity['data']))
                                        <div class="mt-2 p-3 bg-gray-50 rounded border border-gray-100">
                                            @php $order = $activity['data']; @endphp
                                            <div class="text-xs text-gray-600 space-y-1">
                                                <div class="flex justify-between">
                                                    <span>Order Total:</span>
                                                    <span
                                                        class="font-medium">৳{{ number_format($order->total_amount, 2) }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>Payment Method:</span>
                                                    <span>{{ $order->payment_method_name }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>Status:</span>
                                                    <span class="capitalize">{{ $order->status }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-sm text-gray-500">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>No activities found for this customer</div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-admin-layout>
