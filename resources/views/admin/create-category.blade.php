<x-admin-layout title="Create Category">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Create Category</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Create Category</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Create Category Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <!-- Category Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Category Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Category Name -->
              <div class="space-y-2">
                <label for="category_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Category Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="category_name" name="name" class="input @error('name') border-red-500 @enderror"
                  placeholder="Enter category name" value="{{ old('name') }}" required />
                @error('name')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
              </div>      
            </div>

            <!-- Category Description -->
            <div class="space-y-2">
              <label for="category_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description
              </label>
              <textarea id="category_description" name="description"
                class="textarea @error('description') border-red-500 @enderror" rows="4"
                placeholder="Enter category description">{{ old('description') }}</textarea>
              @error('description')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category Image -->
            <div class="space-y-2">
              <label for="category_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Category Image
              </label>
              <input type="file" id="category_image" name="image" class="input @error('image') border-red-500 @enderror"
                accept="image/*" />
              @error('image')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
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
              <label for="meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="meta_title" name="meta_title"
                class="input @error('meta_title') border-red-500 @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title') }}" />
              @error('meta_title')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="meta_description" name="meta_description"
                class="textarea @error('meta_description') border-red-500 @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
              @error('meta_description')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
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
                <label for="sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sort Order
                </label>
                <input type="number" id="sort_order" name="sort_order"
                  class="input @error('sort_order') border-red-500 @enderror" placeholder="0"
                  value="{{ old('sort_order', 0) }}" min="0" />
                @error('sort_order')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Lower numbers appear first in the list
                </p>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="is_active" name="is_active" class="select @error('is_active') border-red-500 @enderror">
                  <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
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
              <span>Create Category</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Category Ends -->
</x-admin-layout>