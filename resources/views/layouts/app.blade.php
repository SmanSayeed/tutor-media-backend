@props([
    'title' => null, // Will use site settings if not provided
])
@php
    $settings = \App\Helpers\SiteSettingsHelper::all();
    $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
    $faviconUrl = \App\Helpers\SiteSettingsHelper::faviconUrl();
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    $secondaryColor = \App\Helpers\SiteSettingsHelper::secondaryColor();
    $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
    $customCss = \App\Helpers\SiteSettingsHelper::customCss();
    $customJs = \App\Helpers\SiteSettingsHelper::customJs();
    $googleAnalyticsId = \App\Helpers\SiteSettingsHelper::googleAnalyticsId();
    $metaTitle = \App\Helpers\SiteSettingsHelper::metaTitle();
    $metaDescription = \App\Helpers\SiteSettingsHelper::metaDescription();
    $metaKeywords = \App\Helpers\SiteSettingsHelper::metaKeywords();
    $ogImageUrl = \App\Helpers\SiteSettingsHelper::ogImageUrl();
    $canonicalUrl = \App\Helpers\SiteSettingsHelper::get('canonical_url');
    
    // Use meta title from settings if available, otherwise use page title
    $pageTitle = $metaTitle ?: ($title ?: $websiteName);
    $pageDescription = $metaDescription ?: \App\Helpers\SiteSettingsHelper::get('website_description');
@endphp
<!DOCTYPE html>
<html lang="{{ \App\Helpers\SiteSettingsHelper::defaultLanguage() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>{{ $pageTitle }}</title>
    @if($pageDescription)
    <meta name="description" content="{{ $pageDescription }}">
    @endif
    @if($metaKeywords)
    <meta name="keywords" content="{{ is_array($metaKeywords) ? implode(', ', $metaKeywords) : $metaKeywords }}">
    @endif
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    @if($pageDescription)
    <meta property="og:description" content="{{ $pageDescription }}">
    @endif
    @if($ogImageUrl)
    <meta property="og:image" content="{{ $ogImageUrl }}">
    @endif
    @if($canonicalUrl)
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @endif
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    @if($pageDescription)
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @endif
    @if($ogImageUrl)
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
    @endif
    
    @if($canonicalUrl)
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @endif
    
    @if($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    @endif
    
    <!-- Theme Colors as CSS Variables -->
    <style>
        :root {
            --color-primary: {{ $primaryColor }};
            --color-secondary: {{ $secondaryColor }};
            --color-accent: {{ $accentColor }};
            /* Map Tailwind colors to theme colors */
            --color-red-500: {{ $accentColor }};
            --color-red-600: {{ $accentColor }};
            --color-red-700: {{ $accentColor }};
            --color-red-800: {{ $accentColor }};
            --color-red-100: {{ $primaryColor }}20;
            --color-amber-400: {{ $primaryColor }};
            --color-amber-500: {{ $primaryColor }};
            --color-amber-600: {{ $primaryColor }};
            --color-amber-700: {{ $primaryColor }};
            --color-amber-100: {{ $primaryColor }}20;
        }
        
        /* Override Tailwind red colors with accent color */
        .text-red-500,
        .text-red-600,
        .text-red-700,
        .text-red-800 { color: {{ $accentColor }} !important; }
        
        .bg-red-500,
        .bg-red-600,
        .bg-red-700,
        .bg-red-800 { background-color: {{ $accentColor }} !important; }
        
        .bg-red-100 { background-color: {{ $accentColor }}20 !important; }
        
        .border-red-500,
        .border-red-600,
        .border-red-700,
        .border-red-800 { border-color: {{ $accentColor }} !important; }
        
        .hover\:bg-red-600:hover,
        .hover\:bg-red-700:hover { background-color: {{ $accentColor }} !important; }
        
        .hover\:text-red-600:hover,
        .hover\:text-red-700:hover { color: {{ $accentColor }} !important; }
        
        /* Override Tailwind amber colors with primary color */
        .text-amber-400,
        .text-amber-500,
        .text-amber-600,
        .text-amber-700 { color: {{ $primaryColor }} !important; }
        
        .bg-amber-100,
        .bg-amber-500,
        .bg-amber-600 { background-color: {{ $primaryColor }} !important; }
        
        .bg-amber-100 { background-color: {{ $primaryColor }}20 !important; }
        
        .border-amber-500,
        .border-amber-600,
        .border-amber-700 { border-color: {{ $primaryColor }} !important; }
        
        .hover\:bg-amber-600:hover,
        .hover\:bg-amber-700:hover { background-color: {{ $primaryColor }} !important; }
        
        .hover\:text-amber-600:hover,
        .hover\:text-amber-700:hover { color: {{ $primaryColor }} !important; }
        
        /* Gradient overrides */
        .from-amber-500,
        .from-amber-600 { --tw-gradient-from: {{ $primaryColor }} var(--tw-gradient-from-position) !important; }
        
        .to-amber-600,
        .to-amber-700 { --tw-gradient-to: {{ $primaryColor }} var(--tw-gradient-to-position) !important; }
        
        .from-red-500,
        .from-red-600 { --tw-gradient-from: {{ $accentColor }} var(--tw-gradient-from-position) !important; }
        
        .to-red-600,
        .to-red-700 { --tw-gradient-to: {{ $accentColor }} var(--tw-gradient-to-position) !important; }
        
        /* Focus ring colors */
        .focus\:ring-red-500:focus,
        .focus\:ring-red-600:focus { --tw-ring-color: {{ $accentColor }} !important; }
        
        .focus\:ring-amber-500:focus,
        .focus\:ring-amber-600:focus { --tw-ring-color: {{ $primaryColor }} !important; }
        
        /* Apply primary color to common elements */
        .text-primary { color: {{ $primaryColor }} !important; }
        .bg-primary { background-color: {{ $primaryColor }} !important; }
        .border-primary { border-color: {{ $primaryColor }} !important; }
        .ring-primary { --tw-ring-color: {{ $primaryColor }}; }
        
        /* Apply accent color */
        .text-accent { color: {{ $accentColor }} !important; }
        .bg-accent { background-color: {{ $accentColor }} !important; }
        .border-accent { border-color: {{ $accentColor }} !important; }
        
        /* Custom CSS from Site Settings */
        @if($customCss)
        {!! $customCss !!}
        @endif
    </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/user/app.css', 'resources/js/user/app.js'])
    @stack('styles')
    
    <!-- Google Analytics -->
    @if($googleAnalyticsId)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $googleAnalyticsId }}');
    </script>
    @endif
</head>
<body>
    <!-- Navigation Drawer - Outside main app container for proper z-index stacking -->
    <x-nav-drawer />

    <div id="user-app">
        <x-header />
         {{ $slot }}
        <x-footer />
    </div>

    @stack('scripts')
    
    <!-- Custom JavaScript from Site Settings -->
    @if($customJs)
    <script>
        {!! $customJs !!}
    </script>
    @endif
</body>
</html>
