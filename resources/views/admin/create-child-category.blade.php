<x-admin-layout title="Create Child Category">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Create Child Category</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.subcategories.index') }}">Subcategories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.child-categories.index') }}">Child Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Create Child Category</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Create Child Category Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.child-categories.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          <!-- Child Category Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Child Category Information</h6>

            <!-- Category Selection -->
            <div class="space-y-2">
              <label for="parent_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Category <span class="text-danger">*</span>
              </label>
              <select id="parent_category" name="category_id" class="select @error('category_id') is-invalid @enderror"
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
              <label for="parent_subcategory" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Subcategory <span class="text-danger">*</span>
              </label>
              <select id="parent_subcategory" name="subcategory_id"
                class="select @error('subcategory_id') is-invalid @enderror" required>
                <option value="">Select Subcategory</option>
                @foreach($subcategories as $subcategory)
                  <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                    {{ $subcategory->name }}
                  </option>
                @endforeach
              </select>
              @error('subcategory_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Child Category Name -->
              <div class="space-y-2">
                <label for="child_category_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Child Category Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="child_category_name" name="name"
                  class="input @error('name') is-invalid @enderror" placeholder="Enter child category name"
                  value="{{ old('name') }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Child Category Slug -->
              <div class="space-y-2">
                <label for="child_category_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Slug <span class="text-danger">*</span>
                </label>
                <input type="text" id="child_category_slug" name="slug"
                  class="input @error('slug') is-invalid @enderror" placeholder="child-category-slug"
                  value="{{ old('slug') }}" required />
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Child Category Description -->
            <div class="space-y-2">
              <label for="child_category_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description
              </label>
              <textarea id="child_category_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter child category description">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Child Category Image -->
            <div class="space-y-2">
              <label for="child_category_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Child Category Image
              </label>
              <input type="file" id="child_category_image" name="image"
                class="input @error('image') is-invalid @enderror" accept="image/*" />
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 800x600px, Max file size: 2MB
              </p>
            </div>
          </div>

          <!-- SEO Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

            <!-- Meta Title -->
            <div class="space-y-2">
              <label for="child_category_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="child_category_meta_title" name="meta_title"
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
              <label for="child_category_meta_description"
                class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="child_category_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>
          </div>

          <!-- Child Category Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Child Category Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Sort Order -->
              <div class="space-y-2">
                <label for="child_category_sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sort Order
                </label>
                <input type="number" id="child_category_sort_order" name="sort_order"
                  class="input @error('sort_order') is-invalid @enderror" placeholder="0" min="0"
                  value="{{ old('sort_order', 0) }}" />
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Lower numbers appear first in the list
                </p>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="child_category_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="child_category_is_active" name="is_active"
                  class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.child-categories.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Create Child Category</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Child Category Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('parent_category');
        const subcategorySelect = document.getElementById('parent_subcategory');

        // Filter subcategories based on selected category
        categorySelect.addEventListener('change', function () {
          const selectedCategoryId = this.value;

          // Reset subcategory selection
          subcategorySelect.value = '';

          // Show/hide subcategories based on selected category
          const options = subcategorySelect.querySelectorAll('option[data-category]');
          options.forEach(option => {
            const categoryId = option.getAttribute('data-category');
            if (selectedCategoryId === '' || categoryId === selectedCategoryId) {
              option.style.display = 'block';
            } else {
              option.style.display = 'none';
            }
          });

          // Update tom-select if it's being used
          if (subcategorySelect.tomselect) {
            subcategorySelect.tomselect.clearOptions();
            subcategorySelect.tomselect.addOptions(Array.from(options).filter(option => option.style.display !== 'none').map(option => ({
              value: option.value,
              text: option.text
            })));
          }
        });

        // Trigger initial filter on page load if category is pre-selected
        if (categorySelect.value) {
          categorySelect.dispatchEvent(new Event('change'));
        }
      });
    </script>
  @endpush
</x-admin-layout>