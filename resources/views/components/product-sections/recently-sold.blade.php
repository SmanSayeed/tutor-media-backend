    <!-- Recently Sold -->
<section id="recent" class="section-spacing bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
  <!-- Subtle background pattern -->
  <div class="absolute inset-0 opacity-30">
    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 40px);"></div>
  </div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Section Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 text-center sm:text-left sm:justify-between flex-col sm:flex-row">
      <!-- Title -->
      <div>
        <h2 class="text-h2 text-slate-900 font-bold mb-2">Recently Sold</h2>
        <p class="text-slate-600 text-sm">Products our customers love</p>
      </div>
      
      <!-- Countdown Timer -->
      <div class="flex items-center gap-2 sm:gap-3 flex-wrap bg-white/80 backdrop-blur-sm rounded-xl p-3 sm:p-4 shadow-sm" id="countdown-timer">
        <div class="text-center">
          <div class="text-xl font-bold text-slate-900" id="countdown-days">02</div>
          <div class="text-xs text-slate-500 font-medium">Days</div>
        </div>
        <div class="text-slate-300">:</div>
        <div class="text-center">
          <div class="text-xl font-bold text-slate-900" id="countdown-hours">18</div>
          <div class="text-xs text-slate-500 font-medium">Hours</div>
        </div>
        <div class="text-slate-300">:</div>
        <div class="text-center">
          <div class="text-xl font-bold text-slate-900" id="countdown-minutes">53</div>
          <div class="text-xs text-slate-500 font-medium">Mins</div>
        </div>
        <div class="text-slate-300">:</div>
        <div class="text-center">
          <div class="text-xl font-bold text-slate-900" id="countdown-seconds">14</div>
          <div class="text-xs text-slate-500 font-medium">Secs</div>
        </div>
      </div>
      
      <!-- Navigation Controls -->
      <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
        <button class="w-8 h-8 sm:w-10 sm:h-10 bg-white/80 backdrop-blur-sm hover:bg-white rounded-lg flex items-center justify-center shadow-sm hover:shadow-md transition-all duration-200" onclick="rsPrev()">
          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
        <a href="{{ route('home') }}#recent" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex-1 sm:flex-none flex items-center justify-center whitespace-nowrap text-sm sm:text-base">
          View All
        </a>
        <button class="w-8 h-8 sm:w-10 sm:h-10 bg-white/80 backdrop-blur-sm hover:bg-white rounded-lg flex items-center justify-center shadow-sm hover:shadow-md transition-all duration-200" onclick="rsNext()">
          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Product Carousel -->
    <div class="relative overflow-hidden" id="recently-sold-viewport">
      <div class="flex gap-4 transition-transform duration-300" id="product-carousel">
        @forelse($processedProducts as $productData)
          @php
            $product = $productData['product'];
            $discountPercentage = $productData['discountPercentage'];
            $rating = $productData['rating'];
            $productImage = $productData['productImage'];
          @endphp
          
          <div class="bg-white rounded-xl shadow-sm hover:shadow-xl flex-shrink-0 relative overflow-hidden group transition-all duration-300">
            @if($discountPercentage > 0)
              <!-- Discount Badge -->
              <div class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-2.5 py-1 text-xs font-bold rounded-lg shadow-sm z-10">-{{ $discountPercentage }}%</div>
            @endif
            
            <!-- Product Image -->
            <div class="h-48 bg-slate-50 flex items-center justify-center overflow-hidden">
              <img src="{{ $productImage }}" 
                   alt="{{ $product->name }}" 
                   class="h-40 w-40 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300"
                   loading="lazy">
            </div>
            
            <!-- Product Code -->
            <div class="absolute top-3 right-3 text-xs text-slate-500 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-md">{{ $product->slug }}</div>
            
            <!-- Product Details -->
            <div class="p-5">
              <h3 class="font-semibold text-sm mb-3 text-slate-900 line-clamp-2">{{ $product->name }}</h3>
              
              <!-- Star Rating -->
              <div class="flex items-center mb-3">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= floor($rating))
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @else
                    <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endif
                @endfor
                <span class="text-xs text-slate-500 ml-2 font-medium">{{ $rating }}</span>
              </div>
              
              <!-- Price -->
              <div class="flex items-center space-x-2 mb-4">
                @if($product->sale_price && $product->sale_price < $product->price)
                  <span class="text-red-600 font-bold text-lg">৳{{ number_format($product->sale_price) }}</span>
                  <span class="text-slate-400 line-through text-sm">৳{{ number_format($product->price) }}</span>
                @else
                  <span class="text-red-600 font-bold text-lg">৳{{ number_format($product->price) }}</span>
                @endif
              </div>
              
              <!-- Action Button -->
              <a href="{{ route('products.show', $product->slug) }}" 
                 class="w-full bg-slate-800 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-slate-700 block text-center transition-colors duration-200">
                Select options
              </a>
            </div>
          </div>
        @empty
          <!-- Fallback content when no products are available -->
          <div class="bg-white rounded-lg shadow-lg flex-shrink-0 relative w-full">
            <div class="p-8 text-center">
              <h3 class="text-lg font-semibold text-gray-600 mb-2">No Recently Sold Products</h3>
              <p class="text-gray-500">Check back later for our latest sales!</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
</section>

<script>
// Countdown Timer
const countdownEndTime = new Date('{{ $countdownEndTime->format('Y-m-d H:i:s') }}').getTime();

function updateCountdown() {
  const now = new Date().getTime();
  const distance = countdownEndTime - now;

  if (distance < 0) {
    // Countdown finished
    document.getElementById('countdown-days').textContent = '00';
    document.getElementById('countdown-hours').textContent = '00';
    document.getElementById('countdown-minutes').textContent = '00';
    document.getElementById('countdown-seconds').textContent = '00';
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
  document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
  document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
  document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown(); // Initial call

// Recently Sold carousel: responsive (1/2/4) cyclic slider — no clones
const rsViewport = document.getElementById('recently-sold-viewport');
const rsTrack = document.getElementById('product-carousel');
const rsGap = 16; // Tailwind gap-4
let rsCardWidth = 0;
let rsTimer;
let rsAnimating = false;

function rsVisibleCount() {
  const w = rsViewport ? rsViewport.clientWidth : 0;
  if (w < 640) return 1;      // mobile: single card
  if (w < 1024) return 2;     // tablet: two cards
  return 4;                   // desktop: four cards
}

function rsSetCardWidths() {
  if (!rsViewport || !rsTrack) return;
  const cards = Array.from(rsTrack.children);
  // mark as cards for sizing (kept for compatibility with older code references)
  // cards.forEach(c => c.setAttribute('data-rs-card',''));
  const visible = rsVisibleCount();
  const viewportWidth = rsViewport.clientWidth;
  const width = visible === 1
    ? viewportWidth - 32 // Full width - horizontal padding on mobile
    : Math.max(0, (viewportWidth - rsGap * (visible - 1)) / visible);
  rsCardWidth = width;
  cards.forEach(c => c.style.width = width + 'px');
  // Adjust track padding for mobile
  rsTrack.style.paddingLeft = visible === 1 ? '16px' : '0px';
  rsTrack.style.paddingRight = visible === 1 ? '16px' : '0px';
  // Reset transform after resize to avoid misalignment
  rsTrack.style.transitionDuration = '0ms';
  rsTrack.style.transform = 'translateX(0px)';
}

function rsStepOffset() {
  return rsCardWidth + rsGap;
}

function rsNext() {
  if (rsAnimating) return;
  rsAnimating = true;
  const step = rsStepOffset();
  rsTrack.style.transitionDuration = '300ms';
  rsTrack.style.transform = `translateX(${-step}px)`;

  const onEnd = () => {
    rsTrack.removeEventListener('transitionend', onEnd);
    // Move first card to the end; no clones used
    const first = rsTrack.firstElementChild;
    if (first) rsTrack.appendChild(first);
    // Reset transform without animation
    rsTrack.style.transitionDuration = '0ms';
    rsTrack.style.transform = 'translateX(0px)';
    // Force reflow to apply the non-animated state before allowing next animation
    void rsTrack.offsetWidth; // reflow
    rsAnimating = false;
  };
  rsTrack.addEventListener('transitionend', onEnd);
}

function rsPrev() {
  if (rsAnimating) return;
  rsAnimating = true;
  const step = rsStepOffset();
  // Prepend last card and set starting offset without animation
  const last = rsTrack.lastElementChild;
  if (last) rsTrack.insertBefore(last, rsTrack.firstElementChild);
  rsTrack.style.transitionDuration = '0ms';
  rsTrack.style.transform = `translateX(${-step}px)`;
  // Force reflow, then animate back to 0
  void rsTrack.offsetWidth; // reflow
  rsTrack.style.transitionDuration = '300ms';
  rsTrack.style.transform = 'translateX(0px)';

  const onEnd = () => {
    rsTrack.removeEventListener('transitionend', onEnd);
    rsAnimating = false;
  };
  rsTrack.addEventListener('transitionend', onEnd);
}

function rsStart() {
  clearInterval(rsTimer);
  rsTimer = setInterval(() => rsNext(), 3000);
}

function rsInit() {
  if (!rsViewport || !rsTrack) return;
  rsSetCardWidths();
  rsStart();
}

window.addEventListener('resize', () => { rsSetCardWidths(); });
document.addEventListener('visibilitychange', () => { if (document.hidden) clearInterval(rsTimer); else rsStart(); });

// Initialize after layout
setTimeout(rsInit, 0);
</script>