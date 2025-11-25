<x-admin-layout title="Edit Color">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Color</h5>

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
        <a href="#">Edit Color</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Color Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.colors.update', $color) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Color Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Color Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Color Name -->
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Color Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="e.g., Red, Blue, Green" value="{{ old('name', $color->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Color Code -->
              <div class="space-y-2">
                <label for="code" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Color Code <span class="text-danger">*</span>
                </label>
                <input type="text" id="code" name="code" class="input @error('code') is-invalid @enderror"
                  placeholder="e.g., RED, BLUE" value="{{ old('code', $color->code) }}" required />
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Unique identifier for this color (used internally)
                </p>
              </div>
            </div>

            <!-- Hex Code -->
            <div class="space-y-2">
              <label for="hex_code" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Hex Code
              </label>
              <div class="flex gap-2">
                <input type="text" id="hex_code" name="hex_code" class="input @error('hex_code') is-invalid @enderror"
                  placeholder="#FF0000" value="{{ old('hex_code', $color->hex_code) }}" />
                <div id="color_preview" class="w-10 h-10 rounded border border-slate-300"
                  style="background-color: {{ old('hex_code', $color->hex_code ?? '#FF0000') }}"></div>
              </div>
              @error('hex_code')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Hex color code (e.g., #FF0000 for red). Leave empty if not applicable.
              </p>
            </div>

            <!-- Status -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Status
              </label>
              <div class="flex items-center gap-6">
                <label class="flex items-center">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', $color->is_active) ? 'checked' : '' }}>
                  <span class="ml-2 text-sm">Active</span>
                </label>
              </div>
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Active colors can be used when creating product variants
              </p>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Color</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Color Ends -->

  @push('scripts')
    <script>
      // Update color preview when hex code changes
      document.getElementById('hex_code').addEventListener('input', function() {
        const hexCode = this.value;
        const preview = document.getElementById('color_preview');

        if (/^#[0-9A-Fa-f]{6}$/.test(hexCode)) {
          preview.style.backgroundColor = hexCode;
        } else {
          preview.style.backgroundColor = '#FF0000';
        }
      });

      // Initialize color preview
      document.addEventListener('DOMContentLoaded', function() {
        const hexInput = document.getElementById('hex_code');
        const preview = document.getElementById('color_preview');

        if (hexInput.value && /^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
          preview.style.backgroundColor = hexInput.value;
        }
      });
    </script>
  @endpush
</x-admin-layout>