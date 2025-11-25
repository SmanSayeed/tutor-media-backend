<x-admin-layout title="Edit Brand">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Brand</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.brands') }}">Brands</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Edit Brand</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Brand Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.brands.update', $brand) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Brand Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Brand Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Brand Name -->
              <div class="space-y-2">
                <label for="brand_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Brand Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="brand_name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="Enter brand name" value="{{ old('name', $brand->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Brand Slug -->
              <div class="space-y-2">
                <label for="brand_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Slug <span class="text-danger">*</span>
                </label>
                <input type="text" id="brand_slug" name="slug" class="input @error('slug') is-invalid @enderror"
                  placeholder="brand-slug" value="{{ old('slug', $brand->slug) }}" required />
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Brand Description -->
            <div class="space-y-2">
              <label for="brand_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description
              </label>
              <textarea id="brand_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter brand description">{{ old('description', $brand->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Brand Website -->
            <div class="space-y-2">
              <label for="brand_website" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Website
              </label>
              <input type="url" id="brand_website" name="website" class="input @error('website') is-invalid @enderror"
                placeholder="https://example.com" value="{{ old('website', $brand->website) }}" />
              @error('website')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Current Logo Display -->
            @if($brand->logo)
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Current Logo</label>
                <div class="flex items-center gap-4">
                  <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}"
                    class="w-20 h-20 object-cover rounded-lg" />
                  <div class="text-sm text-slate-600 dark:text-slate-400">
                    <p>Current logo will be replaced if you upload a new one.</p>
                  </div>
                </div>
              </div>
            @endif

            <!-- Brand Logo -->
            <div class="space-y-2">
              <label for="brand_logo" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                {{ $brand->logo ? 'Change' : 'Upload' }} Brand Logo
              </label>
              <input type="file" id="brand_logo" name="logo" class="input @error('logo') is-invalid @enderror"
                accept="image/*" />
              @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 300x200px, Max file size: 2MB
              </p>
            </div>
          </div>

          <!-- SEO Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

            <!-- Meta Title -->
            <div class="space-y-2">
              <label for="brand_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="brand_meta_title" name="meta_title"
                class="input @error('meta_title') is-invalid @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title', $brand->meta_title) }}" />
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="brand_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="brand_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description', $brand->meta_description) }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>
          </div>

          <!-- Brand Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Brand Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Sort Order -->
              <div class="space-y-2">
                <label for="brand_sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sort Order
                </label>
                <input type="number" id="brand_sort_order" name="sort_order"
                  class="input @error('sort_order') is-invalid @enderror" placeholder="0" min="0"
                  value="{{ old('sort_order', $brand->sort_order) }}" />
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Lower numbers appear first in the list
                </p>
              </div>

              <!-- Status -->
              <div class="space-y-2">
                <label for="brand_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="brand_is_active" name="is_active" class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ ($brand->is_active ? 'selected' : '') }}>Active</option>
                  <option value="0" {{ (!$brand->is_active ? 'selected' : '') }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.brands') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Brand</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Brand Ends -->
</x-admin-layout>