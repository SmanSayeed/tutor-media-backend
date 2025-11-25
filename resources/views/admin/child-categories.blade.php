<x-admin-layout title="Child Categories">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Child Categories List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.subcategories.index') }}">Subcategories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Child Categories List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Child Categories List Starts -->
  <div class="space-y-4">
    <!-- Child Category Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Child Category Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search child categories" />
      </form>
      <!-- Child Category Search Ends -->

      <!-- Child Category Action Starts -->
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
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </li>
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Subcategory</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $subcategory)
                      <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">
                        {{ $subcategory->name }} ({{ $subcategory->category->name }})
                      </option>
                    @endforeach
                  </select>
                </li>
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

        <a class="btn btn-primary" href="{{ route('admin.child-categories.create') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Child Category</span>
        </a>
      </div>
      <!-- Child Category Action Ends -->
    </div>
    <!-- Child Category Header Ends -->

    <!-- Child Category Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".child-category-checkbox" />
            </th>
            <th class="w-[20%] uppercase">Child Category</th>
            <th class="w-[20%] uppercase">Subcategory</th>
            <th class="w-[20%] uppercase">Category</th>
            <th class="w-[20%] uppercase">Products</th>
            <th class="w-[5%] uppercase">Status</th>
            <th class="w-[5%] uppercase">Created Date</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($childCategories as $childCategory)
            <tr>
              <td>
                <input class="checkbox child-category-checkbox" type="checkbox" value="{{ $childCategory->id }}" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    @if($childCategory->image)
                      <img class="avatar-img" src="{{ asset($childCategory->image) }}" alt="{{ $childCategory->name }}" />
                    @else
                      <div class="avatar-img bg-slate-200 flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $childCategory->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $childCategory->slug }}</p>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge badge-soft-primary">{{ $childCategory->subcategory->name ?? 'N/A' }}</span>
              </td>
              <td>
                <span class="badge badge-soft-secondary">{{ $childCategory->subcategory->category->name ?? 'N/A' }}</span>
              </td>
              <td>
                <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                  {{ $childCategory->products->count() }}
                </p>
              </td>
              <td>
                @if($childCategory->is_active)
                  <div class="badge badge-soft-success">Active</div>
                @else
                  <div class="badge badge-soft-danger">Inactive</div>
                @endif
              </td>
              <td>{{ $childCategory->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.child-categories.show', $childCategory) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.child-categories.edit', $childCategory) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <button type="button" class="dropdown-link delete-child-category"
                            data-id="{{ $childCategory->id }}" data-name="{{ $childCategory->name }}">
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
                  <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No child categories found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Get started by creating your first child
                    category.</p>
                  <a href="{{ route('admin.child-categories.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    <span>Add Child Category</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Child Category Table Ends -->

    <!-- Child Category Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $childCategories->firstItem() ?? 0 }} to {{ $childCategories->lastItem() ?? 0 }} of
        {{ $childCategories->total() }} child categories
      </p>
      <!-- Pagination -->
      @if ($childCategories->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($childCategories->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $childCategories->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </a>
              </li>
            @endif

            @foreach ($childCategories->getUrlRange(1, $childCategories->lastPage()) as $page => $url)
              @if ($page == $childCategories->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($childCategories->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $childCategories->nextPageUrl() }}">
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
    <!-- Child Category Pagination Ends -->
  </div>
  <!-- Child Categories List Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-child-category').forEach(button => {
          button.addEventListener('click', function () {
            const childCategoryId = this.getAttribute('data-id');
            const childCategoryName = this.getAttribute('data-name');
  
            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${childCategoryName}" child category?`,
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
                form.action = `${window.location.origin}/admin/child-categories/${childCategoryId}`;
  
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
        const searchInput = document.querySelector('input[placeholder="Search child categories"]');
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
            document.querySelectorAll('.child-category-checkbox:checked').forEach(checkbox => {
              selectedIds.push(checkbox.value);
            });
  
            if (selectedIds.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select child categories to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }
  
            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete ${selectedIds.length} selected child categories?`,
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
                form.action = `${window.location.origin}/admin/child-categories/bulk-delete`;
  
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
