@props(['allProducts'])

<!-- All Products -->
<section id="all-products" class="max-w-7xl mx-auto px-4 pb-12">
  <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between text-center sm:text-left gap-3 mb-6">
    <h2 class="text-xl font-bold w-full">All Products</h2>
    <a href="{{ route('products.index') }}" class="bg-red-600 text-white px-4 min-h-[40px] py-2 rounded-md font-semibold hover:bg-red-700 w-full sm:w-auto flex items-center justify-center whitespace-nowrap">View All</a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
    @forelse($allProducts as $productData)
      @php
        $product = $productData['product'];
      @endphp

      <x-product-card :product="$product" />
    @empty
      <!-- Fallback content when no products are available -->
      <div class="col-span-full">
        <div class="text-center py-12">
          <h3 class="text-lg font-semibold text-gray-600 mb-2">No Products Available</h3>
          <p class="text-gray-500">Check back soon for our products!</p>
        </div>
      </div>
    @endforelse
  </div>
</section>
