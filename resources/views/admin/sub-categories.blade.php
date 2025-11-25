<x-admin-layout title="Subcategories List">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Subcategories List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Subcategories List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Subcategories List Starts -->
  <div class="space-y-4">
    <!-- Subcategory Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Subcategory Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search subcategories" />
      </form>
      <!-- Subcategory Search Ends -->

      <!-- Subcategory Action Starts -->
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
                  <h2 class="my-1 text-sm font-medium">Category</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Category</option>
                    <option value="1">Sneakers</option>
                    <option value="2">Boots</option>
                    <option value="3">Sandals</option>
                    <option value="4">Formal Shoes</option>
                  </select>
                </li>
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Status</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
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

        <a class="btn btn-primary" href="{{ route('admin.subcategories.create') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Subcategory</span>
        </a>
      </div>
      <!-- Subcategory Action Ends -->
    </div>
    <!-- Subcategory Header Ends -->

    <!-- Subcategory Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".subcategory-checkbox" />
            </th>
            <th class="w-[20%] uppercase">Subcategory</th>
            <th class="w-[20%] uppercase">Category</th>
            <th class="w-[30%] uppercase">Child Categories</th>
            <th class="w-[10%] uppercase">Status</th>
            <th class="w-[10%] uppercase">Created Date</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($subcategories as $subcategory)
            <tr>
              <td>
                <input class="checkbox subcategory-checkbox" type="checkbox" value="{{ $subcategory->id }}" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    @if($subcategory->image)
                      <img class="avatar-img" src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}" />
                    @else
                      <div class="avatar-img bg-slate-200 flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $subcategory->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $subcategory->slug }}</p>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge badge-soft-primary">{{ $subcategory->category->name ?? 'N/A' }}</span>
              </td>
              <td>
                <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                  {{ $subcategory->childCategories->count() }}
                </p>
              </td>
              <td>
                @if($subcategory->is_active)
                  <div class="badge badge-soft-success">Active</div>
                @else
                  <div class="badge badge-soft-danger">Inactive</div>
                @endif
              </td>
              <td>{{ $subcategory->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.subcategories.show', $subcategory) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <button type="button" class="dropdown-link delete-subcategory" 
                            data-id="{{ $subcategory->id }}"
                            data-name="{{ $subcategory->name }}"
                            data-url="{{ route('admin.subcategories.destroy', $subcategory) }}">
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
                  <i class="w-12 h-12 text-slate-300 mb-4" data-feather="folder-open"></i>
                  <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No subcategories found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Get started by creating your first
                    subcategory.</p>
                  <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    <span>Add Subcategory</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Subcategory Table Ends -->

    <!-- Subcategory Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $subcategories->firstItem() ?? 0 }} to {{ $subcategories->lastItem() ?? 0 }} of
        {{ $subcategories->total() }} subcategories
      </p>
      <!-- Pagination -->
      @if ($subcategories->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($subcategories->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $subcategories->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </a>
              </li>
            @endif

            @foreach ($subcategories->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
              @if ($page == $subcategories->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($subcategories->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $subcategories->nextPageUrl() }}">
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
    <!-- Subcategory Pagination Ends -->
  </div>
  <!-- Subcategories List Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.addEventListener('click', function(e) {
          if (e.target.closest('.delete-subcategory')) {
            e.preventDefault();
            
            const button = e.target.closest('.delete-subcategory');
            const subcategoryId = button.getAttribute('data-id');
            const subcategoryName = button.getAttribute('data-name');
            const deleteUrl = button.getAttribute('data-url');
            const row = button.closest('tr');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${subcategoryName}" subcategory?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete it!',
              showLoaderOnConfirm: true,
              preConfirm: () => {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                // Add method spoofing for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                
                return fetch(form.action, {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: new URLSearchParams({
                    '_method': 'DELETE',
                    '_token': csrfToken
                  })
                })
                .then(async response => {
                  const data = await response.json();
                  if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete subcategory');
                  }
                  return data;
                })
                .catch(error => {
                  console.error('Error:', error);
                  Swal.showValidationMessage(
                    error.message || 'Failed to delete subcategory. Please try again.'
                  );
                  return Promise.reject(error);
                });
              },
              allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
              if (result.isConfirmed) {
                // The actual deletion is handled in the preConfirm, so we just need to handle the success case
                if (result.value && result.value.success) {
                  // Remove the row from the table
                  if (row) {
                    row.remove();
                  }
                  
                  // Show success message
                  Swal.fire(
                    'Deleted!',
                    result.value.message || 'The subcategory has been deleted.',
                    'success'
                  );
                  
                  // Check if the table is empty after deletion
                  const tbody = document.querySelector('tbody');
                  const rows = tbody ? tbody.querySelectorAll('tr') : [];
                  if (rows.length === 1 && rows[0].querySelector('td[colspan]')) {
                    // If only the empty state row remains, reload the page to show the empty state
                    window.location.reload();
                  } else if (rows.length === 0) {
                    // If no rows left, reload the page
                    window.location.reload();
                  }
                }
              }
            });
          }
        });

        // Search functionality
        const searchInput = document.querySelector('input[placeholder="Search subcategories"]');
        if (searchInput) {
          searchInput.addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
              if (row.cells.length > 1) { // Skip empty state row
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                  row.style.display = '';
                } else {
                  row.style.display = 'none';
                }
              }
            });
          });
        }

        // Bulk delete functionality
        const bulkDeleteBtn = document.querySelector('.bulk-delete-btn');
        if (bulkDeleteBtn) {
          bulkDeleteBtn.addEventListener('click', function () {
            const selectedIds = [];
            document.querySelectorAll('.subcategory-checkbox:checked').forEach(checkbox => {
              selectedIds.push(checkbox.value);
            });

            if (selectedIds.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select subcategories to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete ${selectedIds.length} selected subcategories?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
              if (result.isConfirmed) {
                // Create a form to submit the bulk delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `${window.location.origin}/admin/subcategories/bulk-delete`;

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

                // Add selected IDs
                selectedIds.forEach(id => {
                  const idInput = document.createElement('input');
                  idInput.type = 'hidden';
                  idInput.name = 'ids[]';
                  idInput.value = id;
                  form.appendChild(idInput);
                });

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
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