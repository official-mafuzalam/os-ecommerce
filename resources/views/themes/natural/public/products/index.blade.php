<x-app-layout>
    @section('title', setting('site_name', 'Prokiti Sudha') . ' | Shop All Collections')

    @push('styles')
        <style>
            .product-card {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .product-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 30px 60px -12px rgba(0, 69, 37, 0.08);
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f0eee7;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #004525;
                border-radius: 10px;
            }
        </style>
    @endpush

    <x-slot name="main">
        <main class="pt-32 pb-xl px-margin-desktop max-w-container-max mx-auto">
            <!-- Hero Title Section -->
            <header class="mb-xl text-center md:text-left">
                <h1 class="font-cormorant text-[56px] leading-tight text-primary italic mb-sm">
                    @if (isset($category))
                        {{ $category->name }} Collection
                    @elseif(isset($brand))
                        {{ $brand->name }} Collection
                    @elseif(isset($is_featured) && $is_featured)
                        Featured Collection
                    @elseif(isset($deal))
                        {{ $deal->title }}
                    @else
                        Shop All Collections
                    @endif
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[600px] mx-auto md:mx-0">
                    @if (isset($category))
                        {{ $category->description ?? 'Discover our curated collection of ' . $category->name . ' products' }}
                    @elseif(isset($brand))
                        Experience premium quality from {{ $brand->name }}
                    @else
                        Artisan-crafted wellness solutions, ethically sourced from the heart of nature to revitalize
                        your spirit.
                    @endif
                </p>
                <div class="mt-md">
                    <span class="font-label-md bg-surface-container-high px-3 py-1 rounded-full text-on-surface-variant">
                        {{ $products->total() ?? $products->count() }} items found
                    </span>
                    @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'sort']))
                        <a href="{{ route('public.products') }}" class="font-label-md text-primary ml-2 hover:underline">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </header>
            <div class="flex flex-col md:flex-row gap-xl">
                <!-- Sidebar Filters -->
                <aside class="w-full md:w-64 flex-shrink-0 space-y-xl">
                    @if (isset($categories) && $categories->count() > 0)
                        <div>
                            <h3 class="font-label-md text-label-md text-primary uppercase tracking-widest mb-md">
                                Category</h3>
                            <ul class="space-y-sm">
                                <li class="flex items-center gap-sm cursor-pointer group">
                                    <span
                                        class="w-4 h-4 rounded-full border border-primary {{ !request('category') ? 'bg-primary' : 'group-hover:bg-primary-fixed transition-colors' }}"></span>
                                    <a href="{{ route('public.products', array_merge(request()->except('category', 'page'))) }}"
                                        class="font-body-md {{ !request('category') ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' }}">
                                        All Categories
                                    </a>
                                </li>
                                @foreach ($categories as $cat)
                                    <li class="flex items-center gap-sm cursor-pointer group">
                                        <span
                                            class="w-4 h-4 rounded-full border border-primary {{ request('category') == $cat->slug ? 'bg-primary' : 'group-hover:bg-primary-fixed transition-colors' }}"></span>
                                        <a href="{{ route('public.products', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                                            class="font-body-md {{ request('category') == $cat->slug ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' }} flex justify-between w-full">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-xs opacity-50">{{ $cat->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($brands) && $brands->count() > 0)
                        <div>
                            <h3 class="font-label-md text-label-md text-primary uppercase tracking-widest mb-md">Brands
                            </h3>
                            <ul class="space-y-sm">
                                <li class="flex items-center gap-sm cursor-pointer group">
                                    <span
                                        class="w-4 h-4 rounded-full border border-primary {{ !request('brand') ? 'bg-primary' : 'group-hover:bg-primary-fixed transition-colors' }}"></span>
                                    <a href="{{ route('public.products', array_merge(request()->except('brand', 'page'))) }}"
                                        class="font-body-md {{ !request('brand') ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' }}">
                                        All Brands
                                    </a>
                                </li>
                                @foreach ($brands as $br)
                                    <li class="flex items-center gap-sm cursor-pointer group">
                                        <span
                                            class="w-4 h-4 rounded-full border border-primary {{ request('brand') == $br->slug ? 'bg-primary' : 'group-hover:bg-primary-fixed transition-colors' }}"></span>
                                        <a href="{{ route('public.products', array_merge(request()->except('page'), ['brand' => $br->slug])) }}"
                                            class="font-body-md {{ request('brand') == $br->slug ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' }} flex justify-between w-full">
                                            <span>{{ $br->name }}</span>
                                            <span class="text-xs opacity-50">{{ $br->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="hidden md:block pt-lg border-t border-surface-variant">
                        <p class="font-caption text-caption text-on-surface-variant italic leading-relaxed">
                            "Nature does not hurry, yet everything is accomplished."
                        </p>
                    </div>
                </aside>

                <!-- Product Grid Area -->
                <div class="flex-grow flex flex-col">
                    <!-- Filters Toolbar -->
                    <div class="flex flex-wrap justify-between items-center mb-6 pb-4 border-b border-surface-variant">
                        <form method="GET" action="{{ route('public.products') }}" class="flex items-center gap-2">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('brand'))
                                <input type="hidden" name="brand" value="{{ request('brand') }}">
                            @endif
                            <span class="font-label-md text-on-surface-variant">Sort by:</span>
                            <select name="sort" onchange="this.form.submit()"
                                class="border-outline-variant bg-surface-container-lowest rounded-md text-sm py-1 font-body-md">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                </option>
                                <option value="price_low_high"
                                    {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High
                                </option>
                                <option value="price_high_low"
                                    {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low
                                </option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A-Z
                                </option>
                            </select>
                        </form>
                    </div>

                    @if ($products->count() > 0)
                        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
                            @foreach ($products as $product)
                                <!-- Product Card -->
                                <div
                                    class="product-card bg-surface-container-lowest rounded-xl p-md flex flex-col group border border-outline-variant/30">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[4/5] mb-md bg-surface-container">
                                        <a href="{{ route('public.products.show', $product->slug ?? $product->id) }}"
                                            class="block w-full h-full">
                                            @php $productImage = $product->images->first(); @endphp
                                            @if ($productImage)
                                                <img class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                                                    alt="{{ $product->name }}"
                                                    src="{{ Storage::url($productImage->image_path) }}" />
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-primary/30">
                                                    <span class="material-symbols-outlined text-[48px]">image</span>
                                                </div>
                                            @endif
                                        </a>

                                        @if ($product->discount_price)
                                            <span
                                                class="absolute top-sm left-sm bg-error text-white px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter">Sale</span>
                                        @endif
                                        @if ($product->category)
                                            <span
                                                class="absolute top-sm right-sm bg-tertiary-fixed text-on-tertiary-fixed px-sm py-1 rounded-full font-label-md text-[10px] uppercase tracking-tighter">{{ $product->category->name }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('public.products.show', $product->slug ?? $product->id) }}"
                                        class="font-cormorant text-headline-md text-[24px] text-on-surface mb-xs hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</a>
                                    <p
                                        class="font-caption text-caption text-on-surface-variant mb-md line-clamp-2 min-h-[3rem]">
                                        {{ strip_tags($product->short_description ?? $product->description) }}
                                    </p>
                                    <div class="mt-auto flex justify-between items-end">
                                        <div>
                                            @if ($product->discount_price)
                                                <span
                                                    class="font-label-md text-primary text-lg mr-1 block">৳{{ number_format($product->discount_price) }}</span>
                                                <span
                                                    class="font-caption text-outline line-through text-xs">৳{{ number_format($product->base_price ?? $product->price) }}</span>
                                            @else
                                                <span
                                                    class="font-label-md text-primary text-lg">৳{{ number_format($product->final_price ?? ($product->base_price ?? $product->price)) }}</span>
                                            @endif
                                        </div>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                class="bg-primary text-on-primary h-12 px-md rounded-xl flex items-center gap-xs active:scale-95 transition-transform hover:bg-primary-container disabled:opacity-50"
                                                {{ ($product->stock_quantity ?? 1) <= 0 ? 'disabled' : '' }}>
                                                <span class="material-symbols-outlined text-[20px]"
                                                    data-icon="add_shopping_cart">add_shopping_cart</span>
                                                <span
                                                    class="font-label-md">{{ ($product->stock_quantity ?? 1) <= 0 ? 'Out' : 'Add' }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </section>

                        <!-- Pagination -->
                        @if (method_exists($products, 'links'))
                            <div class="mt-xl flex justify-center">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div
                            class="flex flex-col items-center justify-center py-xl bg-surface-container-lowest rounded-2xl border border-outline-variant/30 text-center">
                            <span class="material-symbols-outlined text-[80px] text-outline/30 mb-md">inventory_2</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">No Products Found</h3>
                            <p class="font-body-md text-on-surface-variant max-w-md mb-lg">We couldn't find any products
                                matching your current filters. Try adjusting your selection.</p>
                            <a href="{{ route('public.products') }}"
                                class="font-label-md bg-primary text-white px-lg py-sm rounded-full hover:bg-primary-container transition-colors">Clear
                                All Filters</a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </x-slot>

    @push('scripts')
        <script>
            // Micro-interactions for product cards
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    const btn = card.querySelector('button');
                    if (btn && !btn.disabled) btn.classList.add('shadow-lg');
                });
                card.addEventListener('mouseleave', () => {
                    const btn = card.querySelector('button');
                    if (btn) btn.classList.remove('shadow-lg');
                });
            });
        </script>
    @endpush
</x-app-layout>
