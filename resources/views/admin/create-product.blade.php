<x-admin-layout title="Create Product">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Create Product</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.products.index') }}">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Create Product</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Create Product Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf

          <!-- Product Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Information</h6>

            <!-- Category Selection -->
            <div class="space-y-2">
              <label for="product_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Category <span class="text-danger">*</span>
              </label>
              <select id="product_category" name="category_id" class="select @error('category_id') is-invalid @enderror"
                required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Subcategory Selection -->
            <div class="space-y-2">
              <label for="product_subcategory" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Subcategory
              </label>
              <select id="product_subcategory" name="subcategory_id"
                class="select @error('subcategory_id') is-invalid @enderror">
                <option value="">Select Subcategory</option>
                <!-- Will be populated by JavaScript based on category selection -->
              </select>
              @error('subcategory_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Child Category Selection -->
            <div class="space-y-2">
              <label for="product_child_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Child Category
              </label>
              <select id="product_child_category" name="child_category_id"
                class="select @error('child_category_id') is-invalid @enderror">
                <option value="">Select Child Category</option>
                <!-- Will be populated by JavaScript based on subcategory selection -->
              </select>
              @error('child_category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Brand Selection -->
            <div class="space-y-2">
              <label for="product_brand" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Brand
              </label>
              <select id="product_brand" name="brand_id" class="select @error('brand_id') is-invalid @enderror">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                  </option>
                @endforeach
              </select>
              @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Product Name -->
              <div class="space-y-2">
                <label for="product_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Product Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="product_name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="Enter product name" value="{{ old('name') }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Product SKU -->
              <div class="space-y-2">
                <label for="product_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  SKU <span class="text-danger">*</span>
                </label>
                <input type="text" id="product_sku" name="sku" class="input @error('sku') is-invalid @enderror"
                  placeholder="Enter product SKU" value="{{ old('sku') }}" required />
                @error('sku')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Product Description -->
            <div class="space-y-2">
              <label for="product_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description <span class="text-danger">*</span>
              </label>
              <textarea id="product_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter product description" required>{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Product Short Description -->
            <div class="space-y-2">
              <label for="product_short_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Short Description
              </label>
              <textarea id="product_short_description" name="short_description"
                class="textarea @error('short_description') is-invalid @enderror" rows="2"
                placeholder="Enter short description">{{ old('short_description') }}</textarea>
              @error('short_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- YouTube Video URL -->
            <div class="space-y-2">
              <label for="product_video_url" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                YouTube Video URL
              </label>
              <input
                type="url"
                id="product_video_url"
                name="video_url"
                class="input @error('video_url') is-invalid @enderror"
                placeholder="https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID"
                value="{{ old('video_url') }}"
              />
              @error('video_url')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Enter a YouTube video URL to embed a video on the product page.
              </p>
            </div>

            <!-- Main Image Upload -->
            <div class="space-y-2">
              <label for="product_main_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Main Image
              </label>
              <input type="file" id="product_main_image" name="main_image"
                class="input @error('main_image') is-invalid @enderror" accept="image/*" required />
              @error('main_image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 800x600px, Max file size: 2MB
              </p>
            </div>

            <!-- Color Selection -->
            <div class="space-y-2">
              <label for="color_id" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Color
              </label>
              <select id="color_id" name="color_id" class="input @error('color_id') is-invalid @enderror">
                <option value="">Select Color</option>
                @foreach($colors as $color)
                  <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                    {{ $color->name }}
                  </option>
                @endforeach
              </select>
              @error('color_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Select the color for this product
              </p>
            </div>

            <!-- Additional Images Upload -->
            <div class="space-y-2">
              <label for="additional_images" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Additional Images
              </label>
              <input type="file" id="additional_images" name="additional_images[]" multiple
                class="input @error('additional_images') is-invalid @enderror" accept="image/*" />
              @error('additional_images')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Upload up to 10 additional images. Max file size: 2MB each
              </p>
            </div>
          </div>

          <!-- Product Variants -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Variants</h6>
              <button type="button" id="add-variant-btn" class="btn btn-sm btn-primary">
                <i class="w-4 h-4" data-feather="plus"></i> Add Variant
              </button>
            </div>

            <div id="variants-container" class="space-y-4">
              <!-- First variant (required) -->
              <div class="p-4 border rounded-md border-slate-200 dark:border-slate-600 space-y-4">
                <div class="flex items-center justify-between">
                  <h6 class="font-medium">Variant #1</h6>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Size -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Size <span class="text-danger">*</span>
                    </label>
                    <select name="variants[0][size_id]" class="select" required>
                      <option value="">Select Size</option>
                      @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Stock Quantity -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Stock Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="variants[0][stock_quantity]" min="0" value="0"
                      class="input" required>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hidden template for new variants -->
            <template id="variant-template">
              <div class="p-4 border rounded-md border-slate-200 dark:border-slate-600 space-y-4 variant-row">
                <div class="flex items-center justify-between">
                  <h6 class="font-medium">Variant #<span class="variant-number"></span></h6>
                  <button type="button" class="text-danger remove-variant-btn">
                    <i class="w-4 h-4" data-feather="trash-2"></i>
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Size -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Size <span class="text-danger">*</span>
                    </label>
                    <select name="variants[INDEX][size_id]" class="select variant-size-select" required>
                      <option value="">Select Size</option>
                      @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Stock Quantity -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Stock Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="variants[INDEX][stock_quantity]" min="0" value="0"
                      class="input" required>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <!-- Product Pricing -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Pricing</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <!-- Regular Price -->
              <div class="space-y-2">
                <label for="product_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Regular Price <span class="text-danger">*</span>
                </label>
                <input type="number" id="product_price" name="price" class="input @error('price') is-invalid @enderror"
                  placeholder="0.00" step="0.01" min="0" value="{{ old('price') }}" required />
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Sale Price -->
              <div class="space-y-2">
                <label for="product_sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sale Price
                </label>
                <input type="number" id="product_sale_price" name="sale_price"
                  class="input @error('sale_price') is-invalid @enderror" placeholder="0.00" step="0.01" min="0"
                  value="{{ old('sale_price') }}" />
                @error('sale_price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Cost Price -->
              <div class="space-y-2">
                <label for="product_cost_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Cost Price
                </label>
                <input type="number" id="product_cost_price" name="cost_price"
                  class="input @error('cost_price') is-invalid @enderror" placeholder="0.00" step="0.01" min="0"
                  value="{{ old('cost_price') }}" />
                @error('cost_price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

           <!-- Stock Management -->
           <div class="space-y-4">
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Variants</h6>
                  <button type="button" id="add-variant-btn" class="btn btn-sm btn-outline-primary">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    Add Variant
                  </button>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Add variants for different sizes and stock levels. Each variant represents a unique combination of size and stock.
                </p>

                <!-- Variants Container -->
                <div id="variants-container" class="space-y-4">
                  <!-- Variant rows will be added here dynamically -->
                </div>
              </div>
           </div>

            <!-- Variant Template (hidden) -->
            <div id="variant-template" class="variant-row border border-slate-200 dark:border-slate-700 rounded-lg p-4" style="display: none;">
              <div class="flex items-center justify-between mb-4">
                <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300">Variant</h6>
                <button type="button" class="remove-variant-btn text-red-500 hover:text-red-700">
                  <i data-feather="trash-2" class="w-4 h-4"></i>
                </button>
              </div>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Variant Size -->
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Size <span class="text-danger">*</span>
                  </label>
                  <select class="variant-size-select select">
                    <option value="">Select Size</option>
                    @foreach($sizes as $size)
                      <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Variant Stock Quantity -->
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Stock Quantity <span class="text-danger">*</span>
                  </label>
                  <input type="number" class="input" placeholder="0" min="0" />
                </div>
              </div>
            </div>

          <!-- SEO Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

            <!-- Meta Title -->
            <div class="space-y-2">
              <label for="product_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="product_meta_title" name="meta_title"
                class="input @error('meta_title') is-invalid @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title') }}" />
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="product_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="product_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>

            <!-- Meta Keywords -->
            <div class="space-y-2">
              <label for="product_meta_keywords" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Keywords
              </label>
              <input type="text" id="product_meta_keywords" name="meta_keywords"
                class="input @error('meta_keywords') is-invalid @enderror"
                placeholder="Enter keywords separated by commas"
                value="{{ old('meta_keywords') ? (is_array(old('meta_keywords')) ? implode(', ', old('meta_keywords')) : old('meta_keywords')) : '' }}" />
              @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Product Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <!-- Status -->
              <div class="space-y-2">
                <label for="product_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="product_is_active" name="is_active" class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Featured -->
              <div class="space-y-2">
                <label for="product_is_featured" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Featured
                </label>
                <select id="product_is_featured" name="is_featured"
                  class="select @error('is_featured') is-invalid @enderror">
                  <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ old('is_featured') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_featured')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Create Product</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Product Ends -->
    @push('scripts')
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const categorySelect = document.getElementById('product_category');
          const subcategorySelect = document.getElementById('product_subcategory');
          const childCategorySelect = document.getElementById('product_child_category');
          const addVariantBtn = document.getElementById('add-variant-btn');
          const variantsContainer = document.getElementById('variants-container');
          const variantTemplate = document.getElementById('variant-template');
          let variantIndex = 1; // Start from 1 because we already have one variant

          // Function to add a new variant
          function addVariant() {
            const variantRow = variantTemplate.content.cloneNode(true);
            const variantNumber = document.querySelectorAll('.variant-row').length + 1;

            // Update variant number
            variantRow.querySelector('.variant-number').textContent = variantNumber;

            // Update all elements with name containing INDEX
            variantRow.querySelectorAll('[name*="INDEX"]').forEach(element => {
              const newName = element.getAttribute('name').replace(/\[INDEX\]/g, `[${variantIndex}]`);
              element.setAttribute('name', newName);
            });

            // Add remove functionality
            const removeBtn = variantRow.querySelector('.remove-variant-btn');
            removeBtn.addEventListener('click', function() {
              this.closest('.variant-row').remove();
              // Renumber remaining variants
              document.querySelectorAll('.variant-row').forEach((row, index) => {
                row.querySelector('.variant-number').textContent = index + 1;
              });
            });

            variantsContainer.appendChild(variantRow);
            variantIndex++;

            if (typeof feather !== 'undefined') {
              feather.replace();
            }
          }

          // Add variant button click handler
          addVariantBtn.addEventListener('click', addVariant);

         // Filter subcategories based on selected category
         categorySelect.addEventListener('change', function () {
           const selectedCategoryId = this.value;

           // Reset subcategory and child category selections
           subcategorySelect.value = '';
           childCategorySelect.value = '';

           if (selectedCategoryId) {
             // Fetch subcategories for selected category
             fetch(`/admin/get-subcategories?category_id=${selectedCategoryId}`)
               .then(response => response.json())
               .then(data => {
                 subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                 data.forEach(subcategory => {
                   const option = document.createElement('option');
                   option.value = subcategory.id;
                   option.textContent = subcategory.name;
                   subcategorySelect.appendChild(option);
                 });
               })
               .catch(error => {
                 console.error('Error fetching subcategories:', error);
               });
           } else {
             subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
             childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
           }
         });

         // Filter child categories based on selected subcategory
         subcategorySelect.addEventListener('change', function () {
           const selectedSubcategoryId = this.value;

           // Reset child category selection
           childCategorySelect.value = '';

           if (selectedSubcategoryId) {
             // Fetch child categories for selected subcategory
             fetch(`/admin/get-child-categories?subcategory_id=${selectedSubcategoryId}`)
               .then(response => response.json())
               .then(data => {
                 childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
                 data.forEach(childCategory => {
                   const option = document.createElement('option');
                   option.value = childCategory.id;
                   option.textContent = childCategory.name;
                   childCategorySelect.appendChild(option);
                 });
               })
               .catch(error => {
                 console.error('Error fetching child categories:', error);
               });
           } else {
             childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
           }
         });
       });
     </script>
   @endpush
</x-admin-layout>
