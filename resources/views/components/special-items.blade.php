<!-- Special Items -->
<section id="special-items" class="max-w-7xl mx-auto px-4 py-12">
  <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
    <h2 class="text-xl font-bold w-full">Special Items</h2>
    <a href="{{ route('home') }}#special-items" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
  </div>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
    @forelse($processedProducts as $productData)
      @php
        $product = $productData['product'];
        $discountPercentage = $productData['discountPercentage'];
        $rating = $productData['rating'];
        $productImage = $productData['productImage'];
      @endphp
      
      <a href="{{ route('products.show', $product->slug) }}" class="card group rounded-xl bg-white overflow-hidden">
        <div class="relative aspect-[4/3] bg-slate-100">
          <img class="h-full w-full object-cover" 
               src="{{ $productImage }}" 
               alt="{{ $product->name }}"
               loading="lazy" />
          @if($discountPercentage > 0)
            <span class="absolute left-3 top-3 text-[10px] font-bold uppercase tracking-wide bg-rose-600 text-white px-2 py-0.5 rounded">-{{ $discountPercentage }}%</span>
          @endif
        </div>
        <div class="p-4">
          <p class="font-semibold text-sm line-clamp-2">{{ $product->name }}</p>
          <div class="mt-2 flex items-center gap-2">
            @php
              $currentPrice = $product->current_price;
              $isOnSale = $product->isOnSale();
            @endphp
            @if($isOnSale)
              <span class="text-amber-700 font-bold">৳{{ number_format($currentPrice) }}</span>
              <span class="text-slate-400 line-through">৳{{ number_format($product->price) }}</span>
            @else
              <span class="text-amber-700 font-bold">৳{{ number_format($currentPrice) }}</span>
            @endif
          </div>
          <button class="mt-3 w-full inline-flex items-center justify-center rounded-md bg-slate-900 text-white py-2 text-sm font-semibold hover:bg-slate-800">Select options</button>
        </div>
      </a>
    @empty
      <!-- Fallback content when no products are available -->
      <div class="col-span-full">
        <div class="text-center py-12">
          <h3 class="text-lg font-semibold text-gray-600 mb-2">No Special Items Available</h3>
          <p class="text-gray-500">Check back soon for our special offers!</p>
        </div>
      </div>
    @endforelse
  </div>
</section>
