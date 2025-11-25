<x-admin-layout title="Shipping Zone Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Shipping Zone Details</h5>

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
        <a href="#">Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Shipping Zone Details Starts -->
  <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <!-- Zone Information -->
    <div class="xl:col-span-2">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Zone Information</h4>
        </div>
        <div class="card-body">
          <div class="space-y-6">
            <!-- Division and Zone -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label class="form-label">Division Name</label>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-100">{{ $zone->division_name }}</p>
              </div>
              <div>
                <label class="form-label">Zone Name</label>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-100">{{ $zone->zone_name }}</p>
              </div>
            </div>

            <!-- Shipping Charge and Status -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label class="form-label">Shipping Charge</label>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-100">
                  ${{ number_format($zone->shipping_charge ?? 0, 2) }}
                  @if(!$zone->shipping_charge)
                    <span class="text-xs text-slate-500">(Uses default)</span>
                  @endif
                </p>
              </div>
              <div>
                <label class="form-label">Status</label>
                <div class="flex items-center gap-2">
                  @if($zone->status === 'active')
                    <div class="badge badge-soft-success">Active</div>
                  @else
                    <div class="badge badge-soft-danger">Inactive</div>
                  @endif
                </div>
              </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label class="form-label">Created At</label>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-100">{{ $zone->created_at->format('d M Y, H:i') }}</p>
              </div>
              <div>
                <label class="form-label">Updated At</label>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-100">{{ $zone->updated_at->format('d M Y, H:i') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Actions Sidebar -->
    <div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Actions</h4>
        </div>
        <div class="card-body">
          <div class="space-y-3">
            <a href="{{ route('admin.shipping-zones.edit', $zone) }}" class="btn btn-primary w-full">
              <i data-feather="edit" class="w-4 h-4"></i>
              <span>Edit Zone</span>
            </a>

            <button type="button" class="btn btn-outline-secondary w-full toggle-status"
                    data-id="{{ $zone->id }}"
                    data-status="{{ $zone->status }}">
              <i data-feather="{{ $zone->status === 'active' ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
              <span>{{ $zone->status === 'active' ? 'Deactivate' : 'Activate' }} Zone</span>
            </button>

            <button type="button" class="btn btn-outline-primary w-full edit-charge-btn"
                    data-id="{{ $zone->id }}"
                    data-charge="{{ $zone->shipping_charge ?? 0 }}">
              <i data-feather="dollar-sign" class="w-4 h-4"></i>
              <span>Update Charge</span>
            </button>

            <hr class="my-4">

            <button type="button" class="btn btn-outline-danger w-full delete-zone"
                    data-id="{{ $zone->id }}"
                    data-name="{{ $zone->division_name }} - {{ $zone->zone_name }}">
              <i data-feather="trash" class="w-4 h-4"></i>
              <span>Delete Zone</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Quick Stats -->
      <div class="card mt-6">
        <div class="card-header">
          <h4 class="card-title">Quick Stats</h4>
        </div>
        <div class="card-body">
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <span class="text-sm text-slate-600 dark:text-slate-400">Zone ID</span>
              <span class="text-sm font-medium">#{{ $zone->id }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm text-slate-600 dark:text-slate-400">Last Modified</span>
              <span class="text-sm font-medium">{{ $zone->updated_at->diffForHumans() }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Back Button -->
  <div class="mt-6">
    <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-outline-secondary">
      <i data-feather="arrow-left" class="w-4 h-4"></i>
      <span>Back to Shipping Zones</span>
    </a>
  </div>
  <!-- Shipping Zone Details Ends -->

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-zone').forEach(button => {
          button.addEventListener('click', function () {
            const zoneId = this.getAttribute('data-id');
            const zoneName = this.getAttribute('data-name');

            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${zoneName}" shipping zone?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.shipping-zones.destroy", ":zoneId") }}'.replace(':zoneId', zoneId);

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Add method DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
              }
            });
          });
        });

        // Toggle status
        document.querySelectorAll('.toggle-status').forEach(button => {
          button.addEventListener('click', function () {
            const zoneId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');

            fetch('{{ route("admin.shipping-zones.toggle-status", ":zoneId") }}'.replace(':zoneId', zoneId), {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                location.reload();
              } else {
                Swal.fire('Error', data.message, 'error');
              }
            })
            .catch(error => {
              Swal.fire('Error', 'An error occurred while updating status.', 'error');
            });
          });
        });

        // Edit charge inline
        document.querySelectorAll('.edit-charge-btn').forEach(button => {
          button.addEventListener('click', function () {
            const zoneId = this.getAttribute('data-id');
            const currentCharge = this.getAttribute('data-charge');

            Swal.fire({
              title: 'Update Shipping Charge',
              input: 'number',
              inputLabel: 'Shipping Charge ($)',
              inputValue: currentCharge,
              inputAttributes: {
                min: 0,
                step: 0.01
              },
              showCancelButton: true,
              confirmButtonText: 'Update',
              preConfirm: (charge) => {
                if (charge < 0) {
                  Swal.showValidationMessage('Shipping charge cannot be negative');
                  return false;
                }
                return charge;
              }
            }).then((result) => {
              if (result.isConfirmed) {
                fetch('{{ route("admin.shipping-zones.update-charge", ":zoneId") }}'.replace(':zoneId', zoneId), {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                  },
                  body: JSON.stringify({
                    shipping_charge: result.value
                  })
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    location.reload();
                  } else {
                    Swal.fire('Error', data.message, 'error');
                  }
                })
                .catch(error => {
                  Swal.fire('Error', 'An error occurred while updating charge.', 'error');
                });
              }
            });
          });
        });
      });
    </script>
  @endpush
</x-admin-layout>
