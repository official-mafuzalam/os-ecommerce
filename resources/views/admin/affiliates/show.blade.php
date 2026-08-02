<x-admin-layout>
    @section('title', 'Affiliate: {{ $affiliate->name }}')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">

            {{-- Back + Header --}}
            <div class="mb-4 flex items-center gap-4">
                <a href="{{ route('admin.affiliates.index') }}"
                    class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Affiliates
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left: Affiliate Profile --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($affiliate->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $affiliate->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $affiliate->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Phone</span>
                                <span class="text-gray-800 dark:text-white">{{ $affiliate->phone ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Referral Code</span>
                                <code class="bg-gray-100 dark:bg-gray-700 text-blue-600 px-2 py-0.5 rounded text-xs">{{ $affiliate->referral_code }}</code>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Status</span>
                                @if($affiliate->status === 'active')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Joined</span>
                                <span class="text-gray-800 dark:text-white">{{ $affiliate->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Referral Link</p>
                            <p class="text-xs text-blue-600 break-all">{{ $affiliate->referral_link }}</p>
                        </div>

                        <div class="mt-4 pt-4 border-t dark:border-gray-700 flex gap-2">
                            <form action="{{ route('admin.affiliates.toggle-status', $affiliate) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="w-full text-center text-sm px-3 py-2 rounded-md {{ $affiliate->status === 'active' ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    {{ $affiliate->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.affiliates.destroy', $affiliate) }}" method="POST"
                                onsubmit="return confirm('Delete this affiliate?')" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full text-center text-sm px-3 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Summary Cards --}}
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                            <p class="text-xl font-bold text-green-600">৳{{ number_format($totalEarnings, 2) }}</p>
                            <p class="text-xs text-gray-500 uppercase mt-1">Approved</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                            <p class="text-xl font-bold text-yellow-600">৳{{ number_format($pendingEarnings, 2) }}</p>
                            <p class="text-xs text-gray-500 uppercase mt-1">Pending</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Earnings Table --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="px-5 py-4 border-b dark:border-gray-700">
                            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Earnings History</h2>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase">Order</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase">Amount</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($earnings as $earning)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-4 py-3">
                                            @if($earning->order)
                                                <a href="{{ route('admin.orders.show', $earning->order->id) }}"
                                                    class="text-blue-600 hover:underline font-medium">
                                                    {{ $earning->order->order_number }}
                                                </a>
                                                <p class="text-xs text-gray-400">৳{{ number_format($earning->order->total_amount, 2) }}</p>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-semibold text-gray-800 dark:text-white">
                                            ৳{{ number_format($earning->amount, 2) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'pending'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                    'approved'  => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                    'paid'      => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                ];
                                            @endphp
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$earning->status] ?? '' }}">
                                                {{ ucfirst($earning->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">
                                            {{ $earning->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <form action="{{ route('admin.affiliates.earning.status', $earning) }}" method="POST" class="flex items-center gap-1">
                                                @csrf @method('PATCH')
                                                <select name="status"
                                                    class="text-xs border border-gray-300 dark:border-gray-600 rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
                                                    <option value="pending"   {{ $earning->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved"  {{ $earning->status === 'approved'  ? 'selected' : '' }}>Approved</option>
                                                    <option value="paid"      {{ $earning->status === 'paid'      ? 'selected' : '' }}>Paid</option>
                                                    <option value="cancelled" {{ $earning->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <button type="submit"
                                                    class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No earnings yet for this affiliate.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="px-4 py-3 border-t dark:border-gray-700">
                            {{ $earnings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
