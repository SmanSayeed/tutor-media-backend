  <!-- Recently Sold -->
  <section id="recent" class="border-t border-slate-100 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold">Recently Sold</h2>
        <a href="{{ route('home') }}#recent" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
      </div>
      <div class="overflow-x-auto">
        <div class="flex gap-4 min-w-max">
          <template id="recent-card">
            <a href="#" class="card bg-white rounded-lg w-56 shrink-0">
              <div class="aspect-square rounded-t-lg bg-slate-100 overflow-hidden">
                <img class="h-full w-full object-cover" src="https://picsum.photos/seed/wallet/400/400" alt="Wallet" />
              </div>
              <div class="p-3">
                <p class="text-xs text-slate-500">Wallet</p>
                <p class="font-semibold truncate">Bifold Leather Wallet</p>
                <div class="mt-1 flex items-center gap-2 text-sm">
                  <span class="font-bold text-amber-700">৳650</span>
                  <span class="text-slate-400 line-through">৳850</span>
                </div>
              </div>
            </a>
          </template>
          <script>
            const rc = document.currentScript.previousElementSibling; for (let i=0;i<8;i++) rc.parentElement.appendChild(rc.content.cloneNode(true));
          </script>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories -->
  <section id="categories" class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br from-rose-100 to-rose-200 p-6" href="#"><h3 class="font-bold text-xl">Men Shoes</h3><p class="text-sm text-slate-600">Oxfords · Loafers</p><img class="absolute bottom-0 right-2 w-28 opacity-90 group-hover:translate-y-1 transition" src="https://images.unsplash.com/photo-1542060748-10c28b62716f?q=80&w=500&auto=format&fit=crop" alt="shoes" /></a>
      <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br from-amber-100 to-amber-200 p-6" href="#"><h3 class="font-bold text-xl">Office Bags</h3><p class="text-sm text-slate-600">Totes · Messenger</p><img class="absolute bottom-0 right-2 w-28 opacity-90 group-hover:translate-y-1 transition" src="https://images.unsplash.com/photo-1520975916090-3105956dac38?q=80&w=500&auto=format&fit=crop" alt="bag" /></a>
      <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br from-sky-100 to-sky-200 p-6" href="#"><h3 class="font-bold text-xl">Belts</h3><p class="text-sm text-slate-600">Formal · Casual</p><img class="absolute bottom-0 right-2 w-28 rotate-6 opacity-90 group-hover:translate-y-1 transition" src="https://images.unsplash.com/photo-1578898887932-2b2bbd903586?q=80&w=500&auto=format&fit=crop" alt="belt" /></a>
      <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br from-emerald-100 to-emerald-200 p-6" href="#"><h3 class="font-bold text-xl">Wallets</h3><p class="text-sm text-slate-600">Minimal · RFID</p><img class="absolute bottom-0 right-2 w-28 opacity-90 group-hover:translate-y-1 transition" src="https://images.unsplash.com/photo-1591375275159-95f21d67f113?q=80&w=500&auto=format&fit=crop" alt="wallet" /></a>
    </div>
  </section>

  <!-- Brands -->
  <section class="bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6 place-items-center opacity-80">
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=SSB" alt="brand" />
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=ANJ" alt="brand" />
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=SLICK" alt="brand" />
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=MONFIA" alt="brand" />
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=LEAF" alt="brand" />
        <img class="h-6" src="https://dummyimage.com/120x24/ddd/000&text=RND" alt="brand" />
      </div>
    </div>
  </section>

  <!-- New Arrivals -->
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-bold">New Products</h2>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
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
  <section class="max-w-7xl mx-auto px-4 pb-12">
    <div class="grid md:grid-cols-3 gap-6 items-stretch">
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
  <section class="max-w-7xl mx-auto px-4 py-12">
    <h2 class="text-xl font-bold text-center mb-6">Just For You</h2>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
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

  <!-- Customer Reviews -->
  <section class="bg-slate-50 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Customer Review</h2>
        <a class="text-sm text-amber-700 hover:underline" href="#">See More</a>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="card rounded-xl bg-white p-6">
          <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">5.0</span></div>
          <p class="mt-3 text-sm text-slate-700">“Loved the leather and finishing. Worth every penny!”</p>
          <p class="mt-4 text-xs text-slate-500">— Arafat</p>
        </div>
        <div class="card rounded-xl bg-white p-6">
          <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">4.5</span></div>
          <p class="mt-3 text-sm text-slate-700">“Bag quality is top‑notch and delivery was fast.”</p>
          <p class="mt-4 text-xs text-slate-500">— Sakib</p>
        </div>
        <div class="card rounded-xl bg-white p-6">
          <div class="flex items-center gap-2 text-amber-500"><i class="fa-solid fa-star text-sm"></i><span class="text-xs text-slate-600">5.0</span></div>
          <p class="mt-3 text-sm text-slate-700">“Shoes are comfortable and elegant. Great value!”</p>
          <p class="mt-4 text-xs text-slate-500">— Faruque</p>
        </div>
      </div>
    </div>
  </section>
