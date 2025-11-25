<x-admin-layout title="Product Details">
         <!-- Page Title Starts -->
            <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
              <h5>Product Details</h5>

              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="{{ route('admin.products.index') }}">Products</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#">Product Details</a>
                </li>
              </ol>
            </div>
            <!-- Page Title Ends -->

            <!-- Product Details Starts -->
            <div class="space-y-6">
              <!-- Product Information Card -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product Information</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Product Main Image -->
                    <div class="space-y-4">
                      @if($product->primaryImage())
                        <div>
                          <img src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}" class="w-full max-w-md rounded-lg shadow-sm" />
                        </div>
                      @else
                        <div class="flex h-48 w-full max-w-md items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800">
                          <i class="text-4xl text-slate-400" data-feather="image"></i>
                        </div>
                      @endif
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-4">
                      <div>
                        <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200">{{ $product->name }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</p>
                      </div>

                      <div class="grid grid-cols-2 gap-4">
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Category</span>
                          <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->category->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Subcategory</span>
                          <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->subcategory->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Child Category</span>
                          <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->childCategory->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Brand</span>
                          <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->brand->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</span>
                          @if($product->is_active)
                            <span class="badge badge-soft-success">Active</span>
                          @else
                            <span class="badge badge-soft-danger">Inactive</span>
                          @endif
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Featured</span>
                          @if($product->is_featured)
                            <span class="badge badge-soft-primary">Yes</span>
                          @else
                            <span class="badge badge-soft-secondary">No</span>
                          @endif
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Digital Product</span>
                          @if($product->is_digital)
                            <span class="badge badge-soft-info">Yes</span>
                          @else
                            <span class="badge badge-soft-secondary">No</span>
                          @endif
                        </div>
                        <div>
                          <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Track Inventory</span>
                          @if($product->track_inventory)
                            <span class="badge badge-soft-success">Yes</span>
                          @else
                            <span class="badge badge-soft-secondary">No</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Description -->
                  @if($product->description)
                  <div class="mt-6">
                    <h6 class="mb-2 text-sm font-medium text-slate-600 dark:text-slate-400">Description</h6>
                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ $product->description }}</p>
                  </div>
                  @endif

                  <!-- Short Description -->
                  @if($product->short_description)
                  <div class="mt-4">
                    <h6 class="mb-2 text-sm font-medium text-slate-600 dark:text-slate-400">Short Description</h6>
                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ $product->short_description }}</p>
                  </div>
                  @endif
                </div>
              </div>

              <!-- Product Images Gallery -->
              @if($product->images->count() > 0)
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product Gallery ({{ $product->images->count() }} images)</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                    @foreach($product->images as $image)
                    <div class="relative group">
                      <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-24 object-cover rounded-lg" />
                      @if($image->is_primary)
                        <div class="absolute top-2 left-2">
                          <span class="badge badge-soft-success text-xs">Primary</span>
                        </div>
                      @endif
                      <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="btn btn-sm btn-primary" onclick="setPrimaryImage({{ $image->id }})">
                          <i data-feather="star" class="w-3 h-3"></i>
                        </button>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif

              <!-- Product Variants -->
              @if($product->variants->count() > 0)
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product Variants ({{ $product->variants->count() }} variants)</h6>
                </div>
                <div class="card-body">
                  <div class="space-y-4">
                    @foreach($product->variants as $variant)
                    <div class="flex items-center justify-between p-4 border border-slate-200 rounded-lg dark:border-slate-700">
                      <div class="flex items-center gap-4">
                        @if($variant->image)
                          <img src="{{ asset($variant->image) }}" alt="{{ $variant->name }}" class="w-12 h-12 object-cover rounded-lg" />
                        @else
                          <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="text-slate-400" data-feather="package"></i>
                          </div>
                        @endif
                        <div>
                          <h6 class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $variant->name }}</h6>
                          <p class="text-xs text-slate-500 dark:text-slate-400">SKU: {{ $variant->sku }}</p>
                          @if($variant->size || $variant->color)
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                              @if($variant->size)Size: {{ $variant->size->name }}@endif
                              @if($variant->size && $variant->color) | @endif
                              @if($variant->color)Color: {{ $variant->color->name }}@endif
                            </p>
                          @endif
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm font-medium">
                          @if($variant->sale_price)
                            <span class="text-primary-500">${{ number_format($variant->sale_price, 2) }}</span>
                            <span class="text-xs text-slate-400 line-through ml-1">${{ number_format($variant->price, 2) }}</span>
                          @else
                            <span>${{ number_format($variant->price, 2) }}</span>
                          @endif
                        </div>
                        <div class="text-xs text-slate-500">
                          <span class="{{ $variant->stock_quantity > 0 ? ($variant->stock_quantity <= ($product->min_stock_level ?? 5) ? 'text-orange-500' : 'text-green-500') : 'text-red-500' }}">
                            {{ $variant->stock_quantity }} in stock
                            @if($variant->stock_quantity == 0)
                              (Out of Stock)
                            @elseif($variant->stock_quantity <= ($product->min_stock_level ?? 5))
                              (Low Stock)
                            @else
                              (In Stock)
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif

              <!-- Product Pricing & Stock -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Pricing & Stock Information</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                      <h6 class="mb-4 text-sm font-medium text-slate-600 dark:text-slate-400">Pricing</h6>
                      <div class="space-y-3">
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Regular Price:</span>
                          <span class="text-sm font-medium">${{ number_format($product->price, 2) }}</span>
                        </div>
                        @if($product->sale_price)
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Sale Price:</span>
                          <span class="text-sm font-medium text-primary-500">${{ number_format($product->sale_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Discount:</span>
                          <span class="text-sm font-medium text-green-500">{{ $product->discount_percentage }}%</span>
                        </div>
                        @endif
                        @if($product->cost_price)
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Cost Price:</span>
                          <span class="text-sm font-medium">${{ number_format($product->cost_price, 2) }}</span>
                        </div>
                        @endif
                      </div>
                    </div>

                    <div>
                      <h6 class="mb-4 text-sm font-medium text-slate-600 dark:text-slate-400">Stock Information</h6>
                      <div class="space-y-3">
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Total Stock:</span>
                          <span class="text-sm font-medium">{{ $product->totalStock() }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Variants:</span>
                          <span class="text-sm font-medium">{{ $product->variants->count() }} variants</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Min Stock Level:</span>
                          <span class="text-sm font-medium">{{ $product->min_stock_level }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Stock Status:</span>
                          <span class="text-sm font-medium">
                            @php
                              $inStockVariants = $product->variants->where('stock_quantity', '>', 0)->count();
                              $outOfStockVariants = $product->variants->where('stock_quantity', 0)->count();
                            @endphp
                            @if($outOfStockVariants == $product->variants->count())
                              <span class="text-red-500">All Out of Stock</span>
                            @elseif($inStockVariants > 0)
                              <span class="text-green-500">{{ $inStockVariants }} In Stock</span>
                            @else
                              <span class="text-orange-500">Check Variants</span>
                            @endif
                          </span>
                        </div>
                        <div class="flex justify-between">
                          <span class="text-sm text-slate-600 dark:text-slate-400">Track Inventory:</span>
                          <span class="text-sm font-medium">{{ $product->track_inventory ? 'Yes' : 'No' }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product Specifications -->
              @if($product->specifications && count($product->specifications) > 0)
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product Specifications</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach($product->specifications as $key => $value)
                    <div class="flex justify-between py-2 border-b border-slate-200 dark:border-slate-700">
                      <span class="text-sm text-slate-600 dark:text-slate-400">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                      <span class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $value }}</span>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif

              <!-- SEO Information -->
              @if($product->meta_title || $product->meta_description)
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">SEO Information</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @if($product->meta_title)
                    <div>
                      <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Title</span>
                      <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->meta_title }}</p>
                    </div>
                    @endif
                    @if($product->meta_description)
                    <div>
                      <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Description</span>
                      <p class="text-sm text-slate-800 dark:text-slate-200">{{ $product->meta_description }}</p>
                    </div>
                    @endif
                    @if($product->meta_keywords && count($product->meta_keywords) > 0)
                    <div class="md:col-span-2">
                      <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Keywords</span>
                      <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($product->meta_keywords as $keyword)
                        <span class="badge badge-soft-secondary text-xs">{{ $keyword }}</span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              @endif

              <!-- Action Buttons -->
              <div class="flex flex-col justify-end gap-3 sm:flex-row ">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                  <i data-feather="arrow-left" class="h-4 w-4"></i>
                  <span>Back to Products</span>
                </a>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                  <i data-feather="edit" class="h-4 w-4"></i>
                  <span>Edit Product</span>
                </a>
                <a href="{{ route('admin.products.stock', $product) }}" class="btn btn-outline-primary">
                  <i data-feather="package" class="h-4 w-4"></i>
                  <span>Manage Stock</span>
                </a>
                <a href="{{ route('admin.products.images', $product) }}" class="btn btn-outline-primary">
                  <i data-feather="image" class="h-4 w-4"></i>
                  <span>Manage Images</span>
                </a>
              </div>
            </div>
            <!-- Product Details Ends -->
            @push('scripts')
            <script>
            function setPrimaryImage(imageId) {
                fetch(`/admin/product-images/${imageId}/primary`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#3b82f6'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update primary image',
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the primary image',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                });
            }
            </script>
            @endpush
</x-admin-layout>

