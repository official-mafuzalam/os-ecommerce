<div
    class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
    <a href="{{ route('public.products.show', $product->slug) }}" class="block group">

        {{-- Product Image --}}
        <div class="relative w-full h-52 sm:h-56 bg-gray-100 overflow-hidden">
            <img src="{{ $product->images->where('is_primary', true)->first()
                ? Storage::url($product->images->where('is_primary', true)->first()->image_path)
                : 'https://placehold.co/400x400?text=No+Image' }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">

            {{-- New Badge --}}
            @if ($product->created_at->gt(now()->subDays(30)))
                <div
                    class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                    NEW
                </div>
            @endif

            {{-- Discount Badge --}}
            @if ($product->discount > 0)
                <div
                    class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                    {{ number_format(($product->discount / $product->price) * 100) }}% OFF
                </div>
            @endif
        </div>
    </a>

    {{-- Product Content --}}
    <div class="p-4">
        {{-- Product Name --}}
        <a href="{{ route('public.products.show', $product->slug) }}" class="block mb-2">
            <h4 class="font-thin text-base text-gray-900 hover:text-indigo-600 transition-colors line-clamp-2"
                title="{{ $product->name }}">
                {{ $product->name }}
            </h4>
        </a>

        {{-- Ratings --}}
        {{-- <div class="flex items-center mb-2">
            <div class="flex text-yellow-400 text-sm">
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
            <span class="text-gray-600 text-xs ml-2">({{ number_format($product->average_rating, 1) }})</span>
        </div> --}}

        {{-- Price --}}
        <div class="mb-2">
            @if ($product->discount > 0)
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-gray-900">{{ number_format($product->final_price) }} TK</span>
                    <span class="text-sm text-gray-500 line-through">{{ number_format($product->price) }} TK</span>
                </div>
            @else
                <span class="text-xl font-bold text-gray-900">{{ number_format($product->price) }} TK</span>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="w-full h-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-300 text-sm flex items-center justify-center">
                    <i class="fas fa-shopping-cart mr-1"></i>
                </button>
            </form>
            <a href="{{ route('public.products.show', $product->slug) }}"
                class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-300 text-sm flex items-center justify-center">
                Buy Now
            </a>
        </div>
    </div>
</div>
