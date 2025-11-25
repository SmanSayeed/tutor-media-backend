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
    
    $pageTitle = $metaTitle ?: (@yield('title') ?: $websiteName);
    $pageDescription = $metaDescription ?: \App\Helpers\SiteSettingsHelper::get('website_description');
@endphp
<!DOCTYPE html>
<html lang="{{ \App\Helpers\SiteSettingsHelper::defaultLanguage() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
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
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    /* Theme Colors as CSS Variables */
    :root {
      --color-primary: {{ $primaryColor }};
      --color-secondary: {{ $secondaryColor }};
      --color-accent: {{ $accentColor }};
      /* Map Tailwind colors to theme colors */
      --color-red-500: {{ $accentColor }};
      --color-red-600: {{ $accentColor }};
      --color-red-700: {{ $accentColor }};
      --color-red-800: {{ $accentColor }};
      --color-red-100: {{ $accentColor }}20;
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
    html { 
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Noto Sans, Ubuntu, Cantarell, Helvetica Neue, Arial; 
      scroll-behavior: smooth;
    }
    
    /* Modern Card Design */
    .card { 
      box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card:hover {
      box-shadow: 0 10px 25px rgba(0,0,0,0.1), 0 4px 6px rgba(0,0,0,0.05);
      transform: translateY(-2px);
    }
    
    /* Typography Scale */
    .text-display { font-size: 3.5rem; line-height: 1.1; font-weight: 800; }
    .text-h1 { font-size: 2.5rem; line-height: 1.2; font-weight: 700; }
    .text-h2 { font-size: 2rem; line-height: 1.3; font-weight: 600; }
    .text-h3 { font-size: 1.5rem; line-height: 1.4; font-weight: 600; }
    .text-h4 { font-size: 1.25rem; line-height: 1.4; font-weight: 500; }
    
    /* Consistent Spacing */
    .section-spacing { padding: 4rem 0; }
    .section-spacing-sm { padding: 2rem 0; }
    .section-spacing-lg { padding: 6rem 0; }
    
    /* Smooth Transitions */
    * {
      transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    /* Loading Animation */
    .loading-skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    /* Focus States */
    .focus-ring:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
    }
    
    /* Responsive Typography */
    @media (max-width: 640px) {
      .text-display { font-size: 2.5rem; }
      .text-h1 { font-size: 2rem; }
      .text-h2 { font-size: 1.75rem; }
      .text-h3 { font-size: 1.25rem; }
    }
    
    /* Line Clamp Utility */
    .line-clamp-1 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 1;
    }
    
    .line-clamp-2 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
    }
    
    .line-clamp-3 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 3;
    }
    
    /* Glass Effect */
    .glass {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Gradient Text */
    .gradient-text {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Custom CSS from Site Settings */
    @if($customCss)
    {!! $customCss !!}
    @endif
  </style>
  @stack('styles')
  @vite('resources/css/app.css')
  
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
<body class="bg-white text-slate-800">
  @include('components.header')
  @include('components.nav-drawer')

  <main>
    @yield('content')
  </main>

  @include('components.footer')

  <!-- Scroll to Top Button -->
  <button id="scroll-to-top" class="fixed bottom-6 right-6 bg-slate-800 text-white p-3 rounded-full shadow-lg hover:bg-slate-700 transform hover:scale-110 transition-all duration-300 opacity-0 invisible z-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
  </button>

  <!-- Enhanced JavaScript for Micro-interactions -->
  <script>
    // Scroll to top functionality
    const scrollToTopBtn = document.getElementById('scroll-to-top');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.remove('opacity-0', 'invisible');
        scrollToTopBtn.classList.add('opacity-100', 'visible');
      } else {
        scrollToTopBtn.classList.add('opacity-0', 'invisible');
        scrollToTopBtn.classList.remove('opacity-100', 'visible');
      }
    });
    
    // Smooth scroll to top
    scrollToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Enhanced page loading with fade-in effect
    document.addEventListener('DOMContentLoaded', function() {
      // Add fade-in animation to main content
      const main = document.querySelector('main');
      if (main) {
        main.style.opacity = '0';
        main.style.transform = 'translateY(20px)';
        main.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
          main.style.opacity = '1';
          main.style.transform = 'translateY(0)';
        }, 100);
      }

      // Add loading states to buttons
      const buttons = document.querySelectorAll('button, a[href]');
      buttons.forEach(button => {
        button.addEventListener('click', function(e) {
          if (this.tagName === 'A' && this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
            // Add loading state for navigation links
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
          }
        });
      });

      // Add hover effects to cards
      const cards = document.querySelectorAll('.card, [class*="bg-white"][class*="rounded"]');
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });

      // Add ripple effect to buttons
      const rippleButtons = document.querySelectorAll('button, .btn');
      rippleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          const ripple = document.createElement('span');
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          const x = e.clientX - rect.left - size / 2;
          const y = e.clientY - rect.top - size / 2;
          
          ripple.style.width = ripple.style.height = size + 'px';
          ripple.style.left = x + 'px';
          ripple.style.top = y + 'px';
          ripple.classList.add('ripple');
          
          this.appendChild(ripple);
          
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });
    });

    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
      .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
      }
      
      @keyframes ripple-animation {
        to {
          transform: scale(4);
          opacity: 0;
        }
      }
      
      button {
        position: relative;
        overflow: hidden;
      }
    `;
    document.head.appendChild(style);
  </script>

  @stack('scripts')
  
  <!-- Custom JavaScript from Site Settings -->
  @if($customJs)
  <script>
      {!! $customJs !!}
  </script>
  @endif
</body>
</html>


