<x-admin-layout>
    @section('title', $product->exists ? 'Edit Product' : 'Create Product')
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $product->exists ? 'Edit Product' : 'Create New Product' }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $product->exists ? 'Update product information' : 'Add a new product to your inventory' }}
                    </p>
                </div>

                <!-- Form -->
                <form
                    action="{{ $product->exists ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                    method="POST" enctype="multipart/form-data" class="px-6 py-4">
                    @csrf
                    @if ($product->exists)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic Information
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product
                                            Name *</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $product->name) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="short_description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Short Description</label>
                                        <input type="text" id="short_description" name="short_description"
                                            value="{{ old('short_description', $product->short_description) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('short_description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="sku"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU
                                            *</label>
                                        <input type="text" id="sku" name="sku"
                                            value="{{ old('sku', $product->sku) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('sku')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Description *
                                        </label>
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-200 dark:border-gray-700 mb-3 space-y-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">AI Marketing Generator</span>
                                                <button type="button" id="generate-description"
                                                    class="text-xs bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors shadow-sm disabled:opacity-50">
                                                    Generate Description
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 text-xs">
                                                <div>
                                                    <label class="block text-gray-500 dark:text-gray-400 mb-1">Language</label>
                                                    <select id="ai-language"
                                                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white py-1 px-2 text-xs">
                                                        <option value="English" selected>English</option>
                                                        <option value="Bengali">Bengali</option>
                                                        <option value="Arabic">Arabic</option>
                                                        <option value="Spanish">Spanish</option>
                                                        <option value="French">French</option>
                                                        <option value="Hindi">Hindi</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-gray-500 dark:text-gray-400 mb-1">Tone</label>
                                                    <select id="ai-tone"
                                                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white py-1 px-2 text-xs">
                                                        <option value="Professional" selected>Professional</option>
                                                        <option value="Casual">Casual</option>
                                                        <option value="Luxury">Luxury</option>
                                                        <option value="Minimal">Minimal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Target Audience (Optional)</label>
                                                <input type="text" id="ai-audience"
                                                    placeholder="e.g. Health conscious, women 20-30"
                                                    class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white py-1 px-2 text-xs">
                                            </div>
                                        </div>
                                        <textarea id="description" name="description" rows="6"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Pricing & Stock
                                </h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price
                                            *</label>
                                        <input type="number" id="price" name="price" step="0.01"
                                            min="0" value="{{ old('price', $product->price) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="discount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount</label>
                                        <input type="number" id="discount" name="discount" step="0.01"
                                            min="0" value="{{ old('discount', $product->discount) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('discount')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="buy_price"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buy
                                            Price</label>
                                        <input type="number" id="buy_price" name="buy_price" step="0.01"
                                            min="0" value="{{ old('buy_price', $product->buy_price) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('buy_price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="stock_quantity"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock
                                            Quantity *</label>
                                        <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                        @error('stock_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="low_stock_threshold"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Low Stock Threshold</label>
                                        <input type="number" id="low_stock_threshold" name="low_stock_threshold"
                                            min="0"
                                            value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('low_stock_threshold')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="min_order_quantity"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Order Qty</label>
                                        <input type="number" id="min_order_quantity" name="min_order_quantity"
                                            min="1"
                                            value="{{ old('min_order_quantity', $product->min_order_quantity ?? 1) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('min_order_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="max_order_quantity"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Order Qty (Leave empty for no limit)</label>
                                        <input type="number" id="max_order_quantity" name="max_order_quantity"
                                            min="1"
                                            value="{{ old('max_order_quantity', $product->max_order_quantity) }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                        @error('max_order_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Categories &
                                    Brands</h3>

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="category_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category
                                            *</label>
                                        <select id="category_id" name="category_id"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="brand_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand
                                            *</label>
                                        <select id="brand_id" name="brand_id"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3"
                                            required>
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Product Images
                                    <span class="ml-2 text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 px-2 py-0.5 rounded-full">Square 1:1</span>
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="image_gallery"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product
                                            Images <span class="text-gray-400 font-normal">(ratio: 1:1 square)</span></label>
                                        <input type="file" id="image_gallery" name="image_gallery[]" multiple
                                            accept="image/*"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">

                                        {{-- Image upload recommendation hint --}}
                                        <div class="mt-2 flex items-start gap-2 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 px-3 py-2">
                                            <svg class="w-4 h-4 mt-0.5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            </svg>
                                            <div class="text-xs text-amber-800 dark:text-amber-300 space-y-0.5">
                                                <p class="font-semibold">Recommended image specs:</p>
                                                <ul class="list-disc list-inside space-y-0.5 text-amber-700 dark:text-amber-400">
                                                    <li>Ratio: <strong>1:1 (square)</strong> — e.g. 800×800, 1000×1000, 1200×1200 px</li>
                                                    <li>Max size: <strong>400 KB</strong> per image (auto-compressed on upload)</li>
                                                    <li>Formats: JPG, PNG, WEBP, AVIF</li>
                                                    <li>Non-square images will be <strong>center-cropped</strong> to 1:1 automatically</li>
                                                </ul>
                                            </div>
                                        </div>

                                        @error('image_gallery')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror

                                        <!-- Current Images with Remove Option -->
                                        @if ($product->exists && $product->images->count() > 0)
                                            <div class="mt-4">
                                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Current Images (check to remove):</p>
                                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                                                    @foreach ($product->images as $image)
                                                        <div class="relative group">
                                                            <img src="{{ Storage::url($image->image_path) }}"
                                                                alt="Gallery image"
                                                                class="h-20 w-20 object-cover rounded-md border-2 {{ $image->is_primary ? 'border-blue-500' : 'border-gray-200' }}">

                                                            <!-- Remove checkbox -->
                                                            <div class="absolute top-0 left-0 mt-1 ml-1">
                                                                <input type="checkbox" name="remove_images[]"
                                                                    value="{{ $image->id }}"
                                                                    id="remove_image_{{ $image->id }}"
                                                                    class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-500 focus:ring-red-500">
                                                            </div>

                                                            @if ($image->is_primary)
                                                                <span
                                                                    class="absolute top-0 right-0 bg-blue-600 text-white text-xs px-1 rounded-bl-md">
                                                                    Primary
                                                                </span>
                                                            @endif

                                                            <!-- Set as primary option (optional) -->
                                                            <div
                                                                class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 opacity-0 group-hover:opacity-100 transition-opacity rounded-b-md">
                                                                <label
                                                                    class="flex items-center justify-center space-x-1">
                                                                    <input type="radio" name="primary_image"
                                                                        value="{{ $image->id }}"
                                                                        {{ $image->is_primary ? 'checked' : '' }}
                                                                        class="text-blue-600 focus:ring-blue-500">
                                                                    <span>Primary</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2">Check images you want to remove.
                                                    Select radio button to set as primary image.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                 <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status & Marketing</h3>

                                 <div class="space-y-4">
                                     <div class="flex items-center">
                                         <input type="checkbox" id="is_active" name="is_active" value="1"
                                             {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                             class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="is_active"
                                             class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                             Active Product
                                         </label>
                                     </div>

                                     <div class="flex items-center">
                                         <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                             {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                             class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="is_featured"
                                             class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                             Featured Product
                                         </label>
                                     </div>

                                     <div class="flex items-center">
                                         <input type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1"
                                             {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}
                                             class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="is_new_arrival"
                                             class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                             New Arrival
                                         </label>
                                     </div>

                                     <div class="flex items-center">
                                         <input type="checkbox" id="is_bestseller" name="is_bestseller" value="1"
                                             {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}
                                             class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                         <label for="is_bestseller"
                                             class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                             Bestseller
                                         </label>
                                     </div>

                                     <div>
                                         <label for="published_at"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Publish Date/Time</label>
                                         <input type="datetime-local" id="published_at" name="published_at"
                                             value="{{ old('published_at', $product->published_at ? $product->published_at->format('Y-m-d\TH:i') : '') }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('published_at')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>

                                     <div>
                                         <label for="label"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Promo Label (e.g. Sale, Hot, Eco)</label>
                                         <input type="text" id="label" name="label"
                                             value="{{ old('label', $product->label) }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('label')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>
                                 </div>
                                 @error('is_active')
                                     <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                 @enderror
                                 @error('is_featured')
                                     <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                 @enderror
                             </div>

                             <div>
                                 <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Logistics & Shipping</h3>
                                 <div class="grid grid-cols-2 gap-4">
                                     <div>
                                         <label for="weight"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Weight (kg)</label>
                                         <input type="number" id="weight" name="weight" step="0.001" min="0"
                                             value="{{ old('weight', $product->weight) }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('weight')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>
                                     <div>
                                         <label for="length"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Length (cm)</label>
                                         <input type="number" id="length" name="length" step="0.1" min="0"
                                             value="{{ old('length', $product->length) }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('length')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>
                                     <div>
                                         <label for="width"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Width (cm)</label>
                                         <input type="number" id="width" name="width" step="0.1" min="0"
                                             value="{{ old('width', $product->width) }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('width')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>
                                     <div>
                                         <label for="height"
                                             class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Height (cm)</label>
                                         <input type="number" id="height" name="height" step="0.1" min="0"
                                             value="{{ old('height', $product->height) }}"
                                             class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                         @error('height')
                                             <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                         @enderror
                                     </div>
                                 </div>
                             </div>

                    <!-- Product Attributes Section -->
                    <div id="attributes-container" class="space-y-4">
                        @if ($product->exists && isset($groupedAttributes) && $groupedAttributes->count() > 0)
                            @foreach ($groupedAttributes as $index => $attribute)
                                <div
                                    class="attribute-row flex items-end space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Attribute
                                        </label>
                                        <select name="product_attributes[{{ $index }}][id]"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                               dark:bg-gray-600 dark:border-gray-500 dark:text-white py-2 px-3"
                                            required>
                                            <option value="">Select Attribute</option>
                                            @foreach ($allAttributes as $attr)
                                                <option value="{{ $attr->id }}"
                                                    {{ $attribute['id'] == $attr->id ? 'selected' : '' }}>
                                                    {{ $attr->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Values</label>
                                        <div class="tag-input w-full flex flex-wrap items-center rounded-md border border-gray-300
                                dark:border-gray-500 bg-white dark:bg-gray-600 px-2 py-1 cursor-text"
                                            data-name="product_attributes[{{ $index }}][values]">
                                            @foreach ($attribute['values'] as $val)
                                                <span
                                                    class="tag bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-sm mr-2 mb-1 flex items-center">
                                                    {{ trim($val) }}
                                                    <button type="button"
                                                        class="remove-tag ml-1 text-red-600 hover:text-red-800">×</button>
                                                    <input type="hidden"
                                                        name="product_attributes[{{ $index }}][values][]"
                                                        value="{{ trim($val) }}">
                                                </span>
                                            @endforeach
                                            <input type="text"
                                                class="tag-input-field flex-1 bg-transparent border-none focus:ring-0 focus:outline-none dark:text-white"
                                                placeholder="Type and press Enter">
                                        </div>
                                    </div>

                                    <div>
                                        <button type="button"
                                            class="remove-attribute text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200
                               px-3 py-2 rounded-md transition-colors">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <button type="button" id="add-attribute"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add Attribute
                        </button>
                    </div>



                    <!-- Specifications (JSON) -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Specifications</h3>
                        <div id="specifications-container" class="space-y-3">
                            <!-- Specifications will be added here dynamically -->
                        </div>
                        <button type="button" id="add-specification"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800">
                            Add Specification
                        </button>
                        <textarea id="specifications-json" name="specifications" class="hidden">{{ old('specifications', $product->specifications ? json_encode($product->specifications) : '{}') }}</textarea>
                        @error('specifications')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Section -->
                    <div class="mt-6 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')"
                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">SEO Settings</h3>
                            <span class="text-gray-500 text-sm">Click to expand</span>
                        </button>
                        <div class="hidden px-4 py-4 space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title <span class="text-gray-400 text-xs">(max 160 chars)</span></label>
                                <input type="text" id="meta_title" name="meta_title" maxlength="160"
                                    value="{{ old('meta_title', $product->meta_title) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                @error('meta_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="2"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Keywords <span class="text-gray-400 text-xs">(comma separated)</span></label>
                                <input type="text" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                    placeholder="e.g. organic, skincare, moisturizer"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                                @error('meta_keywords')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cross-Category Flexible Fields -->
                    <div class="mt-6 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')"
                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700 text-left">
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Product Details (Fashion / Natural / Gadget)</h3>
                            <span class="text-gray-500 text-sm">Click to expand</span>
                        </button>
                        <div class="hidden px-4 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags <span class="text-gray-400 text-xs">(comma separated)</span></label>
                                <input type="text" id="tags" name="tags"
                                    value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}"
                                    placeholder="e.g. organic, vegan, handmade"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                            <div>
                                <label for="origin_country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Origin Country</label>
                                <input type="text" id="origin_country" name="origin_country"
                                    value="{{ old('origin_country', $product->origin_country) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                            <div>
                                <label for="material" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Material / Fabric <span class="text-gray-400 text-xs">(Fashion)</span></label>
                                <input type="text" id="material" name="material"
                                    value="{{ old('material', $product->material) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                            <div>
                                <label for="warranty_info" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Warranty Info <span class="text-gray-400 text-xs">(Gadgets)</span></label>
                                <input type="text" id="warranty_info" name="warranty_info"
                                    value="{{ old('warranty_info', $product->warranty_info) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                            <div>
                                <label for="certifications" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Certifications <span class="text-gray-400 text-xs">(comma separated)</span></label>
                                <input type="text" id="certifications" name="certifications"
                                    value="{{ old('certifications', is_array($product->certifications) ? implode(', ', $product->certifications) : $product->certifications) }}"
                                    placeholder="e.g. ISO, Organic, Halal"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
                            </div>
                            <div class="md:col-span-2">
                                <label for="ingredients" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ingredients <span class="text-gray-400 text-xs">(Natural Products)</span></label>
                                <textarea id="ingredients" name="ingredients" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('ingredients', $product->ingredients) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="usage_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usage Instructions</label>
                                <textarea id="usage_instructions" name="usage_instructions" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('usage_instructions', $product->usage_instructions) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="care_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Care Instructions <span class="text-gray-400 text-xs">(Fashion)</span></label>
                                <textarea id="care_instructions" name="care_instructions" rows="2"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('care_instructions', $product->care_instructions) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $product->exists ? 'Update Product' : 'Create Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Handle dynamic addition/removal of product attributes
            document.addEventListener('DOMContentLoaded', function() {
                const attributesContainer = document.getElementById('attributes-container');
                const addAttributeBtn = document.getElementById('add-attribute');
                let attributeCount = {{ $product->exists ? $product->attributes->count() : 0 }};

                function initTagInput(container) {
                    const input = container.querySelector('.tag-input-field');

                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ',') {
                            e.preventDefault();
                            const value = input.value.trim();
                            if (value !== '') {
                                addTag(container, value);
                                input.value = '';
                            }
                        }
                    });
                }

                function addTag(container, value) {
                    const name = container.dataset.name;

                    const tag = document.createElement('span');
                    tag.className =
                        "tag bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-sm mr-2 mb-1 flex items-center";
                    tag.innerHTML = `
            ${value}
            <button type="button" class="remove-tag ml-1 text-red-600 hover:text-red-800">×</button>
            <input type="hidden" name="${name}[]" value="${value}">
        `;

                    const input = container.querySelector('.tag-input-field');
                    container.insertBefore(tag, input);

                    // remove event
                    tag.querySelector('.remove-tag').addEventListener('click', () => tag.remove());
                }

                // Initialize existing tag inputs
                document.querySelectorAll('.tag-input').forEach(initTagInput);

                // Add new attribute row
                addAttributeBtn.addEventListener('click', function() {
                    const attributeRow = document.createElement('div');
                    attributeRow.className =
                        'attribute-row flex items-end space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-md';
                    attributeRow.innerHTML = `
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Attribute</label>
                <select name="product_attributes[${attributeCount}][id]"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white py-2 px-3" required>
                    <option value="">Select Attribute</option>
                    @foreach ($allAttributes as $attribute)
                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Values</label>
                <div class="tag-input w-full flex flex-wrap items-center rounded-md border border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-600 px-2 py-1 cursor-text"
                     data-name="product_attributes[${attributeCount}][values]">
                    <input type="text"
                           class="tag-input-field flex-1 bg-transparent border-none focus:ring-0 focus:outline-none dark:text-white"
                           placeholder="Type and press Enter">
                </div>
            </div>
            <div>
                <button type="button" class="remove-attribute text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 px-3 py-2 rounded-md transition-colors">
                    Remove
                </button>
            </div>
        `;

                    attributesContainer.appendChild(attributeRow);

                    // initialize new tag input
                    initTagInput(attributeRow.querySelector('.tag-input'));

                    // remove button
                    attributeRow.querySelector('.remove-attribute').addEventListener('click', function() {
                        attributeRow.remove();
                    });

                    attributeCount++;
                });

                // Add event listeners to existing remove buttons
                document.querySelectorAll('.remove-attribute').forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.attribute-row').remove();
                    });
                });
            });

            // Handle specifications
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('specifications-container');
                const jsonInput = document.getElementById('specifications-json');
                const addButton = document.getElementById('add-specification');

                // Load existing specifications
                let specifications = JSON.parse(jsonInput.value || '{}');
                renderSpecifications();

                addButton.addEventListener('click', function() {
                    const key = prompt('Enter specification key:');
                    if (key) {
                        const value = prompt('Enter specification value:');
                        if (value !== null) {
                            specifications[key] = value;
                            updateJsonInput();
                            renderSpecifications();
                        }
                    }
                });

                function renderSpecifications() {
                    container.innerHTML = '';
                    for (const [key, value] of Object.entries(specifications)) {
                        const div = document.createElement('div');
                        div.className = 'flex items-center space-x-2';
                        div.innerHTML = `
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">${key}:</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">${value}</span>
                            <button type="button" class="text-red-600 hover:text-red-800 text-sm" data-key="${key}">
                                Remove
                            </button>
                        `;
                        container.appendChild(div);
                    }

                    // Add event listeners to remove buttons
                    container.querySelectorAll('button').forEach(button => {
                        button.addEventListener('click', function() {
                            const key = this.getAttribute('data-key');
                            delete specifications[key];
                            updateJsonInput();
                            renderSpecifications();
                        });
                    });
                }

                function updateJsonInput() {
                    jsonInput.value = JSON.stringify(specifications);
                }
            });
        </script>

        <script>
            document.getElementById('generate-description').addEventListener('click', function() {
                const productName = document.getElementById('name').value;
                const descriptionField = document.getElementById('description');
                const generateButton = this;

                if (!productName) {
                    alert('Please enter a product name first');
                    return;
                }

                // Gather extra dynamic context
                const price = document.getElementById('price') ? document.getElementById('price').value : '';
                const discount = document.getElementById('discount') ? document.getElementById('discount').value : '';

                const categoryEl = document.getElementById('category_id');
                const category = categoryEl && categoryEl.selectedIndex > 0 ? categoryEl.options[categoryEl.selectedIndex].text : '';

                const brandEl = document.getElementById('brand_id');
                const brand = brandEl && brandEl.selectedIndex > 0 ? brandEl.options[brandEl.selectedIndex].text : '';

                const language = document.getElementById('ai-language').value;
                const tone = document.getElementById('ai-tone').value;
                const targetAudience = document.getElementById('ai-audience').value;

                // Show loading state
                generateButton.innerHTML = 'Generating...';
                generateButton.disabled = true;

                fetch('{{ route('admin.products.generate-description') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_name: productName,
                            price: price,
                            discount: discount,
                            category: category,
                            brand: brand,
                            language: language,
                            tone: tone,
                            target_audience: targetAudience
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.description) {
                            descriptionField.value = data.description;
                            
                            if (data.short_description && document.getElementById('short_description')) {
                                document.getElementById('short_description').value = data.short_description;
                            }

                            // Auto-populate SEO Settings & Product Details
                            if (data.meta_title && document.getElementById('meta_title')) {
                                document.getElementById('meta_title').value = data.meta_title;
                            }
                            if (data.meta_description && document.getElementById('meta_description')) {
                                document.getElementById('meta_description').value = data.meta_description;
                            }
                            if (data.meta_keywords && document.getElementById('meta_keywords')) {
                                document.getElementById('meta_keywords').value = data.meta_keywords;
                            }
                            if (data.tags && document.getElementById('tags')) {
                                document.getElementById('tags').value = data.tags;
                            }
                            if (data.certifications && document.getElementById('certifications')) {
                                document.getElementById('certifications').value = data.certifications;
                            }
                            if (data.material && document.getElementById('material')) {
                                document.getElementById('material').value = data.material;
                            }
                            if (data.warranty_info && document.getElementById('warranty_info')) {
                                document.getElementById('warranty_info').value = data.warranty_info;
                            }
                            if (data.ingredients && document.getElementById('ingredients')) {
                                document.getElementById('ingredients').value = data.ingredients;
                            }
                            if (data.usage_instructions && document.getElementById('usage_instructions')) {
                                document.getElementById('usage_instructions').value = data.usage_instructions;
                            }
                            if (data.care_instructions && document.getElementById('care_instructions')) {
                                document.getElementById('care_instructions').value = data.care_instructions;
                            }
                        } else if (data.error) {
                            let msg = 'AI Generation Notice: ' + data.error;
                            if (data.details) msg += '\n\nDetails: ' + data.details;
                            alert(msg);
                        } else {
                            alert('Failed to generate description. Please check your AI API settings.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while generating the description');
                    })
                    .finally(() => {
                        generateButton.innerHTML = 'Generate Description';
                        generateButton.disabled = false;
                    });
            });
        </script>
    </x-slot>
</x-admin-layout>
