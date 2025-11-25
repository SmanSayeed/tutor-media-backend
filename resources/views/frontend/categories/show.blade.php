<x-app-layout title="Browse Categories">
    <div class="bg-white">
        <!-- Breadcrumb -->
        <div class="border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @php
                    $breadcrumbItems = [
                        ['label' => 'Home', 'url' => '/'],
                        ['label' => 'Categories', 'url' => '/categories']
                    ];

                    if (isset($subcategory)) {
                        $breadcrumbItems[] = ['label' => $category->name, 'url' => route('categories.show', $category->slug)];
                        $breadcrumbItems[] = ['label' => $subcategory->name];
                    } else {
                        $breadcrumbItems[] = ['label' => $category->name];
                    }
                @endphp

                @include('components.breadcrumb', ['items' => $breadcrumbItems])
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-24">
                        <x-category-sidebar
                            :categories="$categories"
                            :active-category="$activeCategory"
                            :active-subcategory="$activeSubcategory"
                        />
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Category/Subcategory Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    {{ $subcategory->name ?? $category->name }}
                                </h1>
                                @if(($subcategory ?? $category)->description)
                                    <p class="text-gray-600">{{ $subcategory->description ?? $category->description }}</p>
                                @endif
                                <p class="text-sm text-gray-500 mt-2">{{ $products->total() }} products found</p>
                            </div>

                            @php
                                $categoryImagePath = ($subcategory ?? $category)->image;
                                $hasCategoryImage = filled($categoryImagePath);

                                if ($hasCategoryImage && !\Illuminate\Support\Str::startsWith($categoryImagePath, ['http://', 'https://', '//'])) {
                                    $categoryImagePath = asset($categoryImagePath);
                                }
                            @endphp

                            @if($hasCategoryImage)
                                <div class="md:w-32 md:h-32 w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $categoryImagePath }}"
                                         alt="{{ $subcategory->name ?? $category->name }}"
                                         class="w-full h-full object-cover"
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

                    <!-- Subcategories (if viewing a category) -->
                    @if(!isset($subcategory) && $category->subcategories->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Subcategories</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                @foreach($category->subcategories as $subcat)
                                    @php
                                        $imagePath = $subcat->image;
                                        $hasImage = filled($imagePath);

                                        if ($hasImage && !\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '//'])) {
                                            $imagePath = asset($imagePath);
                                        }
                                    @endphp
                                    <a href="{{ route('subcategories.show', [$category->slug, $subcat->slug]) }}"
                                       class="group block bg-white border border-gray-200 rounded-xl p-4 hover:border-amber-400 hover:shadow-md transition-all duration-200">
                                        <div class="w-full h-24 mb-3 rounded-lg overflow-hidden bg-gray-50">
                                            @if($hasImage)
                                                <img src="{{ $imagePath }}" 
                                                     alt="{{ $subcat->name }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                                     onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                            @endif
                                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center {{ $hasImage ? 'hidden' : '' }}">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h3 class="font-medium text-gray-900 text-sm mb-1 group-hover:text-amber-600 transition-colors">{{ $subcat->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $subcat->products_count ?? 0 }} {{ Str::plural('product', $subcat->products_count ?? 0) }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Products Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        @if($products->count() > 0)
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">
                                    {{ isset($subcategory) ? 'Products' : 'Featured Products' }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($products as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($products->hasPages())
                            <div class="mt-8 border-t border-gray-200 pt-6">
                                {{ $products->links() }}
                            </div>
                            @endif
                        @else
                            <!-- No Products Found -->
                            <div class="text-center py-12">
                                <div class="w-24 h-24 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
                                <p class="text-gray-500 mb-6">We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Continue Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
