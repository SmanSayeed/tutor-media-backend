@props(['banners'])

<!-- Hero area with desktop category sidebar -->
<section class="max-w-7xl mx-auto px-4 mt-3">
  <div class="grid lg:grid-cols-12 gap-4">
    <!-- Left: Category Sidebar (desktop only) -->
    <x-category-sidebar :activeCategory="request()->route('category')?->id"
                       :activeSubcategory="request()->route('subcategory')?->id" />

    <!-- Right: Hero Slider -->
    <div class="lg:col-span-9">
      <!-- Hero Slider -->
      <section class="relative overflow-hidden h-64 sm:h-80 lg:h-96 rounded-md">
        <!-- Slider Container -->
        <div class="relative h-full w-full">
          <!-- Image Slides Container -->
          <div class="flex h-full transition-transform duration-1000 ease-in-out" id="slider-container">
            @forelse($banners as $banner)
              <div class="w-full h-full flex-shrink-0 relative group">
                <img src="{{ $banner->image }}"
                     alt="{{ $banner->title }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                  <div class="text-center text-white px-4 max-w-3xl mx-auto">
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
            @empty
              <!-- Fallback content if no banners -->
              <div class="w-full h-full flex-shrink-0 bg-gradient-to-r from-blue-500 to-emerald-500 flex items-center justify-center">
                <div class="text-center text-white px-4">
                  <h2 class="text-2xl sm:text-4xl font-bold mb-4">Welcome to Our Store</h2>
                  <p class="text-lg mb-6">Discover amazing deals on the latest products</p>
                  <a href="{{ route('products.index') }}" 
                     class="inline-flex items-center px-6 py-3 bg-white text-emerald-600 rounded-full font-medium hover:bg-gray-100 transition-colors duration-300">
                    Shop Now
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </a>
                </div>
              </div>
            @endforelse
          </div>
        </div>

        @if($banners->count() > 1)
          <!-- Slider Indicators -->
          <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
            @foreach($banners as $index => $banner)
              <button
                class="w-2 h-2 rounded-full transition-all duration-300 {{ $loop->first ? 'w-3 h-3 bg-white opacity-100' : 'bg-gray-600 opacity-60' }}"
                onclick="goToSlide({{ $index }})"
                aria-label="Go to slide {{ $index + 1 }}">
              </button>
            @endforeach
          </div>

          <!-- Navigation Arrows -->
          <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition-colors duration-300 z-10" 
                  onclick="prevSlide()" 
                  aria-label="Previous slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition-colors duration-300 z-10" 
                  onclick="nextSlide()" 
                  aria-label="Next slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        @endif
      </section>
    </div>
  </div>
</section>

<script>
let currentSlide = 0;
const totalSlides = {{ $banners->count() }};
const sliderContainer = document.getElementById('slider-container');
let autoSlideInterval;

function goToSlide(slideIndex) {
  currentSlide = slideIndex;
  const translateX = -slideIndex * 100;
  sliderContainer.style.transform = `translateX(${translateX}%)`;

  // Update indicators
  const indicators = document.querySelectorAll('[onclick^="goToSlide"]');
  indicators.forEach((indicator, index) => {
    if (index === slideIndex) {
      indicator.className = 'w-3 h-3 bg-white rounded-full opacity-100 transition-opacity duration-300';
    } else {
      indicator.className = 'w-2 h-2 bg-gray-600 rounded-full opacity-60 transition-opacity duration-300';
    }
  });

  // Reset auto-slide timer
  resetAutoSlide();
}

function prevSlide() {
  currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
  goToSlide(currentSlide);
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % totalSlides;
  goToSlide(currentSlide);
}

function resetAutoSlide() {
  clearInterval(autoSlideInterval);
  if (totalSlides > 1) {
    autoSlideInterval = setInterval(nextSlide, 5000);
  }
}

// Initialize auto-slide
resetAutoSlide();
</script>
