<x-admin-layout>
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Product Images</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.products.index') }}">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.products.show', $product) }}">Product Details</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Manage Images</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Product Images Management Starts -->
  <div class="space-y-6">
    <!-- Product Info Card -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Product: {{ $product->name }}</h6>
      </div>
      <div class="card-body">
        <div class="flex items-center gap-4">
          @if($product->primaryImage())
            <img src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}"
              class="w-16 h-16 object-cover rounded-lg" />
          @else
            <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
              <i class="text-slate-400" data-feather="image"></i>
            </div>
          @endif
          <div>
            <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</h6>
            <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Images Card -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Upload Images</h6>
      </div>
      <div class="card-body">
        <form id="uploadImagesForm" enctype="multipart/form-data">
          @csrf
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">
                Select Images (Max 10 files)
              </label>
              <input type="file" id="productImages" name="images[]" multiple accept="image/*" class="input" required />
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Supported formats: JPEG, PNG, JPG, GIF. Max file size: 2MB each.
              </p>
            </div>

            <div class="flex items-center">
              <input type="checkbox" id="setPrimary" name="set_primary" class="checkbox">
              <label for="setPrimary" class="ml-2 text-sm text-slate-600 dark:text-slate-400">
                Set first image as primary
              </label>
            </div>

            <div class="flex justify-end">
              <button type="submit" class="btn btn-primary" id="uploadBtn">
                <i data-feather="upload" class="w-4 h-4 mr-2"></i>
                <span>Upload Images</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Current Images Gallery -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Current Images ({{ $product->images->count() }} images)</h6>
      </div>
      <div class="card-body">
        @if($product->images->count() > 0)
          <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($product->images as $image)
              <div class="relative group border border-slate-200 rounded-lg overflow-hidden dark:border-slate-700">
                <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-24 object-cover" />
                @if($image->is_primary)
                  <div class="absolute top-2 left-2">
                    <span class="badge badge-soft-success text-xs">Primary</span>
                  </div>
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200">
                  <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="flex gap-1">
                      @if(!$image->is_primary)
                        <button class="btn btn-xs btn-success" onclick="setPrimaryImage({{ $image->id }})"
                          title="Set as Primary">
                          <i data-feather="star" class="w-3 h-3"></i>
                        </button>
                      @endif
                      <button class="btn btn-xs btn-danger" onclick="deleteImage({{ $image->id }})" title="Delete Image">
                        <i data-feather="trash-2" class="w-3 h-3"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-8">
            <i class="w-12 h-12 text-slate-300 mb-4" data-feather="image"></i>
            <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No images uploaded</h6>
            <p class="text-xs text-slate-400 dark:text-slate-500">Upload some images to showcase your product.</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col justify-end gap-3 sm:flex-row ">
      <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="h-4 w-4"></i>
        <span>Back to Product</span>
      </a>
      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
        <i data-feather="edit" class="h-4 w-4"></i>
        <span>Edit Product</span>
      </a>
    </div>
  </div>
  <!-- Product Images Management Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const uploadForm = document.getElementById('uploadImagesForm');
        const uploadBtn = document.getElementById('uploadBtn');
        const imagesInput = document.getElementById('productImages');
  
        uploadForm.addEventListener('submit', function (e) {
          e.preventDefault();
  
          const formData = new FormData(uploadForm);
          const files = imagesInput.files;
  
          if (files.length === 0) {
            Swal.fire({
              title: 'No Images Selected',
              text: 'Please select at least one image to upload.',
              icon: 'warning',
              confirmButtonColor: '#3b82f6'
            });
            return;
          }
  
          if (files.length > 10) {
            Swal.fire({
              title: 'Too Many Files',
              text: 'You can only upload up to 10 images at once.',
              icon: 'warning',
              confirmButtonColor: '#3b82f6'
            });
            return;
          }
  
          // Show loading state
          uploadBtn.innerHTML = '<i data-feather="loader-2" class="w-4 h-4 mr-2 animate-spin"></i><span>Uploading...</span>';
          uploadBtn.disabled = true;
  
          fetch(`/admin/products/${{{ $product->id }}}}/images`, {
            method: 'POST',
            body: formData,
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                Swal.fire({
                  title: 'Success!',
                  text: data.message,
                  icon: 'success',
                  confirmButtonColor: '#3b82f6'
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  title: 'Error!',
                  text: 'Failed to upload images',
                  icon: 'error',
                  confirmButtonColor: '#ef4444'
                });
              }
            })
            .catch(error => {
              console.error('Error:', error);
              Swal.fire({
                title: 'Error!',
                text: 'An error occurred while uploading images',
                icon: 'error',
                confirmButtonColor: '#ef4444'
              });
            })
            .finally(() => {
              // Reset button state
              uploadBtn.innerHTML = '<i data-feather="upload" class="w-4 h-4 mr-2"></i><span>Upload Images</span>';
              uploadBtn.disabled = false;
            });
        });
      });
  
      function setPrimaryImage(imageId) {
        fetch(`/admin/product-images/${imageId}/primary`, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#3b82f6'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: 'Failed to update primary image',
                icon: 'error',
                confirmButtonColor: '#ef4444'
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire({
              title: 'Error!',
              text: 'An error occurred while updating the primary image',
              icon: 'error',
              confirmButtonColor: '#ef4444'
            });
          });
      }
  
      function deleteImage(imageId) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete this image?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`/admin/product-images/${imageId}`, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
            })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#3b82f6'
                  }).then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete image',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                  });
                }
              })
              .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                  title: 'Error!',
                  text: 'An error occurred while deleting the image',
                  icon: 'error',
                  confirmButtonColor: '#ef4444'
                });
              });
          }
        });
      }
    </script>
  @endpush
</x-admin-layout>
