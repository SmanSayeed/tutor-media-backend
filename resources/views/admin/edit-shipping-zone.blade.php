<x-admin-layout title="Edit Shipping Zone">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Shipping Zone</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Shipping</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.shipping-zones.index') }}">Shipping Zones</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Edit</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Shipping Zone Form Starts -->
  <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
    <!-- Form Section -->
    <div class="xl:col-span-2">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Shipping Zone Information</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.shipping-zones.update', $zone) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Division Name -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label for="division_name" class="form-label">Division Name <span class="text-red-500">*</span></label>
                <input type="text" id="division_name" name="division_name" class="form-input @error('division_name') is-invalid @enderror"
                       value="{{ old('division_name', $zone->division_name) }}" placeholder="e.g., Dhaka, Chittagong" required>
                @error('division_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Zone Name -->
              <div>
                <label for="zone_name" class="form-label">Zone Name <span class="text-red-500">*</span></label>
                <input type="text" id="zone_name" name="zone_name" class="form-input @error('zone_name') is-invalid @enderror"
                       value="{{ old('zone_name', $zone->zone_name) }}" placeholder="e.g., Dhaka City, Comilla" required>
                @error('zone_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Shipping Charge -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label for="shipping_charge" class="form-label">Shipping Charge ($)</label>
                <input type="number" id="shipping_charge" name="shipping_charge" class="form-input @error('shipping_charge') is-invalid @enderror"
                       value="{{ old('shipping_charge', $zone->shipping_charge) }}" placeholder="0.00" min="0" step="0.01">
                <small class="text-slate-500">Leave empty to use default shipping charge from config</small>
                @error('shipping_charge')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Status -->
              <div>
                <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                  <option value="">Select Status</option>
                  <option value="active" {{ old('status', $zone->status) === 'active' ? 'selected' : '' }}>Active</option>
                  <option value="deactive" {{ old('status', $zone->status) === 'deactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col gap-4 sm:flex-row sm:justify-end">
              <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-outline-secondary">
                <i data-feather="arrow-left" class="w-4 h-4"></i>
                <span>Cancel</span>
              </a>
              <button type="submit" class="btn btn-primary">
                <i data-feather="save" class="w-4 h-4"></i>
                <span>Update Shipping Zone</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Shipping Zone Form Ends -->

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Auto-capitalize division and zone names
        document.getElementById('division_name').addEventListener('input', function() {
          this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });

        document.getElementById('zone_name').addEventListener('input', function() {
          this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });
      });
    </script>
  @endpush
</x-admin-layout>
