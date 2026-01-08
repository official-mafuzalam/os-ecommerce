<x-admin-layout>
    @section('title', $product->name)
    <x-slot name="main">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg border border-gray-200 mb-4">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Back to Products">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h1>
                        <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="openDealAssignmentModal()"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded transition-colors">
                        Assign Deals
                    </button>
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left Column - Images -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Main Image -->
                <div class="bg-white rounded-lg border border-gray-200 p-3">
                    <img id="mainProductImage"
                        src="{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : 'https://via.placeholder.com/300' }}"
                        alt="{{ $product->name }}" class="w-full h-64 object-contain">
                </div>

                <!-- Image Gallery -->
                @if ($product->images->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200 p-3">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-gray-900">Gallery</h3>
                            <button onclick="openSetPrimaryModal()"
                                class="text-xs text-indigo-600 hover:text-indigo-800">
                                Set Primary
                            </button>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $image)
                                <div class="relative group cursor-pointer"
                                    onclick="changeMainImage('{{ Storage::url($image->image_path) }}')">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail"
                                        class="w-full h-16 object-cover rounded border border-gray-200 group-hover:border-indigo-400 transition-colors">
                                    @if ($image->is_primary)
                                        <span
                                            class="absolute top-0 right-0 bg-indigo-500 text-white text-xs px-1 rounded-bl">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Details -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Product Info Card -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="p-4 space-y-4">
                        <!-- Status Badges -->
                        <div class="flex items-center space-x-2">
                            <span
                                class="px-2 py-1 text-xs font-medium rounded
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if ($product->is_featured)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-100 text-blue-800">
                                    Featured
                                </span>
                            @endif
                            <span
                                class="px-2 py-1 text-xs font-medium rounded
                                {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>

                        <!-- Basic Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Basic Info</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-xs text-gray-500">Name</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">SKU</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->sku }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Description</dt>
                                        <dd class="text-sm text-gray-900">{{ Str::limit($product->description, 100) }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Category & Brand</h3>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-xs text-gray-500">Category</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->category->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Brand</dt>
                                        <dd class="text-sm text-gray-900">{{ $product->brand->name }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Pricing & Stock</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <dt class="text-xs text-gray-500">Buy Price</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ number_format($product->buy_price, 2) }} TK</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Price</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ number_format($product->price, 2) }}
                                    TK</dd>
                            </div>
                            @if ($product->discount > 0)
                                <div>
                                    <dt class="text-xs text-gray-500">Discount</dt>
                                    <dd class="text-sm text-red-600">-{{ number_format($product->discount, 2) }} TK
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">Final Price</dt>
                                    <dd class="text-sm font-semibold text-green-600">
                                        {{ number_format($product->final_price, 2) }} TK</dd>
                                </div>
                            @else
                                <div class="md:col-span-2">
                                    <dt class="text-xs text-gray-500">Stock</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $product->stock_quantity }} units
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Attributes -->
                @if ($groupedAttributes->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Attributes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($groupedAttributes as $attribute)
                                    <div>
                                        <dt class="text-xs text-gray-500">{{ $attribute['name'] }}</dt>
                                        <dd class="text-sm text-gray-900">{{ implode(', ', $attribute['values']) }}
                                        </dd>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Specifications -->
                @if ($product->specifications && count($product->specifications) > 0)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Specifications</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($product->specifications as $key => $value)
                                    <div>
                                        <dt class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}
                                        </dt>
                                        <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Current Deals Section -->
        <div class="mt-4 mb-2">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900">Assigned Deals</h3>
                    <span class="text-xs text-gray-500">{{ $product->deals->count() }} deals</span>
                </div>

                @if ($product->deals->count() > 0)
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($product->deals as $deal)
                                <div
                                    class="border border-gray-200 rounded-lg p-3 hover:border-gray-300 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $deal->title }}
                                            </h4>
                                            <div class="mt-1 flex items-center space-x-2">
                                                <span
                                                    class="text-xs {{ $deal->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <span class="text-xs text-gray-500">Priority:
                                                    {{ $deal->priority }}</span>
                                                @if ($deal->pivot->is_featured)
                                                    <span class="text-xs text-purple-600">Featured</span>
                                                @endif
                                            </div>
                                            @if ($deal->starts_at || $deal->ends_at)
                                                <div class="mt-2 text-xs text-gray-500">
                                                    @if ($deal->starts_at && $deal->ends_at)
                                                        {{ $deal->starts_at->format('M d') }} -
                                                        {{ $deal->ends_at->format('M d, Y') }}
                                                    @elseif($deal->starts_at)
                                                        Starts: {{ $deal->starts_at->format('M d, Y') }}
                                                    @elseif($deal->ends_at)
                                                        Ends: {{ $deal->ends_at->format('M d, Y') }}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <form
                                            action="{{ route('admin.products.deals.remove', [$product->id, $deal->id]) }}"
                                            method="POST" class="ml-2">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Remove from deal?')"
                                                class="text-gray-400 hover:text-red-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <p class="text-sm text-gray-500 mb-3">This product is not assigned to any deals</p>
                        <button onclick="openDealAssignmentModal()"
                            class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded transition-colors">
                            Assign to Deals
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Set Primary Image Modal -->
        <div id="setPrimaryModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-[80vh] overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900">Set Primary Image</h3>
                </div>
                <div class="p-4 overflow-y-auto max-h-[60vh]">
                    <div class="space-y-2">
                        @foreach ($product->images as $image)
                            <div
                                class="flex items-center justify-between p-2 border border-gray-200 rounded hover:bg-gray-50">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail"
                                        class="w-10 h-10 object-cover rounded">
                                    <span class="text-sm text-gray-700">Image {{ $loop->iteration }}</span>
                                    @if ($image->is_primary)
                                        <span class="text-xs text-indigo-600 font-medium">Current</span>
                                    @endif
                                </div>
                                <button type="button" onclick="setAsPrimary({{ $image->id }})"
                                    class="px-2 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded transition-colors {{ $image->is_primary ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                    Set
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200">
                    <button type="button" onclick="closeSetPrimaryModal()"
                        class="w-full px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Deal Assignment Modal -->
        <div id="dealAssignmentModal"
            class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[80vh] overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900">Assign to Deals</h3>
                </div>
                <form id="dealAssignmentForm" action="{{ route('admin.products.deals.assign', $product->id) }}"
                    method="POST" class="p-4 overflow-y-auto max-h-[60vh]">
                    @csrf
                    <div class="space-y-2">
                        @foreach ($allDeals as $deal)
                            <label
                                class="flex items-center p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="deal_ids[]" value="{{ $deal->id }}"
                                    {{ $product->deals->contains($deal->id) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <div class="ml-3 flex-1 min-w-0">
                                    <span class="text-sm text-gray-900">{{ $deal->title }}</span>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs text-gray-500">Priority: {{ $deal->priority }}</span>
                                        @if ($deal->is_active)
                                            <span class="text-xs text-green-600">Active</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </form>
                <div class="p-4 border-t border-gray-200 flex items-center justify-end space-x-2">
                    <button type="button" onclick="closeDealAssignmentModal()"
                        class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="dealAssignmentForm"
                        class="px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition-colors">
                        Save Assignments
                    </button>
                </div>
            </div>
        </div>

        <script>
            // Image Functions
            function changeMainImage(src) {
                document.getElementById('mainProductImage').src = src;
            }

            function openSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function setAsPrimary(imageId) {
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML =
                    '<svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>';
                button.disabled = true;

                fetch('{{ route('admin.products.set-primary-image', $product->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            image_id: imageId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to set primary image');
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            }

            // Deal Functions
            function openDealAssignmentModal() {
                document.getElementById('dealAssignmentModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDealAssignmentModal() {
                document.getElementById('dealAssignmentModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Close modals on outside click and Escape key
            document.addEventListener('click', function(e) {
                if (e.target.id === 'setPrimaryModal' || e.target.id === 'dealAssignmentModal') {
                    closeSetPrimaryModal();
                    closeDealAssignmentModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSetPrimaryModal();
                    closeDealAssignmentModal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
