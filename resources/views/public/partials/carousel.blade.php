<!-- Carousel Partial -->
<div class="col-span-2">
    <section class="relative overflow-hidden rounded-xl">
        <div class="hero-carousel h-80 md:h-96 lg:h-[600px]">
            @foreach ($carousels as $index => $carousel)
                <div
                    class="hero-slide {{ $index === 0 ? 'active' : '' }} bg-{{ $carousel->background_color }} text-white">
                    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center h-full py-6 md:py-0">
                        <div class="md:w-1/2 flex flex-col justify-center text-center md:text-left mt-4 md:mt-0">
                            <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold leading-tight mb-4">
                                {{ $carousel->title }}
                            </h3>
                            @if ($carousel->description)
                                <p class="text-base md:text-lg mb-6 line-clamp-2">{{ $carousel->description }}</p>
                            @endif

                            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                                @if ($carousel->button_text && $carousel->button_url)
                                    <a href="{{ $carousel->button_url }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 text-base md:text-lg">
                                        {{ $carousel->button_text }}
                                    </a>
                                @endif

                                @if ($carousel->secondary_button_text && $carousel->secondary_button_url)
                                    <a href="{{ $carousel->secondary_button_url }}"
                                        class="bg-transparent hover:bg-white hover:text-indigo-600 text-white font-medium py-3 px-6 rounded-lg border border-white md:border-2 transition duration-300 text-base md:text-lg">
                                        {{ $carousel->secondary_button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="md:w-1/2 mt-6 md:mt-0">
                            <img src="{{ $carousel->image_url }}" alt="{{ $carousel->title }}"
                                class="rounded-xl h-[250px] md:h-[400px] lg:h-[500px] object-contain mx-auto">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Indicators --}}
        @if ($carousels->count() > 1)
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                @foreach ($carousels as $index => $carousel)
                    <button
                        class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-40 {{ $index === 0 ? 'active' : '' }}"
                        data-slide="{{ $index }}"></button>
                @endforeach
            </div>

            {{-- Navigation Arrows --}}
            <button
                class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-60 hover:bg-opacity-80 text-gray-800 p-3 rounded-full shadow-lg">
                <i class="fas fa-chevron-left text-base"></i>
            </button>
            <button
                class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-60 hover:bg-opacity-80 text-gray-800 p-3 rounded-full shadow-lg">
                <i class="fas fa-chevron-right text-base"></i>
            </button>
        @endif
    </section>
</div>

@push('styles')
    <style>
        .hero-carousel {
            position: relative;
            overflow: hidden;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            display: flex;
            align-items: center;
        }

        .hero-slide.active {
            opacity: 1;
            z-index: 1;
        }

        .hero-slide img {
            object-fit: contain;
            width: 100%;
        }

        .carousel-dot.active {
            background-color: white !important;
        }

        /* Responsive Heights */
        @media (max-width: 640px) {
            .hero-carousel {
                height: 320px;
            }

            .hero-slide img {
                height: 220px;
            }
        }

        @media (min-width: 768px) {
            .hero-carousel {
                height: 420px;
            }

            .hero-slide img {
                height: 350px;
            }
        }

        @media (min-width: 1024px) {
            .hero-carousel {
                height: 600px;
            }

            .hero-slide img {
                height: 500px;
            }
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.hero-slide');
            if (slides.length <= 0) return;

            const dots = document.querySelectorAll('.carousel-dot');
            const prevButton = document.querySelector('.carousel-prev');
            const nextButton = document.querySelector('.carousel-next');

            let currentSlide = 0;
            let slideInterval;

            function showSlide(n) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
                if (dots[currentSlide]) {
                    dots[currentSlide].classList.add('active');
                }
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startSlideShow() {
                // Only start if more than one slide
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 2000);
                }
            }

            function stopSlideShow() {
                clearInterval(slideInterval);
            }

            // Only add event listeners if elements exist
            if (nextButton && slides.length > 1) {
                nextButton.addEventListener('click', () => {
                    stopSlideShow();
                    nextSlide();
                    startSlideShow();
                });
            }

            if (prevButton && slides.length > 1) {
                prevButton.addEventListener('click', () => {
                    stopSlideShow();
                    prevSlide();
                    startSlideShow();
                });
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopSlideShow();
                    showSlide(index);
                    startSlideShow();
                });
            });

            const carousel = document.querySelector('.hero-carousel');
            if (carousel && slides.length > 1) {
                carousel.addEventListener('mouseenter', stopSlideShow);
                carousel.addEventListener('mouseleave', startSlideShow);

                // Touch events for mobile
                let touchStartX = 0;
                let touchEndX = 0;

                carousel.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                carousel.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);

                function handleSwipe() {
                    if (touchEndX < touchStartX - 50) {
                        // Swipe left - next slide
                        stopSlideShow();
                        nextSlide();
                        startSlideShow();
                    }

                    if (touchEndX > touchStartX + 50) {
                        // Swipe right - previous slide
                        stopSlideShow();
                        prevSlide();
                        startSlideShow();
                    }
                }
            }

            showSlide(0);
            startSlideShow();
        });
    </script>
@endpush
