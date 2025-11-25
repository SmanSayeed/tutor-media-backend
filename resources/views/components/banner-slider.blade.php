@props(['banners'])

@if($banners->isNotEmpty())
<section class="relative overflow-hidden h-64 sm:h-80 lg:h-96 rounded-md my-6">
    <!-- Slider Container -->
    <div class="relative h-full w-full">
        <!-- Banner Slides Container -->
        <div class="flex h-full transition-transform duration-1000 ease-in-out" id="banner-slider-container">
            @foreach($banners as $banner)
                <div class="w-full h-full flex-shrink-0 relative group">
                    <img src="{{ $banner->image_url }}"
                         alt="{{ $banner->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-8 text-white">
                        <div class="max-w-2xl mx-auto text-center">
                            @if($banner->subtitle)
                                <p class="text-lg sm:text-xl font-medium text-emerald-300 mb-2">{{ $banner->subtitle }}</p>
                            @endif
                            <h2 class="text-2xl sm:text-4xl font-bold mb-4">{{ $banner->title }}</h2>
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" 
                                   class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-full hover:bg-emerald-700 transition-colors duration-300">
                                    {{ $banner->button_text }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button id="banner-prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/75 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="banner-next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/75 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Dots Navigation -->
        @if($banners->count() > 1)
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                @foreach($banners as $index => $banner)
                    <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors banner-dot {{ $index === 0 ? 'bg-white' : '' }}" 
                            data-index="{{ $index }}" 
                            aria-label="Go to slide {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('banner-slider-container');
    const slides = container.querySelectorAll('> div');
    const prevBtn = document.getElementById('banner-prev');
    const nextBtn = document.getElementById('banner-next');
    const dots = document.querySelectorAll('.banner-dot');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    let slideInterval;

    function goToSlide(index) {
        if (index < 0) {
            currentSlide = totalSlides - 1;
        } else if (index >= totalSlides) {
            currentSlide = 0;
        } else {
            currentSlide = index;
        }
        
        container.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update active dot
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === currentSlide);
            dot.classList.toggle('bg-white/50', i !== currentSlide);
        });
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
    }

    // Auto slide
    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Event Listeners
    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const slideIndex = parseInt(dot.getAttribute('data-index'));
            stopAutoSlide();
            goToSlide(slideIndex);
            startAutoSlide();
        });
    });

    // Pause on hover
    container.addEventListener('mouseenter', stopAutoSlide);
    container.addEventListener('mouseleave', startAutoSlide);

    // Start auto slide
    if (totalSlides > 1) {
        startAutoSlide();
    }
});
</script>
@endpush
@endif
