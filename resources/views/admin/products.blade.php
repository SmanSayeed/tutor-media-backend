<x-admin-layout title="Products">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Products List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Products List Starts -->
  <div class="space-y-4">
    <!-- Product Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Product Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search products" />
      </form>
      <!-- Product Search Ends -->

      <!-- Product Action Starts -->
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
                  <h2 class="my-1 text-sm font-medium">Brand</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Stock Status</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Stock Status</option>
                    <option value="in_stock">In Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                    <option value="low_stock">Low Stock</option>
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

        <a class="btn btn-primary" href="{{ route('admin.products.create') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Product</span>
        </a>
      </div>
      <!-- Product Action Ends -->
    </div>
    <!-- Product Header Ends -->

    <!-- Product Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".product-checkbox" />
            </th>
            <th class="w-[25%] uppercase">Product</th>
            <th class="w-[10%] uppercase">SKU</th>
            <th class="w-[10%] uppercase">Price</th>
            <th class="w-[10%] uppercase">Stock</th>
            <th class="w-[10%] uppercase">Brand</th>
            <th class="w-[10%] uppercase">Category</th>
            <th class="w-[10%] uppercase">Status</th>
            <th class="w-[10%] uppercase">Created</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
            <tr>
              <td>
                <input class="checkbox product-checkbox" type="checkbox" value="{{ $product->id }}" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    @if($product->primaryImage())
                      <img class="avatar-img" src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}" />
                    @else
                      <div class="avatar-img bg-slate-200 flex items-center justify-center">
                        <i class="text-slate-400" data-feather="image"></i>
                      </div>
                    @endif
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $product->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $product->sku }}</p>
                  </div>
                </div>
              </td>
              <td>{{ $product->sku }}</td>
              <td>
                @if($product->sale_price)
                  <div>
                    <span
                      class="text-sm font-semibold text-primary-500">${{ number_format($product->sale_price, 2) }}</span>
                    <br>
                    <span class="text-xs text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                  </div>
                @else
                  <span class="text-sm font-semibold">${{ number_format($product->price, 2) }}</span>
                @endif
              </td>
              <td>
                <div class="flex flex-col">
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">{{ $product->totalStock() }} pcs</span>
                    <span class="text-xs text-slate-500">({{ $product->variants->count() }} variants)</span>
                  </div>
                  @php
                    $inStockVariants = $product->variants->where('stock_quantity', '>', 0)->count();
                    $lowStockVariants = $product->variants->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', ($product->min_stock_level ?? 5))->count();
                    $outOfStockVariants = $product->variants->where('stock_quantity', 0)->count();
                  @endphp
                  @if($product->track_inventory)
                    @if($outOfStockVariants == $product->variants->count())
                      <span class="text-xs text-red-500">All Out of Stock</span>
                    @elseif($lowStockVariants > 0)
                      <span class="text-xs text-orange-500">{{ $lowStockVariants }} Low Stock</span>
                    @else
                      <span class="text-xs text-green-500">{{ $inStockVariants }} In Stock</span>
                    @endif
                  @else
                    <span class="text-xs text-blue-500">No Tracking</span>
                  @endif
                </div>
              </td>
              <td>
                <span class="badge badge-soft-primary">{{ $product->brand->name ?? 'N/A' }}</span>
              </td>
              <td>
                <span class="badge badge-soft-secondary">{{ $product->category->name ?? 'N/A' }}</span>
              </td>
              <td>
                @if($product->is_active)
                  <div class="badge badge-soft-success">Active</div>
                @else
                  <div class="badge badge-soft-danger">Inactive</div>
                @endif
              </td>
              <td>{{ $product->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.show', $product) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.edit', $product) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.images', $product) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="image"></i>
                            <span>Images</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.stock', $product) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="package"></i>
                            <span>Manage Stock</span>
                          </a>
                        </li>
                        {{-- <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.variants', $product) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="settings"></i>
                            <span>Variants</span>
                          </a>
                        </li> --}}
                         <li class="dropdown-list-item">
                           <button type="button" class="dropdown-link delete-product {{ $product->variants->count() > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                             data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                             {{ $product->variants->count() > 0 ? 'disabled' : '' }}>
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
              <td colspan="10" class="text-center py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="w-12 h-12 text-slate-300 mb-4" data-feather="folder-open"></i>
                  <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No products found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Get started by creating your first product.
                  </p>
                  <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    <span>Add Product</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Product Table Ends -->

    <!-- Product Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
        products
      </p>
      <!-- Pagination -->
      @if ($products->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($products->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $products->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="1em" height="1em"></i>
                </a>
              </li>
            @endif

            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
              @if ($page == $products->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($products->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $products->nextPageUrl() }}">
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
    <!-- Product Pagination Ends -->
  </div>
  <!-- Products List Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-product').forEach(button => {
          button.addEventListener('click', function () {
            // Check if button is disabled
            if (this.disabled) {
              return;
            }

            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');

            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${productName}" product?`,
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
                form.action = '{{ route("admin.products.destroy", ":productId") }}'.replace(':productId', productId);

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
        const searchInput = document.querySelector('input[placeholder="Search products"]');
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
            const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');

            if (selectedCheckboxes.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select products to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            // Filter out products that have variants
            const validCheckboxes = Array.from(selectedCheckboxes).filter(checkbox => {
              const row = checkbox.closest('tr');
              const variantsText = row.querySelector('td:nth-child(5)').textContent;
              const variantsCount = parseInt(variantsText.match(/\((\d+) variants\)/)?.[1] || '0');
              return variantsCount === 0;
            });

            if (validCheckboxes.length === 0) {
              Swal.fire({
                title: 'Cannot Delete',
                text: 'None of the selected products can be deleted because they have variants.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            const selectedIds = validCheckboxes.map(checkbox => checkbox.value);

            let confirmText = `You want to delete ${selectedIds.length} selected products?`;
            if (validCheckboxes.length !== selectedCheckboxes.length) {
              confirmText = `${selectedCheckboxes.length - validCheckboxes.length} product(s) cannot be deleted because they have variants. ${confirmText}`;
            }

            Swal.fire({
              title: 'Are you sure?',
              text: confirmText,
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
                form.action = '{{ route("admin.products.bulk-destroy") }}';

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Add selected IDs (only valid ones)
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