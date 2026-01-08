@props(['deal', 'compact' => false])

<a href="{{ $deal->button_link }}" class="block">
    <div
        class="relative bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group {{ $compact ? 'h-64' : 'h-72' }} border border-gray-100">
        <!-- Deal Image -->
        <div class="relative h-2/3 overflow-hidden">
            <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

            <!-- Discount Badge -->
            @if ($deal->discount_percentage)
                <div class="absolute top-3 left-3">
                    <span class="bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                        {{ $deal->discount_percentage }}% OFF
                    </span>
                </div>
            @endif

            <!-- Time Remaining Badge (Optional) -->
            @if ($deal->expires_at)
                <div class="absolute top-3 right-3">
                    <span class="bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $deal->expires_at->diffForHumans() }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-4">
            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                {{ $deal->title }}
            </h3>
            {{-- <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                {{ $deal->description }}
            </p> --}}
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-indigo-600">
                    {{ $deal->button_text }}
                </span>
                <i
                    class="fas fa-arrow-right text-indigo-500 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
            </div>
        </div>
    </div>
</a>
