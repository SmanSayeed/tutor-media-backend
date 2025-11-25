  <!-- New Arrivals -->
  <section id="new-arrivals" class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">New Products</h2>
        <a href="{{ route('home') }}#new-arrivals" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
      <template id="product-card">
        <a href="#" class="card group rounded-xl bg-white overflow-hidden">
          <div class="relative aspect-[4/3] bg-slate-100">
            <img class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" src="https://picsum.photos/seed/leather/600/450" alt="product" />
            <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">-25%</span>
          </div>
          <div class="p-4">
            <p class="text-xs text-slate-500">Leather</p>
            <p class="font-semibold line-clamp-2">Classic Formal Shoes For Men</p>
            <div class="mt-2 flex items-center gap-2"><span class="text-amber-700 font-bold">৳2250</span><span class="text-slate-400 line-through">৳2999</span></div>
            <button class="mt-3 w-full inline-flex items-center justify-center rounded-md bg-slate-900 text-white py-2 text-sm font-semibold hover:bg-slate-800">Select options</button>
          </div>
        </a>
      </template>
      <script>
        const pg = document.currentScript.previousElementSibling; for (let i=0;i<5;i++) pg.parentElement.appendChild(pg.content.cloneNode(true));
      </script>
    </div>
  </section>

  <!-- Feature trio (Travel/Executive/Women bag) -->
  <section id="best-items" class="max-w-7xl mx-auto px-4 pb-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">Best Items</h2>
        <a href="{{ route('home') }}#best-items" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1547949003-9792a18a2601?q=80&w=1200&auto=format&fit=crop" alt="Travel Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Travel Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1561344640-2453889cde5b?q=80&w=1200&auto=format&fit=crop" alt="Executive Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Executive Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?q=80&w=1200&auto=format&fit=crop" alt="Women's Bag" />
        <div class="p-4"><h3 class="font-bold text-center mb-4">Women's Bag</h3><button class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded">Order Now</button></div>
      </div>
    </div>
  </section>

  <!-- Just For You -->
  <section id="special-items" class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
      <h2 class="text-xl font-bold w-full">Special Items</h2>
        <a href="{{ route('home') }}#special-items" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
      <template id="pick-card">
        <a href="#" class="card group rounded-xl bg-white overflow-hidden">
          <div class="relative aspect-[4/3] bg-slate-100">
            <img class="h-full w-full object-cover" src="https://picsum.photos/seed/ssb/600/450" alt="pick" />
            <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">-53%</span>
          </div>
          <div class="p-4">
            <p class="font-semibold text-sm line-clamp-2">Luxury Penny Formal Shoes</p>
            <div class="mt-2 flex items-center gap-2"><span class="text-amber-700 font-bold">৳1899</span><span class="text-slate-400 line-through">৳3999</span></div>
            <button class="mt-3 w-full inline-flex items-center justify-center rounded-md bg-slate-900 text-white py-2 text-sm font-semibold hover:bg-slate-800">Select options</button>
          </div>
        </a>
      </template>
      <script>
        const pk = document.currentScript.previousElementSibling; for (let i=0;i<5;i++) pk.parentElement.appendChild(pk.content.cloneNode(true));
      </script>
    </div>
  </section>

  <!-- Customer Reviews (Slider) -->
  <section class="bg-slate-50 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Customer Review</h2>
        <a class="text-sm text-amber-700 hover:underline" href="#">See More</a>
      </div>
      <div class="relative overflow-hidden" id="reviews-viewport">
        <div class="flex gap-6 transition-transform duration-500 ease-in-out" id="reviews-track">
          <div class="card rounded-xl bg-white p-6 w-80 flex-shrink-0">
            <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">5.0</span></div>
            <p class="mt-3 text-sm text-slate-700">“Loved the leather and finishing. Worth every penny!”</p>
            <p class="mt-4 text-xs text-slate-500">— Arafat</p>
          </div>
          <div class="card rounded-xl bg-white p-6 w-80 flex-shrink-0">
            <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">4.5</span></div>
            <p class="mt-3 text-sm text-slate-700">“Bag quality is top‑notch and delivery was fast.”</p>
            <p class="mt-4 text-xs text-slate-500">— Sakib</p>
          </div>
          <div class="card rounded-xl bg-white p-6 w-80 flex-shrink-0">
            <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">5.0</span></div>
            <p class="mt-3 text-sm text-slate-700">“Shoes are comfortable and elegant. Great value!”</p>
            <p class="mt-4 text-xs text-slate-500">— Faruque</p>
          </div>
          <div class="card rounded-xl bg-white p-6 w-80 flex-shrink-0">
            <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">4.8</span></div>
            <p class="mt-3 text-sm text-slate-700">“Excellent craftsmanship on the belt. Feels premium.”</p>
            <p class="mt-4 text-xs text-slate-500">— Mitu</p>
          </div>
        </div>
        <!-- Dots -->
        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
          <button class="w-2 h-2 rounded-full bg-slate-300" data-review-dot="0"></button>
          <button class="w-2 h-2 rounded-full bg-slate-300" data-review-dot="1"></button>
          <button class="w-2 h-2 rounded-full bg-slate-300" data-review-dot="2"></button>
          <button class="w-2 h-2 rounded-full bg-slate-300" data-review-dot="3"></button>
        </div>
      </div>
    </div>
  </section>
  <script>
  // Lightweight review slider showing 3 on desktop, 1 on mobile
  (function(){
    const viewport = document.getElementById('reviews-viewport');
    const track = document.getElementById('reviews-track');
    if (!viewport || !track) return;
    const gap = 24; // gap-6 = 1.5rem = 24px
    let index = 0;
    let cardWidth = 0;
    let visible = 1;
    const dots = Array.from(viewport.querySelectorAll('[data-review-dot]'));

    function measure(){
      const first = track.querySelector('.w-80');
      if (!first) return;
      cardWidth = first.getBoundingClientRect().width;
      visible = Math.max(1, Math.floor(viewport.clientWidth / (cardWidth + gap)));
    }

    function goto(i){
      index = i;
      const translate = -(cardWidth + gap) * index;
      track.style.transform = `translateX(${translate}px)`;
      dots.forEach((d,di)=> d.className = di===index ? 'w-2 h-2 rounded-full bg-slate-800' : 'w-2 h-2 rounded-full bg-slate-300');
    }

    function next(){
      const total = track.children.length;
      const maxIndex = Math.max(0, total - visible);
      index = (index >= maxIndex) ? 0 : index + 1;
      goto(index);
    }

    dots.forEach(d=> d.addEventListener('click', ()=> goto(Number(d.dataset.reviewDot||'0'))));

    measure();
    goto(0);
    let timer = setInterval(next, 4000);
    window.addEventListener('resize', ()=>{ measure(); goto(index); });
    viewport.addEventListener('mouseenter', ()=> clearInterval(timer));
    viewport.addEventListener('mouseleave', ()=> timer = setInterval(next, 4000));
  })();
  </script>