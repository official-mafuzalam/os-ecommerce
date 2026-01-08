<x-admin-layout>
    @section('title', $deal->title)
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.deals.index') }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Deals">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $deal->title }}</h1>
                        <p class="text-xs text-gray-500">Deal Details</p>
                    </div>
                </div>
                <div class="gap-2 flex">
                    <a href="{{ route('admin.deals.edit', $deal->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Edit Deal
                    </a>
                    <a href="{{ route('admin.deals.products.show', $deal->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Assign Products
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column - Deal Preview -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <!-- Deal Preview -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-2/3 text-white">
                                <h2 class="text-lg font-bold mb-2">{{ $deal->title }}</h2>
                                <p class="text-sm text-white/80 mb-3">{{ Str::limit($deal->description, 80) }}</p>
                                @if ($deal->discount_percentage)
                                    <div class="flex items-center mb-3">
                                        <div class="bg-white/20 rounded px-2 py-1 mr-2">
                                            <span class="text-sm font-bold">{{ $deal->discount_percentage }}%</span>
                                            <span class="text-xs">OFF</span>
                                        </div>
                                        <span class="text-xs">{{ $deal->discount_details }}</span>
                                    </div>
                                @endif
                                <button type="button"
                                    class="inline-flex items-center bg-white text-blue-600 text-xs font-medium py-1.5 px-3 rounded hover:bg-gray-100 transition-colors">
                                    {{ $deal->button_text }}
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                            @if ($deal->image_url)
                                <div class="md:w-1/3 mt-3 md:mt-0">
                                    <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                        class="w-full h-32 object-cover rounded shadow">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status & Dates -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded
                                    {{ $deal->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($deal->is_featured)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                        Featured
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500">
                                Priority: {{ $deal->priority }}
                            </div>
                        </div>

                        <!-- Schedule -->
                        @if ($deal->starts_at || $deal->ends_at)
                            <div class="mt-2 text-xs text-gray-600">
                                @if ($deal->starts_at && $deal->ends_at)
                                    {{ $deal->starts_at->format('M d') }} - {{ $deal->ends_at->format('M d, Y') }}
                                @elseif($deal->starts_at)
                                    Starts: {{ $deal->starts_at->format('M d, Y') }}
                                @elseif($deal->ends_at)
                                    Ends: {{ $deal->ends_at->format('M d, Y') }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="mt-4 bg-white rounded-lg border border-gray-200">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Statistics</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center p-2 bg-blue-50 rounded border border-blue-100">
                                <div class="text-lg font-bold text-blue-700">{{ $deal->products->count() }}</div>
                                <div class="text-xs text-blue-600">Total Products</div>
                            </div>
                            <div class="text-center p-2 bg-purple-50 rounded border border-purple-100">
                                <div class="text-lg font-bold text-purple-700">{{ $deal->featuredProducts->count() }}
                                </div>
                                <div class="text-xs text-purple-600">Featured</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Deal Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="p-4 space-y-4">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Basic Information</h3>
                            <div class="space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">Title</dt>
                                    <dd class="text-sm text-gray-900">{{ $deal->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">Description</dt>
                                    <dd class="text-sm text-gray-900">{{ $deal->description ?? 'No description' }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Action Details -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Action Details</h3>
                            <div class="space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">Button Text</dt>
                                    <dd class="text-sm text-gray-900">{{ $deal->button_text }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">Button Link</dt>
                                    <dd class="text-sm text-blue-600 truncate">{{ $deal->button_link }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Details -->
                        @if ($deal->discount_percentage)
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Discount Details</h3>
                                <div class="space-y-2">
                                    <div>
                                        <dt class="text-xs text-gray-500">Discount Percentage</dt>
                                        <dd class="text-sm text-gray-900">{{ $deal->discount_percentage }}% OFF</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Discount Details</dt>
                                        <dd class="text-sm text-gray-900">{{ $deal->discount_details }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Design Details -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Design</h3>
                            <div class="space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">Background Color</dt>
                                    <dd class="flex items-center">
                                        <span class="w-4 h-4 rounded mr-2"
                                            style="background-color: {{ $deal->background_color }}"></span>
                                        <span class="text-sm text-gray-900">{{ $deal->background_color }}</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">Image URL</dt>
                                    <dd class="text-sm text-gray-900 truncate">{{ $deal->image_url ?: 'No image' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Timestamps</h3>
                            <div class="space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">Created</dt>
                                    <dd class="text-sm text-gray-900">{{ $deal->created_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">Updated</dt>
                                    <dd class="text-sm text-gray-900">{{ $deal->updated_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="mt-4 mb-2">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Assigned Products</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $deal->products->count() }} products</p>
                    </div>
                    <a href="{{ route('admin.products.index', ['deal_id' => $deal->id]) }}"
                        class="text-xs text-blue-600 hover:text-blue-800">
                        View all products →
                    </a>
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
                                        Order
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
                                @foreach ($deal->products as $product)
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
                                                    <div class="text-xs text-gray-500">{{ $product->sku }}</div>
                                                </div>
                                            </div>
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
                                            <div class="text-sm text-gray-900">{{ $product->pivot->order }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col space-y-1">
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded
                                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                @if ($product->pivot->is_featured)
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                                        Featured
                                                    </span>
                                                @endif
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
                                                    <button type="submit"
                                                        onclick="return confirm('Remove product from deal?')"
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
                        <a href="{{ route('admin.products.index') }}"
                            class="mt-3 inline-block px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                            Add Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-admin-layout>
