<x-admin-layout title="Create Size">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Create Size</h5>

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
        <a href="#">Create Size</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Create Size Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.sizes.store') }}" method="POST">
          @csrf

          <!-- Size Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Size Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Size Name -->
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Size Number <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="enter size number" value="{{ old('name') }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>       
            </div>

            <!-- Status -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Status
              </label>
              <div class="flex items-center gap-6">
                <label class="flex items-center">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
              <span>Create Size</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Size Ends -->
</x-admin-layout>