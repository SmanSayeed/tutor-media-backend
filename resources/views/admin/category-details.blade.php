<x-admin-layout title="Category Details - Admin Dashboard">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <div>
      <h5>Category Details</h5>
      <p class="text-sm text-slate-500 dark:text-slate-400">Detailed information about {{ $category->name }}</p>
    </div>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Category Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <div class="space-y-6">
    <!-- Category Information Card -->
    <div class="card">
      <div class="card-header">
        <div class="flex items-center justify-between">
          <h6 class="card-title">Category Information</h6>
          <div class="space-x-2">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
              <i data-feather="edit" class="w-4 h-4 mr-1"></i>
              Edit
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
              <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i>
              Back
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Category Image and Basic Info -->
          <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
              @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                  class="w-32 h-32 object-cover rounded-lg border border-slate-200 dark:border-slate-700" />
              @else
                <div class="w-32 h-32 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                  <i data-feather="image" class="w-12 h-12 text-slate-400"></i>
                </div>
              @endif
            </div>
            <div class="flex-1">
              <h4 class="text-xl font-semibold text-slate-700 dark:text-slate-100 mb-2">{{ $category->name }}</h4>
              <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">{{ $category->slug }}</p>

              <div class="space-y-2">
                <div class="flex items-center gap-2">
                  <span class="badge {{ $category->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                  </span>
                  <span class="text-sm text-slate-500 dark:text-slate-400">
                    Sort Order: {{ $category->sort_order }}
                  </span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                  Created {{ $category->created_at->format('M d, Y \a\t h:i A') }}
                </p>
              </div>
            </div>
          </div>

          <!-- Category Details -->
          <div class="space-y-4">
            <div>
              <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Description</h6>
              <p class="text-sm text-slate-700 dark:text-slate-100">
                {{ $category->description ?? 'No description provided' }}
              </p>
            </div>

            @if($category->meta_title || $category->meta_description)
              <div>
                <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">SEO Information</h6>
                @if($category->meta_title)
                  <p class="text-sm text-slate-700 dark:text-slate-100">
                    <strong>Meta Title:</strong> {{ $category->meta_title }}
                  </p>
                @endif
                @if($category->meta_description)
                  <p class="text-sm text-slate-700 dark:text-slate-100">
                    <strong>Meta Description:</strong> {{ $category->meta_description }}
                  </p>
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <!-- Products Count -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center justify-between">
            <div>
              <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300">Products</h6>
              <h4 class="text-2xl font-semibold text-slate-700 dark:text-slate-100">{{ $category->products_count ?? 0 }}
              </h4>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
              <i data-feather="package" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Subcategories Count -->
      <div class="card">
        <div class="card-body">
          <div class="flex items-center justify-between">
            <div>
              <h6 class="text-sm font-medium text-slate-600 dark:text-slate-300">Subcategories</h6>
              <h4 class="text-2xl font-semibold text-slate-700 dark:text-slate-100">
                {{ $category->subcategories_count ?? 0 }}</h4>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
              <i data-feather="folder" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Subcategories Section -->
    @if($category->subcategories->count() > 0)
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">Subcategories ({{ $category->subcategories->count() }})</h6>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($category->subcategories as $subcategory)
              <div
                class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                    <i data-feather="folder" class="w-5 h-5 text-slate-600 dark:text-slate-400"></i>
                  </div>
                  <div class="flex-1">
                    <h6 class="font-medium text-slate-700 dark:text-slate-100">{{ $subcategory->name }}</h6>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $subcategory->slug }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    <!-- Recent Products Section -->
    @if($category->products->count() > 0)
      <div class="card">
        <div class="card-header">
          <div class="flex items-center justify-between">
            <h6 class="card-title">Recent Products
              ({{ $category->products->count() > 10 ? '10' : $category->products->count() }} of
              {{ $category->products->count() }})</h6>
            <a href="#" class="text-sm text-primary-600 hover:text-primary-700">View All Products →</a>
          </div>
        </div>
        <div class="card-body">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach($category->products->take(10) as $product)
              <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="aspect-square mb-3 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                  @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                      class="w-full h-full object-cover rounded-lg" />
                  @else
                    <i data-feather="package" class="w-8 h-8 text-slate-400"></i>
                  @endif
                </div>
                <h6 class="font-medium text-slate-700 dark:text-slate-100 text-sm mb-1">{{ $product->name }}</h6>
                <p class="text-sm text-slate-500 dark:text-slate-400">${{ number_format($product->price, 2) }}</p>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    <!-- Action Buttons -->
    <div class="card">
      <div class="card-body">
        <div class="flex flex-wrap gap-3">
          <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
            <i data-feather="edit" class="w-4 h-4 mr-2"></i>
            Edit Category
          </a>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Back to Categories
          </a>
          @if($category->products->count() == 0 && $category->subcategories->count() == 0)
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this category?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger">
                <i data-feather="trash" class="w-4 h-4 mr-2"></i>
                Delete Category
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-admin-layout>