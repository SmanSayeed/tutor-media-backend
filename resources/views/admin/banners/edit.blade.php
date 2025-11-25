<x-admin-layout title="Edit Banner">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Edit Banner</h1>
            <a href="{{ route('admin.banners.index') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-200">
                Back to Banners
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100">
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div>
                            <label for="subtitle" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Subtitle
                            </label>
                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $banner->subtitle) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100">
                            @error('subtitle')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Button Text
                            </label>
                            <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100">
                            @error('button_text')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button URL -->
                        <div>
                            <label for="button_url" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Button URL
                            </label>
                            <input name="button_url" id="button_url" value="{{ old('button_url', $banner->button_url) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100">
                            @error('button_url')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Current Image -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Current Banner
                            </label>
                            <div class="mt-1">
                                <img id="current-banner" src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="h-48 w-full object-cover rounded-md">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Current banner image
                                </p>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Change Banner Image
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer bg-white dark:bg-slate-700 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <!-- Image Preview -->
                                    <div id="image-preview" class="mt-4 hidden">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">New Banner Preview:</p>
                                        <img id="preview" class="h-48 w-full object-cover rounded-md border border-gray-200 dark:border-gray-600" src="#" alt="Preview" />
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF up to 2MB
                                    </p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded dark:bg-slate-700 dark:border-gray-600">
                            <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                Active
                            </label>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Order
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $banner->order) }}" min="0"
                                class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100">
                            @error('order')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('image-preview');
            const currentBanner = document.getElementById('current-banner');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        if (currentBanner) {
                            currentBanner.classList.add('opacity-50');
                        }
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    previewContainer.classList.add('hidden');
                    if (currentBanner) {
                        currentBanner.classList.remove('opacity-50');
                    }
                }
            });
            
            // Handle drag and drop
            const dropZone = document.querySelector('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-slate-700');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-slate-700');
            }
            
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];
                
                if (file && file.type.match('image.*')) {
                    imageInput.files = dt.files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
