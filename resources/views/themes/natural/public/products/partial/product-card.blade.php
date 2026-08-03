<div
    class="group bg-white rounded-2xl overflow-hidden hover-lift p-base shadow-sm hover:shadow-md transition-shadow flex flex-col">
    <a href="{{ route('public.products.show', $product->slug ?? $product->id) }}"
        class="block relative aspect-square rounded-xl overflow-hidden mb-md bg-surface-container-low">
        @php
            $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
        @endphp
        @if ($primaryImg)
            <img class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110"
                alt="{{ $product->name }}" src="{{ Storage::url($primaryImg->image_path) }}" />
        @else
            <div class="w-full h-full flex items-center justify-center text-primary/30">
                <span class="material-symbols-outlined text-[64px]">image</span>
            </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-md left-md flex flex-col gap-1 z-10">
            @if ($product->is_bestseller)
                <span
                    class="bg-amber-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full shadow-sm uppercase">
                    BESTSELLER
                </span>
            @endif

            @if ($product->is_new_arrival || (isset($product->created_at) && $product->created_at->gt(now()->subDays(7))))
                <span
                    class="bg-emerald-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full shadow-sm uppercase">
                    NEW
                </span>
            @endif
        </div>

        @if ($product->category)
            <div
                class="absolute top-md right-md bg-primary text-white px-sm py-xs rounded-full font-label-md text-caption shadow-md">
                {{ $product->category->name }}
            </div>
        @endif
    </a>
    <div class="px-sm pb-md flex flex-col flex-grow">
        <a href="{{ route('public.products.show', $product->slug ?? $product->id) }}" class="block">
            <h3
                class="font-headline-md text-[24px] text-primary mb-xs group-hover:text-secondary transition-colors truncate">
                {{ $product->name }}
            </h3>
        </a>
        <p class="font-body-md text-on-surface-variant text-sm mb-md leading-relaxed line-clamp-2 min-h-[2.5rem]">
            {{ strip_tags($product->short_description ?? $product->description) }}
        </p>
        <div class="flex justify-between items-center mt-auto">
            <div>
                @if ($product->discount_price || (isset($product->discount) && $product->discount > 0))
                    <span
                        class="font-label-md text-primary text-lg font-bold mr-2">৳{{ number_format($product->discount_price ?? $product->final_price, 2) }}</span>
                    <span
                        class="font-caption text-on-surface-variant line-through">৳{{ number_format($product->base_price ?? $product->price, 2) }}</span>
                @else
                    <span
                        class="font-label-md text-primary text-lg font-bold">৳{{ number_format($product->final_price ?? ($product->base_price ?? $product->price), 2) }}</span>
                @endif
            </div>
            <form action="{{ route('public.products.buy-now', $product) }}" method="GET">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="bg-gradient-to-r from-emerald-600 to-primary text-white text-xs font-bold px-3.5 py-2 rounded-xl hover:from-emerald-500 hover:to-primary/90 transition-all duration-300 active:scale-95 shadow-md shadow-emerald-700/20 hover:shadow-lg hover:shadow-emerald-700/30 flex items-center gap-1 group"
                    {{ ($product->stock_quantity ?? 1) <= 0 ? 'disabled' : '' }}>
                    <span class="material-symbols-outlined text-amber-300 text-sm group-hover:animate-bounce">bolt</span>
                    <span>{{ ($lang ?? null) === '1' ? 'অর্ডার করুন' : 'Order Now' }}</span>
                </button>
            </form>
        </div>
    </div>
</div>