<x-app-layout title="Browse Categories">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Category header and pill label -->
        <div class="flex flex-col sm:flex-row items-center justify-between text-center sm:text-left gap-4 mb-10">
            <div class="w-full">
                <span class="inline-flex items-center bg-black text-white font-semibold px-3 py-2 rounded-md uppercase tracking-wide text-xs">Categories</span>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="mt-2 text-slate-600">{{ $category->description }}</p>
                @endif
                <p class="mt-4 text-sm text-slate-500">{{ $products->total() }} products found in this category</p>
            </div>
        </div>

        <div class="lg:hidden mb-6">
            <button type="button" data-mobile-filter-open class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-slate-300 hover:text-slate-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h7" />
                </svg>
                Filters
            </button>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
            <aside class="mobile-filter-panel hidden lg:block lg:sticky lg:top-24 self-start" data-mobile-filter-panel>
                <x-sidebar-filteration
                    :action="route('categories.show', $category->slug)"
                    :colors="$colors ?? collect()"
                    :sizes="$sizes ?? collect()"
                    :price-range="$priceRange ?? []"
                    :applied="$appliedFilters ?? []"
                />
            </aside>

            <div>
                @if($products->count() > 0)
                    <!-- Product cards grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty state when no products exist -->
                    <div class="bg-white border border-slate-100 rounded-xl p-10 text-center">
                        <h2 class="text-xl font-semibold text-slate-900 mb-2">No products found</h2>
                        <p class="text-slate-500 mb-5">We could not find any products under this category yet.</p>
                        <a
                            href="{{ route('home') }}"
                            class="inline-block bg-amber-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-amber-700 transition"
                        >
                            Back to Home
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="mobile-filter-backdrop hidden lg:hidden" data-mobile-filter-backdrop></div>
    </div>
</x-app-layout>
