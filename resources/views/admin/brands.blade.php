<x-admin-layout title="Brands List">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Brands List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Brands List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Brands List Starts -->
  <div class="space-y-4">
    <!-- Brand Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Brand Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search brands" />
      </form>
      <!-- Brand Search Ends -->

      <!-- Brand Action Starts -->
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
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
            <i class="h-4" data-feather="upload"></i>
            <span class="hidden sm:inline-block">Export</span>
          </button>
          <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800 bulk-delete-btn">
            <i class="h-4" data-feather="trash-2"></i>
            <span class="hidden sm:inline-block">Delete Selected</span>
          </button>
        </div>

        <a class="btn btn-primary" href="{{ route('admin.create-brand') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Brand</span>
        </a>
      </div>
      <!-- Brand Action Ends -->
    </div>
    <!-- Brand Header Ends -->

    <!-- Brand Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".brand-checkbox" />
            </th>
            <th class="w-[20%] uppercase">Brand</th>
            <th class="w-[25%] uppercase">Description</th>
            <th class="w-[15%] uppercase">Website</th>
            <th class="w-[10%] uppercase">Products</th>
            <th class="w-[10%] uppercase">Status</th>
            <th class="w-[10%] uppercase">Created Date</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($brands as $brand)
            <tr>
              <td>
                <input class="checkbox brand-checkbox" type="checkbox" value="{{ $brand->id }}" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    @if($brand->logo)
                      <img class="avatar-img" src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" />
                    @else
                      <div class="avatar-img bg-slate-200 flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $brand->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $brand->slug }}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                  {{ $brand->description ?? 'No description available' }}
                </p>
              </td>
              <td>
                @if($brand->website)
                  <a href="{{ $brand->website }}" target="_blank" class="text-primary-500 hover:underline">
                    {{ parse_url($brand->website, PHP_URL_HOST) }}
                  </a>
                @else
                  <span class="text-slate-400">N/A</span>
                @endif
              </td>
              <td>
                <span class="badge badge-soft-primary">{{ $brand->products->count() }}</span>
              </td>
              <td>
                @if($brand->is_active)
                  <div class="badge badge-soft-success">Active</div>
                @else
                  <div class="badge badge-soft-danger">Inactive</div>
                @endif
              </td>
              <td>{{ $brand->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.brands.show', $brand) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.brands.edit', $brand) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <button type="button" class="dropdown-link delete-brand" data-id="{{ $brand->id }}"
                            data-name="{{ $brand->name }}">
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
              <td colspan="8" class="text-center py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="w-12 h-12 text-slate-300 mb-4" data-feather="folder-open"></i>
                  <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No brands found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Get started by creating your first brand.</p>
                  <a href="{{ route('admin.create-brand') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    <span>Add Brand</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Brand Table Ends -->

    <!-- Brand Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $brands->firstItem() ?? 0 }} to {{ $brands->lastItem() ?? 0 }} of {{ $brands->total() }} brands
      </p>
      <!-- Pagination -->
      @if ($brands->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($brands->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $brands->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </a>
              </li>
            @endif

            @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
              @if ($page == $brands->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($brands->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $brands->nextPageUrl() }}">
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
    <!-- Brand Pagination Ends -->
  </div>
  <!-- Brands List Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-brand').forEach(button => {
          button.addEventListener('click', function () {
            const brandId = this.getAttribute('data-id');
            const brandName = this.getAttribute('data-name');
  
            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${brandName}" brand?`,
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
                form.action = `${window.location.origin}/admin/brands/${brandId}`;
  
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
  
        // Search functionality
        const searchInput = document.querySelector('input[placeholder="Search brands"]');
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
            document.querySelectorAll('.brand-checkbox:checked').forEach(checkbox => {
              selectedIds.push(checkbox.value);
            });
  
            if (selectedIds.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select brands to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }
  
            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete ${selectedIds.length} selected brands?`,
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
                form.action = `${window.location.origin}/admin/brands`;
  
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
