<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2 items-center">
        <!-- Content -->
        <div class="p-8 md:p-12 text-white">
            <span class="inline-block bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                🎯 Limited Time Offer
            </span>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                {{ $deal->title }}
            </h2>
            <p class="text-indigo-100 mb-6 text-lg">
                {{ $deal->description }}
            </p>

            <!-- Stats -->
            <div class="flex items-center gap-6 mb-8">
                @if ($deal->discount_percentage)
                    <div class="text-center">
                        <div class="text-4xl font-bold">{{ $deal->discount_percentage }}%</div>
                        <div class="text-sm opacity-90">OFF</div>
                    </div>
                @endif

                @if ($deal->expires_at)
                    <div class="border-l border-white/30 pl-6">
                        <div class="text-sm opacity-90 mb-1">Offer ends in</div>
                        <div class="text-xl font-bold">
                            {{ $deal->expires_at->diffForHumans() }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- CTA -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ $deal->button_link }}"
                    class="inline-flex items-center bg-white text-indigo-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg">
                    {{ $deal->button_text }}
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>

                @if ($deal->secondary_button_text && $deal->secondary_button_url)
                    <a href="{{ $deal->secondary_button_url }}"
                        class="inline-flex items-center bg-transparent border-2 border-white text-white font-medium py-3 px-6 rounded-lg hover:bg-white/10 transition-colors">
                        {{ $deal->secondary_button_text }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Image -->
        <div class="relative h-full min-h-[300px] md:min-h-[400px]">
            <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-purple-600/20"></div>
        </div>
    </div>
</div>
