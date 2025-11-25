<x-admin-layout title="Site Settings">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Site Settings</h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Settings</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Site Settings Form Starts -->
  <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data" id="site-settings-form">
    @csrf
    @method('PUT')

    <!-- Tabs Navigation -->
    <div class="mb-6 border-b border-slate-200 dark:border-slate-700">
      <nav class="flex space-x-2" role="tablist">
        <button type="button" class="tab-button active" data-tab="general" role="tab">
          <i data-feather="settings" class="w-4 h-4 mr-2"></i>
          General
        </button>
        <button type="button" class="tab-button" data-tab="branding" role="tab">
          <i data-feather="image" class="w-4 h-4 mr-2"></i>
          Branding
        </button>
        <button type="button" class="tab-button" data-tab="contact" role="tab">
          <i data-feather="phone" class="w-4 h-4 mr-2"></i>
          Contact
        </button>
        <button type="button" class="tab-button" data-tab="social" role="tab">
          <i data-feather="share-2" class="w-4 h-4 mr-2"></i>
          Social Media
        </button>
        <button type="button" class="tab-button" data-tab="localization" role="tab">
          <i data-feather="globe" class="w-4 h-4 mr-2"></i>
          Localization
        </button>
        <button type="button" class="tab-button" data-tab="seo" role="tab">
          <i data-feather="search" class="w-4 h-4 mr-2"></i>
          SEO
        </button>
        <button type="button" class="tab-button" data-tab="maintenance" role="tab">
          <i data-feather="tool" class="w-4 h-4 mr-2"></i>
          Maintenance
        </button>
        <button type="button" class="tab-button" data-tab="advanced" role="tab">
          <i data-feather="code" class="w-4 h-4 mr-2"></i>
          Advanced
        </button>
      </nav>
    </div>

    <!-- Tab Contents -->
    <div class="space-y-6">
      <!-- General Tab -->
      <div class="tab-content active" id="tab-general">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Website Information</h6>
            <p class="card-subtitle">Configure basic website information</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label for="website_name" class="form-label required">Website Name</label>
              <input type="text" id="website_name" name="website_name" 
                     value="{{ old('website_name', $settings->website_name) }}"
                     class="form-control @error('website_name') is-invalid @enderror" required>
              @error('website_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="website_tagline" class="form-label">Tagline</label>
              <input type="text" id="website_tagline" name="website_tagline" 
                     value="{{ old('website_tagline', $settings->website_tagline) }}"
                     class="form-control @error('website_tagline') is-invalid @enderror"
                     placeholder="Your website tagline">
              @error('website_tagline')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="website_description" class="form-label">Description</label>
              <textarea id="website_description" name="website_description" rows="4"
                        class="form-control @error('website_description') is-invalid @enderror"
                        placeholder="Brief description of your website">{{ old('website_description', $settings->website_description) }}</textarea>
              @error('website_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="footer_text" class="form-label">Footer Text</label>
              <textarea id="footer_text" name="footer_text" rows="3"
                        class="form-control @error('footer_text') is-invalid @enderror"
                        placeholder="Text to display in footer">{{ old('footer_text', $settings->footer_text) }}</textarea>
              @error('footer_text')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="copyright_notice" class="form-label">Copyright Notice</label>
              <input type="text" id="copyright_notice" name="copyright_notice" 
                     value="{{ old('copyright_notice', $settings->copyright_notice) }}"
                     class="form-control @error('copyright_notice') is-invalid @enderror"
                     placeholder="© 2024 Your Company. All rights reserved.">
              @error('copyright_notice')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Branding Tab -->
      <div class="tab-content hidden" id="tab-branding">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Logo & Favicon</h6>
            <p class="card-subtitle">Upload your website logo and favicon</p>
          </div>
          <div class="card-body space-y-6">
            <!-- Logo Upload -->
            <div class="form-group">
              <label class="form-label">Logo</label>
              <div class="flex items-start gap-4">
                @if($settings->logo_path)
                  <div class="flex-shrink-0">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo_path) }}" alt="Logo" 
                         class="w-32 h-32 object-contain border border-slate-200 dark:border-slate-700 rounded-lg p-2">
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="deleteLogo()">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                      Delete Logo
                    </button>
                  </div>
                @endif
                <div class="flex-1">
                  <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                         class="form-control @error('logo') is-invalid @enderror"
                         onchange="previewImage(this, 'logo-preview')">
                  @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">PNG, JPG, SVG, or WEBP. Max 2MB. Recommended: 300x300px</div>
                  <div id="logo-preview" class="mt-2 hidden">
                    <img src="" alt="Logo Preview" class="w-32 h-32 object-contain border border-slate-200 dark:border-slate-700 rounded-lg p-2">
                  </div>
                </div>
              </div>
            </div>

            <!-- Favicon Upload -->
            <div class="form-group">
              <label class="form-label">Favicon</label>
              <div class="flex items-start gap-4">
                @if($settings->favicon_path)
                  <div class="flex-shrink-0">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon_path) }}" alt="Favicon" 
                         class="w-16 h-16 object-contain border border-slate-200 dark:border-slate-700 rounded-lg p-2">
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="deleteFavicon()">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                      Delete Favicon
                    </button>
                  </div>
                @endif
                <div class="flex-1">
                  <input type="file" id="favicon" name="favicon" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/x-icon"
                         class="form-control @error('favicon') is-invalid @enderror"
                         onchange="previewImage(this, 'favicon-preview')">
                  @error('favicon')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">PNG, JPG, SVG, or ICO. Max 1MB. Recommended: 32x32px</div>
                  <div id="favicon-preview" class="mt-2 hidden">
                    <img src="" alt="Favicon Preview" class="w-16 h-16 object-contain border border-slate-200 dark:border-slate-700 rounded-lg p-2">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Theme Colors -->
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Theme Colors</h6>
            <p class="card-subtitle">Customize your website color scheme</p>
          </div>
          <div class="card-body space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="form-group">
                <label for="primary_color" class="form-label required">Primary Color</label>
                <div class="flex gap-2">
                  <input type="color" id="primary_color" name="primary_color" 
                         value="{{ old('primary_color', $settings->primary_color) }}"
                         class="form-control h-10 w-20 @error('primary_color') is-invalid @enderror" required>
                  <input type="text" value="{{ old('primary_color', $settings->primary_color) }}"
                         class="form-control flex-1 @error('primary_color') is-invalid @enderror"
                         placeholder="#F59E0B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                         onchange="document.getElementById('primary_color').value = this.value">
                </div>
                @error('primary_color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_color" class="form-label required">Secondary Color</label>
                <div class="flex gap-2">
                  <input type="color" id="secondary_color" name="secondary_color" 
                         value="{{ old('secondary_color', $settings->secondary_color) }}"
                         class="form-control h-10 w-20 @error('secondary_color') is-invalid @enderror" required>
                  <input type="text" value="{{ old('secondary_color', $settings->secondary_color) }}"
                         class="form-control flex-1 @error('secondary_color') is-invalid @enderror"
                         placeholder="#1E293B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                         onchange="document.getElementById('secondary_color').value = this.value">
                </div>
                @error('secondary_color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="accent_color" class="form-label required">Accent Color</label>
                <div class="flex gap-2">
                  <input type="color" id="accent_color" name="accent_color" 
                         value="{{ old('accent_color', $settings->accent_color) }}"
                         class="form-control h-10 w-20 @error('accent_color') is-invalid @enderror" required>
                  <input type="text" value="{{ old('accent_color', $settings->accent_color) }}"
                         class="form-control flex-1 @error('accent_color') is-invalid @enderror"
                         placeholder="#EF4444" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                         onchange="document.getElementById('accent_color').value = this.value">
                </div>
                @error('accent_color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Tab -->
      <div class="tab-content hidden" id="tab-contact">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Contact Information</h6>
            <p class="card-subtitle">Manage your business contact details</p>
          </div>
          <div class="card-body space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-group">
                <label for="primary_email" class="form-label">Primary Email</label>
                <input type="email" id="primary_email" name="primary_email" 
                       value="{{ old('primary_email', $settings->primary_email) }}"
                       class="form-control @error('primary_email') is-invalid @enderror"
                       placeholder="info@example.com">
                @error('primary_email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_email" class="form-label">Secondary Email</label>
                <input type="email" id="secondary_email" name="secondary_email" 
                       value="{{ old('secondary_email', $settings->secondary_email) }}"
                       class="form-control @error('secondary_email') is-invalid @enderror"
                       placeholder="support@example.com">
                @error('secondary_email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="primary_phone" class="form-label">Primary Phone</label>
                <input type="text" id="primary_phone" name="primary_phone" 
                       value="{{ old('primary_phone', $settings->primary_phone) }}"
                       class="form-control @error('primary_phone') is-invalid @enderror"
                       placeholder="+880 1234 567890">
                @error('primary_phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_phone" class="form-label">Secondary Phone</label>
                <input type="text" id="secondary_phone" name="secondary_phone" 
                       value="{{ old('secondary_phone', $settings->secondary_phone) }}"
                       class="form-control @error('secondary_phone') is-invalid @enderror"
                       placeholder="+880 1234 567891">
                @error('secondary_phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="physical_address" class="form-label">Physical Address</label>
              <textarea id="physical_address" name="physical_address" rows="3"
                        class="form-control @error('physical_address') is-invalid @enderror"
                        placeholder="Your business address">{{ old('physical_address', $settings->physical_address) }}</textarea>
              @error('physical_address')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="business_hours" class="form-label">Business Hours</label>
              <textarea id="business_hours" name="business_hours" rows="2"
                        class="form-control @error('business_hours') is-invalid @enderror"
                        placeholder="Mon-Fri: 9:00 AM - 6:00 PM">{{ old('business_hours', $settings->business_hours) }}</textarea>
              @error('business_hours')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media Tab -->
      <div class="tab-content hidden" id="tab-social">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Social Media Links</h6>
            <p class="card-subtitle">Add your social media profile URLs</p>
          </div>
          <div class="card-body space-y-4">
            @php
              $socialLinks = old('social_media_links', $settings->social_media_links ?? []);
            @endphp
            <div class="form-group">
              <label for="social_facebook" class="form-label">Facebook</label>
              <input type="url" id="social_facebook" name="social_media_links[facebook]" 
                     value="{{ $socialLinks['facebook'] ?? '' }}"
                     class="form-control @error('social_media_links.facebook') is-invalid @enderror"
                     placeholder="https://facebook.com/yourpage">
              @error('social_media_links.facebook')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_twitter" class="form-label">Twitter/X</label>
              <input type="url" id="social_twitter" name="social_media_links[twitter]" 
                     value="{{ $socialLinks['twitter'] ?? '' }}"
                     class="form-control @error('social_media_links.twitter') is-invalid @enderror"
                     placeholder="https://twitter.com/yourhandle">
              @error('social_media_links.twitter')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_instagram" class="form-label">Instagram</label>
              <input type="url" id="social_instagram" name="social_media_links[instagram]" 
                     value="{{ $socialLinks['instagram'] ?? '' }}"
                     class="form-control @error('social_media_links.instagram') is-invalid @enderror"
                     placeholder="https://instagram.com/yourprofile">
              @error('social_media_links.instagram')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_linkedin" class="form-label">LinkedIn</label>
              <input type="url" id="social_linkedin" name="social_media_links[linkedin]" 
                     value="{{ $socialLinks['linkedin'] ?? '' }}"
                     class="form-control @error('social_media_links.linkedin') is-invalid @enderror"
                     placeholder="https://linkedin.com/company/yourcompany">
              @error('social_media_links.linkedin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_youtube" class="form-label">YouTube</label>
              <input type="url" id="social_youtube" name="social_media_links[youtube]" 
                     value="{{ $socialLinks['youtube'] ?? '' }}"
                     class="form-control @error('social_media_links.youtube') is-invalid @enderror"
                     placeholder="https://youtube.com/@yourchannel">
              @error('social_media_links.youtube')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_tiktok" class="form-label">TikTok</label>
              <input type="url" id="social_tiktok" name="social_media_links[tiktok]" 
                     value="{{ $socialLinks['tiktok'] ?? '' }}"
                     class="form-control @error('social_media_links.tiktok') is-invalid @enderror"
                     placeholder="https://tiktok.com/@yourhandle">
              @error('social_media_links.tiktok')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Localization Tab -->
      <div class="tab-content hidden" id="tab-localization">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Localization Settings</h6>
            <p class="card-subtitle">Configure currency, language, and timezone</p>
          </div>
          <div class="card-body space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-group">
                <label for="default_currency" class="form-label required">Default Currency</label>
                <select id="default_currency" name="default_currency" 
                        class="form-control @error('default_currency') is-invalid @enderror" required>
                  <option value="USD" {{ old('default_currency', $settings->default_currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                  <option value="EUR" {{ old('default_currency', $settings->default_currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                  <option value="GBP" {{ old('default_currency', $settings->default_currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                  <option value="BDT" {{ old('default_currency', $settings->default_currency) == 'BDT' ? 'selected' : '' }}>BDT - Bangladeshi Taka</option>
                  <option value="INR" {{ old('default_currency', $settings->default_currency) == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                  <option value="PKR" {{ old('default_currency', $settings->default_currency) == 'PKR' ? 'selected' : '' }}>PKR - Pakistani Rupee</option>
                  <option value="AED" {{ old('default_currency', $settings->default_currency) == 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                  <option value="SAR" {{ old('default_currency', $settings->default_currency) == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                </select>
                @error('default_currency')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="default_language" class="form-label required">Default Language</label>
                <select id="default_language" name="default_language" 
                        class="form-control @error('default_language') is-invalid @enderror" required>
                  <option value="en" {{ old('default_language', $settings->default_language) == 'en' ? 'selected' : '' }}>English</option>
                  <option value="bn" {{ old('default_language', $settings->default_language) == 'bn' ? 'selected' : '' }}>Bengali</option>
                  <option value="ar" {{ old('default_language', $settings->default_language) == 'ar' ? 'selected' : '' }}>Arabic</option>
                  <option value="hi" {{ old('default_language', $settings->default_language) == 'hi' ? 'selected' : '' }}>Hindi</option>
                  <option value="ur" {{ old('default_language', $settings->default_language) == 'ur' ? 'selected' : '' }}>Urdu</option>
                  <option value="fr" {{ old('default_language', $settings->default_language) == 'fr' ? 'selected' : '' }}>French</option>
                  <option value="de" {{ old('default_language', $settings->default_language) == 'de' ? 'selected' : '' }}>German</option>
                  <option value="es" {{ old('default_language', $settings->default_language) == 'es' ? 'selected' : '' }}>Spanish</option>
                </select>
                @error('default_language')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group md:col-span-2">
                <label for="supported_languages" class="form-label">Supported Languages</label>
                <div class="flex flex-wrap gap-2">
                  @php
                    $supportedLanguages = old('supported_languages', $settings->supported_languages ?? []);
                  @endphp
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="en" 
                           {{ in_array('en', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    English
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="bn" 
                           {{ in_array('bn', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    Bengali
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="ar" 
                           {{ in_array('ar', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    Arabic
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="hi" 
                           {{ in_array('hi', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    Hindi
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="ur" 
                           {{ in_array('ur', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    Urdu
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="fr" 
                           {{ in_array('fr', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    French
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="de" 
                           {{ in_array('de', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    German
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" name="supported_languages[]" value="es" 
                           {{ in_array('es', $supportedLanguages) ? 'checked' : '' }}
                           class="mr-2 rounded border-slate-300">
                    Spanish
                  </label>
                </div>
                @error('supported_languages')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group md:col-span-2">
                <label for="timezone" class="form-label required">Timezone</label>
                <select id="timezone" name="timezone" 
                        class="form-control @error('timezone') is-invalid @enderror" required>
                  @foreach(timezone_identifiers_list() as $tz)
                    <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) == $tz ? 'selected' : '' }}>
                      {{ $tz }}
                    </option>
                  @endforeach
                </select>
                @error('timezone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Tab -->
      <div class="tab-content hidden" id="tab-seo">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">SEO Meta Tags</h6>
            <p class="card-subtitle">Configure search engine optimization settings</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label for="meta_title" class="form-label">Meta Title</label>
              <input type="text" id="meta_title" name="meta_title" 
                     value="{{ old('meta_title', $settings->meta_title) }}"
                     class="form-control @error('meta_title') is-invalid @enderror"
                     placeholder="Your website title for search engines"
                     maxlength="255">
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Recommended: 50-60 characters</div>
            </div>

            <div class="form-group">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea id="meta_description" name="meta_description" rows="3"
                        class="form-control @error('meta_description') is-invalid @enderror"
                        placeholder="Brief description of your website for search engines"
                        maxlength="500">{{ old('meta_description', $settings->meta_description) }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Recommended: 150-160 characters</div>
            </div>

            <div class="form-group">
              <label for="meta_keywords" class="form-label">Meta Keywords</label>
              <input type="text" id="meta_keywords" name="meta_keywords" 
                     value="{{ old('meta_keywords', $settings->meta_keywords) }}"
                     class="form-control @error('meta_keywords') is-invalid @enderror"
                     placeholder="keyword1, keyword2, keyword3"
                     maxlength="500">
              @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Comma-separated keywords</div>
            </div>

            <div class="form-group">
              <label for="canonical_url" class="form-label">Canonical URL</label>
              <input type="url" id="canonical_url" name="canonical_url" 
                     value="{{ old('canonical_url', $settings->canonical_url) }}"
                     class="form-control @error('canonical_url') is-invalid @enderror"
                     placeholder="https://yourwebsite.com">
              @error('canonical_url')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Open Graph Tags -->
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Open Graph Tags (Social Sharing)</h6>
            <p class="card-subtitle">Configure how your site appears when shared on social media</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label for="og_title" class="form-label">OG Title</label>
              <input type="text" id="og_title" name="og_title" 
                     value="{{ old('og_title', $settings->og_title) }}"
                     class="form-control @error('og_title') is-invalid @enderror"
                     placeholder="Title for social media sharing"
                     maxlength="255">
              @error('og_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="og_description" class="form-label">OG Description</label>
              <textarea id="og_description" name="og_description" rows="3"
                        class="form-control @error('og_description') is-invalid @enderror"
                        placeholder="Description for social media sharing"
                        maxlength="500">{{ old('og_description', $settings->og_description) }}</textarea>
              @error('og_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">OG Image</label>
              <div class="flex items-start gap-4">
                @if($settings->og_image)
                  <div class="flex-shrink-0">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->og_image) }}" alt="OG Image" 
                         class="w-32 h-32 object-cover border border-slate-200 dark:border-slate-700 rounded-lg">
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="deleteOgImage()">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                      Delete Image
                    </button>
                  </div>
                @endif
                <div class="flex-1">
                  <input type="file" id="og_image" name="og_image" accept="image/png,image/jpeg,image/jpg,image/webp"
                         class="form-control @error('og_image') is-invalid @enderror"
                         onchange="previewImage(this, 'og-image-preview')">
                  @error('og_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">PNG, JPG, or WEBP. Max 2MB. Recommended: 1200x630px</div>
                  <div id="og-image-preview" class="mt-2 hidden">
                    <img src="" alt="OG Image Preview" class="w-32 h-32 object-cover border border-slate-200 dark:border-slate-700 rounded-lg">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Maintenance Tab -->
      <div class="tab-content hidden" id="tab-maintenance">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Maintenance Mode</h6>
            <p class="card-subtitle">Control site maintenance and scheduled downtime</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label class="flex items-center gap-2">
                <input type="checkbox" name="maintenance_mode" value="1" 
                       {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}
                       class="rounded border-slate-300">
                <span class="font-medium">Enable Maintenance Mode</span>
              </label>
              <div class="form-text">When enabled, visitors will see a maintenance message instead of your site</div>
            </div>

            <div class="form-group">
              <label for="maintenance_message" class="form-label">Maintenance Message</label>
              <textarea id="maintenance_message" name="maintenance_message" rows="4"
                        class="form-control @error('maintenance_message') is-invalid @enderror"
                        placeholder="We're currently performing scheduled maintenance. Please check back soon.">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
              @error('maintenance_message')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-group">
                <label for="maintenance_scheduled_at" class="form-label">Scheduled Start</label>
                <input type="datetime-local" id="maintenance_scheduled_at" name="maintenance_scheduled_at" 
                       value="{{ old('maintenance_scheduled_at', $settings->maintenance_scheduled_at ? $settings->maintenance_scheduled_at->format('Y-m-d\TH:i') : '') }}"
                       class="form-control @error('maintenance_scheduled_at') is-invalid @enderror">
                @error('maintenance_scheduled_at')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="maintenance_scheduled_until" class="form-label">Scheduled End</label>
                <input type="datetime-local" id="maintenance_scheduled_until" name="maintenance_scheduled_until" 
                       value="{{ old('maintenance_scheduled_until', $settings->maintenance_scheduled_until ? $settings->maintenance_scheduled_until->format('Y-m-d\TH:i') : '') }}"
                       class="form-control @error('maintenance_scheduled_until') is-invalid @enderror">
                @error('maintenance_scheduled_until')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Advanced Tab -->
      <div class="tab-content hidden" id="tab-advanced">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Analytics & Tracking</h6>
            <p class="card-subtitle">Configure analytics and tracking codes</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
              <input type="text" id="google_analytics_id" name="google_analytics_id" 
                     value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                     class="form-control @error('google_analytics_id') is-invalid @enderror"
                     placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X">
              @error('google_analytics_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Custom Code</h6>
            <p class="card-subtitle">Add custom CSS and JavaScript</p>
          </div>
          <div class="card-body space-y-4">
            <div class="form-group">
              <label for="custom_css" class="form-label">Custom CSS</label>
              <textarea id="custom_css" name="custom_css" rows="10"
                        class="font-mono text-sm form-control @error('custom_css') is-invalid @enderror"
                        placeholder="/* Your custom CSS code */">{{ old('custom_css', $settings->custom_css) }}</textarea>
              @error('custom_css')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">CSS will be injected in the &lt;head&gt; section</div>
            </div>

            <div class="form-group">
              <label for="custom_js" class="form-label">Custom JavaScript</label>
              <textarea id="custom_js" name="custom_js" rows="10"
                        class="font-mono text-sm form-control @error('custom_js') is-invalid @enderror"
                        placeholder="// Your custom JavaScript code">{{ old('custom_js', $settings->custom_js) }}</textarea>
              @error('custom_js')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">JavaScript will be injected before &lt;/body&gt; tag</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="mt-6 flex justify-end gap-3">
      <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
        <i data-feather="refresh-cw" class="w-4 h-4 mr-2"></i>
        Reset
      </button>
      <button type="submit" class="btn btn-primary">
        <i data-feather="save" class="w-4 h-4 mr-2"></i>
        Save Settings
      </button>
    </div>
  </form>

  @push('styles')
  <style>
    .tab-button {
      @apply px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 border-b-2 border-transparent hover:text-primary hover:border-primary transition-colors;
    }
    .tab-button.active {
      @apply text-primary border-primary;
    }
    .tab-content {
      @apply hidden;
    }
    .tab-content.active {
      @apply block;
    }
  </style>
  @endpush

  @push('scripts')
  <script>
    // Tab switching
    document.querySelectorAll('.tab-button').forEach(button => {
      button.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        
        // Remove active class from all buttons and contents
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => {
          content.classList.remove('active');
          content.classList.add('hidden');
        });
        
        // Add active class to clicked button and corresponding content
        this.classList.add('active');
        const content = document.getElementById('tab-' + tabId);
        if (content) {
          content.classList.add('active');
          content.classList.remove('hidden');
        }
      });
    });

    // Image preview
    function previewImage(input, previewId) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById(previewId);
          if (preview) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
          }
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Delete logo
    async function deleteLogo() {
      if (!confirm('Are you sure you want to delete the logo?')) return;
      
      try {
        const response = await fetch('{{ route("admin.site-settings.delete-logo") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          location.reload();
        } else {
          alert('Failed to delete logo');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the logo');
      }
    }

    // Delete favicon
    async function deleteFavicon() {
      if (!confirm('Are you sure you want to delete the favicon?')) return;
      
      try {
        const response = await fetch('{{ route("admin.site-settings.delete-favicon") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          location.reload();
        } else {
          alert('Failed to delete favicon');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the favicon');
      }
    }

    // Delete OG image
    async function deleteOgImage() {
      if (!confirm('Are you sure you want to delete the OG image?')) return;
      
      try {
        const response = await fetch('{{ route("admin.site-settings.delete-og-image") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          location.reload();
        } else {
          alert('Failed to delete OG image');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the OG image');
      }
    }

    // Initialize Feather icons
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof feather !== 'undefined') {
        feather.replace();
      }
    });
  </script>
  @endpush
</x-admin-layout>

