@props(['popularProducts'])

<!-- Popular Products -->
<section id="popular-products" class="max-w-7xl mx-auto px-4 pb-12">
  <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
    <h2 class="text-xl font-bold w-full">Popular Products</h2>
    <a href="{{ route('home') }}#popular-products" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
    @forelse($popularProducts as $productData)
      @php
        $product = $productData['product'];
        $discountPercentage = $productData['discountPercentage'];
        $rating = $productData['rating'];
        $productImage = $productData['productImage'];
      @endphp
      
      <div class="card rounded-xl overflow-hidden">
        <img class="w-full h-64 object-cover" 
             src="{{ $productImage }}" 
             alt="{{ $product->name }}"
             loading="lazy" />
        <div class="p-4">
          <h3 class="font-bold text-center mb-2">{{ $product->name }}</h3>
          <div class="text-center mb-3">
            @php
              $currentPrice = $product->current_price;
              $isOnSale = $product->isOnSale();
            @endphp
            @if($isOnSale)
              <span class="text-amber-700 font-bold text-lg">৳{{ number_format($currentPrice) }}</span>
              <span class="text-slate-400 line-through text-sm ml-2">৳{{ number_format($product->price) }}</span>
            @else
              <span class="text-amber-700 font-bold text-lg">৳{{ number_format($currentPrice) }}</span>
            @endif
          </div>
          <a href="{{ route('products.show', $product->slug) }}" 
             class="w-full bg-slate-900 hover:bg-slate-800 text-white py-2 rounded block text-center">
            Order Now
          </a>
        </div>
      </div>
    @empty
      <!-- Fallback content when no products are available -->
      <div class="col-span-full">
        <div class="text-center py-12">
          <h3 class="text-lg font-semibold text-gray-600 mb-2">No Popular Products Available</h3>
          <p class="text-gray-500">Check back soon for our popular products!</p>
        </div>
      </div>
    @endforelse
  </div>
</section>
