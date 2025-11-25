<x-app-layout title="Browse Subcategories">
    <!-- Breadcrumb -->
    @include('components.breadcrumb', [
        'items' => [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Categories', 'url' => '/categories'],
            ['label' => $category->name, 'url' => route('categories.show', $category->slug)],
            ['label' => $subcategory->name]
        ]
    ])

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Category Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $subcategory->name }}</h1>
                    @if($subcategory->description)
                    <p class="text-gray-600">{{ $subcategory->description }}</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} products found</p>
                </div>

                @php
                    $imagePath = $subcategory->image;
                    $hasImage = filled($imagePath);

                    if ($hasImage && !\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '//'])) {
                        $imagePath = asset($imagePath);
                    }
                @endphp

                @if($hasImage)
                <div class="hidden md:block w-32 h-32 rounded-lg overflow-hidden">
                    <img src="{{ $imagePath }}" alt="{{ $subcategory->name }}" class="w-full h-full object-cover"
                         onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 hidden items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @php
            $subcategoryRoute = route('subcategories.show', [$category->slug, $subcategory->slug]);
            $sharedQueryParams = request()->except(['page']);
            $allProductsParams = request()->except(['child_category', 'page']);
            $buildQuery = static fn (array $params): string => empty($params)
                ? ''
                : '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
            $allProductsUrl = $subcategoryRoute . $buildQuery($allProductsParams);
            $activeChildSlug = request('child_category');
        @endphp

        <div class="lg:hidden mb-6">
            <button type="button" data-mobile-filter-open class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-slate-300 hover:text-slate-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h7" />
                </svg>
                Filters
            </button>
        </div>

        <div class="grid gap-6 lg:gap-10 lg:grid-cols-[minmax(0,280px)_1fr]">
            <aside class="mobile-filter-panel hidden lg:block lg:sticky lg:top-24 self-start" data-mobile-filter-panel>
                <x-sidebar-filteration
                    :action="$subcategoryRoute"
                    :colors="$colors ?? collect()"
                    :sizes="$sizes ?? collect()"
                    :price-range="$priceRange ?? []"
                    :applied="$appliedFilters ?? []"
                />
            </aside>

            <div class="space-y-8 lg:space-y-10">
                @if($subcategory->childCategories && $subcategory->childCategories->count() > 0)
                    <div class="overflow-hidden">
                        <div class="flex flex-wrap items-center gap-3 overflow-x-auto pb-1">
                            <a href="{{ $allProductsUrl }}"
                               class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-medium {{ ! $activeChildSlug ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} transition">
                                All Products
                            </a>
                            @foreach($subcategory->childCategories as $childCategory)
                                @php
                                    $childParams = array_merge($sharedQueryParams, ['child_category' => $childCategory->slug]);
                                    unset($childParams['page']);
                                    $childUrl = $subcategoryRoute . $buildQuery($childParams);
                                @endphp
                                <a href="{{ $childUrl }}"
                                   class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-medium {{ $activeChildSlug === $childCategory->slug ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} transition">
                                    {{ $childCategory->name }}
                                    <span class="text-xs opacity-75">({{ $childCategory->products()->count() }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 lg:gap-7 xl:grid-cols-3 xl:gap-8">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-6">There are no products in this subcategory yet.</p>
                        <a href="{{ route('categories.show', $category->slug) }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                            Browse {{ $category->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="mobile-filter-backdrop hidden lg:hidden" data-mobile-filter-backdrop></div>
    </div>
</x-app-layout>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
