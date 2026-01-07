<x-admin-layout>
    @section('title', 'Attributes Management')
    <x-slot name="main">
        <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Attributes</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage product attributes (color, size, etc.)</p>
                    </div>
                    <a href="{{ route('admin.attributes.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        New Attribute
                    </a>
                </div>
            </div>

            <!-- Attributes List Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                @if ($attributes->isEmpty())
                    <div class="px-4 py-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">No attributes</h3>
                        <p class="text-xs text-gray-500 mb-3">Add attributes for product variations</p>
                        <a href="{{ route('admin.attributes.create') }}"
                            class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Attribute
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach ($attributes as $attribute)
                            <div class="hover:bg-gray-50 transition-colors p-4">
                                <div class="flex items-start justify-between">
                                    <!-- Left side: Attribute info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $attribute->name }}</h3>
                                            <span @class([
                                                'inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium',
                                                'bg-green-100 text-green-800' => $attribute->is_active,
                                                'bg-gray-100 text-gray-800' => !$attribute->is_active,
                                            ])>
                                                {{ $attribute->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-500 mb-2">
                                            <span
                                                class="font-mono bg-gray-100 px-1.5 py-0.5 rounded">{{ $attribute->slug }}</span>
                                        </div>

                                        <p class="text-xs text-gray-600 mb-3">
                                            {{ $attribute->description ?? 'No description' }}
                                        </p>

                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                {{ $attribute->products_count }} products
                                            </span>
                                            @if ($attribute->values_count > 0)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                    {{ $attribute->values_count }} values
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Right side: Actions -->
                                    <div class="flex items-center gap-2 ml-4">
                                        <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.attributes.destroy', $attribute->id) }}"
                                            method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                onclick="return confirm('Delete this attribute?')" title="Delete">
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
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if ($attributes->hasPages())
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $attributes->firstItem() }}</span> to
                        <span class="font-medium">{{ $attributes->lastItem() }}</span> of
                        <span class="font-medium">{{ $attributes->total() }}</span> attributes
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($attributes->onFirstPage())
                            <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $attributes->previousPageUrl() }}"
                                class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Previous
                            </a>
                        @endif

                        @if ($attributes->hasMorePages())
                            <a href="{{ $attributes->nextPageUrl() }}"
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
    </x-slot>
</x-admin-layout>
