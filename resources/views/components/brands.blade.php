<!-- Brands -->
<section class="bg-white border-y border-slate-100">
  <div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 place-items-center opacity-80">
      @forelse($processedBrands as $brandData)
        @php
          $brand = $brandData['brand'];
          $logoUrl = $brandData['logoUrl'];
          $altText = $brandData['altText'];
        @endphp
        
        <img class="h-6" 
             src="{{ $logoUrl }}" 
             alt="{{ $altText }}"
             loading="lazy" />
      @empty
        <!-- Fallback content when no brands are available -->
        <div class="col-span-full">
          <div class="text-center py-8">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Brands Available</h3>
            <p class="text-gray-500">Brand logos will appear here once they are added.</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
