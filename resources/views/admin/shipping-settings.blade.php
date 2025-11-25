<x-admin-layout title="Shipping Settings">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Shipping Settings</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Shipping</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Settings</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Shipping Settings Form Starts -->
  <div class="space-y-4">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Default Shipping Charge</h6>
        <p class="card-subtitle">Configure the default shipping charge that will be applied when no specific zone-based charge is available.</p>
      </div>

      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success mb-4">
            <i class="w-5 h-5" data-feather="check-circle"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger mb-4">
            <i class="w-5 h-5" data-feather="alert-circle"></i>
            <span>Please fix the following errors:</span>
            <ul class="mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.shipping-settings.update') }}" method="POST" class="space-y-4">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="default_shipping_charge" class="form-label required">Default Shipping Charge (BDT)</label>
            <input
              type="number"
              id="default_shipping_charge"
              name="default_shipping_charge"
              value="{{ old('default_shipping_charge', $defaultShippingCharge) }}"
              class="form-control @error('default_shipping_charge') is-invalid @enderror"
              placeholder="Enter default shipping charge"
              min="0"
              step="0.01"
              required
            />
            @error('default_shipping_charge')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">This charge will be used as fallback when no zone-specific charge is configured.</div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">
              <i class="w-4 h-4 mr-2" data-feather="save"></i>
              Update Settings
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Shipping Settings Form Ends -->
</x-admin-layout>
