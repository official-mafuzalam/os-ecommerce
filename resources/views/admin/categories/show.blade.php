<x-admin-layout>
    @section('title', $category->name)
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Categories">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h1>
                        <p class="text-xs text-gray-500">Category Details</p>
                    </div>
                </div>
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                    Edit Category
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left Column -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Image Card -->
                <div class="bg-white rounded-lg border border-gray-200">
                    @if ($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                            class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="h-48 bg-gray-100 rounded-t-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900">Status</span>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded
                                {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500">
                            Updated: {{ $category->updated_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Statistics</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Total Products</span>
                                <span class="text-sm font-medium text-gray-900">{{ $products->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Subcategories</span>
                                <span class="text-sm font-medium text-gray-900">{{ $category->children->count() }}</span>
                            </div>
                            @if ($category->parent)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">Parent Category</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $category->parent->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Basic Information</h3>
                        <div class="space-y-3">
                            <div>
                                <dt class="text-xs text-gray-500">Name</dt>
                                <dd class="text-sm text-gray-900">{{ $category->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Slug</dt>
                                <dd class="text-sm text-gray-900">{{ $category->slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900">{{ $category->description ?? 'No description' }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subcategories -->
                @if ($category->children->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Subcategories</h3>
                            <span class="text-xs text-gray-500">{{ $category->children->count() }} total</span>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach ($category->children as $subcategory)
                                    <a href="{{ route('admin.categories.show', $subcategory->id) }}"
                                        class="group p-3 border border-gray-200 rounded hover:border-gray-300 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 group-hover:text-blue-600">
                                                {{ $subcategory->name }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $subcategory->products_count }} products
                                            </span>
                                        </div>
                                        @if (!$subcategory->is_active)
                                            <div class="mt-1">
                                                <span class="text-xs text-red-600">Inactive</span>
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Products Table Section -->
        <div class="mt-4 mb-2">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Products in this Category</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $products->count() }} products found</p>
                    </div>
                    @if ($products->count() > 0)
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}"
                            class="text-xs text-blue-600 hover:text-blue-800">
                            View all products →
                        </a>
                    @endif
                </div>

                @if ($products->count() > 0)
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
                                        SKU
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
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 rounded border border-gray-200 overflow-hidden">
                                                    <img src="{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs">
                                                        {{ $product->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $product->brand->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-900">{{ $product->sku }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-900">{{ number_format($product->price, 2) }}
                                                TK</div>
                                            @if ($product->discount > 0)
                                                <div class="text-xs text-red-600">
                                                    -{{ number_format($product->discount, 2) }} TK</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div
                                                class="text-sm {{ $product->stock_quantity > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                                {{ $product->stock_quantity }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded
                                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
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
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="p-1 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-600">
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                                    {{ $products->total() }} products
                                </div>
                                <div class="flex space-x-2">
                                    @if ($products->onFirstPage())
                                        <span
                                            class="px-2 py-1 text-xs text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $products->previousPageUrl() }}"
                                            class="px-2 py-1 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                            Previous
                                        </a>
                                    @endif

                                    @if ($products->hasMorePages())
                                        <a href="{{ $products->nextPageUrl() }}"
                                            class="px-2 py-1 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                            Next
                                        </a>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs text-gray-400 bg-gray-100 rounded cursor-not-allowed">
                                            Next
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="p-6 text-center">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-sm text-gray-500">No products found in this category</p>
                        <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}"
                            class="mt-3 inline-block px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                            Add Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-admin-layout>
