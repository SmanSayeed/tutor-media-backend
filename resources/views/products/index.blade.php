<x-app-layout title="All Products">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">All Products</h1>
            <p class="text-gray-600">Discover our complete collection of shoes</p>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search products..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <!-- Sort -->
                <div class="md:w-48">
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($products as $productData)
                @php
                    $product = $productData['product'];
                @endphp

                <x-product-card :product="$product" />
            @empty
                <!-- No products found -->
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Products Found</h3>
                        <p class="text-gray-500">Try adjusting your search or filters.</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            View All Products
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
