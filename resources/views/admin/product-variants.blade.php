<x-admin-layout>
         <!-- Page Title Starts -->
            <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
              <h5>Product Variants</h5>

              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                 <li class="breadcrumb-item">
                   <a href="{{ route('admin.product-variants.index') }}">Product Variants</a>
                 </li>
                 <li class="breadcrumb-item">
                   <a href="#">Manage Variants</a>
                 </li>
              </ol>
            </div>
            <!-- Page Title Ends -->

            <!-- Product Variants Management Starts -->
            <div class="space-y-6">
              <!-- Product Info Card -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product: {{ $product->name }}</h6>
                </div>
                <div class="card-body">
                  <div class="flex items-center gap-4">
                    @if($product->primaryImage())
                      <img src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg" />
                    @else
                      <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                    <div>
                      <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</h6>
                      <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Add Variant Card -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Add New Variant</h6>
                </div>
                <div class="card-body">
                  <!-- Error Display Container -->
                  <div id="variantErrors" class="hidden mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <i data-feather="alert-circle" class="h-5 w-5 text-red-400"></i>
                      </div>
                      <div class="ml-3">
                        <h3 class="text-sm font-medium">Please fix the following errors:</h3>
                        <ul id="variantErrorList" class="mt-2 text-sm list-disc list-inside">
                        </ul>
                      </div>
                      <button type="button" onclick="document.getElementById('variantErrors').classList.add('hidden')" class="ml-auto">
                        <i data-feather="x" class="h-4 w-4"></i>
                      </button>
                    </div>
                  </div>

                  <form id="addVariantForm" action="{{ route('admin.products.variants.store', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                      <div class="space-y-2">
                        <label for="variant_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Variant Name <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          id="variant_name"
                          name="name"
                          class="input"
                          placeholder="e.g., Small, Red, etc."
                          required
                        />
                      </div>

                      <div class="space-y-2">
                        <label for="variant_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Variant SKU <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          id="variant_sku"
                          name="sku"
                          class="input"
                          placeholder="Unique SKU for this variant"
                          required
                        />
                      </div>

                      <div class="space-y-2">
                        <label for="variant_size" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Size
                        </label>
                        <select
                          id="variant_size"
                          name="size_id"
                          class="input"
                        >
                          <option value="">Select Size</option>
                          @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }} ({{ $size->code }})</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="space-y-2">
                        <label for="variant_color" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Color
                        </label>
                        <select
                          id="variant_color"
                          name="color_id"
                          class="input"
                        >
                          <option value="">Select Color</option>
                          @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="space-y-2">
                        <label for="variant_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Price
                        </label>
                        <input
                          type="number"
                          id="variant_price"
                          name="price"
                          class="input"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                        />
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                          Leave empty to use product price
                        </p>
                      </div>

                      <div class="space-y-2">
                        <label for="variant_sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Sale Price
                        </label>
                        <input
                          type="number"
                          id="variant_sale_price"
                          name="sale_price"
                          class="input"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                        />
                      </div>

                      <div class="space-y-2">
                        <label for="variant_stock" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Stock Quantity <span class="text-danger">*</span>
                        </label>
                        <input
                          type="number"
                          id="variant_stock"
                          name="stock_quantity"
                          class="input"
                          placeholder="0"
                          min="0"
                          required
                        />
                      </div>

                      <div class="space-y-2">
                        <label for="variant_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Variant Image
                        </label>
                        <input
                          type="file"
                          id="variant_image"
                          name="image"
                          class="input"
                          accept="image/*"
                        />
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                          Optional: Specific image for this variant
                        </p>
                      </div>

                      <div class="space-y-2">
                        <label for="variant_weight" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Weight (kg)
                        </label>
                        <input
                          type="number"
                          id="variant_weight"
                          name="weight"
                          class="input"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                        />
                      </div>

                      <div class="space-y-2 md:col-span-2 lg:col-span-3">
                        <label class="flex items-center">
                          <input type="checkbox" id="variant_is_active" name="is_active" class="checkbox" value="1" checked>
                          <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Active</span>
                        </label>
                      </div>
                    </div>

                    <div class="flex justify-end mt-6">
                      <button type="submit" class="btn btn-primary" id="addVariantBtn">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        <span>Add Variant</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Current Variants -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Current Variants ({{ $product->variants->count() }} variants)</h6>
                </div>
                <div class="card-body">
                  @if($product->variants->count() > 0)
                  <div class="space-y-4">
                    @foreach($product->variants as $variant)
                    <div class="border border-slate-200 rounded-lg p-4 dark:border-slate-700">
                      <div class="flex items-center justify-between">
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
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                @if($variant->size)Size: {{ $variant->size->name }}@endif
                                @if($variant->size && $variant->color) | @endif
                                @if($variant->color)Color: {{ $variant->color->name }}@endif
                            </p>
                          </div>
                        </div>

                        <div class="flex items-center gap-4">
                          <div class="text-right">
                            <div class="text-sm font-medium">
                              @if($variant->sale_price)
                                <span class="text-primary-500">${{ number_format($variant->sale_price, 2) }}</span>
                                <span class="text-xs text-slate-400 line-through ml-1">${{ number_format($variant->price, 2) }}</span>
                              @else
                                <span>${{ number_format($variant->price, 2) }}</span>
                              @endif
                            </div>
                            <div class="text-xs text-slate-500">{{ $variant->stock_quantity }} in stock</div>
                          </div>

                          <div class="flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="editVariant({{ $variant->id }})">
                              <i data-feather="edit" class="w-3 h-3"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteVariant({{ $variant->id }})">
                              <i data-feather="trash-2" class="w-3 h-3"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                  @else
                  <div class="text-center py-8">
                    <i class="w-12 h-12 text-slate-300 mb-4" data-feather="package"></i>
                    <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No variants created</h6>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Add variants for different sizes, colors, or other attributes.</p>
                  </div>
                  @endif
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex flex-col justify-end gap-3 sm:flex-row ">
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
                  <i data-feather="arrow-left" class="h-4 w-4"></i>
                  <span>Back to Product</span>
                </a>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                  <i data-feather="edit" class="h-4 w-4"></i>
                  <span>Edit Product</span>
                </a>
              </div>
            </div>
            <!-- Product Variants Management Ends -->
            @push('scripts')
            <script>
            // Helper function to display validation errors
            function displayErrors(errors) {
                const errorContainer = document.getElementById('variantErrors');
                const errorList = document.getElementById('variantErrorList');
                
                // Clear previous errors
                errorList.innerHTML = '';
                
                // Add each error to the list
                Object.values(errors).flat().forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                
                // Show error container
                errorContainer.classList.remove('hidden');
                
                // Scroll to error container
                errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Reinitialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded');
            
                const addVariantForm = document.getElementById('addVariantForm');
                const addVariantBtn = document.getElementById('addVariantBtn');
            
                console.log('Form element:', addVariantForm);
                console.log('Button element:', addVariantBtn);
            
                if (!addVariantForm) {
                    console.error('CRITICAL: Form element not found!');
                    alert('Error: Form element not found. Please refresh the page.');
                    return;
                }
            
                if (!addVariantBtn) {
                    console.error('CRITICAL: Button element not found!');
                    alert('Error: Button element not found. Please refresh the page.');
                    return;
                }
            
                addVariantForm.addEventListener('submit', function(e) {
                    console.log('🚀 Form submit event triggered!');
                    e.preventDefault(); // Ensure this prevents default
            
                    const formData = new FormData(addVariantForm);
            
                    // Debug: Log form data
                    console.log('📝 Submitting variant with data:');
                    for (let [key, value] of formData.entries()) {
                        console.log(`  ${key}: ${value}`);
                    }
            
                    // Check CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    console.log('🔐 CSRF Token element:', csrfToken);
                    console.log('🔐 CSRF Token value:', csrfToken ? csrfToken.getAttribute('content') : 'NOT FOUND');
            
                    if (!csrfToken) {
                        alert('Error: CSRF token not found. Please refresh the page.');
                        return;
                    }
            
                    // Show loading state
                    addVariantBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 mr-2 animate-spin"></i><span>Adding...</span>';
                    addVariantBtn.disabled = true;
            
                    // Construct the full URL
                    const productId = {{ $product->id }};
                    const url = `/admin/products/${productId}/variants`;
                    console.log('📡 Fetch URL:', url);
            
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(async response => {
                        const data = await response.json();
                        console.log('Response Status:', response.status);
                        console.log('Response Data:', data);
            
                        if (!response.ok) {
                            // Handle validation errors
                            if (response.status === 422 && data.errors) {
                                // Display errors in inline container
                                displayErrors(data.errors);
            
                                // Also show in toast
                                const errorMessages = Object.values(data.errors).flat().join('<br>');
                                throw new Error(errorMessages);
                            } else if (data.message) {
                                throw new Error(data.message);
                            } else {
                                throw new Error('Failed to add variant');
                            }
                        }
            
                        return data;
                    })
                    .then(data => {
                        console.log('Success data:', data);
                        if (data.success) {
                            // Hide any previous errors
                            document.getElementById('variantErrors').classList.add('hidden');

                            // Show success toast
                            showSuccessToast(data.message);

                            // Reload page after a short delay to show the toast
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Catch block error:', error);
                        // Show error toast
                        showErrorToast(error.message || 'An error occurred while adding the variant');
                        // If it's a validation error, show inline errors
                        if (error.message && error.message.includes('required')) {
                            // Try to extract field-specific errors
                            const fieldErrors = {
                                'name': ['Variant name is required'],
                                'sku': ['SKU is required'],
                                'stock_quantity': ['Stock quantity is required']
                            };
            
                            // Simple check for common validation errors
                            if (error.message.includes('name')) {
                                displayErrors({'name': ['Variant name is required']});
                            } else if (error.message.includes('sku')) {
                                displayErrors({'sku': ['SKU is required']});
                            } else if (error.message.includes('stock')) {
                                displayErrors({'stock_quantity': ['Stock quantity is required']});
                            }
                        }
                    })
                    .finally(() => {
                        console.log('Finally block executed');
                        // Reset button state
                        addVariantBtn.innerHTML = '<i data-feather="plus" class="w-4 h-4 mr-2"></i><span>Add Variant</span>';
                        addVariantBtn.disabled = false;
                        // Reinitialize feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    });
                });
            
                // Log that event listener is attached
                console.log('Variant form submit listener attached');
            
                // Also add a direct click handler as backup
                addVariantBtn.addEventListener('click', function(e) {
                    console.log('🔘 Button clicked directly');
                    // Check if form is valid
                    if (!addVariantForm.checkValidity()) {
                        console.log('❌ Form validation failed');
                        addVariantForm.reportValidity();
                        e.preventDefault();
                        return false;
                    }
                    console.log('✅ Form validation passed');
                });
            });
            
            function editVariant(variantId) {
                window.location.href = `{{ route('admin.product-variants.edit', ':id') }}`.replace(':id', variantId);
            }
            
            function deleteVariant(variantId) {
                if (confirm('Are you sure you want to delete this variant?')) {
                    fetch(`{{ route('admin.product-variants.destroy', ':id') }}`.replace(':id', variantId), {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast
                            showSuccessToast(data.message);

                            // Reload page after showing toast
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            showErrorToast('Failed to delete variant');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showErrorToast(error.message || 'An error occurred while deleting the variant');
                    });
                }
            }
            </script>
            @endpush
</x-admin-layout>

