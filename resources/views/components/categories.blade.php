<!-- Categories -->
<section id="categories" class="max-w-7xl mx-auto px-4 py-12">
  <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($processedCategories as $categoryData)
      @php
        $category = $categoryData['category'];
        $image = $categoryData['image'];
        $subcategoryText = $categoryData['subcategoryText'];
        $gradientClass = $categoryData['gradientClass'];
      @endphp
      
      <a class="card group rounded-xl overflow-hidden relative bg-gradient-to-br {{ $gradientClass }} p-6" 
         href="{{ route('categories.show', $category->slug) }}">
        <h3 class="font-bold text-xl">{{ $category->name }}</h3>
        <p class="text-sm text-slate-600">{{ $subcategoryText }}</p>
        <img class="absolute bottom-0 right-2 w-28 opacity-90 group-hover:translate-y-1 transition" 
             src="{{ $image }}" 
             alt="{{ $category->name }}"
             loading="lazy" />
      </a>
    @empty
      <!-- Fallback content when no categories are available -->
      <div class="col-span-full">
        <div class="text-center py-12">
          <h3 class="text-lg font-semibold text-gray-600 mb-2">No Categories Available</h3>
          <p class="text-gray-500">Categories will appear here once they are added.</p>
        </div>
      </div>
    @endforelse
  </div>
</section>
