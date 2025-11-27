@props([
  'title'=>'tutionmediabd Admin Panel'
])
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @php
        $faviconUrl = \App\Helpers\SiteSettingsHelper::faviconUrl();
    @endphp
    @if($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    @endif
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    @stack('styles')
     <script>
      if (
        localStorage.getItem('theme') === 'dark' ||
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
      ) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    </script>
</head>
<body>
 
    <div id="app">
  
        @include('admin.partials.sidebar')
  
        <!-- Wrapper Starts -->
        <div class="wrapper">
       
          @include('admin.partials.header')
  
          <!-- Page Content Starts -->
          <div class="content">
            <!-- Flash Messages -->
          
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

            @if(session('error'))
              <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
              <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-center mb-2">
                  <i data-feather="alert-circle" class="w-5 h-5 mr-2"></i>
                  <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside ml-4">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Main Content Starts -->
            <main class="flex-grow p-4 sm:p-6">
                {{ $slot }}
            </main>
            <!-- Main Content Ends -->
  
          @include('admin.partials.footer')
          </div>
          <!-- Page Content Ends -->
        </div>
        <!-- Wrapper Ends -->
  
        @include('admin.partials.search-modal')
      </div>
      
    
    @stack('scripts')
</body>
</html>