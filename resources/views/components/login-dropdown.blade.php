<!-- Modern Login Dropdown Component -->
<div class="relative group">
  @if($isAuthenticated)
    <!-- Authenticated User Menu -->
    <button class="flex items-center text-slate-700 hover:text-slate-900 px-2 sm:px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">
      <div class="w-6 h-6 sm:w-7 sm:h-7 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-2">
        <span class="text-white text-xs sm:text-sm font-semibold">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </span>
      </div>
      <div class="hidden sm:block text-left">
        <div class="text-sm font-medium">{{ $user->name }}</div>
        <div class="text-xs text-slate-500">{{ $user->email }}</div>
      </div>
      <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z"/>
      </svg>
    </button>

    <!-- User Dropdown Menu -->
    <div class="absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-2 group-hover:translate-y-0">
      <!-- User Info Header -->
      <div class="px-4 py-3 border-b border-slate-100">
        <div class="flex items-center">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
            <span class="text-white text-sm font-semibold">
              {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>
          </div>
          <div>
            <div class="font-semibold text-slate-900">{{ $user->name }}</div>
            <div class="text-sm text-slate-500">{{ $user->email }}</div>
          </div>
        </div>
      </div>

      <!-- Menu Items -->
      <div class="py-2">
        @if($user->isAdmin())
          <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Admin Dashboard
          </a>
        @endif
        
        @if($user->isCustomer())
          <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
            </svg>
            Dashboard
          </a>
          
          <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            My Profile
          </a>
          
          <a href="#" class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Wishlist
          </a>
          
          <a href="#" class="flex items-center px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Orders
          </a>
        @endif
        
        <div class="border-t border-slate-100 my-1"></div>
        
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
          </button>
        </form>
      </div>
    </div>
  @else
    <!-- Guest User - Login Button -->
    <a href="{{ route('login') }}" class="flex items-center text-slate-700 hover:text-slate-900 text-sm font-medium px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
      </svg>
      <span class="hidden sm:inline">Login</span>
    </a>
  @endif
</div>

