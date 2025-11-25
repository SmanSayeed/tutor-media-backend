  @php
    $settings = \App\Helpers\SiteSettingsHelper::all();
    $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
    $tagline = \App\Helpers\SiteSettingsHelper::tagline();
    $footerText = \App\Helpers\SiteSettingsHelper::footerText();
    $primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
    $secondaryEmail = \App\Helpers\SiteSettingsHelper::secondaryEmail();
    $primaryPhone = \App\Helpers\SiteSettingsHelper::primaryPhone();
    $secondaryPhone = \App\Helpers\SiteSettingsHelper::secondaryPhone();
    $physicalAddress = \App\Helpers\SiteSettingsHelper::physicalAddress();
    $businessHours = \App\Helpers\SiteSettingsHelper::businessHours();
    $socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();
    $copyrightNotice = \App\Helpers\SiteSettingsHelper::copyrightNotice();
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
    
    // Get website name initials for logo badge
    $initials = strtoupper(substr($websiteName, 0, 3));
    if (strlen($websiteName) > 3) {
      $words = explode(' ', $websiteName);
      if (count($words) > 1) {
        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
      }
    }
  @endphp
  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-200 relative overflow-hidden">
    <!-- Subtle diagonal pattern background -->
    <div class="absolute inset-0 opacity-5">
      <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 40px);"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
        <div>
          @php
            $footerLogoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
          @endphp
          <a href="/" class="flex items-center gap-3 mb-4 group inline-block">
            @if($footerLogoUrl)
              <!-- Footer Logo Image -->
              <div class="relative overflow-hidden rounded-xl transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-20 transition-opacity duration-300" style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $accentColor }});"></div>
                <img src="{{ $footerLogoUrl }}" 
                     alt="{{ $websiteName }}" 
                     class="h-14 w-auto object-contain relative z-10 transition-transform duration-300 group-hover:scale-110"
                     loading="lazy">
              </div>
            @else
              <!-- Enhanced Footer Logo Badge -->
              <div class="relative">
                <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-md" style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $accentColor }});"></div>
                <div class="relative inline-flex h-14 w-14 items-center justify-center rounded-xl text-white font-black shadow-xl transition-all duration-300 group-hover:scale-110 group-hover:shadow-2xl group-hover:rotate-3" 
                     style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $accentColor }} 100%);">
                  <span class="text-xl">{{ $initials }}</span>
                </div>
              </div>
            @endif
            <div class="flex-1">
              <span class="font-extrabold text-xl tracking-tight block text-white group-hover:text-slate-200 transition-colors duration-200">{{ $websiteName }}</span>
              @if($tagline)
                <p class="text-sm text-slate-400 mt-1 group-hover:text-slate-300 transition-colors duration-200">{{ $tagline }}</p>
              @endif
            </div>
          </a>
          @if($footerText)
            <p class="text-sm text-slate-400 leading-relaxed">{{ $footerText }}</p>
          @else
            <p class="text-sm text-slate-400 leading-relaxed">Shop confidently with secure checkout and nationwide shipping. Need help? Our support team is ready to assist you.</p>
          @endif
        </div>

        <div>
          <h4 class="font-semibold text-lg text-white mb-4">Contact</h4>
          <ul class="space-y-3 text-sm">
            @if($primaryEmail)
            <li>
              <a href="mailto:{{ $primaryEmail }}" class="text-slate-300 hover:text-white transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ $primaryEmail }}
              </a>
            </li>
            @endif
            @if($secondaryEmail)
            <li>
              <a href="mailto:{{ $secondaryEmail }}" class="text-slate-300 hover:text-white transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ $secondaryEmail }}
              </a>
            </li>
            @endif
            @if($primaryPhone)
            <li>
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $primaryPhone) }}" class="text-slate-300 hover:text-white transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $primaryPhone }}
              </a>
            </li>
            @endif
            @if($secondaryPhone)
            <li>
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $secondaryPhone) }}" class="text-slate-300 hover:text-white transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $secondaryPhone }}
              </a>
            </li>
            @endif
            @if($physicalAddress)
            <li class="text-slate-400 flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              {{ $physicalAddress }}
            </li>
            @endif
            @if($businessHours)
            <li class="text-slate-400 flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              {{ $businessHours }}
            </li>
            @endif
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-lg text-white mb-4">Account</h4>
          <ul class="space-y-3 text-sm">
            <li><a class="text-slate-300 hover:text-white transition-colors duration-200" href="#">Dashboard</a></li>
            <li><a class="text-slate-300 hover:text-white transition-colors duration-200" href="#">Orders</a></li>
            <li><a class="text-slate-300 hover:text-white transition-colors duration-200" href="#">Wishlist</a></li>
            <li><a class="text-slate-300 hover:text-white transition-colors duration-200" href="#">Privacy Policy</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-lg text-white mb-4">Follow Us</h4>
          <div class="flex items-center gap-4 text-slate-300">
            @if(!empty($socialLinks['facebook']))
            <a href="{{ $socialLinks['facebook'] }}" target="_blank" rel="noopener noreferrer" aria-label="facebook" class="hover:text-white hover:scale-110 transition-all duration-200" title="Facebook">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99H7.898v-2.89h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/></svg>
            </a>
            @endif
            @if(!empty($socialLinks['instagram']))
            <a href="{{ $socialLinks['instagram'] }}" target="_blank" rel="noopener noreferrer" aria-label="instagram" class="hover:text-white hover:scale-110 transition-all duration-200" title="Instagram">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm8 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10z"/></svg>
            </a>
            @endif
            @if(!empty($socialLinks['twitter']))
            <a href="{{ $socialLinks['twitter'] }}" target="_blank" rel="noopener noreferrer" aria-label="twitter" class="hover:text-white hover:scale-110 transition-all duration-200" title="Twitter/X">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 5.924c-.69.307-1.432.513-2.208.605.794-.476 1.404-1.23 1.692-2.131-.743.44-1.567.76-2.444.933-.703-.75-1.71-1.216-2.823-1.216-2.136 0-3.868 1.732-3.868 3.868 0 .303.034.598.1.883-3.214-.161-6.066-1.7-7.979-4.041-.333.574-.524 1.242-.524 1.953 0 1.35.687 2.54 1.732 3.237-.638-.02-1.238-.196-1.763-.488v.049c0 1.884 1.34 3.456 3.118 3.813-.326.088-.669.136-1.023.136-.25 0-.493-.025-.73-.07.494 1.543 1.927 2.665 3.624 2.698-1.328 1.04-2.998 1.66-4.814 1.66-.313 0-.623-.018-.93-.053 1.717 1.101 3.755 1.743 5.947 1.743 7.135 0 11.04-5.913 11.04-11.04 0-.168-.004-.335-.012-.5.758-.547 1.415-1.23 1.934-2.01-.693.307-1.437.513-2.208.605z"/></svg>
            </a>
            @endif
            @if(!empty($socialLinks['linkedin']))
            <a href="{{ $socialLinks['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="linkedin" class="hover:text-white hover:scale-110 transition-all duration-200" title="LinkedIn">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            @endif
            @if(!empty($socialLinks['youtube']))
            <a href="{{ $socialLinks['youtube'] }}" target="_blank" rel="noopener noreferrer" aria-label="youtube" class="hover:text-white hover:scale-110 transition-all duration-200" title="YouTube">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            @endif
            @if(!empty($socialLinks['tiktok']))
            <a href="{{ $socialLinks['tiktok'] }}" target="_blank" rel="noopener noreferrer" aria-label="tiktok" class="hover:text-white hover:scale-110 transition-all duration-200" title="TikTok">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
            </a>
            @endif
          </div>
        </div>
      </div>

      <div class="mt-12 border-t border-slate-700 pt-6">
        <div class="text-center">
          @if($copyrightNotice)
            <p class="text-sm text-slate-400 mb-3">{{ str_replace('{year}', date('Y'), $copyrightNotice) }}</p>
          @else
            <p class="text-sm text-slate-400 mb-3">© <span id="year"></span> {{ $websiteName }}. All rights reserved.</p>
          @endif
          <div class="flex items-center justify-center gap-4">
            <a href="#" class="text-slate-400 hover:text-white transition-colors duration-200">Terms</a>
            <span class="text-slate-600">·</span>
            <a href="#" class="text-slate-400 hover:text-white transition-colors duration-200">Privacy</a>
            <span class="text-slate-600">·</span>
            <a href="#" class="text-slate-400 hover:text-white transition-colors duration-200">Support</a>
          </div>
        </div>
      </div>
    </div>
    <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
  </footer>