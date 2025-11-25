<x-app-layout title="User Profile">
    <div class="space-y-6 max-w-7xl mx-auto py-10">
        <!-- Page Header -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="w-16 h-16 rounded-full border-2 border-gray-200 mr-4">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ ucfirst($user->role) }}</p>
                    </div>
                </div>
                <a href="{{ route('user.profile.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Full Name:</span>
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email Address:</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phone Number:</span>
                        <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Timezone:</span>
                        <span class="font-medium">{{ $user->timezone ?? 'UTC' }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Account Role:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'vendor' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Account Status:</span>
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Inactive
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Member Since:</span>
                        <span class="font-medium">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium">{{ $user->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h3>
                <p class="mt-1 text-sm text-gray-500">Activity tracking will be available soon.</p>
            </div>
        </div>
    </div>
</x-app-layout>
