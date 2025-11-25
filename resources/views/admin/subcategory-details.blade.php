<x-admin-layout title="Subcategory Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Subcategory Details</h5>

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
        <a href="#">Subcategory Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Subcategory Details Starts -->
  <div class="space-y-6">
    <!-- Subcategory Information Card -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Subcategory Information</h6>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Subcategory Image -->
          <div class="space-y-4">
            @if($subcategory->image)
              <div>
                <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                  class="w-full max-w-md rounded-lg shadow-sm" />
              </div>
            @else
              <div
                class="flex h-48 w-full max-w-md items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800">
                <i class="text-4xl text-slate-400" data-feather="image"></i>
              </div>
            @endif
          </div>

          <!-- Subcategory Details -->
          <div class="space-y-4">
            <div>
              <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200">{{ $subcategory->name }}</h3>
              <p class="text-sm text-slate-500 dark:text-slate-400">Slug: {{ $subcategory->slug }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Parent Category</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $subcategory->category->name ?? 'N/A' }}</p>
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</span>
                @if($subcategory->is_active)
                  <span class="badge badge-soft-success">Active</span>
                @else
                  <span class="badge badge-soft-danger">Inactive</span>
                @endif
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Sort Order</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $subcategory->sort_order }}</p>
              </div>
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Created Date</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $subcategory->created_at->format('M d, Y') }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Description -->
        @if($subcategory->description)
          <div class="mt-6">
            <h6 class="mb-2 text-sm font-medium text-slate-600 dark:text-slate-400">Description</h6>
            <p class="text-sm text-slate-700 dark:text-slate-300">{{ $subcategory->description }}</p>
          </div>
        @endif
      </div>
    </div>

    <!-- SEO Information Card -->
    @if($subcategory->meta_title || $subcategory->meta_description)
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">SEO Information</h6>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @if($subcategory->meta_title)
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Title</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $subcategory->meta_title }}</p>
              </div>
            @endif
            @if($subcategory->meta_description)
              <div>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Meta Description</span>
                <p class="text-sm text-slate-800 dark:text-slate-200">{{ $subcategory->meta_description }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif

    <!-- Products in this Subcategory -->
    @if($subcategory->products->count() > 0)
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">Products in this Subcategory ({{ $subcategory->products->count() }})</h6>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($subcategory->products->take(6) as $product)
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
            @if($subcategory->products->count() > 6)
              <div class="flex items-center justify-center rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                <span class="text-sm text-slate-600 dark:text-slate-400">+{{ $subcategory->products->count() - 6 }} more
                  products</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-col justify-end gap-3 sm:flex-row ">
      <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="h-4 w-4"></i>
        <span>Back to Subcategories</span>
      </a>
      <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-primary">
        <i data-feather="edit" class="h-4 w-4"></i>
        <span>Edit Subcategory</span>
      </a>
    </div>
  </div>
  <!-- Subcategory Details Ends -->
</x-admin-layout>