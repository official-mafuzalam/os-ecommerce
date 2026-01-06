<div
    class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
    <div class="relative">
        <!-- Product Image -->
        <a href="{{ route('public.products.show', $product->slug) }}">
            <div class="relative overflow-hidden bg-gray-50 aspect-square">
                <img src="{{ $product->images->where('is_primary', true)->first()
                    ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                    : 'https://placehold.co/400x400?text=No+Image' }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                <!-- Quick Actions Overlay -->
                <div
                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-1">
                    <button class="bg-white text-gray-900 p-1.5 rounded-full hover:bg-gray-100 transition-colors"
                        onclick="showQuickView({{ $product->id }})" title="Quick View">
                        <i class="fas fa-eye text-xs"></i>
                    </button>
                </div>
            </div>
        </a>

        <!-- Badges -->
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if ($product->created_at->gt(now()->subDays(7)))
                <span class="bg-green-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                    NEW
                </span>
            @endif

            @if ($product->discount > 0)
                @php
                    $discountPercent = round(($product->discount / $product->price) * 100);
                @endphp
                <span class="bg-red-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                    -{{ $discountPercent }}%
                </span>
            @endif
        </div>

        @if ($product->stock_quantity <= 10 && $product->stock_quantity > 0)
            <div class="absolute top-2 right-2">
                <span class="bg-yellow-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                    {{ $product->stock_quantity }} left
                </span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-3">
        <!-- Category -->
        @if ($product->category)
            <a href="{{ route('public.categories.show', $product->category->slug) }}"
                class="inline-block text-[11px] text-gray-500 hover:text-indigo-600 font-medium mb-0.5 truncate w-full">
                {{ $product->category->name }}
            </a>
        @endif

        <!-- Product Name -->
        <a href="{{ route('public.products.show', $product->slug) }}" class="block">
            <h3
                class="text-sm font-medium text-gray-900 mb-1 line-clamp-2 hover:text-indigo-600 transition-colors min-h-[40px]">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Price -->
        <div class="mb-3">
            @if ($product->discount > 0)
                <div class="flex items-baseline gap-1">
                    <span class="text-lg font-bold text-gray-900">
                        {{ number_format($product->final_price) }} TK
                    </span>
                    <span class="text-xs text-gray-400 line-through">
                        {{ number_format($product->price) }} TK
                    </span>
                </div>
                <div class="text-[11px] text-green-600 font-medium mt-0.5">
                    Save {{ number_format($product->discount) }} TK
                </div>
            @else
                <span class="text-lg font-bold text-gray-900">
                    {{ number_format($product->price) }} TK
                </span>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex gap-1.5">
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-200 text-xs font-medium flex items-center justify-center group/cart">
                    <i
                        class="fas fa-shopping-cart mr-1.5 text-xs group-hover/cart:translate-x-0.5 transition-transform"></i>
                    Cart
                </button>
            </form>
            <a href="{{ route('public.products.show', $product->slug) }}"
                class="bg-gray-800 hover:bg-black text-white py-2 px-3 rounded-lg transition duration-200 text-xs font-medium flex items-center justify-center">
                Buy Now
            </a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function showQuickView(productId) {
            // Implement quick view modal
            console.log('Quick view for product:', productId);
        }
    </script>
@endpush
