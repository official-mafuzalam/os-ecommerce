<x-admin-layout>
    @section('title', 'Carousel Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Carousel</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage homepage carousel slides</p>
                    </div>
                    <a href="{{ route('admin.carousels.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        New Slide
                    </a>
                </div>
            </div>

            <!-- Drag & Drop Instructions -->
            @if ($carousels->isNotEmpty())
                <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 16h-1v-4h1m0 0h-1m1 0v4m-4-6h.01M5 12a7 7 0 1014 0 7 7 0 00-14 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Drag to reorder slides</p>
                            <p class="text-xs text-blue-700 mt-0.5">Drag the handle (<svg
                                    class="w-3 h-3 inline text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>) to change slide order. Changes save automatically.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Carousel Slides Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                @if ($carousels->isEmpty())
                    <div class="px-4 py-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">No carousel slides</h3>
                        <p class="text-xs text-gray-500 mb-3">Add slides to create a homepage carousel</p>
                        <a href="{{ route('admin.carousels.create') }}"
                            class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Slide
                        </a>
                    </div>
                @else
                    <div id="sortable-carousels" class="divide-y divide-gray-200">
                        @foreach ($carousels as $carousel)
                            <div class="hover:bg-gray-50 transition-colors" data-id="{{ $carousel->id }}">
                                <div class="p-4 flex items-center justify-between">
                                    <!-- Left side: Drag handle and slide info -->
                                    <div class="flex items-center gap-3 flex-1">
                                        <span
                                            class="drag-handle cursor-move text-gray-400 hover:text-gray-600 p-1.5 rounded hover:bg-gray-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </span>

                                        <!-- Slide Image -->
                                        <div class="w-16 h-12 rounded overflow-hidden flex-shrink-0">
                                            @if ($carousel->image)
                                                <img src="{{ $carousel->image_url }}" alt="{{ $carousel->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <img src="https://cdn.octosyncsoftware.com//storage/files/2/main-site/logo/banner.jpg" alt="No Image"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <!-- Slide Details -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $carousel->title }}
                                                </h4>
                                                <span @class([
                                                    'inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium',
                                                    'bg-green-100 text-green-800' => $carousel->is_active,
                                                    'bg-gray-100 text-gray-800' => !$carousel->is_active,
                                                ])>
                                                    {{ $carousel->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ $carousel->description ? Str::limit($carousel->description, 60) : 'No description' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Right side: Order and actions -->
                                    <div class="flex items-center gap-3 ml-4">
                                        <span class="text-xs font-medium text-gray-500">
                                            Order: <span class="text-gray-900">{{ $carousel->order }}</span>
                                        </span>

                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.carousels.edit', $carousel) }}"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.carousels.destroy', $carousel) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                    onclick="return confirm('Delete this slide?')" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sortableElement = document.getElementById('sortable-carousels');
                    if (!sortableElement) return;

                    const sortable = new Sortable(sortableElement, {
                        handle: '.drag-handle',
                        animation: 150,
                        ghostClass: 'bg-blue-50',
                        dragClass: 'opacity-50',
                        onEnd: function(evt) {
                            const order = Array.from(evt.from.children).map((child, index) => {
                                return child.dataset.id;
                            });

                            // Show saving indicator
                            const dragHandle = evt.item.querySelector('.drag-handle');
                            const originalHTML = dragHandle.innerHTML;
                            dragHandle.innerHTML = `
                                <svg class="w-4 h-4 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            `;

                            fetch('{{ route('admin.carousels.reorder') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        order: order
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Restore drag handle icon
                                    dragHandle.innerHTML = originalHTML;

                                    if (data.success) {
                                        // Update order numbers in UI
                                        document.querySelectorAll('[data-id]').forEach((item, index) => {
                                            const orderText = item.querySelector(
                                                '.text-xs.font-medium.text-gray-500 .text-gray-900'
                                                );
                                            if (orderText) {
                                                orderText.textContent = index;
                                            }
                                        });

                                        // Show success message
                                        const message = document.createElement('div');
                                        message.className =
                                            'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm z-50 animate-fade-in-up';
                                        message.textContent = 'Order updated successfully';
                                        document.body.appendChild(message);
                                        setTimeout(() => message.remove(), 3000);
                                    }
                                })
                                .catch(error => {
                                    dragHandle.innerHTML = originalHTML;
                                    console.error('Error:', error);
                                });
                        }
                    });
                });
            </script>
        @endpush

        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.3s ease-out;
            }
        </style>
    </x-slot>
</x-admin-layout>
