<x-admin-layout>
    @section('title', $brand->exists ? 'Edit Brand' : 'Create Brand')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $brand->exists ? 'Edit Brand' : 'Create New Brand' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $brand->exists ? 'Update brand information' : 'Add a new product brand' }}
                    </p>
                </div>

                <!-- Form -->
                <form
                    action="{{ $brand->exists ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}"
                    method="POST" enctype="multipart/form-data" class="px-6 py-4">
                    @csrf
                    @if ($brand->exists)
                        @method('PUT')
                    @endif
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand
                                    Name *</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $brand->name) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea id="description" name="description"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                    rows="4">{{ old('description', $brand->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Logo -->
                            <div>
                                <label for="logo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand
                                    Logo (Max size: 2 MB) | (Recommended ratio 1:1)</label>
                                <input type="file" id="logo" name="logo"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                @if ($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }} Logo"
                                        class="mt-2 h-16">
                                @endif
                                @error('logo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>

                                <div class="flex items-center">
                                    <input type="checkbox" id="is_active" name="is_active" value="1"
                                        {{ old('is_active', $brand->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="is_active"
                                        class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Active Brand
                                    </label>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $brand->exists ? 'Update Brand' : 'Create Brand' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
