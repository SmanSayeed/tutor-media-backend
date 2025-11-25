<!-- Customer Reviews (Slider) -->
<section class="section-spacing bg-gradient-to-br from-slate-50 to-white relative overflow-hidden">
  <!-- Subtle background pattern -->
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.1) 1px, transparent 0); background-size: 20px 20px;"></div>
  </div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Section Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 text-center sm:text-left">
      <div>
        <h2 class="text-h2 text-slate-900 font-bold mb-2">Customer Reviews</h2>
        <p class="text-slate-600 text-sm">What our customers say about us</p>
      </div>
      <a class="inline-flex items-center text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors duration-200" href="#">
        <span>See All Reviews</span>
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
    <!-- Reviews Slider -->
    <div class="relative overflow-hidden rounded-2xl" id="reviews-viewport">
      <div class="flex gap-6 transition-transform duration-500 ease-in-out" id="reviews-track">
        @forelse($processedReviews as $index => $reviewData)
          <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl flex-shrink-0 w-80 sm:w-96 transition-all duration-300 group">
            <!-- Review Card Header -->
            <div class="p-6 pb-4">
              <!-- Rating Stars -->
              <div class="flex items-center gap-2 mb-4">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= floor($reviewData['rating']))
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @else
                    <svg class="w-5 h-5 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endif
                @endfor
                <span class="text-sm font-medium text-slate-600 ml-1">{{ $reviewData['rating'] }}</span>
              </div>
              
              <!-- Review Comment -->
              <blockquote class="text-slate-700 leading-relaxed mb-4">
                <p class="text-sm sm:text-base">"{{ $reviewData['comment'] }}"</p>
              </blockquote>
            </div>
            
            <!-- Review Card Footer -->
            <div class="px-6 pb-6 pt-2 border-t border-slate-100">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <!-- Customer Avatar -->
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm font-semibold">
                      {{ strtoupper(substr($reviewData['customerName'], 0, 1)) }}
                    </span>
                  </div>
                  <div>
                    <p class="font-semibold text-slate-900 text-sm">{{ $reviewData['customerName'] }}</p>
                    <p class="text-xs text-slate-500">{{ $reviewData['productName'] }}</p>
                  </div>
                </div>
                
                <!-- Quote Icon -->
                <div class="text-slate-200 group-hover:text-amber-300 transition-colors duration-200">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        @empty
          <!-- Fallback content when no reviews are available -->
          <div class="w-80 sm:w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
              <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-slate-900 mb-2">No Reviews Yet</h3>
              <p class="text-sm text-slate-600">Be the first to share your experience with our products!</p>
            </div>
          </div>
        @endforelse
      </div>
      
      <!-- Navigation Controls -->
      @if($processedReviews->count() > 0)
        <div class="flex items-center justify-center gap-4 mt-8">
          <!-- Previous Button -->
          <button class="w-10 h-10 bg-white/80 backdrop-blur-sm hover:bg-white rounded-lg flex items-center justify-center shadow-sm hover:shadow-md transition-all duration-200" id="reviews-prev">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          
          <!-- Dots Indicator -->
          <div class="flex gap-2">
            @for($i = 0; $i < $processedReviews->count(); $i++)
              <button class="w-2 h-2 rounded-full transition-all duration-200 {{ $i === 0 ? 'bg-slate-800 w-6' : 'bg-slate-300 hover:bg-slate-400' }}" data-review-dot="{{ $i }}"></button>
            @endfor
          </div>
          
          <!-- Next Button -->
          <button class="w-10 h-10 bg-white/80 backdrop-blur-sm hover:bg-white rounded-lg flex items-center justify-center shadow-sm hover:shadow-md transition-all duration-200" id="reviews-next">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      @endif
    </div>
  </div>
</section>

<script>
// Enhanced review slider with modern interactions
(function(){
  const viewport = document.getElementById('reviews-viewport');
  const track = document.getElementById('reviews-track');
  const prevBtn = document.getElementById('reviews-prev');
  const nextBtn = document.getElementById('reviews-next');
  
  if (!viewport || !track) return;
  
  const gap = 24; // gap-6 = 1.5rem = 24px
  let index = 0;
  let cardWidth = 0;
  let visible = 1;
  let isAnimating = false;
  let autoplayTimer = null;
  
  const dots = Array.from(viewport.querySelectorAll('[data-review-dot]'));

  function measure(){
    const first = track.querySelector('.w-80, .w-96');
    if (!first) return;
    cardWidth = first.getBoundingClientRect().width;
    visible = Math.max(1, Math.floor(viewport.clientWidth / (cardWidth + gap)));
  }

  function updateDots(){
    dots.forEach((d, di) => {
      if (di === index) {
        d.className = 'w-6 h-2 rounded-full bg-slate-800 transition-all duration-200';
      } else {
        d.className = 'w-2 h-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all duration-200';
      }
    });
  }

  function goto(i, animate = true){
    if (isAnimating) return;
    
    const total = track.children.length;
    const maxIndex = Math.max(0, total - visible);
    
    // Handle infinite loop
    if (i < 0) i = maxIndex;
    if (i > maxIndex) i = 0;
    
    index = i;
    const translate = -(cardWidth + gap) * index;
    
    if (animate) {
      isAnimating = true;
      track.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
      track.style.transform = `translateX(${translate}px)`;
      
      setTimeout(() => {
        isAnimating = false;
      }, 500);
    } else {
      track.style.transition = 'none';
      track.style.transform = `translateX(${translate}px)`;
    }
    
    updateDots();
  }

  function next(){
    goto(index + 1);
  }

  function prev(){
    goto(index - 1);
  }

  function startAutoplay(){
    if (autoplayTimer) clearInterval(autoplayTimer);
    autoplayTimer = setInterval(next, 5000);
  }

  function stopAutoplay(){
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  // Event listeners
  if (prevBtn) prevBtn.addEventListener('click', prev);
  if (nextBtn) nextBtn.addEventListener('click', next);
  
  dots.forEach(d => d.addEventListener('click', () => goto(Number(d.dataset.reviewDot || '0'))));

  // Touch/swipe support
  let startX = 0;
  let startY = 0;
  let isDragging = false;

  viewport.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
    isDragging = true;
    stopAutoplay();
  });

  viewport.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
  });

  viewport.addEventListener('touchend', (e) => {
    if (!isDragging) return;
    
    const endX = e.changedTouches[0].clientX;
    const endY = e.changedTouches[0].clientY;
    const diffX = startX - endX;
    const diffY = startY - endY;
    
    // Only trigger if horizontal swipe is more significant than vertical
    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
      if (diffX > 0) {
        next();
      } else {
        prev();
      }
    }
    
    isDragging = false;
    startAutoplay();
  });

  // Mouse events for desktop
  viewport.addEventListener('mouseenter', stopAutoplay);
  viewport.addEventListener('mouseleave', startAutoplay);

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.target.closest('#reviews-viewport')) {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        prev();
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        next();
      }
    }
  });

  // Initialize
  measure();
  goto(0, false);
  startAutoplay();
  
  // Handle resize
  window.addEventListener('resize', () => {
    measure();
    goto(index, false);
  });
})();
</script>
