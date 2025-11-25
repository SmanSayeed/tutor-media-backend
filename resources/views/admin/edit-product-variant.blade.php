<x-admin-layout title="Edit Product Variant">
         <!-- Page Title Starts -->
            <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
              <h5>Edit Product Variant</h5>

               <ol class="breadcrumb">
                 <li class="breadcrumb-item">
                   <a href="/">Home</a>
                 </li>
                 <li class="breadcrumb-item">
                   <a href="{{ route('admin.product-variants.index') }}">Product Variants</a>
                 </li>
                 <li class="breadcrumb-item">
                   <a href="{{ route('admin.product-variants.show', $variant) }}">Variant Details</a>
                 </li>
                 <li class="breadcrumb-item">
                   <a href="#">Edit Variant</a>
                 </li>
               </ol>
            </div>
            <!-- Page Title Ends -->

            <!-- Edit Product Variant Starts -->
            <div class="space-y-6">
              <!-- Product Info Card -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Product: {{ $variant->product->name }}</h6>
                </div>
                <div class="card-body">
                  <div class="flex items-center gap-4">
                    @if($variant->product->primaryImage())
                      <img src="{{ asset($variant->product->primaryImage()) }}" alt="{{ $variant->product->name }}" class="w-16 h-16 object-cover rounded-lg" />
                    @else
                      <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                    <div>
                      <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $variant->product->name }}</h6>
                      <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $variant->product->sku }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Edit Variant Card -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Edit Variant</h6>
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

                  <form id="editVariantForm" action="{{ route('admin.product-variants.update', $variant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                      <div class="space-y-2">
                        <label for="variant_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Variant Name <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          id="variant_name"
                          name="name"
                          class="input @error('name') is-invalid @enderror"
                          placeholder="e.g., Small, Red, etc."
                          value="{{ old('name', $variant->name) }}"
                          required
                        />
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2">
                        <label for="variant_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Variant SKU <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          id="variant_sku"
                          name="sku"
                          class="input @error('sku') is-invalid @enderror"
                          placeholder="Unique SKU for this variant"
                          value="{{ old('sku', $variant->sku) }}"
                          required
                        />
                        @error('sku')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2">
                        <label for="variant_size" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Size
                        </label>
                        <select
                          id="variant_size"
                          name="size_id"
                          class="select @error('size_id') is-invalid @enderror"
                        >
                          <option value="">Select Size</option>
                          @foreach($sizes as $size)
                            <option value="{{ $size->id }}" {{ ($variant->size_id == $size->id) ? 'selected' : '' }}>
                              {{ $size->name }} ({{ $size->code }})
                            </option>
                          @endforeach
                        </select>
                        @error('size_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2">
                        <label for="variant_color" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Color
                        </label>
                        <select
                          id="variant_color"
                          name="color_id"
                          class="select @error('color_id') is-invalid @enderror"
                        >
                          <option value="">Select Color</option>
                          @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ ($variant->color_id == $color->id) ? 'selected' : '' }}>
                              {{ $color->name }}
                            </option>
                          @endforeach
                        </select>
                        @error('color_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2">
                        <label for="variant_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Price
                        </label>
                        <input
                          type="number"
                          id="variant_price"
                          name="price"
                          class="input @error('price') is-invalid @enderror"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                          value="{{ old('price', $variant->price) }}"
                        />
                        @error('price')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                          class="input @error('sale_price') is-invalid @enderror"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                          value="{{ old('sale_price', $variant->sale_price) }}"
                        />
                        @error('sale_price')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2">
                        <label for="variant_stock" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Stock Quantity <span class="text-danger">*</span>
                        </label>
                        <input
                          type="number"
                          id="variant_stock"
                          name="stock_quantity"
                          class="input @error('stock_quantity') is-invalid @enderror"
                          placeholder="0"
                          min="0"
                          value="{{ old('stock_quantity', $variant->stock_quantity) }}"
                          required
                        />
                        @error('stock_quantity')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Current Image Display -->
                      @if($variant->image)
                      <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Variant Image</label>
                        <div class="flex items-center gap-4">
                          <img src="{{ asset($variant->image) }}" alt="{{ $variant->name }}" class="w-20 h-20 object-cover rounded-lg" />
                          <div class="text-sm text-slate-600 dark:text-slate-400">
                            <p>Current variant image will be replaced if you upload a new one.</p>
                          </div>
                        </div>
                      </div>
                      @endif

                      <div class="space-y-2">
                        <label for="variant_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          {{ $variant->image ? 'Change' : 'Upload' }} Variant Image
                        </label>
                        <input
                          type="file"
                          id="variant_image"
                          name="image"
                          class="input @error('image') is-invalid @enderror"
                          accept="image/*"
                        />
                        @error('image')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                          class="input @error('weight') is-invalid @enderror"
                          placeholder="0.00"
                          step="0.01"
                          min="0"
                          value="{{ old('weight', $variant->weight) }}"
                        />
                        @error('weight')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="space-y-2 md:col-span-2 lg:col-span-3">
                        <label class="flex items-center">
                          <input type="checkbox" id="variant_is_active" name="is_active" class="checkbox" value="1" {{ $variant->is_active ? 'checked' : '' }}>
                          <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Active</span>
                        </label>
                        @error('is_active')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                       <a href="{{ route('admin.product-variants.show', $variant) }}" class="btn btn-secondary">
                        <i data-feather="x" class="w-4 h-4"></i>
                        <span>Cancel</span>
                      </a>
                      <button type="submit" class="btn btn-primary" id="editVariantBtn">
                        <i data-feather="save" class="w-4 h-4"></i>
                        <span>Update Variant</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Current Variant Info -->
              <div class="card">
                <div class="card-header">
                  <h6 class="card-title">Variant Information</h6>
                </div>
                <div class="card-body">
                  <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                      <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Current Details</h6>
                      <div class="space-y-1 text-sm text-slate-600 dark:text-slate-400">
                        <p><strong>Name:</strong> {{ $variant->name }}</p>
                        <p><strong>SKU:</strong> {{ $variant->sku }}</p>
                        @if($variant->size)
                          <p><strong>Size:</strong> {{ $variant->size->name }} ({{ $variant->size->code }})</p>
                        @endif
                        @if($variant->color)
                          <p><strong>Color:</strong> {{ $variant->color->name }}</p>
                        @endif
                        <p><strong>Stock:</strong> {{ $variant->stock_quantity }} units</p>
                        <p><strong>Status:</strong> {{ $variant->is_active ? 'Active' : 'Inactive' }}</p>
                      </div>
                    </div>
                    <div>
                      <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Pricing</h6>
                      <div class="space-y-1 text-sm text-slate-600 dark:text-slate-400">
                        @if($variant->sale_price)
                          <p><strong>Sale Price:</strong> ${{ number_format($variant->sale_price, 2) }}</p>
                          <p><strong>Regular Price:</strong> <span class="line-through">${{ number_format($variant->price, 2) }}</span></p>
                        @else
                          <p><strong>Price:</strong> ${{ number_format($variant->price, 2) }}</p>
                        @endif
                        @if($variant->weight)
                          <p><strong>Weight:</strong> {{ $variant->weight }} kg</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Edit Product Variant Ends -->
            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editVariantForm = document.getElementById('editVariantForm');
                const editVariantBtn = document.getElementById('editVariantBtn');

                if (!editVariantForm) {
                    console.error('CRITICAL: Edit variant form element not found!');
                    return;
                }

                if (!editVariantBtn) {
                    console.error('CRITICAL: Edit variant button element not found!');
                    return;
                }

                // Form submission handler
                editVariantForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(editVariantForm);

                    // Check CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        alert('Error: CSRF token not found. Please refresh the page.');
                        return;
                    }

                    // Show loading state
                    editVariantBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i><span>Updating...</span>';
                    editVariantBtn.disabled = true;

                    fetch(editVariantForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422 && data.errors) {
                                displayErrors(data.errors);
                                throw new Error('Validation failed');
                            } else if (data.message) {
                                throw new Error(data.message);
                            } else {
                                throw new Error('Failed to update variant');
                            }
                        }

                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            // Hide any previous errors
                            document.getElementById('variantErrors').classList.add('hidden');

                            // Show success toast
                            showSuccessToast(data.message);

                             // Redirect back to variant details page after a short delay
                             setTimeout(() => {
                                 window.location.href = '{{ route("admin.product-variants.show", $variant) }}';
                             }, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showErrorToast(error.message || 'An error occurred while updating the variant');
                    })
                    .finally(() => {
                        // Reset button state
                        editVariantBtn.innerHTML = '<i data-feather="save" class="w-4 h-4"></i><span>Update Variant</span>';
                        editVariantBtn.disabled = false;

                        // Reinitialize feather icons
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    });
                });

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
            });
            </script>
            @endpush
</x-admin-layout>
