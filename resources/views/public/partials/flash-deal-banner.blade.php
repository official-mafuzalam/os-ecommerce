<div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-2xl overflow-hidden shadow-lg">
    <div class="p-6 md:p-8 text-white relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg
                fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath
                d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                /%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        </div>

        <div class="relative z-10">
            <!-- Countdown Timer -->
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold">
                    <i class="fas fa-bolt mr-2"></i>FLASH DEAL
                </span>
                @if ($deal->expires_at)
                    <div class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-semibold">
                        <i class="fas fa-clock mr-2"></i>
                        <span id="countdown-{{ $deal->id }}" class="countdown-timer"
                            data-expires="{{ $deal->expires_at->toISOString() }}">
                            {{ $deal->expires_at->diffForHumans() }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Deal Content -->
            <h3 class="text-xl md:text-2xl font-bold mb-2">{{ $deal->title }}</h3>
            <p class="text-white/90 mb-4">{{ $deal->description }}</p>

            <!-- Discount -->
            <div class="flex items-center gap-4 mb-6">
                @if ($deal->discount_percentage)
                    <div class="bg-white text-red-600 px-4 py-2 rounded-xl">
                        <span class="text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
                        <span class="text-sm font-semibold">OFF</span>
                    </div>
                @endif
                <div class="text-sm">
                    {{ $deal->discount_details }}
                </div>
            </div>

            <!-- CTA Button -->
            <a href="{{ $deal->button_link }}"
                class="inline-flex items-center bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                {{ $deal->button_text }}
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Initialize countdown timers
        document.querySelectorAll('.countdown-timer').forEach(element => {
            const expiresAt = new Date(element.dataset.expires).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = expiresAt - now;

                if (distance < 0) {
                    element.textContent = 'Deal expired';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (days > 0) {
                    element.textContent = `${days}d ${hours}h`;
                } else {
                    element.textContent = `${hours}h ${minutes}m ${seconds}s`;
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endpush
