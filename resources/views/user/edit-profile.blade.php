<x-app-layout title="Edit Profile">
    <div class="space-y-6 max-w-7xl mx-auto py-10">
        <!-- Page Header -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="w-12 h-12 rounded-full border-2 border-gray-200 mr-3">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Edit Profile</h1>
                        <p class="text-gray-600">Update your personal information</p>
                    </div>
                </div>
                <a href="{{ route('user.profile') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg font-medium transition-colors text-sm">
                    Back to Profile
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            @csrf
            @method('POST')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Profile Picture Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Picture</h2>
                    <div class="flex items-center space-x-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current Profile Picture" class="w-20 h-20 rounded-full border-2 border-gray-300">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                            <label for="avatar" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                Change Picture
                            </label>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                        </div>
                    </div>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Personal Information -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                    <div class="space-y-4">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('name') ? 'border-red-300' : '' }}"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('email') ? 'border-red-300' : '' }}"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('phone') ? 'border-red-300' : '' }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Timezone -->
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                            <select name="timezone" id="timezone"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('timezone') ? 'border-red-300' : '' }}">
                                <option value="">Select Timezone</option>
                                <option value="UTC" {{ old('timezone', $user->timezone) === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone', $user->timezone) === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="America/Chicago" {{ old('timezone', $user->timezone) === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                <option value="America/Denver" {{ old('timezone', $user->timezone) === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                <option value="America/Los_Angeles" {{ old('timezone', $user->timezone) === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                <option value="Europe/London" {{ old('timezone', $user->timezone) === 'Europe/London' ? 'selected' : '' }}>London</option>
                                <option value="Europe/Paris" {{ old('timezone', $user->timezone) === 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                                <option value="Asia/Tokyo" {{ old('timezone', $user->timezone) === 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo</option>
                                <option value="Asia/Shanghai" {{ old('timezone', $user->timezone) === 'Asia/Shanghai' ? 'selected' : '' }}>Shanghai</option>
                                <option value="Australia/Sydney" {{ old('timezone', $user->timezone) === 'Australia/Sydney' ? 'selected' : '' }}>Sydney</option>
                            </select>
                            @error('timezone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('user.profile') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
    // Preview selected image
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You can add image preview functionality here if needed
                console.log('Image selected:', file.name);
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</x-app-layout>

