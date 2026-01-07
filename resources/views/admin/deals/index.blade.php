<x-admin-layout>
    @section('title', 'Deals Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Deals</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage promotional deals and discounts</p>
                    </div>

                    <a href="{{ route('admin.deals.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        New Deal
                    </a>
                </div>
            </div>

            <!-- Deals Table Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deal
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Discount
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Range
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Products
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
                            @forelse($deals as $deal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <img class="w-10 h-10 rounded object-cover" src="{{ $deal->image_url }}"
                                                alt="{{ $deal->title }}"
                                                onerror="this.src='https://via.placeholder.com/40'">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($deal->title, 25) }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    ID: {{ $deal->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($deal->discount_percentage)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $deal->discount_percentage }}% OFF
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500">No discount</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        @if ($deal->starts_at && $deal->ends_at)
                                            <div class="text-sm">{{ $deal->starts_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">to {{ $deal->ends_at->format('M d, Y') }}
                                            </div>
                                        @elseif($deal->starts_at)
                                            <div class="text-sm">Starts: {{ $deal->starts_at->format('M d, Y') }}</div>
                                        @elseif($deal->ends_at)
                                            <div class="text-sm">Ends: {{ $deal->ends_at->format('M d, Y') }}</div>
                                        @else
                                            <span class="text-xs text-gray-500">No date restrictions</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $deal->priority }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.deals.products.show', $deal) }}"
                                            class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                            {{ $deal->products->count() }} products
                                        </a>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1">
                                            <form action="{{ route('admin.deals.toggle-status', $deal) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-colors',
                                                        'bg-green-100 text-green-800 hover:bg-green-200' => $deal->is_active,
                                                        'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$deal->is_active,
                                                    ])>
                                                        {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.deals.toggle-featured', $deal) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-colors',
                                                        'bg-blue-100 text-blue-800 hover:bg-blue-200' => $deal->is_featured,
                                                        'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$deal->is_featured,
                                                    ])>
                                                        {{ $deal->is_featured ? 'Featured' : 'Standard' }}
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.deals.show', $deal) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="View">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.deals.edit', $deal) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                    onclick="return confirm('Delete this deal?')" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
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
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>No deals found</div>
                                            <a href="{{ route('admin.deals.create') }}"
                                                class="text-blue-600 hover:text-blue-800 hover:underline text-sm">
                                                Create your first deal
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($deals->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $deals->firstItem() }}</span> to
                            <span class="font-medium">{{ $deals->lastItem() }}</span> of
                            <span class="font-medium">{{ $deals->total() }}</span> results
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($deals->onFirstPage())
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $deals->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($deals->hasMorePages())
                                <a href="{{ $deals->nextPageUrl() }}"
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
