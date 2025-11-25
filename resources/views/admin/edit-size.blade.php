<x-admin-layout title="Edit Size">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Size</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.sizes.index') }}">Sizes</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Edit Size</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Size Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.sizes.update', $size) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Size Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Size Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Size Name -->
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Size Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="e.g., Small, Medium, Large" value="{{ old('name', $size->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Size Code -->
              <div class="space-y-2">
                <label for="code" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Size Code <span class="text-danger">*</span>
                </label>
                <input type="text" id="code" name="code" class="input @error('code') is-invalid @enderror"
                  placeholder="e.g., S, M, L, XL" value="{{ old('code', $size->code) }}" required />
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Unique identifier for this size (used internally)
                </p>
              </div>
            </div>

            <!-- Status -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Status
              </label>
              <div class="flex items-center gap-6">
                <label class="flex items-center">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', $size->is_active) ? 'checked' : '' }}>
                  <span class="ml-2 text-sm">Active</span>
                </label>
              </div>
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Active sizes can be used when creating product variants
              </p>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Size</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Size Ends -->
</x-admin-layout>