<x-app-layout title="Popular Products">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Popular Products</h1>
            <p class="text-gray-600">Discover our best-selling shoes loved by customers</p>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('products.popular') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search popular products..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <!-- Sort -->
                <div class="md:w-48">
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="sales_count" {{ request('sort') == 'sales_count' ? 'selected' : '' }}>Best Sellers</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Most Popular</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
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

                <div class="relative">
                    <div class="absolute top-3 left-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-2.5 py-1 text-xs font-bold rounded-lg shadow-sm z-10">
                        Popular
                    </div>
                    <x-product-card :product="$product" />
                </div>
            @empty
                <!-- No popular products found -->
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Popular Products Found</h3>
                        <p class="text-gray-500">Check back soon for our best-selling items!</p>
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
