<x-admin-layout title="Banner - tutionmediabd Admin">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Banners</h1>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                Add New Banner
            </a>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
            @if($banners->count() > 0)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700" id="sortable-banners">
                    @foreach($banners as $banner)
                        <li class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-slate-700" data-id="{{ $banner->id }}">
                            <div class="flex-shrink-0 mr-4 cursor-move">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-32 overflow-hidden rounded-md">
                                        <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">{{ $banner->title }}</p>
                                        @if($banner->subtitle)
                                            <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $banner->subtitle }}</p>
                                        @endif
                                        <div class="mt-1 flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">
                                                Order: {{ $banner->order }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No banners</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new banner.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Banner
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sortable = new Sortable(document.getElementById('sortable-banners'), {
                    handle: '.cursor-move',
                    animation: 150,
                    onEnd: function() {
                        const banners = [];
                        document.querySelectorAll('#sortable-banners li').forEach((item, index) => {
                            banners.push({
                                id: item.getAttribute('data-id'),
                                order: index + 1
                            });
                        });

                        fetch('{{ route("admin.banners.update-order") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ banners })
                        });
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
