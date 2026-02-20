<x-app-layout>
    @section('title', $product->name)
    <x-slot name="main">
        @php
            $lang = setting('order_form_bangla') ? '1' : '0';
        @endphp
        <!-- Fashion Product Section -->
        <div class="container mx-auto px-4 py-8 md:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4 bg-white rounded-2xl shadow-sm p-4 md:p-6">
                        <div class="relative overflow-hidden rounded-xl">
                            @if ($product->images->count() > 0)
                                <img id="main-product-image"
                                    src="{{ Storage::url($product->images->first()->image_path) }}"
                                    alt="{{ $product->name }}" class="w-full h-80 md:h-96 object-contain bg-gray-50">
                            @else
                                <div class="w-full h-80 md:h-96 bg-gray-100 flex items-center justify-center rounded-xl">
                                    <i class="fas fa-image text-5xl text-gray-300"></i>
                                </div>
                            @endif

                            <div class="absolute top-2 left-2 flex flex-col gap-1">
                                @if ($product->created_at->gt(now()->subDays(7)))
                                    <span
                                        class="bg-green-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                        NEW
                                    </span>
                                @endif

                                @if ($product->discount > 0)
                                    @php
                                        $discountPercent = round(($product->discount / $product->price) * 100);
                                    @endphp
                                    <span
                                        class="bg-red-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                        -{{ $discountPercent }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2 md:gap-3">
                            @foreach ($product->images as $image)
                                <button onclick="changeImage('{{ Storage::url($image->image_path) }}')"
                                    class="group relative overflow-hidden rounded-lg border-2 border-transparent hover:border-gray-300 focus:border-gray-300 transition-all duration-200 p-1">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-16 md:h-20 object-cover rounded">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors">
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
                        <!-- Brand & Status -->
                        <div class="flex justify-between items-start mb-4">
                            @if ($product->brand)
                                <a href="{{ route('public.products', parameters: ['brand' => $product->brand->slug]) }}"
                                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">
                                    <span>By {{ $product->brand->name }}</span>
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            @endif

                            @if ($product->stock_quantity > 0)
                                <div class="flex items-center gap-2 text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="text-sm font-medium">In Stock</span>
                                    @if ($product->stock_quantity <= 10)
                                        <span class="text-xs bg-green-100 px-2 py-1 rounded-full">
                                            Only {{ $product->stock_quantity }} left
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-red-600">
                                    <i class="fas fa-times-circle"></i>
                                    <span class="text-sm font-medium">Out of Stock</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Title -->
                        <h1
                            class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 elegant-heading leading-tight">
                            {{ $product->name }}
                        </h1>

                        <!-- Rating & Reviews -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex items-center gap-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->average_rating))
                                            <i class="fas fa-star text-sm"></i>
                                        @elseif($i - 0.5 <= $product->average_rating)
                                            <i class="fas fa-star-half-alt text-sm"></i>
                                        @else
                                            <i class="far fa-star text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">({{ $product->reviews_count }} reviews)</span>
                            </div>
                            <span class="text-gray-400">•</span>
                            <span class="text-sm text-gray-600">{{ $product->sku }}</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-8">
                            @if ($product->discount > 0)
                                <div class="flex items-baseline gap-4">
                                    <span class="text-3xl md:text-4xl font-bold text-gray-900">
                                        {{ number_format($product->final_price) }} TK
                                    </span>
                                    <span class="text-xl text-gray-500 line-through">
                                        {{ number_format($product->price) }} TK
                                    </span>
                                    <span class="text-sm font-semibold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                        Save {{ number_format($product->discount) }} TK
                                    </span>
                                </div>
                            @else
                                <span class="text-3xl md:text-4xl font-bold text-gray-900">
                                    {{ number_format($product->price) }} TK
                                </span>
                            @endif
                        </div>

                        <!-- Product Description -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $product->short_description ?? Str::limit($product->description, 200) }}
                            </p>
                        </div>

                        <!-- Product Attributes -->
                        @if ($groupedAttributes->count() > 0)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Options</h3>
                                <div class="space-y-6">
                                    @foreach ($groupedAttributes as $attribute)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                {{ $attribute['name'] }}
                                            </label>
                                            <div class="flex flex-wrap gap-2">
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
                                                            name="{{ $inputName }}" value="{{ $value }}"
                                                            class="peer hidden" required>
                                                        <span
                                                            class="inline-block px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium
                                                                   peer-checked:border-gray-900 peer-checked:bg-gray-900 peer-checked:text-white 
                                                                   hover:border-gray-900 hover:bg-gray-50 transition-all duration-200">
                                                            {{ $value }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity & Actions -->
                        <div class="space-y-6">
                            <!-- Quantity Selector -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Quantity</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="decreaseQuantity()"
                                            class="px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ $product->stock_quantity }}"
                                            class="w-16 text-center border-0 focus:ring-0 text-lg font-medium">
                                        <button type="button" onclick="increaseQuantity()"
                                            class="px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $product->stock_quantity }} items available
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <!-- Add to Cart -->
                                <form action="{{ route('cart.add', $product) }}" method="POST" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1" id="form-quantity">
                                    @if ($groupedAttributes->count() > 0)
                                        @foreach ($groupedAttributes as $attribute)
                                            <input type="hidden" name="attributes[{{ $attribute['id'] }}]"
                                                id="attribute-{{ $attribute['id'] }}" value="">
                                        @endforeach
                                    @endif
                                    <button type="submit"
                                        class="w-full fashion-btn flex items-center justify-center gap-2 py-4"
                                        {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-bag"></i>
                                        @if ($lang === '1')
                                            কার্টে যোগ করুন
                                        @else
                                            Add to Cart
                                        @endif
                                    </button>
                                </form>

                                <!-- Buy Now -->
                                <form action="{{ route('public.products.buy-now', $product) }}" method="GET"
                                    id="buy-now-form">
                                    <input type="hidden" name="quantity" value="1">
                                    @if ($groupedAttributes->count() > 0)
                                        @foreach ($groupedAttributes as $attribute)
                                            <input type="hidden" name="attributes[{{ $attribute['id'] }}]"
                                                id="buy-now-attribute-{{ $attribute['id'] }}" value="">
                                        @endforeach
                                    @endif
                                    <button type="submit"
                                        class="w-full fashion-btn fashion-btn-outline flex items-center justify-center gap-2 py-4">
                                        <i class="fas fa-bolt"></i>
                                        @if ($lang === '1')
                                            এখনই কিনুন
                                        @else
                                            Buy Now
                                        @endif
                                    </button>
                                </form>
                            </div>

                            <!-- Contact Options -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if (setting('site_phone'))
                                    <a href="tel:{{ setting('site_phone', '+8801621833839') }}"
                                        class="flex items-center justify-center gap-2 py-3 px-4 bg-blue-50 text-blue-600 hover:bg-blue-100 
                                              rounded-lg transition-colors font-medium">
                                        <i class="fas fa-phone-alt"></i>
                                        @if ($lang === '1')
                                            কল করুন
                                        @else
                                            Call Now
                                        @endif
                                    </a>
                                @endif
                                @if (setting('whatsapp_enabled', true))
                                    <a href="https://wa.me/{{ setting('whatsapp_number', '+8801621833839') }}?text={{ urlencode('I want to know about ' . $product->name) }}"
                                        target="_blank"
                                        class="flex items-center justify-center gap-2 py-3 px-4 bg-green-50 text-green-600 hover:bg-green-100 
                                              rounded-lg transition-colors font-medium">
                                        <i class="fab fa-whatsapp"></i>
                                        @if ($lang === '1')
                                            হোয়াটসঅ্যাপে যোগাযোগ
                                        @else
                                            WhatsApp Contact
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Info -->
                        {{-- <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-truck text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Free Shipping</p>
                                        <p class="text-xs text-gray-600">On orders over ৳1000</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-sync-alt text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">30-Day Returns</p>
                                        <p class="text-xs text-gray-600">Easy return policy</p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-12 bg-white rounded-2xl shadow-sm overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-1 overflow-x-auto">
                        <button id="tab-description"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 border-transparent text-gray-600 
                                       hover:text-gray-900 transition-colors data-[active=true]:border-gray-900 data-[active=true]:text-gray-900"
                            data-active="true">
                            Description
                        </button>
                        <button id="tab-specifications"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 border-transparent text-gray-600 
                                       hover:text-gray-900 transition-colors data-[active=false]:border-gray-900 data-[active=false]:text-gray-900"
                            data-active="false">
                            Specifications
                        </button>
                        <button id="tab-reviews"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 border-transparent text-gray-600 
                                       hover:text-gray-900 transition-colors data-[active=false]:border-gray-900 data-[active=false]:text-gray-900"
                            data-active="false">
                            Reviews ({{ $product->reviews_count }})
                        </button>
                        <button id="tab-shipping"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b-2 border-transparent text-gray-600 
                                       hover:text-gray-900 transition-colors data-[active=false]:border-gray-900 data-[active=false]:text-gray-900"
                            data-active="false">
                            Shipping & Returns
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6 md:p-8">
                    <!-- Description Tab -->
                    <div id="content-description" class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-900">Product Description</h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="content-specifications" class="hidden space-y-6">
                        <h3 class="text-xl font-bold text-gray-900">Product Specifications</h3>
                        @if ($product->specifications && count($product->specifications) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($product->specifications as $key => $value)
                                    <div class="border-b border-gray-100 pb-3">
                                        <dt class="font-medium text-gray-900 mb-1">{{ $key }}</dt>
                                        <dd class="text-gray-700">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No specifications available for this product.</p>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div id="content-reviews" class="hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Rating Overview -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Customer Reviews</h3>
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="text-center mb-4">
                                        <div class="text-5xl font-bold text-gray-900 mb-2">
                                            {{ number_format($product->average_rating, 1) }}
                                        </div>
                                        <div class="flex justify-center text-yellow-400 mb-2">
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
                                        <p class="text-sm text-gray-600">Based on {{ $product->reviews_count }}
                                            reviews</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews List -->
                            <div class="lg:col-span-2">
                                <div class="space-y-6 max-h-[500px] overflow-y-auto pr-4">
                                    @forelse($product->reviews->where('is_approved', true) as $review)
                                        <div class="border-b border-gray-200 pb-6 last:border-0">
                                            <div class="flex items-start justify-between mb-2">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">
                                                        {{ $review->user->full_name }}
                                                    </h4>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <div class="flex text-yellow-400">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <i class="fas fa-star text-sm"></i>
                                                                @else
                                                                    <i class="far fa-star text-sm"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span
                                                            class="text-sm text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-gray-700">{{ $review->comment }}</p>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <i class="fas fa-comment-alt text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-gray-600">No reviews yet. Be the first to review this
                                                product!</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Review Form -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h4 class="text-xl font-bold text-gray-900 mb-6">Write a Review</h4>
                            <form action="{{ route('public.products.review.submit', $product) }}" method="POST"
                                class="space-y-6">
                                @csrf

                                <!-- Rating -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Your Rating *</label>
                                    <div class="flex items-center gap-1" id="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" onclick="setRating({{ $i }})"
                                                class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors"
                                                onmouseover="highlightStars({{ $i }})"
                                                onmouseout="resetStars()">
                                                <i class="far fa-star"></i>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-value" value="0" required>
                                    @error('rating')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Order ID -->
                                <div>
                                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Order ID *
                                    </label>
                                    <input type="text" id="order_number" name="order_number"
                                        class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="Enter your order number" required>
                                    @error('order_number')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Review Comment -->
                                <div>
                                    <label for="review-body" class="block text-sm font-medium text-gray-700 mb-2">
                                        Your Review *
                                    </label>
                                    <textarea id="review-body" name="comment" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="Share your experience with this product..." required></textarea>
                                    @error('comment')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="fashion-btn px-8 py-3">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div id="content-shipping" class="hidden space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Shipping Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-shipping-fast text-gray-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Standard Shipping</h4>
                                            <p class="text-sm text-gray-600">2-5 business days</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">All orders are processed within 24 hours. Free shipping on
                                        orders over ৳1000.</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-rocket text-gray-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Express Shipping</h4>
                                            <p class="text-sm text-gray-600">1-2 business days</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">Available at checkout for an additional fee. Delivered to
                                        your doorstep.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Returns Policy</h3>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="space-y-4">
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-check text-green-500 mt-1"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">30-Day Money-Back Guarantee</h4>
                                            <p class="text-gray-700">If you're not completely satisfied with your
                                                purchase, return it within 30 days for a full refund.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-check text-green-500 mt-1"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Easy Returns Process</h4>
                                            <p class="text-gray-700">Contact our customer service team with your order
                                                number to initiate a return.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-check text-green-500 mt-1"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Condition Requirements</h4>
                                            <p class="text-gray-700">Products must be in original condition with all
                                                tags attached for a full refund.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-16 bg-gray-50 py-12">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">You May Also Like</h2>
                        <p class="text-gray-600">Discover similar products you might love</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="fashion-product-card">
                                @include('public.products.partial.product-card', [
                                    'product' => $relatedProduct,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </x-slot>

    @push('scripts')
        <script>
            // Function to change the main product image
            function changeImage(src) {
                document.getElementById('main-product-image').src = src;
            }

            // Quantity functions
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

                        // Update active states
                        tabs.forEach(t => {
                            t.setAttribute('data-active', 'false');
                            t.classList.remove('border-gray-900', 'text-gray-900');
                            t.classList.add('border-transparent', 'text-gray-600');
                        });

                        this.setAttribute('data-active', 'true');
                        this.classList.add('border-gray-900', 'text-gray-900');
                        this.classList.remove('border-transparent', 'text-gray-600');

                        // Show target content
                        contents.forEach(content => content.classList.add('hidden'));
                        document.getElementById(target).classList.remove('hidden');
                    });
                });

                // Update attribute values in forms
                function updateAttributeValues() {
                    const forms = [document.getElementById('add-to-cart-form'),
                        document.getElementById('buy-now-form')
                    ];

                    forms.forEach(form => {
                        if (form) {
                            const attributeInputs = form.querySelectorAll('input[name^="attributes["]');
                            attributeInputs.forEach(input => {
                                const attributeId = input.name.match(/\[(\d+)\]/)[1];
                                const radio = document.querySelector(
                                    `input[name="attributes[${attributeId}]"]:checked`);
                                if (radio) {
                                    input.value = radio.value;
                                }
                            });
                        }
                    });
                }

                // Add event listeners to attribute radios
                const attributeRadios = document.querySelectorAll('input[name^="attributes["]');
                attributeRadios.forEach(radio => {
                    radio.addEventListener('change', updateAttributeValues);
                });

                // Update forms on page load
                updateAttributeValues();

                // Form submit handlers
                const addToCartForm = document.getElementById('add-to-cart-form');
                if (addToCartForm) {
                    addToCartForm.addEventListener('submit', function(e) {
                        updateAttributeValues();
                    });
                }

                const buyNowForm = document.getElementById('buy-now-form');
                if (buyNowForm) {
                    buyNowForm.addEventListener('submit', function(e) {
                        updateAttributeValues();
                    });
                }

                // Rating stars functionality
                window.currentRating = 0;

                window.highlightStars = function(count) {
                    const stars = document.querySelectorAll('#rating-stars button');
                    stars.forEach((star, index) => {
                        const icon = star.querySelector('i');
                        if (index < count) {
                            icon.classList.remove('far', 'text-gray-300');
                            icon.classList.add('fas', 'text-yellow-400');
                        } else {
                            icon.classList.remove('fas', 'text-yellow-400');
                            icon.classList.add('far', 'text-gray-300');
                        }
                    });
                };

                window.resetStars = function() {
                    highlightStars(window.currentRating);
                };

                window.setRating = function(count) {
                    window.currentRating = count;
                    document.getElementById('rating-value').value = count;
                    highlightStars(count);
                };
            });
        </script>
    @endpush
</x-app-layout>
