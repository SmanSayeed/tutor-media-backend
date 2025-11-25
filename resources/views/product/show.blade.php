<x-app-layout title="Product Details">
    <!-- Product Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Product Images -->
            <div class="space-y-4">
                @php
                    $resolveImageUrl = function ($path) {
                        if (! $path) {
                            return null;
                        }
                        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])
                            ? $path
                            : asset($path);
                    };
                    $rawMainImage = $product->main_image
                        ?? $product->images->first()->image_path
                        ?? 'https://images.unsplash.com/photo-1603796847227-9183fd69e884';
                    $mainImage = $resolveImageUrl($rawMainImage);
                @endphp
                <div class="product-image bg-white rounded-lg overflow-hidden shadow-sm">
                    <img id="main-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>
                @if($product->images && $product->images->count() > 1)
                    <div id="thumbnail-grid" class="grid grid-cols-4 gap-2">
                        @foreach($product->images->take(4) as $image)
                            <div
                                class="product-image bg-white rounded cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition">
                                @php
                                    $thumbUrl = $resolveImageUrl($image->image_path);
                                @endphp
                                <img src="{{ $thumbUrl }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover" onclick="changeMainImage('{{ $thumbUrl }}')">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
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

                <!-- Product Variants -->
                @php
                    $variantsWithSize = $product->variants->filter(function ($variant) {
                        return $variant->size_id !== null && $variant->stock_quantity > 0;
                    });
                    $availableSizes = $variantsWithSize->unique('size_id')->sortBy(function ($variant) {
                        return $variant->size ? $variant->size->name : '';
                    });
                    $firstSize = $availableSizes->first();
                @endphp
                @if($variantsWithSize->count() > 0)
                                <div id="product-variants" class="space-y-4">
                                    <!-- Variants data for JavaScript -->
                                     <script>
                                         window.productVariants = {!! json_encode($product->variants->filter(function ($variant) {
                         return $variant->size_id !== null &&
                             $variant->stock_quantity > 0;
                     })->map(function ($variant) use ($product) {
                         return [
                             'id' => $variant->id,
                             'size_id' => $variant->size_id,
                             'size_name' => $variant->size ? $variant->size->name : 'Unknown',
                             'price' => (float) $product->current_price,
                             'stock' => (int) $variant->stock_quantity,
                             'sku' => $product->sku,
                         ];
                     })->values()->toArray(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!};
                                     </script>

                                    <div class="space-y-4">
                                        <label class="text-sm font-medium text-gray-700">Select Size:</label>
                                        <div class="flex flex-wrap gap-2" id="size-buttons">
                                            @foreach($availableSizes as $index => $variant)
                                                @php
                                                    $sizeStock = $variantsWithSize->where('size_id', $variant->size_id)->sum('stock_quantity');
                                                @endphp
                                                @php
                                                    $sizeName = $variant->size ? addslashes($variant->size->name) : 'Unknown';
                                                    $sizeId = $variant->size ? $variant->size->id : 0;
                                                @endphp
                                                <button
                                                    class="size-btn px-4 py-2 border rounded hover:border-amber-600  transition {{ $index === 0 ? 'bg-amber-600 text-white border-amber-600' : '' }}"
                                                    data-size-id="{{ $sizeId }}"
                                                    data-size-name="{{ $sizeName }}"
                                                    data-stock="{{ $sizeStock }}"
                                                    onclick="selectSize('{{ $sizeId }}', '{{ $sizeName }}', {{ $sizeStock }})">
                                                    {{ $sizeName }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Color Selection -->
                                    <div id="color-selection" class="space-y-4 hidden">
                                        <label class="text-sm font-medium text-gray-700">Select Color:</label>
                                        <div class="flex flex-wrap gap-2" id="color-buttons"></div>
                                    </div>

                                    <!-- Selected variant info -->
                                    <div id="selected-variant" class="hidden">
                                        <div class="text-sm text-gray-600">
                                            Selected: <span id="selected-info" class="font-medium text-gray-900"></span>
                                        </div>
                                    </div>
                                </div>
                @endif

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
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700">Quantity:</label>
                        <div class="flex items-center border rounded">
                            <button id="qty-minus" class="px-3 py-2 hover:bg-gray-100">-</button>
                            <input id="quantity" type="number" value="1" min="1"
                                class="w-16 text-center border-0 focus:ring-0">
                            <button id="qty-plus" class="px-3 py-2 hover:bg-gray-100">+</button>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button id="add-to-cart"
                            class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition">
                            Add to Cart
                        </button>
                        <button id="buy-now"
                            class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-800 transition">
                            Buy Now
                        </button>
                    </div>
                </div>

                <!-- YouTube Video -->
                @if($product->video_url)
                            @php
                                // Extract video ID from YouTube URL
                                $videoId = null;
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $product->video_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if($videoId)
                                <div class="mb-8">
                                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                        <iframe
                                            src="https://www.youtube.com/embed/{{ $videoId }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            class="w-full h-full">
                                        </iframe>
                                    </div>
                                </div>
                            @endif
                        @endif

                <!-- Product Tabs -->
                <div class="mt-16">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8">
                            <button
                                class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium active"
                                data-tab="description">
                                Description
                            </button>
                            @if($product->specifications)
                                <button
                                    class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium"
                                    data-tab="specifications">
                                    Specifications
                                </button>
                            @endif
                            @if($product->reviews && $product->reviews->count() > 0)
                                <button
                                    class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium"
                                    data-tab="reviews">
                                    Reviews ({{ $product->reviews->count() }})
                                </button>
                            @endif
                        </nav>
                    </div>

                    <div class="py-8">


                        <!-- Description Tab -->
                        <div id="description" class="tab-content active">
                            <div class="prose max-w-none">
                                <div id="product-description">
                                    @if($product->description)
                                        {!! nl2br(e($product->description)) !!}
                                    @elseif($product->short_description)
                                        {!! nl2br(e($product->short_description)) !!}
                                    @else
                                        <p class="text-gray-500">No description available for this product.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        @if($product->specifications)
                            <div id="specifications" class="tab-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div id="product-specs">
                                        @php
                                            $specs = is_array($product->specifications) ? $product->specifications : json_decode($product->specifications, true);
                                        @endphp
                                        @if($specs && is_array($specs))
                                            <div class="space-y-3">
                                                @foreach($specs as $key => $value)
                                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                                        <span class="font-medium text-gray-700">{{ $key }}:</span>
                                                        <span class="text-gray-600">{{ $value }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500">No specifications available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reviews Tab -->
                        @if($product->reviews && $product->reviews->count() > 0)
                            <div id="reviews" class="tab-content">
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xl font-semibold">Customer Reviews</h3>
                                        <button class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                                            Write a Review
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        @foreach($product->reviews as $review)
                                            <div class="border rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-amber-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                                                        <span
                                                            class="font-medium">{{ $review->customer->name ?? 'Anonymous' }}</span>
                                                    </div>
                                                    <span
                                                        class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                                </div>
                                                @if($review->comment)
                                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Suggested Products Section -->
        @php
            $suggestedProducts = \App\Models\Product::with(['images', 'variants'])
                ->where('child_category_id', $product->child_category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get()
                ->map(function($suggestedProduct) {
                    return [
                        'product' => $suggestedProduct,
                        'discountPercentage' => $suggestedProduct->isOnSale() ?
                            round((($suggestedProduct->price - $suggestedProduct->sale_price) / $suggestedProduct->price) * 100) : 0,
                        'rating' => number_format(rand(350, 500) / 100, 1),
                        'productImage' => $suggestedProduct->main_image ??
                            ($suggestedProduct->images->first()->image_path ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop'),
                    ];
                });
        @endphp

        @if($suggestedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Suggested Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                    @foreach($suggestedProducts as $suggestedData)
                        <x-product-card :product="$suggestedData['product']" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
            @push('scripts')
                <script>
                    // Tab functionality
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const tabId = btn.dataset.tab;

                            // Remove active class from all tabs and buttons
                            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));

                            // Add active class to clicked button and corresponding tab
                            btn.classList.add('active');
                            document.getElementById(tabId).classList.add('active');
                        });
                    });

                    // Change main image when thumbnail is clicked
                    function changeMainImage(imageSrc) {
                        const mainImg = document.getElementById('main-image');
                        if (mainImg) {
                            mainImg.src = imageSrc;
                        }
                    }

                    // Variant selection functionality
                    let selectedVariant = null;
                    let selectedSizeId = null;

                    function selectSize(sizeId, sizeName, stock) {
                        selectedSizeId = sizeId;

                        // Update size button states
                        document.querySelectorAll('.size-btn').forEach(btn => {
                            btn.classList.remove('bg-amber-600', 'text-white', 'border-amber-600');
                            btn.classList.add('border-gray-300', 'text-gray-700');
                        });

                        // Highlight selected size
                        const selectedSizeBtn = document.querySelector(`[data-size-id="${sizeId}"]`);
                        if (selectedSizeBtn) {
                            selectedSizeBtn.classList.remove('border-gray-300', 'text-gray-700');
                            selectedSizeBtn.classList.add('bg-amber-600', 'text-white', 'border-amber-600');
                        }

                        const selectedVariantInfo = document.getElementById('selected-variant');
                        const sizeVariants = window.productVariants ? window.productVariants.filter(variant => variant.size_id === parseInt(sizeId)) : [];

                        if (sizeVariants.length > 0) {
                            selectedVariant = sizeVariants[0].id; // Select first variant

                            // Enable add to cart button
                            const addToCartBtn = document.getElementById('add-to-cart');
                            if (addToCartBtn) {
                                addToCartBtn.disabled = false;
                                addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            }

                            // Update stock status
                            const stockStatus = document.getElementById('stock-status');
                            if (stockStatus) {
                                const totalStock = sizeVariants.reduce((sum, v) => sum + (parseInt(v.stock) || 0), 0);
                                stockStatus.textContent = totalStock > 0 ? 'In Stock' : 'Out of Stock';
                                stockStatus.className = totalStock > 0 ? 'text-green-600' : 'text-red-600';
                            }
                        } else {
                            selectedVariant = null;
                            // Disable add to cart button if no variants found
                            const addToCartBtn = document.getElementById('add-to-cart');
                            if (addToCartBtn) {
                                addToCartBtn.disabled = true;
                                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        }

                        // Update selected info
                        const selectedInfo = document.getElementById('selected-info');
                        if (selectedInfo) {
                            selectedInfo.textContent = `Size: ${sizeName}`;
                        }
                        if (selectedVariantInfo) {
                            selectedVariantInfo.classList.remove('hidden');
                        }
                    }



                        // Update selected info
                        const sizeName = document.querySelector('.size-btn.bg-amber-600')?.dataset?.sizeName || 'Unknown Size';
                        const selectedInfo = document.getElementById('selected-info');
                        if (selectedInfo) {
                            selectedInfo.textContent = `${sizeName}`;
                        }



                    // Quantity controls
                    const qtyMinusBtn = document.getElementById('qty-minus');
                    const qtyPlusBtn = document.getElementById('qty-plus');
                    const qtyInput = document.getElementById('quantity');

                    if (qtyMinusBtn) {
                        qtyMinusBtn.addEventListener('click', () => {
                            if (qtyInput && qtyInput.value > 1) {
                                qtyInput.value = parseInt(qtyInput.value) - 1;
                            }
                        });
                    }

                    if (qtyPlusBtn) {
                        qtyPlusBtn.addEventListener('click', () => {
                            if (qtyInput) {
                                const selectedSize = document.querySelector('.size-btn.bg-amber-600');
                                const availableStock = selectedSize ? parseInt(selectedSize.dataset.stock) : 0;
                                const currentValue = parseInt(qtyInput.value) || 0;
                                
                                if (currentValue < availableStock) {
                                    qtyInput.value = currentValue + 1;
                                } else {
                                    showNotification(`Only ${availableStock} items available in stock`, 'error');
                                }
                            }
                        });
                    }

                    // Add to cart functionality
                    const addToCartBtn = document.getElementById('add-to-cart');
                    if (addToCartBtn) {
                        addToCartBtn.addEventListener('click', () => {
                            if (!selectedVariant) {
                                alert('Please select a size.');
                                return;
                            }

                            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                            const selectedSize = document.querySelector('.size-btn.bg-amber-600');
                            const availableStock = selectedSize ? parseInt(selectedSize.dataset.stock) : 0;
                            
                            // Validate quantity against available stock
                            if (quantity > availableStock) {
                                showNotification(`Only ${availableStock} items available in stock`, 'error');
                                return;
                            }
                            
                            // Validate minimum quantity
                            if (quantity < 1) {
                                showNotification('Quantity must be at least 1', 'error');
                                return;
                            }

                            const originalText = addToCartBtn.textContent;
                            addToCartBtn.disabled = true;
                            addToCartBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Adding...';

                            // Make API call to add to cart
                            fetch('{{ route("cart.add") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    variant_id: selectedVariant,
                                    quantity: quantity,
                                }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update cart count in header
                                        updateCartCount(data.cart_count);

                                        // Show success message
                                        showNotification('Product added to cart successfully!', 'success');

                                        // Reset button
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.textContent = originalText;
                                    } else {
                                        showNotification(data.message || 'Failed to add product to cart', 'error');
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.textContent = originalText;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error adding to cart:', error);
                                    showNotification('Failed to add product to cart. Please try again.', 'error');
                                    addToCartBtn.disabled = false;
                                    addToCartBtn.textContent = originalText;
                                });
                        });
                    }

                    // Buy now functionality
                    const buyNowBtn = document.getElementById('buy-now');
                    if (buyNowBtn) {
                        buyNowBtn.addEventListener('click', () => {
                            if (!selectedVariant) {
                                alert('Please select a size.');
                                return;
                            }

                            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
                            const originalText = buyNowBtn.textContent;

                            buyNowBtn.disabled = true;
                            buyNowBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';

                            // First add to cart
                            fetch('{{ route("cart.add") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    variant_id: selectedVariant,
                                    quantity: quantity,
                                    buy_now: true // Special flag for buy now
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update cart count in header
                                    updateCartCount(data.cart_count);

                                    // Redirect to checkout
                                    window.location.href = '{{ route("checkout.index") }}';
                                } else {
                                    if (data.redirect) {
                                        // Redirect to login if not authenticated
                                        window.location.href = data.redirect;
                                    } else {
                                        showNotification(data.message || 'Failed to add to cart', 'error');
                                        buyNowBtn.disabled = false;
                                        buyNowBtn.textContent = originalText;
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Error adding to cart:', error);
                                showNotification('Failed to add to cart. Please try again.', 'error');
                                buyNowBtn.disabled = false;
                                buyNowBtn.textContent = originalText;
                            });
                        });
                    }

                    // Initialize on page load
                    document.addEventListener('DOMContentLoaded', function () {
                        // Make sure description tab is active by default
                        const descriptionTab = document.querySelector('[data-tab="description"]');
                        const descriptionContent = document.getElementById('description');

                        if (descriptionTab && descriptionContent) {
                            // Remove active from all tabs
                            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                            // Activate description tab
                            descriptionTab.classList.add('active');
                            descriptionContent.classList.add('active');
                        }

                        // Initialize cart buttons state
                        const addToCartBtn = document.getElementById('add-to-cart');
                        const stockStatus = document.getElementById('stock-status');
                        if ({{ $variantsWithSize->count() > 0 ? 'true' : 'false' }}) {
                            if (addToCartBtn) {
                                // addToCartBtn.disabled = true;
                                // addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                            if (stockStatus) {
                                stockStatus.textContent = 'Please select size';
                                stockStatus.className = 'text-gray-500';
                            }

                            // Auto-select first size
                            @if($firstSize)
                                @php
                                    $firstSizeId = $firstSize->size ? $firstSize->size->id : 0;
                                    $firstSizeName = $firstSize->size ? $firstSize->size->name : 'Unknown';
                                    $firstStock = $variantsWithSize->where('size_id', $firstSize->size_id)->sum('stock_quantity');
                                @endphp
                                selectSize('{{ $firstSizeId }}', '{{ $firstSizeName }}', {{ $firstStock }});
                            @endif
                        } else {
                            if (addToCartBtn) {
                                addToCartBtn.disabled = true;
                                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                            if (stockStatus) {
                                stockStatus.textContent = 'Out of Stock';
                                stockStatus.className = 'text-red-600';
                            }
                        }
                    });

                    // Helper function to update cart count in header
                    function updateCartCount(count) {
                        const cartCountElements = document.querySelectorAll('.cart-count, [data-cart-count]');
                        cartCountElements.forEach(element => {
                            if (element.tagName === 'SPAN' || element.tagName === 'DIV') {
                                element.textContent = count;
                            } else {
                                element.setAttribute('data-cart-count', count);
                            }
                        });
                    }

                    // Helper function to show notifications
                    function showNotification(message, type = 'info') {
                        // Create notification element
                        const notification = document.createElement('div');
                        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

                        if (type === 'success') {
                            notification.className += ' bg-green-500 text-white';
                        } else if (type === 'error') {
                            notification.className += ' bg-red-500 text-white';
                        } else {
                            notification.className += ' bg-blue-500 text-white';
                        }

                        notification.textContent = message;

                        // Add to page
                        document.body.appendChild(notification);

                        // Animate in
                        setTimeout(() => {
                            notification.classList.remove('translate-x-full');
                        }, 100);

                        // Auto remove after 3 seconds
                        setTimeout(() => {
                            notification.classList.add('translate-x-full');
                            setTimeout(() => {
                                if (notification.parentNode) {
                                    notification.parentNode.removeChild(notification);
                                }
                            }, 300);
                        }, 3000);
                    }

                    // Helper function to show notifications
                    function showNotification(message, type = 'info') {
                        // Create notification element
                        const notification = document.createElement('div');
                        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

                        if (type === 'success') {
                            notification.className += ' bg-green-500 text-white';
                        } else if (type === 'error') {
                            notification.className += ' bg-red-500 text-white';
                        } else {
                            notification.className += ' bg-blue-500 text-white';
                        }

                        notification.textContent = message;

                        // Add to page
                        document.body.appendChild(notification);

                        // Animate in
                        setTimeout(() => {
                            notification.classList.remove('translate-x-full');
                        }, 100);

                        // Auto remove after 3 seconds
                        setTimeout(() => {
                            notification.classList.add('translate-x-full');
                            setTimeout(() => {
                                if (notification.parentNode) {
                                    notification.parentNode.removeChild(notification);
                                }
                            }, 300);
                        }, 3000);
                    }
                </script>
            @endpush

</x-app-layout>
