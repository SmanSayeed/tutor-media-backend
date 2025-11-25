<x-admin-layout title="Admin Profile">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Admin Profile</h1>
            
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
    
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-slate-800 dark:text-slate-200 mb-6">Profile Information</h2>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-6">
                    <h2 class="text-lg font-medium text-slate-800 dark:text-slate-200 mb-6">Update Password</h2>
                    
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="password" name="current_password" id="current_password" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100" required>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="password" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="password" name="password" id="password" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100" required>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-700 dark:text-slate-100" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-admin-layout>
</div>

