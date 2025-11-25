<aside class="hidden lg:block lg:col-span-3">
  <div class="bg-white rounded-md border border-emerald-200 overflow-hidden">
    <!-- Sidebar Header -->
    <div class="bg-black text-white font-semibold px-3 py-2">
      Categories
    </div>
    <!-- Category List -->
    <nav class="max-h-[380px] overflow-auto p-2">
      <ul class="space-y-1 text-sm">
        @forelse($categories as $category)
          <li x-data="{ open: {{ $category->id == $activeCategory ? 'true' : 'false' }} }">
            <a href="{{ route('categories.show', $category->slug) }}"
               class="flex items-center justify-between px-2 py-2 rounded-md hover:bg-emerald-50 {{ $category->id == $activeCategory ? 'bg-emerald-50 text-emerald-700 font-medium' : 'text-gray-700' }}">
              <span>{{ $category->name }}</span>
              @if($category->subcategories->count() > 0)
                <button @click.prevent="open = !open" class="text-gray-400 hover:text-emerald-500">
                  <svg class="w-4 h-4 transition-transform duration-200"
                       :class="{ 'rotate-90': open }"
                       fill="none"
                       stroke="currentColor"
                       viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </button>
              @endif
            </a>

            @if($category->subcategories->count() > 0)
              <ul x-show="open"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-y-1"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 -translate-y-1"
                  class="pl-4 mt-1 space-y-1">
                @foreach($category->subcategories as $subcategory)
                  <li>
                    <a href="{{ route('subcategories.show', [$category->slug, $subcategory->slug]) }}"
                       class="flex items-center px-2 py-1.5 text-sm rounded-md hover:bg-emerald-50 {{ $subcategory->id == $activeSubcategory ? 'text-emerald-700 font-medium' : 'text-gray-600' }}">
                      {{ $subcategory->name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @empty
          <li class="px-2 py-4 text-center text-gray-500">
            No categories available
          </li>
        @endforelse
      </ul>
    </nav>
  </div>
</aside>
