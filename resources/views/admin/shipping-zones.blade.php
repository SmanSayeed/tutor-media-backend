<x-admin-layout title="Shipping Zones">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Shipping Zones List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Shipping</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Shipping Zones</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Shipping Zones List Starts -->
  <div class="space-y-4">
    <!-- Shipping Zone Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Shipping Zone Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search zones" />
      </form>
      <!-- Shipping Zone Search Ends -->

      <!-- Shipping Zone Action Starts -->
      <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
        <div class="flex items-center gap-x-4">
          <div class="dropdown" data-placement="bottom-end">
            <div class="dropdown-toggle">
              <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                <i class="w-4" data-feather="filter"></i>
                <span class="hidden sm:inline-block">Filter</span>
                <i class="w-4" data-feather="chevron-down"></i>
              </button>
            </div>
            <div class="dropdown-content w-72 !overflow-visible">
              <ul class="dropdown-list space-y-4 p-4">
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Division</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Division</option>
                    @foreach($divisions as $division)
                      <option value="{{ $division }}">{{ $division }}</option>
                    @endforeach
                  </select>
                </li>
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Status</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="deactive">Inactive</option>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800 bulk-delete-btn">
            <i class="h-4" data-feather="trash-2"></i>
            <span class="hidden sm:inline-block">Delete Selected</span>
          </button>
        </div>

        <a class="btn btn-primary" href="{{ route('admin.shipping-zones.create') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Zone</span>
        </a>
      </div>
      <!-- Shipping Zone Action Ends -->
    </div>
    <!-- Shipping Zone Header Ends -->

    <!-- Shipping Zone Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".zone-checkbox" />
            </th>
            <th class="w-[20%] uppercase">Division</th>
            <th class="w-[20%] uppercase">Zone</th>
            <th class="w-[15%] uppercase">Shipping Charge</th>
            <th class="w-[15%] uppercase">Status</th>
            <th class="w-[15%] uppercase">Created</th>
            <th class="w-[10%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($zones as $zone)
            <tr>
              <td>
                <input class="checkbox zone-checkbox" type="checkbox" value="{{ $zone->id }}" />
              </td>
              <td>
                <span class="text-sm font-medium">{{ $zone->division_name }}</span>
              </td>
              <td>
                <span class="text-sm font-medium">{{ $zone->zone_name }}</span>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <span class="text-sm font-semibold">${{ number_format($zone->shipping_charge ?? 0, 2) }}</span>
                  <button type="button" class="edit-charge-btn text-primary-500 hover:text-primary-700"
                          data-id="{{ $zone->id }}"
                          data-charge="{{ $zone->shipping_charge ?? 0 }}">
                    <i class="w-4 h-4" data-feather="edit-2"></i>
                  </button>
                </div>
              </td>
              <td>
                @if($zone->status === 'active')
                  <div class="badge badge-soft-success">Active</div>
                @else
                  <div class="badge badge-soft-danger">Inactive</div>
                @endif
              </td>
              <td>{{ $zone->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.shipping-zones.show', $zone) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.shipping-zones.edit', $zone) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <button type="button" class="dropdown-link toggle-status"
                                  data-id="{{ $zone->id }}"
                                  data-status="{{ $zone->status }}">
                            <i class="h-5 text-slate-400" data-feather="{{ $zone->status === 'active' ? 'eye-off' : 'eye' }}"></i>
                            <span>{{ $zone->status === 'active' ? 'Deactivate' : 'Activate' }}</span>
                          </button>
                        </li>
                        <li class="dropdown-list-item">
                          <button type="button" class="dropdown-link delete-zone"
                                  data-id="{{ $zone->id }}"
                                  data-name="{{ $zone->division_name }} - {{ $zone->zone_name }}">
                            <i class="h-5 text-slate-400" data-feather="trash"></i>
                            <span>Delete</span>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="w-12 h-12 text-slate-300 mb-4" data-feather="map-pin"></i>
                  <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No shipping zones found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Get started by creating your first shipping zone.</p>
                  <a href="{{ route('admin.shipping-zones.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    <span>Add Zone</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Shipping Zone Table Ends -->

    <!-- Shipping Zone Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $zones->firstItem() ?? 0 }} to {{ $zones->lastItem() ?? 0 }} of {{ $zones->total() }}
        shipping zones
      </p>
      <!-- Pagination -->
      @if ($zones->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($zones->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $zones->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </a>
              </li>
            @endif

            @foreach ($zones->getUrlRange(1, $zones->lastPage()) as $page => $url)
              @if ($page == $zones->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($zones->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $zones->nextPageUrl() }}">
                  <i data-feather="chevron-right" width="1em" height="1em"></i>
                </a>
              </li>
            @else
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-next-icon">
                  <i data-feather="chevron-right" width="1em" height="1em"></i>
                </span>
              </li>
            @endif
          </ul>
        </nav>
      @endif
    </div>
    <!-- Shipping Zone Pagination Ends -->
  </div>
  <!-- Shipping Zones List Ends -->

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

        // Bulk delete functionality
        const bulkDeleteBtn = document.querySelector('.bulk-delete-btn');
        if (bulkDeleteBtn) {
          bulkDeleteBtn.addEventListener('click', function () {
            const selectedCheckboxes = document.querySelectorAll('.zone-checkbox:checked');

            if (selectedCheckboxes.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select shipping zones to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete ${selectedIds.length} selected shipping zones?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
              if (result.isConfirmed) {
                // Create a form to submit the bulk delete request
                const form = document.createElement('form');
                form.method = 'DELETE';
                form.action = '{{ route("admin.shipping-zones.bulk-destroy") }}';

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Add selected IDs
                selectedIds.forEach(id => {
                  const idInput = document.createElement('input');
                  idInput.type = 'hidden';
                  idInput.name = 'ids[]';
                  idInput.value = id;
                  form.appendChild(idInput);
                });

                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
              }
            });
          });
        }
      });
    </script>
  @endpush
</x-admin-layout>
