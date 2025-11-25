<x-admin-layout title="Size Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Size Details</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.sizes.index') }}">Sizes</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Size Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Size Details Starts -->
  <div class="space-y-6">
    <!-- Size Information -->
    <div class="card">
      <div class="card-header flex justify-between items-center">
        <h6 class="card-title">Size Information</h6>
        <div class="card-action">
          <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-sm btn-outline-warning">
            <i class="w-4 h-4" data-feather="edit"></i>
            <span>Edit</span>
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Size Name</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $size->name }}</p>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Size Code</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $size->code }}</p>
            </div>
          </div>

          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
              <div class="mt-1">
                <span class="badge {{ $size->is_active ? 'badge-success' : 'badge-danger' }}">
                  {{ $size->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Created At</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $size->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Updated At</label>
              <p class="text-sm text-slate-800 dark:text-slate-200 mt-1">{{ $size->updated_at->format('M d, Y H:i') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Variants Using This Size -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Product Variants Using This Size ({{ $size->variants->count() }})</h6>
      </div>
      <div class="card-body">
        @if($size->variants->count() > 0)
          <div class="overflow-x-auto">
            <table class="table">
              <thead>
                <tr>
                  <th>Variant Name</th>
                  <th>Product</th>
                  <th>Stock</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($size->variants as $variant)
                  <tr>
                    <td>{{ $variant->name }}</td>
                    <td>
                      <a href="{{ route('admin.products.show', $variant->product) }}" class="text-primary hover:underline">
                        {{ $variant->product->name }}
                      </a>
                    </td>
                    <td>{{ $variant->stock_quantity }}</td>
                    <td>
                      @if($variant->price)
                        ${{ number_format($variant->price, 2) }}
                      @else
                        <span class="text-slate-500">-</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge {{ $variant->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $variant->is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>
                      <a href="{{ route('admin.products.variants', $variant->product) }}" class="btn btn-sm btn-outline-info">
                        <i class="w-4 h-4" data-feather="eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-8">
            <i class="w-12 h-12 text-slate-300" data-feather="package"></i>
            <p class="text-slate-500 mt-2">No product variants are using this size</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col justify-end gap-3 sm:flex-row">
      <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="h-4 w-4"></i>
        <span>Back to Sizes</span>
      </a>
      <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-primary">
        <i data-feather="edit" class="h-4 w-4"></i>
        <span>Edit Size</span>
      </a>
    </div>
  </div>
  <!-- Size Details Ends -->
</x-admin-layout>