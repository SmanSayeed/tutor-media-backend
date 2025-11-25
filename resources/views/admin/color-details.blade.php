<x-admin-layout title="Color Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Color Details</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.colors.index') }}">Colors</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Color Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Color Details Starts -->
  <div class="space-y-6">
    <!-- Color Information -->
    <div class="card">
      <div class="card-header flex justify-between items-center">
        <h6 class="card-title">Color Information</h6>
        <div class="card-action">
          <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-sm btn-outline-warning">
            <i class="w-4 h-4" data-feather="edit"></i>
            <span>Edit</span>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Color Name</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $color->name }}</p>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Color Code</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $color->code }}</p>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Hex Code</label>
              <div class="flex items-center gap-2 mt-1">
                @if($color->hex_code)
                  <div class="w-6 h-6 rounded border border-slate-300" style="background-color: {{ $color->hex_code }}"></div>
                  <code class="text-sm">{{ $color->hex_code }}</code>
                @else
                  <span class="text-sm text-slate-500">Not set</span>
                @endif
              </div>
            </div>
          </div>

          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
              <div class="mt-1">
                <span class="badge {{ $color->is_active ? 'badge-success' : 'badge-danger' }}">
                  {{ $color->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Created At</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $color->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Updated At</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $color->updated_at->format('M d, Y H:i') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Action Buttons -->
    <div class="flex flex-col justify-end gap-3 sm:flex-row">
      <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="h-4 w-4"></i>
        <span>Back to Colors</span>
      </a>
      <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-primary">
        <i data-feather="edit" class="h-4 w-4"></i>
        <span>Edit Color</span>
      </a>
    </div>
  </div>
  <!-- Color Details Ends -->
</x-admin-layout>