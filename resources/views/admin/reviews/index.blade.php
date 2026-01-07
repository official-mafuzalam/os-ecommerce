<x-admin-layout>
    @section('title', 'Reviews Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Reviews</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage customer product reviews</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Table Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product & Customer
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Review Details
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reviews as $index => $review)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $index + 1 + ($reviews->currentPage() - 1) * $reviews->perPage() }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($review->product->name, 25) }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            @if ($review->user)
                                                By: {{ $review->user->name }}
                                            @else
                                                By: Anonymous
                                            @endif
                                        </div>
                                        <div class="flex items-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">{{ $review->rating }}.0</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ Str::limit($review->comment, 60) }}</div>
                                        @if (strlen($review->comment) > 60)
                                            <button type="button" onclick="alert('{{ addslashes($review->comment) }}')"
                                                class="text-xs text-blue-600 hover:text-blue-800 hover:underline mt-1">
                                                Read more
                                            </button>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST"
                                            class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="focus:outline-none">
                                                <span @class([
                                                    'inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-colors',
                                                    'bg-green-100 text-green-800 hover:bg-green-200' => $review->is_approved,
                                                    'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$review->is_approved,
                                                ])>
                                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                                </span>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $review->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $review->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                    onclick="return confirm('Delete this review?')" title="Delete">
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
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            <div>No reviews found</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($reviews->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $reviews->firstItem() }}</span> to
                            <span class="font-medium">{{ $reviews->lastItem() }}</span> of
                            <span class="font-medium">{{ $reviews->total() }}</span> reviews
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($reviews->onFirstPage())
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $reviews->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($reviews->hasMorePages())
                                <a href="{{ $reviews->nextPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Next
                                </a>
                            @else
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
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
