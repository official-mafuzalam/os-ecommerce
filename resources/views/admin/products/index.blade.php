<x-admin-layout>
    @section('title', 'Products Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Products</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your product inventory and listings</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.trash') }}"
                            class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Trash
                        </a>

                        <a href="{{ route('admin.products.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <form id="bulk-action-form" method="POST" action="{{ route('admin.products.bulk-destroy') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="selected_products" id="selected-products-input">
                <div id="bulk-actions-container"
                    class="hidden mb-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span id="selected-count" class="text-sm font-medium text-yellow-800">0 selected</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="cancel-bulk-action"
                                class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="button" id="bulk-delete-btn"
                                class="px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Filters Card -->
            <div class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <div>
                                <label for="search"
                                    class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" placeholder="Name or SKU"
                                    value="{{ request('search') }}"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="brand" class="block text-xs font-medium text-gray-700 mb-1">Brand</label>
                                <select name="brand" id="brand"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Brands</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category"
                                    class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status"
                                    class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('admin.products.index') }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-12 px-4 py-3 text-left">
                                    <input type="checkbox" id="select-all"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    onclick="sortTable(1)">
                                    <div class="flex items-center">
                                        ID
                                        <svg class="ml-1 w-3 h-3 text-gray-400 sort-icon" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category/Brand
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    onclick="sortTable(4)">
                                    <div class="flex items-center">
                                        Price
                                        <svg class="ml-1 w-3 h-3 text-gray-400 sort-icon" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
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
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="selected_products[]"
                                            value="{{ $product->id }}"
                                            class="product-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $product->id }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 flex-shrink-0">
                                                <img class="w-10 h-10 rounded object-cover"
                                                    src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($product->name, 25) }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    SKU: {{ $product->sku }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900">{{ $product->category->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $product->brand->name }}</div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900"
                                            data-price="{{ $product->price - $product->discount }}">
                                            {{ number_format($product->price - $product->discount) }} TK
                                        </div>
                                        @if ($product->discount > 0)
                                            <div class="text-xs text-gray-400 line-through">
                                                {{ number_format($product->price) }} TK
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <span @class([
                                            'inline-flex items-center px-2 py-1 rounded text-xs font-medium',
                                            'bg-green-100 text-green-800' => $product->stock_quantity > 10,
                                            'bg-yellow-100 text-yellow-800' =>
                                                $product->stock_quantity > 0 && $product->stock_quantity <= 10,
                                            'bg-red-100 text-red-800' => $product->stock_quantity == 0,
                                        ])>
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1">
                                            <form action="{{ route('admin.products.toggle-status', $product) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-colors',
                                                        'bg-green-100 text-green-800 hover:bg-green-200' => $product->is_active,
                                                        'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$product->is_active,
                                                    ])>
                                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.products.toggle-featured', $product) }}"
                                                method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="focus:outline-none">
                                                    <span @class([
                                                        'inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-colors',
                                                        'bg-blue-100 text-blue-800 hover:bg-blue-200' => $product->is_featured,
                                                        'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$product->is_featured,
                                                    ])>
                                                        {{ $product->is_featured ? 'Featured' : 'Standard' }}
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.show', $product) }}"
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
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                    onclick="return confirm('Move to trash?')" title="Trash">
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
                                    <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $products->firstItem() }}</span> to
                            <span class="font-medium">{{ $products->lastItem() }}</span> of
                            <span class="font-medium">{{ $products->total() }}</span> results
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($products->onFirstPage())
                                <span
                                    class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
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

        <script>
            // Bulk selection functionality
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const productCheckboxes = document.querySelectorAll('.product-checkbox');
                const bulkActionsContainer = document.getElementById('bulk-actions-container');
                const selectedCountElement = document.getElementById('selected-count');
                const cancelBulkActionButton = document.getElementById('cancel-bulk-action');
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
                const bulkDeleteForm = document.getElementById('bulk-action-form');
                const selectedProductsInput = document.getElementById('selected-products-input');

                function updateSelectedCount() {
                    const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
                    selectedCountElement.textContent = `${selectedCount} selected`;

                    if (selectedCount > 0) {
                        bulkActionsContainer.classList.remove('hidden');
                    } else {
                        bulkActionsContainer.classList.add('hidden');
                    }

                    selectAllCheckbox.checked = selectedCount === productCheckboxes.length && productCheckboxes.length >
                        0;
                    selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < productCheckboxes.length;
                }

                selectAllCheckbox.addEventListener('change', function() {
                    productCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                    updateSelectedCount();
                });

                productCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });

                cancelBulkActionButton.addEventListener('click', function() {
                    productCheckboxes.forEach(checkbox => checkbox.checked = false);
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                    bulkActionsContainer.classList.add('hidden');
                });

                bulkDeleteBtn.addEventListener('click', function() {
                    const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                        .map(checkbox => checkbox.value);

                    if (selectedProducts.length === 0) {
                        alert('Please select at least one product.');
                        return;
                    }

                    if (!confirm(
                            `Delete ${selectedProducts.length} product${selectedProducts.length !== 1 ? 's' : ''}?`
                            )) {
                        return;
                    }

                    selectedProductsInput.value = JSON.stringify(selectedProducts);
                    bulkDeleteForm.submit();
                });

                updateSelectedCount();
            });

            // Table sorting
            let sortDirection = 1;
            let currentSortColumn = -1;

            function sortTable(columnIndex) {
                const actualColumnIndex = columnIndex + 1;
                const tableBody = document.querySelector('tbody');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const sortIcons = document.querySelectorAll('.sort-icon');

                if (currentSortColumn === actualColumnIndex) {
                    sortDirection *= -1;
                } else {
                    currentSortColumn = actualColumnIndex;
                    sortDirection = 1;
                }

                rows.sort((a, b) => {
                    let aValue, bValue;

                    if (actualColumnIndex === 1) {
                        aValue = parseInt(a.cells[actualColumnIndex].textContent.trim());
                        bValue = parseInt(b.cells[actualColumnIndex].textContent.trim());
                        return (aValue - bValue) * sortDirection;
                    } else if (actualColumnIndex === 4) {
                        aValue = parseFloat(a.cells[actualColumnIndex].querySelector('[data-price]').dataset.price);
                        bValue = parseFloat(b.cells[actualColumnIndex].querySelector('[data-price]').dataset.price);
                        return (aValue - bValue) * sortDirection;
                    } else {
                        aValue = a.cells[actualColumnIndex].textContent.trim();
                        bValue = b.cells[actualColumnIndex].textContent.trim();
                        return aValue.localeCompare(bValue) * sortDirection;
                    }
                });

                while (tableBody.firstChild) {
                    tableBody.removeChild(tableBody.firstChild);
                }
                rows.forEach(row => tableBody.appendChild(row));

                sortIcons.forEach(icon => {
                    icon.classList.remove('text-blue-600', 'rotate-180', 'text-gray-400');
                    icon.classList.add('text-gray-400');
                });

                const activeIcon = document.querySelector(`thead th:nth-child(${actualColumnIndex + 1}) .sort-icon`);
                if (activeIcon) {
                    activeIcon.classList.remove('text-gray-400');
                    activeIcon.classList.add('text-blue-600');
                    if (sortDirection === -1) {
                        activeIcon.classList.add('rotate-180');
                    }
                }
            }
        </script>

        <style>
            .rotate-180 {
                transform: rotate(180deg);
                transition: transform 0.2s ease;
            }
        </style>
    </x-slot>
</x-admin-layout>
