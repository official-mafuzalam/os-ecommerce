<x-app-layout>
    <x-slot name="main">

        <!-- Search Results -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Search Results for "{{ $query }}"
                </h1>

                @if ($products->count() > 0)
                    <p class="text-gray-600">{{ $products->total() }} results found</p>
                @else
                    <p class="text-gray-600">No results found for "{{ $query }}"</p>
                @endif
            </div>

            @if ($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                    @foreach ($products as $product)
                        @include('public.products.partial.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-4">Try different keywords or browse our categories</p>
                    <div class="space-x-4">
                        <a href="{{ route('public.products') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Browse All Products
                        </a>
                        <a href="{{ route('public.categories') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300">
                            View Categories
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>
</x-app-layout>
