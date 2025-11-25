<x-admin-layout title="Brand Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Brand Details</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.brands') }}">Brands</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Brand Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Brand Details Starts -->
  <div class="space-y-6">
    <!-- Brand Information Card -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Brand Information</h6>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Brand Logo -->
          <div class="space-y-4">
            @if($brand->logo)
              <div>
                <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}"
                  class="w-full max-w-md rounded-lg shadow-sm" />
              </div>
            @else
              <div
                class="flex h-48 w-full max-w-md items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800">
                <i class="text-4xl text-slate-400" data-feather="image"></i>
              </div>
            @endif
          </div>

          <!-- Brand Details -->
          <div class="space-y-4">
            <div>
              <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200">{{ $brand->name }}</h3>
              <p class="text-sm text-slate-500 dark:text-slate-400">Slug: {{ $brand->slug }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Website</span>
                @if($brand->website)
                  <p class="text-sm text-slate-800 dark:text-slate-200">
                    <a href="{{ $brand->website }}" target="_blank" class="text-primary-500 hover:underline">
                      {{ parse_url($brand->website, PHP_URL_HOST) }}
                    </a>
                  </p>
                @else
                  <p class="text-sm text-slate-500 dark:text-slate-400">N/A</p>
                @endif
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</span>
                @if($brand->is_active)
                  <span class="badge badge-soft-success">Active</span>
                @else
                  <span class="badge badge-soft-danger">Inactive</span>
                @endif
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Sort Order</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $brand->sort_order }}</p>
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Products Count</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $brand->products->count() }}</p>
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Created Date</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $brand->created_at->format('M d, Y') }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Description -->
        @if($brand->description)
          <div class="mt-6">
            <h6 class="mb-2 text-sm font-medium text-slate-600 dark:text-slate-400">Description</h6>
            <p class="text-sm text-slate-700 dark:text-slate-300">{{ $brand->description }}</p>
          </div>
        @endif
      </div>
    </div>

    <!-- SEO Information Card -->
    @if($brand->meta_title || $brand->meta_description)
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">SEO Information</h6>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @if($brand->meta_title)
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Title</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $brand->meta_title }}</p>
              </div>
            @endif
            @if($brand->meta_description)
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Description</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $brand->meta_description }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif

    <!-- Products in this Brand -->
    @if($brand->products->count() > 0)
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">Products in this Brand ({{ $brand->products->count() }})</h6>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($brand->products->take(6) as $product)
              <div class="flex items-center gap-3 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                @if($product->image)
                  <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                    class="h-12 w-12 rounded-lg object-cover" />
                @else
                  <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800">
                    <i class="text-slate-400" data-feather="package"></i>
                  </div>
                @endif
                <div class="flex-1 min-w-0">
                  <h6 class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</h6>
                  <p class="text-xs text-slate-500 dark:text-slate-400">{{ $product->sku }}</p>
                </div>
              </div>
            @endforeach
            @if($brand->products->count() > 6)
              <div class="flex items-center justify-center rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                <span class="text-sm text-slate-600 dark:text-slate-400">+{{ $brand->products->count() - 6 }} more
                  products</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-col justify-end gap-3 sm:flex-row ">
      <a href="{{ route('admin.brands') }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="h-4 w-4"></i>
        <span>Back to Brands</span>
      </a>
      <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-primary">
        <i data-feather="edit" class="h-4 w-4"></i>
        <span>Edit Brand</span>
      </a>
    </div>
  </div>
  <!-- Brand Details Ends -->
</x-admin-layout>