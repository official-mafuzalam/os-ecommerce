<x-app-layout>
    @section('title', $product->name)
    <x-slot name="main">
        <!-- Product Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4 bg-white rounded-lg shadow-md p-4">
                        <div class="relative overflow-hidden rounded-lg">
                            @if ($product->images->count() > 0)
                                <img id="main-product-image"
                                    src="{{ Storage::url($product->images->first()->image_path) }}"
                                    alt="{{ $product->name }}" class="w-full h-96 object-contain">
                            @else
                                <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            @if ($product->discount > 0)
                                <div
                                    class="absolute top-4 left-4 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full">
                                    {{ number_format($product->discount) }} TK OFF
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Images -->
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $image)
                                <div class="border-2 border-transparent hover:border-indigo-500 rounded-lg p-1 cursor-pointer transition-all"
                                    onclick="changeImage('{{ Storage::url($image->image_path) }}')">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 object-cover rounded-md">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Brand & Status -->
                        <div class="flex justify-between items-start mb-4">
                            @if ($product->brand)
                                <span class="text-sm text-gray-500">By <a
                                        href="{{ route('public.brands.show', $product->brand->slug) }}"
                                        class="text-indigo-600 hover:underline">{{ $product->brand->name }}</a></span>
                            @endif
                            @if ($product->stock_quantity > 0)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">In
                                    Stock</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of
                                    Stock</span>
                            @endif
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                        <!-- Rating -->
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product->average_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $product->average_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">({{ $product->reviews_count }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            @if ($product->discount > 0)
                                <div class="flex items-center">
                                    <span
                                        class="text-3xl font-bold text-gray-900">{{ number_format($product->final_price) }}
                                        TK</span>
                                    <span
                                        class="ml-3 text-xl text-gray-500 line-through">{{ number_format($product->price) }}
                                        TK</span>
                                    <span class="ml-3 bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded">
                                        Save {{ number_format($product->discount) }} TK
                                    </span>
                                </div>
                            @else
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price) }}
                                    TK</span>
                            @endif
                        </div>

                        <!-- Add to Cart -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800"
                                        onclick="decreaseQuantity()">-</button>
                                    <input type="number" id="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-12 text-center border-0 focus:ring-0">
                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800"
                                        onclick="increaseQuantity()">+</button>
                                </div>
                                {{-- <span class="text-sm text-gray-500">{{ $product->stock_quantity }} available</span> --}}
                            </div>

                            <!-- Categories -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Category</h3>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('public.categories.show', $product->category->slug) }}"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                                        {{ $product->category->name }}
                                    </a>
                                </div>
                            </div>

                            @if ($groupedAttributes->count() > 0)
                                <div class="md:col-span-2">
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Choose Options
                                    </h3>
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach ($groupedAttributes as $attribute)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                    {{ $attribute['name'] }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-200 mt-1">
                                                    <div class="flex flex-wrap gap-3">
                                                        @foreach ($attribute['values'] as $value)
                                                            @php
                                                                $inputName = 'attributes[' . $attribute['id'] . ']';
                                                                $valueId =
                                                                    $attribute['id'] .
                                                                    '_' .
                                                                    \Illuminate\Support\Str::slug($value, '_');
                                                            @endphp

                                                            <label for="{{ $valueId }}" class="cursor-pointer">
                                                                <input type="radio" id="{{ $valueId }}"
                                                                    name="{{ $inputName }}"
                                                                    value="{{ $value }}" class="peer hidden"
                                                                    required>
                                                                <span
                                                                    class="inline-block px-3 py-1 rounded-md border border-gray-300 text-sm peer-checked:bg-indigo-600 peer-checked:text-white hover:bg-indigo-100 transition-colors">
                                                                    {{ $value }}
                                                                </span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex space-x-4">
                                <form action="{{ route('public.products.buy-now', $product) }}" method="GET"
                                    class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center">
                                        <i class="fas fa-shopping-bag mr-2"></i>
                                        Buy Now
                                    </button>
                                </form>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1" id="form-quantity">
                                    <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center"
                                        {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                            <div class="flex space-x-4 mt-2">
                                @if (setting('site_phone'))
                                    <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                        class="flex-1 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center">
                                        <i class="fas fa-phone-alt mr-2"></i>
                                        Call
                                    </a>
                                @endif
                                @if (setting('whatsapp_enabled', true))
                                    <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode('I want to know about ' . $product->name) }}"
                                        target="_blank"
                                        class="flex-1 w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-12 bg-white rounded-lg shadow-md">
                <div class="border-b border-gray-200">
                    <nav class="flex flex-wrap -mb-px overflow-x-auto">
                        <button id="tab-description"
                            class="py-3 px-4 md:py-4 md:px-6 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600 whitespace-nowrap">Description</button>
                        <button id="tab-specifications"
                            class="py-3 px-4 md:py-4 md:px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">Specifications</button>
                        <button id="tab-reviews"
                            class="py-3 px-4 md:py-4 md:px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">Reviews
                            ({{ $product->reviews_count }})</button>
                        <button id="tab-shipping"
                            class="py-3 px-4 md:py-4 md:px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">Shipping
                            & Returns</button>
                    </nav>
                </div>
                <div class="p-6">
                    <!-- Description Tab -->
                    <div id="content-description" class="prose max-w-none">
                        <p>
                            {!! nl2br(e($product->description)) !!}
                        </p>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="content-specifications" class="prose max-w-none hidden">
                        @if ($product->specifications && count($product->specifications) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($product->specifications as $key => $value)
                                    <div class="border-b border-gray-100 pb-2">
                                        <dt class="font-medium text-gray-900">{{ $key }}</dt>
                                        <dd class="text-gray-700">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No specifications available.</p>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div id="content-reviews" class="hidden">
                        <div class="flex items-center mb-6">
                            <div class="mr-4">
                                <span
                                    class="text-5xl font-bold text-gray-900">{{ number_format($product->average_rating, 1) }}</span>
                                <span class="text-gray-500">/5</span>
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <div class="flex text-yellow-400 mr-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product->average_rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $product->average_rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">Based on {{ $product->reviews_count }} reviews</p>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div class="space-y-6">
                            @forelse($product->reviews->where('is_approved', true) as $review)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-2">{{ $review->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>

                        <!-- Review Form -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Write a Review</h4>
                            <form action="{{ route('public.products.review.submit', $product) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center">
                                        <div class="flex text-gray-300" id="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star cursor-pointer hover:text-yellow-400 text-lg"
                                                    onmouseover="highlightStars({{ $i }})"
                                                    onclick="setRating({{ $i }})"></i>
                                            @endfor
                                        </div>
                                        @error('order_number')
                                            <p class="text-red-500 text-sm mt-1 ml-4">{{ $message }}</p>
                                        @enderror
                                        <input type="hidden" name="rating" id="rating-value" value="0">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="order_number"
                                        class="block text-sm font-medium text-gray-700 mb-2">Order ID *</label>
                                    <input type="text" id="order_number" name="order_number"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                @error('order_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <div class="mb-4">
                                    <label for="review-body"
                                        class="block text-sm font-medium text-gray-700 mb-2">Review *</label>
                                    <textarea id="review-body" name="comment" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                                </div>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition-colors">Submit
                                    Review</button>
                            </form>
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div id="content-shipping" class="prose max-w-none hidden">
                        <h3>Shipping Information</h3>
                        <p>We offer standard shipping within 2-5 business days. Express shipping options are available
                            at checkout for an additional fee.</p>
                        <p>Free shipping on orders over ৳1000. All orders are processed within 24 hours of placement.
                        </p>

                        <h3>Returns Policy</h3>
                        <p>We offer a 30-day money-back guarantee on all products. If you're not completely satisfied
                            with your purchase, you can return it for a full refund.</p>
                        <p>To initiate a return, please contact our customer service team with your order number and
                            reason for return.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-12 p-4 container mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">You May Also Like</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    @foreach ($relatedProducts as $product)
                        @include('public.products.partial.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif

        @if (setting('google_tag_manager_id'))
            @push('scripts')
                <script>
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push({
                        event: 'view_item',
                        ecommerce: {
                            items: [{
                                item_id: {{ $product->id }},
                                item_name: '{{ $product->name }}',
                                price: {{ $product->price }}
                            }]
                        }
                    });
                </script>
            @endpush
        @endif
        @if (setting('fb_pixel_id') && !empty($eventId))
            <script>
                fbq('track', 'ViewContent', {
                    content_ids: ['{{ $product->sku }}'],
                    content_type: 'product',
                    value: {{ $product->price }},
                    currency: "USD"
                }, {
                    eventID: "{{ $eventId }}"
                });
            </script>
        @endif


        <script>
            // Function to change the main product image
            function changeImage(src) {
                document.getElementById('main-product-image').src = src;
            }

            // Function to increase quantity
            function increaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                const max = parseInt(quantityInput.max);
                let value = parseInt(quantityInput.value);
                if (value < max) {
                    quantityInput.value = value + 1;
                    formQuantityInput.value = value + 1;
                }
            }

            // Function to decrease quantity
            function decreaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                    formQuantityInput.value = value - 1;
                }
            }

            // Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('[id^="tab-"]');
                const contents = document.querySelectorAll('[id^="content-"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const target = this.id.replace('tab-', 'content-');

                        // Update active tab
                        tabs.forEach(t => {
                            t.classList.remove('border-indigo-500', 'text-indigo-600');
                            t.classList.add('border-transparent', 'text-gray-500');
                        });
                        this.classList.add('border-indigo-500', 'text-indigo-600');
                        this.classList.remove('border-transparent', 'text-gray-500');

                        // Show target content
                        contents.forEach(content => {
                            content.classList.add('hidden');
                        });
                        document.getElementById(target).classList.remove('hidden');
                    });
                });

                // Rating stars functionality
                window.highlightStars = function(count) {
                    const stars = document.querySelectorAll('#rating-stars i');
                    stars.forEach((star, index) => {
                        if (index < count) {
                            star.classList.add('text-yellow-400');
                            star.classList.remove('text-gray-300');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                };

                window.setRating = function(count) {
                    document.getElementById('rating-value').value = count;
                    const stars = document.querySelectorAll('#rating-stars i');
                    stars.forEach((star, index) => {
                        if (index < count) {
                            star.classList.add('text-yellow-400');
                            star.classList.remove('text-gray-300');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                };
            });
        </script>
    </x-slot>
</x-app-layout>
