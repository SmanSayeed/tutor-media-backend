<x-admin-layout title="Colors List">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Colors List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Colors</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Colors List Starts -->
  <div class="space-y-4">
    <!-- Color Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Color Search Starts -->
      <form method="GET" action="{{ route('admin.colors.index') }}"
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" name="search" placeholder="Search colors" value="{{ request('search') }}" />
      </form>
      <!-- Color Search Ends -->

      <!-- Color Action Starts -->
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
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => 'asc'])) }}"
                    class="dropdown-link">Name (A-Z)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Name (Z-A)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => 'asc'])) }}"
                    class="dropdown-link">Code (A-Z)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Code (Z-A)</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => 'desc'])) }}"
                    class="dropdown-link">Newest First</a>
                </li>
                <li class="dropdown-list-item">
                  <a href="{{ route('admin.colors.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => 'asc'])) }}"
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
          <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
            <i class="w-4" data-feather="plus"></i>
            <span>Add Color</span>
          </a>
        </div>
      </div>
      <!-- Color Action Ends -->
    </div>
    <!-- Color Header Ends -->

    <!-- Colors Table Starts -->
    <div class="card">
      <div class="card-body">
        <form id="filterForm" method="GET" action="{{ route('admin.colors.index') }}">
          <input type="hidden" name="status" value="{{ request('status') }}">
        </form>

        <form id="bulkActionForm" method="DELETE" action="{{ route('admin.colors.bulk-destroy') }}">
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
                  <th>Code</th>
                  <th>Hex Code</th>
                  <th>Products</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th class="w-32">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($colors as $color)
                  <tr>
                    <td>
                      <div class="flex items-center">
                        <input type="checkbox" name="ids[]" value="{{ $color->id }}" class="item-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      </div>
                    </td>
                    <td>
                      <div class="flex items-center gap-3">
                        @if($color->hex_code)
                          <div class="h-4 w-4 rounded-full border border-slate-300" style="background-color: {{ $color->hex_code }}"></div>
                        @endif
                        <span class="font-medium">{{ $color->name }}</span>
                      </div>
                    </td>
                    <td>{{ $color->code }}</td>
                    <td>
                      @if($color->hex_code)
                        <code class="text-xs text-slate-700">{{ $color->hex_code }}</code>
                      @else
                        <span class="text-slate-400">-</span>
                      @endif
                    </td>
                    <td>{{ $color->products()->count() }}</td>
                    <td>
                      <span class="badge {{ $color->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $color->is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>{{ $color->created_at->format('M d, Y') }}</td>
                    <td>
                      <div class="flex items-center gap-2">
                        <a href="{{ route('admin.colors.show', $color) }}" class="btn btn-sm btn-outline-info">
                          <i class="w-4 h-4" data-feather="eye"></i>
                        </a>
                        <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-sm btn-outline-warning">
                          <i class="w-4 h-4" data-feather="edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm {{ $color->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                          onclick="toggleStatus({{ $color->id }}, '{{ $color->is_active ? 'deactivate' : 'activate' }}')">
                          <i class="w-4 h-4" data-feather="{{ $color->is_active ? 'x' : 'check' }}"></i>
                        </button>
                         <button class="btn btn-sm btn-outline-danger {{ $color->products()->count() > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                           onclick="return confirmDelete(event, {{ $color->id }}, '{{ $color->name }}')"
                           {{ $color->products()->count() > 0 ? 'disabled' : '' }}>
                           <i class="w-4 h-4" data-feather="trash-2"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center py-8">
                      <div class="flex flex-col items-center gap-2">
                        <i class="w-12 h-12 text-slate-300" data-feather="palette"></i>
                        <p class="text-slate-500">No colors found</p>
                        <a href="{{ route('admin.colors.create') }}" class="btn btn-primary btn-sm">
                          <i class="w-4 h-4" data-feather="plus"></i>
                          Add First Color
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </form>

        @if($colors->hasPages())
          <div class="mt-6">
            {{ $colors->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    </div>
    <!-- Colors Table Ends -->
  </div>
  <!-- Colors List Ends -->

  @push('scripts')
    <script>
      // Select all checkboxes
      document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
          selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
              checkbox.checked = this.checked;
              // Trigger change event manually for each checkbox
              checkbox.dispatchEvent(new Event('change'));
            });
            updateBulkDeleteButton();
          });
        }

        // Update bulk delete button visibility
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
          checkbox.addEventListener('change', updateBulkDeleteButton);
        });
      });

      function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        if (bulkDeleteBtn) {
          bulkDeleteBtn.classList.toggle('hidden', checkedBoxes.length === 0);
        }
      }

      // Toggle status
      function toggleStatus(id, action) {
        if (confirm(`Are you sure you want to ${action} this color?`)) {
          fetch(`{{ url('admin/colors') }}/${id}/toggle-status`, {
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
         const button = event.target.closest('a, button');
         if (button && button.disabled) {
           return false;
         }

         if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
           const form = document.createElement('form');
          form.method = 'POST';
          form.action = `{{ url('admin/colors') }}/${id}`;
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
          
          return false;
         }
       }

      // Clear filters
      function clearFilters() {
        window.location.href = '{{ route("admin.colors.index") }}';
      }

      // Bulk delete
      document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkedBoxes.length === 0) {
          alert('Please select at least one color to delete.');
          return;
        }

        // Filter out colors that have variants
        const validBoxes = Array.from(checkedBoxes).filter(checkbox => {
          const row = checkbox.closest('tr');
          const variantsCount = parseInt(row.querySelector('td:nth-child(5)').textContent.trim());
          return variantsCount === 0;
        });

        if (validBoxes.length === 0) {
          alert('None of the selected colors can be deleted because they are associated with products.');
          return;
        }

        if (validBoxes.length !== checkedBoxes.length) {
          alert(`${checkedBoxes.length - validBoxes.length} color(s) cannot be deleted because they are associated with products. Only ${validBoxes.length} color(s) will be deleted.`);
        }

        if (confirm(`Are you sure you want to delete ${validBoxes.length} selected color(s)? This action cannot be undone.`)) {
          // Uncheck the invalid boxes
          checkedBoxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const variantsCount = parseInt(row.querySelector('td:nth-child(5)').textContent.trim());
            if (variantsCount > 0) {
              checkbox.checked = false;
            }
          });
          document.getElementById('bulkActionForm').submit();
        }
      });
    </script>
  @endpush
</x-admin-layout>