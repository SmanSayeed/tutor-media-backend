<x-admin-layout title="Sizes List">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Sizes List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Sizes</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Sizes List Starts -->
  <div class="space-y-4">
    <!-- Size Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Size Search Starts -->
      <form method="GET" action="{{ route('admin.sizes.index') }}"
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" name="search" placeholder="Search sizes" value="{{ request('search') }}" />
      </form>
      <!-- Size Search Ends -->

      <!-- Size Action Starts -->
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
                  <h2 class="my-1 text-sm font-medium">Status</h2>
                  <div class="space-y-2">
                    <label class="flex items-center">
                      <input type="radio" name="status" value="" class="radio" {{ !request('status') ? 'checked' : '' }}>
                      <span class="ml-2 text-sm">All</span>
                    </label>
                    <label class="flex items-center">
                      <input type="radio" name="status" value="active" class="radio" {{ request('status') === 'active' ? 'checked' : '' }}>
                      <span class="ml-2 text-sm">Active</span>
                    </label>
                    <label class="flex items-center">
                      <input type="radio" name="status" value="inactive" class="radio" {{ request('status') === 'inactive' ? 'checked' : '' }}>
                      <span class="ml-2 text-sm">Inactive</span>
                    </label>
                  </div>
                </li>
              </ul>
              <div class="flex items-center justify-between p-4">
                <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear</button>
                <button type="submit" form="filterForm" class="btn btn-primary">Apply</button>
              </div>
            </div>
          </div>

          <div class="dropdown" data-placement="bottom-end">
            <div class="dropdown-toggle">
              <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                <i class="w-4" data-feather="arrow-up-down"></i>
                <span class="hidden sm:inline-block">Sort</span>
                <i class="w-4" data-feather="chevron-down"></i>
              </button>
            </div>
            <div class="dropdown-content w-72">
              <ul class="dropdown-list">
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => 'asc'])) }}"
                    class="dropdown-link">Name (A-Z)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Name (Z-A)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => 'asc'])) }}"
                    class="dropdown-link">Code (A-Z)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Code (Z-A)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Newest First</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.sizes.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => 'asc'])) }}"
                    class="dropdown-link">Oldest First</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-x-4">
          <button type="button" id="bulkDeleteBtn" class="btn btn-danger hidden">
            <i class="w-4" data-feather="trash-2"></i>
            <span>Delete Selected</span>
          </button>
          <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">
            <i class="w-4" data-feather="plus"></i>
            <span>Add Size</span>
          </a>
        </div>
      </div>
      <!-- Size Action Ends -->
    </div>
    <!-- Size Header Ends -->

    <!-- Sizes Table Starts -->
    <div class="card">
      <div class="card-body">
        <form id="filterForm" method="GET" action="{{ route('admin.sizes.index') }}">
          <input type="hidden" name="status" value="{{ request('status') }}">
        </form>

        <form id="bulkActionForm" method="DELETE" action="{{ route('admin.sizes.bulk-destroy') }}">
          @csrf

          <div class="overflow-x-auto">
            <table class="table">
              <thead>
                <tr>
                  <th class="w-12">
                    <label class="checkbox">
                      <input type="checkbox" id="selectAll">
                      <span class="checkmark"></span>
                    </label>
                  </th>
                  <th>Name</th>
                  <th>Variants Count</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th class="w-32">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sizes as $size)
                  <tr>
                    <td>
                      <label class="checkbox">
                        <input type="checkbox" name="ids[]" value="{{ $size->id }}" class="row-checkbox">
                        <span class="checkmark"></span>
                      </label>
                    </td>
                    <td>
                      <span class="font-medium">{{ $size->name }}</span>
                    </td>
                    <td>{{ $size->variants_count }}</td>
                    <td>
                      <span class="badge {{ $size->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $size->is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>{{ $size->created_at->format('M d, Y') }}</td>
                    <td>
                      <div class="flex items-center gap-2">
                        <a href="{{ route('admin.sizes.show', $size) }}" class="btn btn-sm btn-outline-info">
                          <i class="w-4 h-4" data-feather="eye"></i>
                        </a>
                        <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-sm btn-outline-warning">
                          <i class="w-4 h-4" data-feather="edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm {{ $size->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                          onclick="toggleStatus({{ $size->id }}, '{{ $size->is_active ? 'deactivate' : 'activate' }}')">
                          <i class="w-4 h-4" data-feather="{{ $size->is_active ? 'x' : 'check' }}"></i>
                        </button>
                         <button class="btn btn-sm btn-outline-danger {{ $size->variants_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                           onclick="return confirmDelete(event, {{ $size->id }}, '{{ $size->name }}')"
                           {{ $size->variants_count > 0 ? 'disabled' : '' }}>
                           <i class="w-4 h-4" data-feather="trash-2"></i>
                         </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-8">
                      <div class="flex flex-col items-center gap-2">
                        <i class="w-12 h-12 text-slate-300" data-feather="maximize"></i>
                        <p class="text-slate-500">No sizes found</p>
                        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary btn-sm">
                          <i class="w-4 h-4" data-feather="plus"></i>
                          Add First Size
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </form>

        @if($sizes->hasPages())
          <div class="mt-6">
            {{ $sizes->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    </div>
    <!-- Sizes Table Ends -->
  </div>
  <!-- Sizes List Ends -->

  @push('scripts')
    <script>
      // Select all checkboxes
      document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        updateBulkDeleteButton();
      });

      // Update bulk delete button visibility
      document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteButton);
      });

      function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        bulkDeleteBtn.classList.toggle('hidden', checkedBoxes.length === 0);
      }

      // Toggle status
      function toggleStatus(id, action) {
        if (confirm(`Are you sure you want to ${action} this size?`)) {
          fetch(`{{ url('admin/sizes') }}/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating status');
          });
        }
      }

       // Confirm delete
       function confirmDelete(event, id, name) {
         // Prevent default link behavior
         event.preventDefault();
         event.stopPropagation();
         
         // Check if the button that triggered this is disabled
         const button = event.target.closest('button, a');
         if (button && button.disabled) {
           return false;
         }

         if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
           const form = document.createElement('form');
           form.method = 'POST';
           form.action = `{{ url('admin/sizes') }}/${id}`;
           form.style.display = 'none';

           // Add method spoofing for DELETE
           const method = document.createElement('input');
           method.type = 'hidden';
           method.name = '_method';
           method.value = 'DELETE';
           form.appendChild(method);

           const csrfToken = document.createElement('input');
           csrfToken.type = 'hidden';
           csrfToken.name = '_token';
           csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           form.appendChild(csrfToken);

           document.body.appendChild(form);
           form.submit();
         }
         return false;
      }

      // Clear filters
      function clearFilters() {
        window.location.href = '{{ route("admin.sizes.index") }}';
      }

      // Bulk delete
      document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) {
          alert('Please select at least one size to delete.');
          return;
        }

        // Filter out sizes that have variants
        const validBoxes = Array.from(checkedBoxes).filter(checkbox => {
          const row = checkbox.closest('tr');
          const variantsCount = parseInt(row.querySelector('td:nth-child(3)').textContent.trim());
          return variantsCount === 0;
        });

        if (validBoxes.length === 0) {
          alert('None of the selected sizes can be deleted because they are associated with products.');
          return;
        }

        if (validBoxes.length !== checkedBoxes.length) {
          if (!confirm(`${checkedBoxes.length - validBoxes.length} size(s) cannot be deleted because they are associated with products. Do you want to delete the remaining ${validBoxes.length} size(s)?`)) {
            return;
          }
        }

        // Create form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.sizes.bulk-destroy") }}';
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);

        // Add method spoofing for DELETE
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        // Add selected size IDs
        validBoxes.forEach(checkbox => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'ids[]';
          input.value = checkbox.value;
          form.appendChild(input);
        });

        // Submit the form
        document.body.appendChild(form);
        form.submit();
      });
    </script>
  @endpush
</x-admin-layout>