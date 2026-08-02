<x-admin-layout>
    @section('title', 'Affiliate Marketing')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Affiliate Marketing</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage affiliates, track referrals and commissions</p>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                        <i class="fas fa-users text-blue-600 dark:text-blue-300"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Total Affiliates</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $totalAffiliates }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-300"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Active</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $activeAffiliates }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-900 rounded-full p-3">
                        <i class="fas fa-money-bill-wave text-emerald-600 dark:text-emerald-300"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Approved Earnings</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">৳{{ number_format($totalApproved, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-900 rounded-full p-3">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-300"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Pending Earnings</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">৳{{ number_format($totalPending, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-2 mb-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search name, email, code..."
                    class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                <select name="status"
                    class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit"
                    class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.affiliates.index') }}"
                    class="bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-md hover:bg-gray-300">Reset</a>
            </form>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Referral Code</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Referrals</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Approved</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pending</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($affiliates as $affiliate)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $affiliates->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $affiliate->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $affiliate->email }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <code class="bg-gray-100 dark:bg-gray-900 text-blue-600 dark:text-blue-400 px-2 py-1 rounded text-xs">{{ $affiliate->referral_code }}</code>
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $affiliate->earnings_count }}</td>
                                <td class="px-4 py-3 font-medium text-green-600 dark:text-green-400">
                                    ৳{{ number_format($affiliate->approved_earnings ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-3 font-medium text-yellow-600 dark:text-yellow-400">
                                    ৳{{ number_format($affiliate->pending_earnings ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($affiliate->status === 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $affiliate->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.affiliates.show', $affiliate) }}"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-xs font-medium">
                                            View
                                        </a>
                                        <form action="{{ route('admin.affiliates.toggle-status', $affiliate) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-medium {{ $affiliate->status === 'active' ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                                                {{ $affiliate->status === 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.affiliates.destroy', $affiliate) }}" method="POST"
                                            onsubmit="return confirm('Delete this affiliate?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No affiliates found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $affiliates->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
