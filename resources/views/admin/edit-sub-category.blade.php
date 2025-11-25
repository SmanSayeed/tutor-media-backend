<x-admin-layout title="Edit Subcategory">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Subcategory</h5>

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
        <a href="{{ route('admin.subcategories.edit', $subcategory) }}">Edit Subcategory</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Subcategory Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Subcategory Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Subcategory Information</h6>

            <!-- Parent Category Selection -->
            <div class="space-y-2">
              <label for="parent_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Parent Category <span class="text-danger">*</span>
              </label>
              <select id="parent_category" name="category_id" class="select @error('category_id') is-invalid @enderror"
                required>
                <option value="">Select Parent Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ ($subcategory->category_id == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Subcategory Name -->
              <div class="space-y-2">
                <label for="subcategory_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Subcategory Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="subcategory_name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="Enter subcategory name" value="{{ old('name', $subcategory->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Subcategory Slug -->
              <div class="space-y-2">
                <label for="subcategory_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Slug <span class="text-danger">*</span>
                </label>
                <input type="text" id="subcategory_slug" name="slug" class="input @error('slug') is-invalid @enderror"
                  placeholder="subcategory-slug" value="{{ old('slug', $subcategory->slug) }}" required />
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Subcategory Description -->
            <div class="space-y-2">
              <label for="subcategory_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description
              </label>
              <textarea id="subcategory_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter subcategory description">{{ old('description', $subcategory->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Current Image Display -->
            @if($subcategory->image)
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Image</label>
                <div class="flex items-center gap-4">
                  <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                    class="w-20 h-20 object-cover rounded-lg" />
                  <div class="text-sm text-slate-600 dark:text-slate-400">
                    <p>Current image will be replaced if you upload a new one.</p>
                  </div>
                </div>
              </div>
            @endif

            <!-- Subcategory Image -->
            <div class="space-y-2">
              <label for="subcategory_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                {{ $subcategory->image ? 'Change' : 'Upload' }} Subcategory Image
              </label>
              <input type="file" id="subcategory_image" name="image" class="input @error('image') is-invalid @enderror"
                accept="image/*" />
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
              <label for="subcategory_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="subcategory_meta_title" name="meta_title"
                class="input @error('meta_title') is-invalid @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title', $subcategory->meta_title) }}" />
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="subcategory_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="subcategory_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description', $subcategory->meta_description) }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>
          </div>

          <!-- Subcategory Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Subcategory Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Sort Order -->
              <div class="space-y-2">
                <label for="subcategory_sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sort Order
                </label>
                <input type="number" id="subcategory_sort_order" name="sort_order"
                  class="input @error('sort_order') is-invalid @enderror" placeholder="0" min="0"
                  value="{{ old('sort_order', $subcategory->sort_order) }}" />
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Lower numbers appear first in the list
                </p>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="subcategory_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="subcategory_is_active" name="is_active"
                  class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ ($subcategory->is_active ? 'selected' : '') }}>Active</option>
                  <option value="0" {{ (!$subcategory->is_active ? 'selected' : '') }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Subcategory</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Subcategory Ends -->
</x-admin-layout>