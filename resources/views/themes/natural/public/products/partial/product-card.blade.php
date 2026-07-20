<div class="group rounded-3xl border border-emerald-100 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('public.products.show', $product->slug) }}" class="block overflow-hidden rounded-3xl bg-emerald-50 mb-4">
        <img src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://placehold.co/400x400?text=No+Image' }}"
            alt="{{ $product->name }}" class="w-full h-56 object-cover transition duration-500 group-hover:scale-105">
    </a>

    <div class="space-y-3">
        <div class="flex items-center justify-between text-xs uppercase tracking-[0.25em] text-emerald-600 font-semibold">
            <span>{{ $product->category?->name ?? 'Wellness' }}</span>
            @if ($product->discount > 0)
                <span class="text-emerald-900">-{{ round(($product->discount / max($product->price, 1)) * 100) }}%</span>
            @endif
        </div>

        <a href="{{ route('public.products.show', $product->slug) }}" class="block">
            <h3 class="text-lg font-semibold text-emerald-900 leading-tight">{{ $product->name }}</h3>
        </a>

        <p class="text-sm text-emerald-700 line-clamp-2">{{ Str::limit($product->short_description ?? $product->name, 85) }}</p>

        <div class="flex items-center justify-between gap-3">
            <div>
                <div class="text-xl font-bold text-emerald-900">{{ number_format($product->final_price) }} TK</div>
                @if ($product->discount > 0)
                    <div class="text-sm text-emerald-500 line-through">{{ number_format($product->price) }} TK</div>
                @endif
            </div>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-900 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-800 transition">
                    <i class="fas fa-shopping-bag"></i>
                    Add
                </button>
            </form>
        </div>
    </div>
</div>
