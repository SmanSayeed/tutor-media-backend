<x-admin-layout title="Edit Product">
    <!-- Page Title Starts -->
      <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Edit Product</h5>

        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('admin.products.index') }}">Products</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">Edit Product</a>
          </li>
        </ol>
      </div>
      <!-- Page Title Ends -->

      <!-- Edit Product Starts -->
      <div class="space-y-6">
        <div class="card">
          <div class="card-body">
            <form class="space-y-6" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <!-- Product Basic Information -->
              <div class="space-y-4">
                <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Information</h6>

                <!-- Category Selection -->
                <div class="space-y-2">
                  <label for="product_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Category <span class="text-danger">*</span>
                  </label>
                  <select id="product_category" name="category_id" class="select @error('category_id') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ ($product->category_id == $category->id) ? 'selected' : '' }}>
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
                  <select id="product_subcategory" name="subcategory_id" class="select @error('subcategory_id') is-invalid @enderror">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $subcategory)
                      <option value="{{ $subcategory->id }}" {{ ($product->subcategory_id == $subcategory->id) ? 'selected' : '' }}>
                        {{ $subcategory->name }}
                      </option>
                    @endforeach
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
                  <select id="product_child_category" name="child_category_id" class="select @error('child_category_id') is-invalid @enderror">
                    <option value="">Select Child Category</option>
                    @foreach($childCategories as $childCategory)
                      <option value="{{ $childCategory->id }}" {{ ($product->child_category_id == $childCategory->id) ? 'selected' : '' }}>
                        {{ $childCategory->name }}
                      </option>
                    @endforeach
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
                      <option value="{{ $brand->id }}" {{ ($product->brand_id == $brand->id) ? 'selected' : '' }}>
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
                    <input
                      type="text"
                      id="product_name"
                      name="name"
                      class="input @error('name') is-invalid @enderror"
                      placeholder="Enter product name"
                      value="{{ old('name', $product->name) }}"
                      required
                    />
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Product SKU -->
                  <div class="space-y-2">
                    <label for="product_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      SKU <span class="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      id="product_sku"
                      name="sku"
                      class="input @error('sku') is-invalid @enderror"
                      placeholder="Enter product SKU"
                      value="{{ old('sku', $product->sku) }}"
                      required
                    />
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
                  <textarea
                    id="product_description"
                    name="description"
                    class="textarea @error('description') is-invalid @enderror"
                    rows="4"
                    placeholder="Enter product description"
                    required
                  >{{ old('description', $product->description) }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Product Short Description -->
                <div class="space-y-2">
                  <label for="product_short_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Short Description
                  </label>
                  <textarea
                    id="product_short_description"
                    name="short_description"
                    class="textarea @error('short_description') is-invalid @enderror"
                    rows="2"
                    placeholder="Enter short description"
                  >{{ old('short_description', $product->short_description) }}</textarea>
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
                    value="{{ old('video_url', $product->video_url) }}"
                  />
                  @error('video_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <p class="text-xs text-slate-500 dark:text-slate-400">
                    Enter a YouTube video URL to embed a video above the product description on the product page
                  </p>
                </div>

                <!-- Current Main Image Display -->
                @if($product->main_image)
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Main Image</label>
                  <div class="flex items-center gap-4">
                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-lg" />
                    <div class="text-sm text-slate-600 dark:text-slate-400">
                      <p>Current main image will be replaced if you upload a new one.</p>
                    </div>
                  </div>
                </div>
                @endif

                <!-- Main Image Upload -->
                <div class="space-y-2">
                  <label for="product_main_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    {{ $product->main_image ? 'Change' : 'Upload' }} Main Image
                  </label>
                  <input
                    type="file"
                    id="product_main_image"
                    name="main_image"
                    class="input @error('main_image') is-invalid @enderror"
                    accept="image/*"
                  />
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
                      <option value="{{ $color->id }}" {{ ($product->color_id == $color->id) ? 'selected' : '' }}>
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

                <!-- Current Additional Images -->
                @if($product->images->count() > 0)
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Additional Images</label>
                  <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach($product->images as $image)
                      <div class="relative">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-20 object-cover rounded-lg" />
                        <button type="button" onclick="deleteImage({{ $image->id }}, this)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                          ×
                        </button>
                      </div>
                    @endforeach
                  </div>
                </div>
                @endif
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
                    <input
                      type="number"
                      id="product_price"
                      name="price"
                      class="input @error('price') is-invalid @enderror"
                      placeholder="0.00"
                      step="0.01"
                      min="0"
                      value="{{ old('price', $product->price) }}"
                      required
                    />
                    @error('price')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Sale Price -->
                  <div class="space-y-2">
                    <label for="product_sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Sale Price
                    </label>
                    <input
                      type="number"
                      id="product_sale_price"
                      name="sale_price"
                      class="input @error('sale_price') is-invalid @enderror"
                      placeholder="0.00"
                      step="0.01"
                      min="0"
                      value="{{ old('sale_price', $product->sale_price) }}"
                    />
                    @error('sale_price')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Cost Price -->
                  <div class="space-y-2">
                    <label for="product_cost_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Cost Price
                    </label>
                    <input
                      type="number"
                      id="product_cost_price"
                      name="cost_price"
                      class="input @error('cost_price') is-invalid @enderror"
                      placeholder="0.00"
                      step="0.01"
                      min="0"
                      value="{{ old('cost_price', $product->cost_price) }}"
                    />
                    @error('cost_price')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <!-- Variants Section -->
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Variants</h6>
                  <button type="button" id="add-variant-btn" class="btn btn-sm btn-outline-primary">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    Add Variant
                  </button>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Add or edit variants for different sizes and stock levels. Each variant represents a unique combination of size and stock.
                </p>

                <!-- Variants Container -->
                <div id="variants-container" class="space-y-4">
                  @if(isset($product) && $product->variants->count() > 0)
                    @foreach($product->variants as $index => $variant)
                      <div class="variant-row border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                          <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300">Variant {{ $index + 1 }}</h6>
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
                            <select name="variants[{{ $index }}][size_id]" class="select" required>
                              <option value="">Select Size</option>
                              @foreach($sizes as $size)
                                <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                  {{ $size->name }}
                                </option>
                              @endforeach
                            </select>
                          </div>

                          <!-- Variant Stock Quantity -->
                          <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                              Stock Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="variants[{{ $index }}][stock_quantity]" class="input" 
                                  placeholder="0" min="0" value="{{ $variant->stock_quantity }}" required />
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
              
              <!-- Variant Template (hidden) -->
              <template id="variant-template">
                <div class="variant-row border border-slate-200 dark:border-slate-700 rounded-lg p-4 mt-4">
                  <div class="flex items-center justify-between mb-4">
                    <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300">New Variant</h6>
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
                      <select name="variants[__INDEX__][size_id]" class="select" required>
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
                      <input type="number" name="variants[__INDEX__][stock_quantity]" class="input" placeholder="0" min="0" required />
                    </div>
                  </div>
                </div>
              </template>
                      

              <!-- SEO Information -->
              <div class="space-y-4">
                <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

                <!-- Meta Title -->
                <div class="space-y-2">
                  <label for="product_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Meta Title
                  </label>
                  <input
                    type="text"
                    id="product_meta_title"
                    name="meta_title"
                    class="input @error('meta_title') is-invalid @enderror"
                    placeholder="Enter meta title for SEO"
                    value="{{ old('meta_title', $product->meta_title) }}"
                  />
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
                  <textarea
                    id="product_meta_description"
                    name="meta_description"
                    class="textarea @error('meta_description') is-invalid @enderror"
                    rows="3"
                    placeholder="Enter meta description for SEO"
                  >{{ old('meta_description', $product->meta_description) }}</textarea>
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
                  <input
                    type="text"
                    id="product_meta_keywords"
                    name="meta_keywords"
                    class="input @error('meta_keywords') is-invalid @enderror"
                    placeholder="Enter keywords separated by commas"
                    value="{{ old('meta_keywords', implode(', ', $product->meta_keywords ?? [])) }}"
                  />
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
                      <option value="1" {{ ($product->is_active ? 'selected' : '') }}>Active</option>
                      <option value="0" {{ (!$product->is_active ? 'selected' : '') }}>Inactive</option>
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
                    <select id="product_is_featured" name="is_featured" class="select @error('is_featured') is-invalid @enderror">
                      <option value="1" {{ ($product->is_featured ? 'selected' : '') }}>Yes</option>
                      <option value="0" {{ (!$product->is_featured ? 'selected' : '') }}>No</option>
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
                  <span>Update Product</span>
                </button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
      <!-- Edit Product Ends -->
      @push('scripts')
      <script>
      document.addEventListener('DOMContentLoaded', function() {
          const categorySelect = document.getElementById('product_category');
          const subcategorySelect = document.getElementById('product_subcategory');
          const childCategorySelect = document.getElementById('product_child_category');
          const addVariantBtn = document.getElementById('add-variant-btn');
          const variantsContainer = document.getElementById('variants-container');
          
          // Initialize variant functionality
          function initVariantFunctionality() {
              const variantTemplate = document.getElementById('variant-template');
              if (!variantTemplate) {
                  console.error('Variant template not found');
                  return false;
              }
              
              let variantIndex = document.querySelectorAll('.variant-row').length;
              
              // Function to add a new variant
              function addVariant() {
                  const variantRow = variantTemplate.content.cloneNode(true);
                  const newVariant = variantRow.querySelector('.variant-row');
                  newVariant.style.display = 'block';

                  // Update index in form names
                  newVariant.querySelectorAll('select, input').forEach(element => {
                      if (element.name) {
                          element.name = element.name.replace('__INDEX__', variantIndex);
                      }
                  });

                  // Add remove functionality
                  const removeBtn = newVariant.querySelector('.remove-variant-btn');
                  if (removeBtn) {
                      removeBtn.addEventListener('click', function(e) {
                          e.preventDefault();
                          const row = this.closest('.variant-row');
                          if (row && !row.id) { // Don't remove the template
                              row.remove();
                          }
                      });
                  }

                                    if (variantsContainer) {
                      variantsContainer.appendChild(newVariant);
                      // Re-initialize Feather icons for the new variant
                      if (typeof feather !== 'undefined') {
                          feather.replace();
                      }
                      
                      // Add click handler for the new remove button
                      const newRemoveBtn = newVariant.querySelector('.remove-variant-btn');
                      if (newRemoveBtn) {
                          newRemoveBtn.addEventListener('click', function(e) {
                              e.preventDefault();
                              newVariant.remove();
                          });
                      }
                  }
                  
                  variantIndex++;

                  return newVariant;
              }

              // Add variant button click handler
              if (addVariantBtn && variantsContainer) {
                  addVariantBtn.addEventListener('click', function(e) {
                      e.preventDefault();
                      addVariant();
                  });
              }

              // Add remove functionality to existing variants
              document.querySelectorAll('.remove-variant-btn').forEach(btn => {
                  btn.addEventListener('click', function(e) {
                      e.preventDefault();
                      const row = this.closest('.variant-row');
                      if (row && !row.id) { // Don't remove the template
                          row.remove();
                      }
                  });
              });
              
              return true;
          }
          
          // Initialize variant functionality when DOM is loaded
          const variantInitialized = initVariantFunctionality();
          
          // If variant template is not found, disable the add variant button
          if (!variantInitialized && addVariantBtn) {
              addVariantBtn.disabled = true;
              console.warn('Add variant functionality is disabled due to missing template');
          }
          
          // Store current selections
          const currentSubcategoryId = '{{ $product->subcategory_id ?? '' }}';
          const currentChildCategoryId = '{{ $product->child_category_id ?? '' }}';
      
          // Filter subcategories based on selected category
          categorySelect.addEventListener('change', function() {
              const selectedCategoryId = this.value;
      
              // Reset child category selection
              childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
      
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
                              // Keep current subcategory selected if it belongs to this category
                              if (currentSubcategoryId && subcategory.id == currentSubcategoryId) {
                                  option.selected = true;
                              }
                              subcategorySelect.appendChild(option);
                          });
                          
                          // If a subcategory is selected, load its child categories
                          if (subcategorySelect.value) {
                              subcategorySelect.dispatchEvent(new Event('change'));
                          }
                      })
                      .catch(error => {
                          console.error('Error fetching subcategories:', error);
                          subcategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
                      });
              } else {
                  subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                  childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
              }
          });
      
          // Filter child categories based on selected subcategory
          subcategorySelect.addEventListener('change', function() {
              const selectedSubcategoryId = this.value;
      
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
                              // Keep current child category selected if it belongs to this subcategory
                              if (currentChildCategoryId && childCategory.id == currentChildCategoryId) {
                                  option.selected = true;
                              }
                              childCategorySelect.appendChild(option);
                          });
                      })
                      .catch(error => {
                          console.error('Error fetching child categories:', error);
                          childCategorySelect.innerHTML = '<option value="">Error loading child categories</option>';
                      });
              } else {
                  childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
              }
          });
      
          // Trigger initial load if category is pre-selected
          if (categorySelect.value) {
              categorySelect.dispatchEvent(new Event('change'));
          }
      });

      // Function to handle image deletion
      function deleteImage(imageId, button) {
          // Get the closest image container
          const imageContainer = button.closest('.relative');
          if (confirm('Are you sure you want to delete this image?')) {
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              
              fetch(`/admin/product-images/${imageId}`, {
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': csrfToken,
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                  },
              })
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(data => {
                  if (data.success) {
                      // Remove the image container from the DOM
                  if (imageContainer) {
                      imageContainer.remove();
                  }   
                      // Show success message
                      if (typeof Toastify !== 'undefined') {
                          Toastify({
                              text: data.message || 'Image deleted successfully',
                              duration: 3000,
                              gravity: 'top',
                              position: 'right',
                              backgroundColor: '#10B981',
                          }).showToast();
                      } else {
                          alert(data.message || 'Image deleted successfully');
                      }
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  alert('Failed to delete image. Please try again.');
              });
          }
      }
      </script>
      @endpush
</x-admin-layout>
