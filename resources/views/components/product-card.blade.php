@props(['product'])

@if($product)
<div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-lg overflow-hidden transition-all duration-300 border border-gray-100 hover:border-gray-200 h-full flex flex-col">
    <!-- Product Image Container -->
    <div class="relative w-full h-48 bg-gray-50 overflow-hidden flex-shrink-0">
        @php
            $productImage = $product->main_image
                ?? ($product->images?->first()?->image_path ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop');
            $hasDiscount = $product->isOnSale();
            $discountPercentage = $hasDiscount && $product->price > 0
                ? max(0, (int) round((($product->price - $product->current_price) / $product->price) * 100))
                : null;
            $rating = $product->rating ? number_format($product->rating, 1) : 4.5;
        @endphp

        <!-- Discount Badge -->
        @if($discountPercentage)
            <div class="absolute top-3 left-3 z-10">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500 text-white shadow-sm">
                    -{{ $discountPercentage }}%
                </span>
            </div>
        @endif

        <!-- Product Image -->
        <img src="{{ asset($productImage) }}"
             alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             loading="lazy">
    </div>

    <!-- Product Details -->
    <div class="p-4 flex-1 flex flex-col">
        <!-- Category -->
        <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
            {{ $product->category->name ?? 'Product' }}
        </div>

        <!-- Product Name -->
        <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 leading-tight mb-3 flex-1">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600 transition-colors duration-200">
                {{ $product->name }}
            </a>
        </h3>

        <!-- Star Rating -->
        <div class="flex items-center gap-2 mb-3">
            <div class="flex items-center gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($rating))
                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endif
                @endfor
            </div>
            <span class="text-sm text-gray-600 font-medium">({{ $rating }})</span>
        </div>

        <!-- Price Section -->
        <div class="flex flex-col mb-4">
            @php
                $currentPrice = $product->current_price;
            @endphp
            @if($hasDiscount)
                <span class="text-lg font-bold text-red-600">৳{{ number_format($currentPrice) }}</span>
                <span class="text-sm text-gray-500 line-through">৳{{ number_format($product->price) }}</span>
            @else
                <span class="text-lg font-bold text-gray-900">৳{{ number_format($currentPrice) }}</span>
            @endif
        </div>

        <!-- View Details Button -->
        <div class="mt-auto">
            <a href="{{ route('products.show', $product->slug) }}"
               class="w-full bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-4 rounded-lg font-medium text-sm text-center transition-colors duration-200 inline-block">
                View Details
            </a>
        </div>
    </div>
</div>
@else
<div class="bg-gray-100 rounded-2xl p-4 text-center text-gray-500">
    Product not available
</div>
@endif

{{--
    This is a more detailed product card that was in the product/show.blade.php.
    It seems you want a reusable product card for listings. I've created a simpler one above.
    If you intended to componentize the product purchase details block, you can use the code below
    in a different component, for example, `product-purchase-details.blade.php`.
--}}

{{--
<div>
    <h1 id="product-title" class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
    <div class="flex items-center space-x-4">
        @php
            $currentPrice = $product->current_price;
            $hasDiscount = $product->isOnSale();
        @endphp
        <span id="product-price"
            class="text-2xl font-bold text-amber-600">৳{{ number_format($currentPrice) }}</span>
        @if($hasDiscount)
            <span id="original-price"
                class="text-lg text-gray-500 line-through">৳{{ number_format($product->price) }}</span>
            <span id="discount-badge"
                class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded">-{{ $product->discount_percentage }}%</span>
        @else
            <span id="original-price" class="text-lg text-gray-500 line-through hidden">৳0</span>
            <span id="discount-badge"
                class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded hidden">-0%</span>
        @endif
    </div>
</div>

<!-- Stock Status -->
<div class="border-t pt-6 space-y-2 text-sm text-gray-600">
    <div><strong>SKU:</strong> <span id="product-sku">{{ $product->sku }}</span></div>
    <div><strong>Color:</strong> <span>{{ $product?->color?->name }}</span></div>
    <div><strong>Availability:</strong>
        @if($product->isInStock())
            <span id="stock-status" class="text-green-600">In Stock</span>
        @else
            <span id="stock-status" class="text-red-600">Out of Stock</span>
        @endif
    </div>
    <div><strong>Category:</strong> <span
            id="product-category">{{ $product->category->name ?? 'N/A' }}</span></div>
    @if($product->brand)
        <div><strong>Brand:</strong> {{ $product->brand->name }}</div>
    @endif
</div>

<!-- Quantity and Actions -->
<div class="space-y-4">
    <!-- ... quantity and buttons ... -->
</div>
--}}
