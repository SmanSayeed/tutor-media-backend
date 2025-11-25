<x-app-layout title="Search Results">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Search results</p>
                <h1 class="text-3xl font-bold text-slate-900">“{{ $term }}”</h1>
                <p class="mt-2 text-sm text-slate-600">{{ $products->total() }} product{{ $products->total() === 1 ? '' : 's' }} found</p>
            </div>

            <form action="{{ route('products.search') }}" method="GET" class="w-full md:w-80">
                <div class="relative">
                    <input
                        type="search"
                        name="q"
                        value="{{ $term }}"
                        placeholder="Search again..."
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"
                        required
                    >
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Search
                    </button>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white border border-slate-100 rounded-xl p-10 text-center">
                <h2 class="text-xl font-semibold text-slate-900 mb-2">No products found</h2>
                <p class="text-slate-500 mb-6">We couldn’t find any items matching “{{ $term }}”. Try a different keyword or check your spelling.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-5 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                    Back to Home
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
