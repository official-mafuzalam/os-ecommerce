<x-admin-layout>
    @section('title', $deal->title . ' - Products')
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.deals.show', $deal->id) }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Deal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $deal->title }}</h1>
                        <p class="text-xs text-gray-500">Manage Products</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="openProductAssignmentModal()"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded transition-colors">
                        Add Products
                    </button>
                    <a href="{{ route('admin.deals.edit', $deal->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Edit Deal
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Assigned Products</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $deal->products->count() }} products</p>
                </div>
                @if ($deal->products->count() > 0)
                    <button onclick="openProductAssignmentModal()"
                        class="text-xs text-purple-600 hover:text-purple-800">
                        + Add more
                    </button>
                @endif
            </div>

            @if ($deal->products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Featured
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($deal->products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded border border-gray-200 overflow-hidden">
                                                <img src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                    alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate max-w-xs">
                                                    {{ $product->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">
                                            @if ($product->discount)
                                                <div class="font-semibold text-green-600">
                                                    {{ number_format($product->price - $product->discount) }} TK
                                                </div>
                                                <div class="text-xs text-gray-500 line-through">
                                                    {{ number_format($product->price) }} TK
                                                </div>
                                            @else
                                                {{ number_format($product->price) }} TK
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span
                                                class="text-sm {{ $product->stock_quantity > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                            @if (!$product->is_active)
                                                <span class="ml-1 text-xs text-red-600">Inactive</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <form
                                            action="{{ route('admin.deals.products.toggle-featured', [$deal->id, $product->id]) }}"
                                            method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none
                                                           {{ $product->pivot->is_featured ? 'bg-purple-600' : 'bg-gray-200' }}">
                                                <span class="sr-only">Toggle featured</span>
                                                <span aria-hidden="true"
                                                    class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out
                                                            {{ $product->pivot->is_featured ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-900">{{ $product->pivot->order }}</span>
                                            {{-- <form
                                                action="{{ route('admin.deals.products.move-up', [$deal->id, $product->id]) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="p-1 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                    {{ $loop->first ? 'disabled' : '' }}>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                            </form> --}}
                                            {{-- <form
                                                action="{{ route('admin.deals.products.move-down', [$deal->id, $product->id]) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="p-1 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                    {{ $loop->last ? 'disabled' : '' }}>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </form> --}}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end space-x-1">
                                            <a href="{{ route('admin.products.show', $product->id) }}"
                                                class="p-1 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
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
                                            <form
                                                action="{{ route('admin.deals.products.remove', [$deal->id, $product->id]) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Remove from deal?')"
                                                    class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                    title="Remove">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-sm text-gray-500">No products assigned to this deal</p>
                    <button onclick="openProductAssignmentModal()"
                        class="mt-3 px-3 py-1.5 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded transition-colors">
                        Add Products
                    </button>
                </div>
            @endif
        </div>

        <!-- Product Assignment Modal -->
        <div id="productAssignmentModal"
            class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full max-h-[80vh] overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900">Add Products</h3>
                </div>
                <form id="productAssignmentForm" action="{{ route('admin.deals.products.assign', $deal->id) }}"
                    method="POST" class="p-4 overflow-y-auto max-h-[60vh]">
                    @csrf
                    <div class="space-y-2">
                        @foreach ($allProducts as $product)
                            <label
                                class="flex items-center p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                    {{ $deal->products->contains($product->id) ? 'checked disabled' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <div class="ml-3 flex-1 min-w-0">
                                    <span class="text-sm text-gray-900">{{ $product->name }}</span>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs text-gray-500">SKU: {{ $product->sku }}</span>
                                        <span
                                            class="text-xs {{ $product->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if ($deal->products->contains($product->id))
                                            <span class="text-xs text-blue-600">Already added</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </form>
                <div class="p-4 border-t border-gray-200 flex items-center justify-end space-x-2">
                    <button type="button" onclick="closeProductAssignmentModal()"
                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="productAssignmentForm"
                        class="px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Add Selected
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openProductAssignmentModal() {
                document.getElementById('productAssignmentModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeProductAssignmentModal() {
                document.getElementById('productAssignmentModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Close modal on outside click
            document.getElementById('productAssignmentModal').addEventListener('click', function(e) {
                if (e.target.id === 'productAssignmentModal') {
                    closeProductAssignmentModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('productAssignmentModal').classList.contains(
                        'hidden')) {
                    closeProductAssignmentModal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
