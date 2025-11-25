<x-admin-layout title="Edit Category">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Category</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.edit', $category->id) }}">Edit Category</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Category Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Category Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Category Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Category Name -->
              <div class="space-y-2">
                <label for="category_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Category Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="category_name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="Enter category name" value="{{ old('name', $category->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category Slug -->
              <div class="space-y-2">
                <label for="category_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Slug
                </label>
                <input type="text" id="category_slug" name="slug" class="input @error('slug') is-invalid @enderror"
                  placeholder="Auto-generated from name" value="{{ old('slug', $category->slug) }}" />
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Leave empty to auto-generate from category name
                </p>
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Category Description -->
            <div class="space-y-2">
              <label for="category_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description
              </label>
              <textarea id="category_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Current Image Display -->
            @if($category->image)
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Image</label>
                <div class="flex items-center gap-4">
                  <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                    class="w-20 h-20 object-cover rounded-lg" />
                  <div class="text-sm text-slate-600 dark:text-slate-400">
                    <p>Current image will be replaced if you upload a new one.</p>
                  </div>
                </div>
              </div>
            @endif

            <!-- Category Image -->
            <div class="space-y-2">
              <label for="category_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                {{ $category->image ? 'Change' : 'Upload' }} Category Image
              </label>
              <input type="file" id="category_image" name="image" class="input @error('image') is-invalid @enderror"
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
              <label for="category_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="category_meta_title" name="meta_title"
                class="input @error('meta_title') is-invalid @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title', $category->meta_title) }}" />
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="category_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="category_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description', $category->meta_description) }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>
          </div>

          <!-- Category Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Category Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Sort Order -->
              <div class="space-y-2">
                <label for="category_sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sort Order
                </label>
                <input type="number" id="category_sort_order" name="sort_order"
                  class="input @error('sort_order') is-invalid @enderror" placeholder="0" min="0"
                  value="{{ old('sort_order', $category->sort_order) }}" />
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Lower numbers appear first in the list
                </p>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="category_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="category_is_active" name="is_active"
                  class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ ($category->is_active ? 'selected' : '') }}>Active</option>
                  <option value="0" {{ (!$category->is_active ? 'selected' : '') }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Category</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Category Ends -->
</x-admin-layout>