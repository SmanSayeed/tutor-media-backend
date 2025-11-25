<x-admin-layout title="Site Settings">
  <!-- Enhanced Page Header -->
  <div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
      <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2 flex items-center gap-3">
          <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/25">
            <i data-feather="settings" class="w-6 h-6"></i>
          </span>
          Site Settings
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Manage your website configuration, branding, and preferences</p>
      </div>
      <div class="flex items-center gap-2">
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
          <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
          Auto-save enabled
        </span>
      </div>
    </div>
    <ol class="breadcrumb text-sm">
      <li class="breadcrumb-item">
        <a href="/" class="text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400 transition-colors">Home</a>
      </li>
      <li class="breadcrumb-item">
        <span class="text-slate-900 dark:text-slate-100">Settings</span>
      </li>
    </ol>
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-800 shadow-sm animate-slide-down">
      <div class="flex items-center gap-3">
        <div class="flex-shrink-0">
          <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center">
            <i data-feather="check" class="w-5 h-5 text-white"></i>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">Success!</h3>
          <p class="text-sm text-emerald-700 dark:text-emerald-300 mt-0.5">{{ session('success') }}</p>
        </div>
        <button type="button" onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200">
          <i data-feather="x" class="w-5 h-5"></i>
        </button>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border border-red-200 dark:border-red-800 shadow-sm animate-slide-down">
      <div class="flex items-center gap-3">
        <div class="flex-shrink-0">
          <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center">
            <i data-feather="alert-circle" class="w-5 h-5 text-white"></i>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="text-sm font-semibold text-red-900 dark:text-red-100">Error</h3>
          <p class="text-sm text-red-700 dark:text-red-300 mt-0.5">{{ session('error') }}</p>
        </div>
        <button type="button" onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
          <i data-feather="x" class="w-5 h-5"></i>
        </button>
      </div>
    </div>
  @endif

  <!-- Site Settings Form Starts -->
  <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data" id="site-settings-form" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Enhanced Tabs Navigation -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
      <nav class="flex flex-wrap gap-1 p-2" role="tablist" aria-label="Settings sections">
        <button type="button" class="tab-button active group" data-tab="general" role="tab" aria-selected="true" aria-controls="tab-general">
          <span class="tab-button-content">
            <i data-feather="settings" class="w-4 h-4"></i>
            <span>General</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="branding" role="tab" aria-selected="false" aria-controls="tab-branding">
          <span class="tab-button-content">
            <i data-feather="image" class="w-4 h-4"></i>
            <span>Branding</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="contact" role="tab" aria-selected="false" aria-controls="tab-contact">
          <span class="tab-button-content">
            <i data-feather="phone" class="w-4 h-4"></i>
            <span>Contact</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="social" role="tab" aria-selected="false" aria-controls="tab-social">
          <span class="tab-button-content">
            <i data-feather="share-2" class="w-4 h-4"></i>
            <span>Social</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="localization" role="tab" aria-selected="false" aria-controls="tab-localization">
          <span class="tab-button-content">
            <i data-feather="globe" class="w-4 h-4"></i>
            <span>Localization</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="seo" role="tab" aria-selected="false" aria-controls="tab-seo">
          <span class="tab-button-content">
            <i data-feather="search" class="w-4 h-4"></i>
            <span>SEO</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="maintenance" role="tab" aria-selected="false" aria-controls="tab-maintenance">
          <span class="tab-button-content">
            <i data-feather="tool" class="w-4 h-4"></i>
            <span>Maintenance</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
        <button type="button" class="tab-button group" data-tab="advanced" role="tab" aria-selected="false" aria-controls="tab-advanced">
          <span class="tab-button-content">
            <i data-feather="code" class="w-4 h-4"></i>
            <span>Advanced</span>
          </span>
          <span class="tab-indicator"></span>
        </button>
      </nav>
    </div>

    <!-- Tab Contents -->
    <div class="space-y-6">
      <!-- General Tab -->
      <div class="tab-content active animate-fade-in" id="tab-general">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                <i data-feather="info" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Website Information</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure basic website information and branding</p>
              </div>
            </div>
          </div>
          <div class="card-body space-y-6">
            <div class="form-group">
              <label for="website_name" class="form-label required flex items-center gap-2">
                <i data-feather="globe" class="w-4 h-4 text-slate-500"></i>
                <span>Website Name</span>
              </label>
              <div class="relative">
                <input type="text" id="website_name" name="website_name" 
                       value="{{ old('website_name', $settings->website_name) }}"
                       class="form-control enhanced-input @error('website_name') is-invalid @enderror" 
                       placeholder="Enter your website name"
                       required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <i data-feather="check-circle" class="w-5 h-5 text-emerald-500 hidden input-valid-icon"></i>
                </div>
              </div>
              @error('website_name')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
              <div class="form-text mt-1.5 flex items-start gap-1.5">
                <i data-feather="help-circle" class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"></i>
                <span>This name will appear in browser tabs and search results</span>
              </div>
            </div>

            <div class="form-group">
              <label for="website_tagline" class="form-label flex items-center gap-2">
                <i data-feather="tag" class="w-4 h-4 text-slate-500"></i>
                <span>Tagline</span>
              </label>
              <input type="text" id="website_tagline" name="website_tagline" 
                     value="{{ old('website_tagline', $settings->website_tagline) }}"
                     class="form-control enhanced-input @error('website_tagline') is-invalid @enderror"
                     placeholder="Your website tagline">
              @error('website_tagline')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="website_description" class="form-label flex items-center gap-2">
                <i data-feather="file-text" class="w-4 h-4 text-slate-500"></i>
                <span>Description</span>
              </label>
              <textarea id="website_description" name="website_description" rows="4"
                        class="form-control enhanced-input @error('website_description') is-invalid @enderror"
                        placeholder="Brief description of your website">{{ old('website_description', $settings->website_description) }}</textarea>
              <div class="flex items-center justify-between mt-1.5">
                <div class="form-text flex items-start gap-1.5">
                  <i data-feather="help-circle" class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"></i>
                  <span>Used in meta descriptions and search results</span>
                </div>
                <span class="text-xs text-slate-400" id="description-count">0 characters</span>
              </div>
              @error('website_description')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="footer_text" class="form-label flex items-center gap-2">
                <i data-feather="align-left" class="w-4 h-4 text-slate-500"></i>
                <span>Footer Text</span>
              </label>
              <textarea id="footer_text" name="footer_text" rows="3"
                        class="form-control enhanced-input @error('footer_text') is-invalid @enderror"
                        placeholder="Text to display in footer">{{ old('footer_text', $settings->footer_text) }}</textarea>
              @error('footer_text')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="copyright_notice" class="form-label flex items-center gap-2">
                <i data-feather="copyright" class="w-4 h-4 text-slate-500"></i>
                <span>Copyright Notice</span>
              </label>
              <input type="text" id="copyright_notice" name="copyright_notice" 
                     value="{{ old('copyright_notice', $settings->copyright_notice) }}"
                     class="form-control enhanced-input @error('copyright_notice') is-invalid @enderror"
                     placeholder="© {{ date('Y') }} Your Company. All rights reserved.">
              @error('copyright_notice')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Branding Tab -->
      <div class="tab-content hidden animate-fade-in" id="tab-branding">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <i data-feather="image" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Logo & Favicon</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Upload your website logo and favicon</p>
              </div>
            </div>
          </div>
          <div class="card-body space-y-8">
            <!-- Logo Upload -->
            <div class="form-group">
              <label class="form-label flex items-center gap-2 mb-3">
                <i data-feather="image" class="w-4 h-4 text-slate-500"></i>
                <span class="font-medium">Logo</span>
              </label>
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @if($settings->logo_path)
                  <div class="flex-shrink-0">
                    <div class="relative group">
                      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button type="button" class="btn btn-sm btn-danger shadow-lg" onclick="deleteLogo()">
                          <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                          Delete
                        </button>
                      </div>
                      <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo_path) }}" alt="Logo" 
                           class="w-full h-48 object-contain border-2 border-slate-200 dark:border-slate-700 rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 shadow-sm">
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 text-center">Current Logo</p>
                  </div>
                @endif
                <div class="flex-1">
                  <div class="file-upload-area" id="logo-upload-area">
                    <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                           class="file-input hidden @error('logo') is-invalid @enderror"
                           onchange="previewImage(this, 'logo-preview', 'logo-upload-area')">
                    <div class="file-upload-content">
                      <div class="file-upload-icon">
                        <i data-feather="upload-cloud" class="w-12 h-12 text-slate-400"></i>
                      </div>
                      <p class="file-upload-text">
                        <span class="font-medium text-primary-600 dark:text-primary-400">Click to upload</span>
                        or drag and drop
                      </p>
                      <p class="file-upload-hint">PNG, JPG, SVG, or WEBP (Max 2MB)</p>
                      <p class="file-upload-recommendation">Recommended: 300x300px</p>
                    </div>
                  </div>
                  @error('logo')
                    <div class="invalid-feedback flex items-center gap-1 mt-2">
                      <i data-feather="alert-circle" class="w-4 h-4"></i>
                      <span>{{ $message }}</span>
                    </div>
                  @enderror
                  <div id="logo-preview" class="mt-4 hidden">
                    <div class="relative">
                      <img src="" alt="Logo Preview" class="w-full h-48 object-contain border-2 border-primary-200 dark:border-primary-800 rounded-xl p-4 bg-primary-50 dark:bg-primary-900/20 shadow-sm">
                      <span class="absolute top-2 right-2 px-2 py-1 bg-primary-500 text-white text-xs font-medium rounded-lg">Preview</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Favicon Upload -->
            <div class="form-group">
              <label class="form-label flex items-center gap-2 mb-3">
                <i data-feather="star" class="w-4 h-4 text-slate-500"></i>
                <span class="font-medium">Favicon</span>
              </label>
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @if($settings->favicon_path)
                  <div class="flex-shrink-0">
                    <div class="relative group">
                      <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button type="button" class="btn btn-sm btn-danger shadow-lg" onclick="deleteFavicon()">
                          <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                          Delete
                        </button>
                      </div>
                      <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon_path) }}" alt="Favicon" 
                           class="w-32 h-32 object-contain border-2 border-slate-200 dark:border-slate-700 rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 shadow-sm">
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 text-center">Current Favicon</p>
                  </div>
                @endif
                <div class="flex-1">
                  <div class="file-upload-area" id="favicon-upload-area">
                    <input type="file" id="favicon" name="favicon" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/x-icon"
                           class="file-input hidden @error('favicon') is-invalid @enderror"
                           onchange="previewImage(this, 'favicon-preview', 'favicon-upload-area')">
                    <div class="file-upload-content">
                      <div class="file-upload-icon">
                        <i data-feather="upload-cloud" class="w-12 h-12 text-slate-400"></i>
                      </div>
                      <p class="file-upload-text">
                        <span class="font-medium text-primary-600 dark:text-primary-400">Click to upload</span>
                        or drag and drop
                      </p>
                      <p class="file-upload-hint">PNG, JPG, SVG, or ICO (Max 1MB)</p>
                      <p class="file-upload-recommendation">Recommended: 32x32px</p>
                    </div>
                  </div>
                  @error('favicon')
                    <div class="invalid-feedback flex items-center gap-1 mt-2">
                      <i data-feather="alert-circle" class="w-4 h-4"></i>
                      <span>{{ $message }}</span>
                    </div>
                  @enderror
                  <div id="favicon-preview" class="mt-4 hidden">
                    <div class="relative">
                      <img src="" alt="Favicon Preview" class="w-32 h-32 object-contain border-2 border-primary-200 dark:border-primary-800 rounded-xl p-4 bg-primary-50 dark:bg-primary-900/20 shadow-sm mx-auto">
                      <span class="absolute top-2 right-2 px-2 py-1 bg-primary-500 text-white text-xs font-medium rounded-lg">Preview</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Theme Colors -->
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                <i data-feather="palette" class="w-5 h-5 text-pink-600 dark:text-pink-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Theme Colors</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Customize your website color scheme</p>
              </div>
            </div>
          </div>
          <div class="card-body space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="form-group">
                <label for="primary_color" class="form-label required flex items-center gap-2 mb-3">
                  <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                  <span>Primary Color</span>
                </label>
                <div class="space-y-2">
                  <div class="flex gap-3 items-center">
                    <div class="relative">
                      <input type="color" id="primary_color" name="primary_color" 
                             value="{{ old('primary_color', $settings->primary_color) }}"
                             class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('primary_color') is-invalid @enderror" 
                             required
                             style="padding: 2px;">
                      <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800" 
                           style="background-color: {{ old('primary_color', $settings->primary_color) }}"></div>
                    </div>
                    <input type="text" id="primary_color_text" 
                           value="{{ old('primary_color', $settings->primary_color) }}"
                           class="form-control enhanced-input flex-1 font-mono text-sm @error('primary_color') is-invalid @enderror"
                           placeholder="#F59E0B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                  </div>
                  <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700" 
                       style="background-color: {{ old('primary_color', $settings->primary_color) }}"
                       id="primary_color_preview"></div>
                </div>
                @error('primary_color')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_color" class="form-label required flex items-center gap-2 mb-3">
                  <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                  <span>Secondary Color</span>
                </label>
                <div class="space-y-2">
                  <div class="flex gap-3 items-center">
                    <div class="relative">
                      <input type="color" id="secondary_color" name="secondary_color" 
                             value="{{ old('secondary_color', $settings->secondary_color) }}"
                             class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('secondary_color') is-invalid @enderror" 
                             required
                             style="padding: 2px;">
                      <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800" 
                           style="background-color: {{ old('secondary_color', $settings->secondary_color) }}"></div>
                    </div>
                    <input type="text" id="secondary_color_text" 
                           value="{{ old('secondary_color', $settings->secondary_color) }}"
                           class="form-control enhanced-input flex-1 font-mono text-sm @error('secondary_color') is-invalid @enderror"
                           placeholder="#1E293B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                  </div>
                  <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700" 
                       style="background-color: {{ old('secondary_color', $settings->secondary_color) }}"
                       id="secondary_color_preview"></div>
                </div>
                @error('secondary_color')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="accent_color" class="form-label required flex items-center gap-2 mb-3">
                  <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                  <span>Accent Color</span>
                </label>
                <div class="space-y-2">
                  <div class="flex gap-3 items-center">
                    <div class="relative">
                      <input type="color" id="accent_color" name="accent_color" 
                             value="{{ old('accent_color', $settings->accent_color) }}"
                             class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('accent_color') is-invalid @enderror" 
                             required
                             style="padding: 2px;">
                      <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800" 
                           style="background-color: {{ old('accent_color', $settings->accent_color) }}"></div>
                    </div>
                    <input type="text" id="accent_color_text" 
                           value="{{ old('accent_color', $settings->accent_color) }}"
                           class="form-control enhanced-input flex-1 font-mono text-sm @error('accent_color') is-invalid @enderror"
                           placeholder="#EF4444" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                  </div>
                  <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700" 
                       style="background-color: {{ old('accent_color', $settings->accent_color) }}"
                       id="accent_color_preview"></div>
                </div>
                @error('accent_color')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Tab -->
      <div class="tab-content hidden animate-fade-in" id="tab-contact">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <i data-feather="phone" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Contact Information</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Manage your business contact details</p>
              </div>
            </div>
          </div>
          <div class="card-body space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label for="primary_email" class="form-label flex items-center gap-2">
                  <i data-feather="mail" class="w-4 h-4 text-slate-500"></i>
                  <span>Primary Email</span>
                </label>
                <div class="relative">
                  <input type="email" id="primary_email" name="primary_email" 
                         value="{{ old('primary_email', $settings->primary_email) }}"
                         class="form-control enhanced-input pl-10 @error('primary_email') is-invalid @enderror"
                         placeholder="info@example.com">
                  <i data-feather="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
                @error('primary_email')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_email" class="form-label flex items-center gap-2">
                  <i data-feather="mail" class="w-4 h-4 text-slate-500"></i>
                  <span>Secondary Email</span>
                </label>
                <div class="relative">
                  <input type="email" id="secondary_email" name="secondary_email" 
                         value="{{ old('secondary_email', $settings->secondary_email) }}"
                         class="form-control enhanced-input pl-10 @error('secondary_email') is-invalid @enderror"
                         placeholder="support@example.com">
                  <i data-feather="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
                @error('secondary_email')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="primary_phone" class="form-label flex items-center gap-2">
                  <i data-feather="phone" class="w-4 h-4 text-slate-500"></i>
                  <span>Primary Phone</span>
                </label>
                <div class="relative">
                  <input type="text" id="primary_phone" name="primary_phone" 
                         value="{{ old('primary_phone', $settings->primary_phone) }}"
                         class="form-control enhanced-input pl-10 @error('primary_phone') is-invalid @enderror"
                         placeholder="+880 1234 567890">
                  <i data-feather="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
                @error('primary_phone')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="secondary_phone" class="form-label flex items-center gap-2">
                  <i data-feather="phone" class="w-4 h-4 text-slate-500"></i>
                  <span>Secondary Phone</span>
                </label>
                <div class="relative">
                  <input type="text" id="secondary_phone" name="secondary_phone" 
                         value="{{ old('secondary_phone', $settings->secondary_phone) }}"
                         class="form-control enhanced-input pl-10 @error('secondary_phone') is-invalid @enderror"
                         placeholder="+880 1234 567891">
                  <i data-feather="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                </div>
                @error('secondary_phone')
                  <div class="invalid-feedback flex items-center gap-1 mt-1">
                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                    <span>{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="physical_address" class="form-label flex items-center gap-2">
                <i data-feather="map-pin" class="w-4 h-4 text-slate-500"></i>
                <span>Physical Address</span>
              </label>
              <textarea id="physical_address" name="physical_address" rows="3"
                        class="form-control enhanced-input @error('physical_address') is-invalid @enderror"
                        placeholder="Your business address">{{ old('physical_address', $settings->physical_address) }}</textarea>
              @error('physical_address')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="business_hours" class="form-label flex items-center gap-2">
                <i data-feather="clock" class="w-4 h-4 text-slate-500"></i>
                <span>Business Hours</span>
              </label>
              <textarea id="business_hours" name="business_hours" rows="2"
                        class="form-control enhanced-input @error('business_hours') is-invalid @enderror"
                        placeholder="Mon-Fri: 9:00 AM - 6:00 PM">{{ old('business_hours', $settings->business_hours) }}</textarea>
              @error('business_hours')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media Tab -->
      <div class="tab-content hidden animate-fade-in" id="tab-social">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                <i data-feather="share-2" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Social Media Links</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Add your social media profile URLs</p>
              </div>
            </div>
          </div>
          <div class="card-body space-y-6">
            @php
              $socialLinks = old('social_media_links', $settings->social_media_links ?? []);
            @endphp
            <div class="form-group">
              <label for="social_facebook" class="form-label flex items-center gap-2">
                <i data-feather="facebook" class="w-4 h-4 text-blue-600"></i>
                <span>Facebook</span>
              </label>
              <div class="relative">
                <input type="url" id="social_facebook" name="social_media_links[facebook]" 
                       value="{{ $socialLinks['facebook'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.facebook') is-invalid @enderror"
                       placeholder="https://facebook.com/yourpage">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.facebook')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_twitter" class="form-label flex items-center gap-2">
                <i data-feather="twitter" class="w-4 h-4 text-sky-500"></i>
                <span>Twitter/X</span>
              </label>
              <div class="relative">
                <input type="url" id="social_twitter" name="social_media_links[twitter]" 
                       value="{{ $socialLinks['twitter'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.twitter') is-invalid @enderror"
                       placeholder="https://twitter.com/yourhandle">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.twitter')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_instagram" class="form-label flex items-center gap-2">
                <i data-feather="instagram" class="w-4 h-4 text-pink-600"></i>
                <span>Instagram</span>
              </label>
              <div class="relative">
                <input type="url" id="social_instagram" name="social_media_links[instagram]" 
                       value="{{ $socialLinks['instagram'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.instagram') is-invalid @enderror"
                       placeholder="https://instagram.com/yourprofile">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.instagram')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_linkedin" class="form-label flex items-center gap-2">
                <i data-feather="linkedin" class="w-4 h-4 text-blue-700"></i>
                <span>LinkedIn</span>
              </label>
              <div class="relative">
                <input type="url" id="social_linkedin" name="social_media_links[linkedin]" 
                       value="{{ $socialLinks['linkedin'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.linkedin') is-invalid @enderror"
                       placeholder="https://linkedin.com/company/yourcompany">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.linkedin')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_youtube" class="form-label flex items-center gap-2">
                <i data-feather="youtube" class="w-4 h-4 text-red-600"></i>
                <span>YouTube</span>
              </label>
              <div class="relative">
                <input type="url" id="social_youtube" name="social_media_links[youtube]" 
                       value="{{ $socialLinks['youtube'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.youtube') is-invalid @enderror"
                       placeholder="https://youtube.com/@yourchannel">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.youtube')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="social_tiktok" class="form-label flex items-center gap-2">
                <i data-feather="video" class="w-4 h-4 text-slate-600"></i>
                <span>TikTok</span>
              </label>
              <div class="relative">
                <input type="url" id="social_tiktok" name="social_media_links[tiktok]" 
                       value="{{ $socialLinks['tiktok'] ?? '' }}"
                       class="form-control enhanced-input pl-10 @error('social_media_links.tiktok') is-invalid @enderror"
                       placeholder="https://tiktok.com/@yourhandle">
                <i data-feather="link" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
              </div>
              @error('social_media_links.tiktok')
                <div class="invalid-feedback flex items-center gap-1 mt-1">
                  <i data-feather="alert-circle" class="w-4 h-4"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Localization Tab -->
      <div class="tab-content hidden animate-fade-in" id="tab-localization">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                <i data-feather="globe" class="w-5 h-5 text-cyan-600 dark:text-cyan-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Localization Settings</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure currency, language, and timezone</p>
              </div>
            </div>
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
      <div class="tab-content hidden animate-fade-in" id="tab-seo">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <i data-feather="search" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">SEO Meta Tags</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure search engine optimization settings</p>
              </div>
            </div>
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
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                <i data-feather="share-2" class="w-5 h-5 text-violet-600 dark:text-violet-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Open Graph Tags (Social Sharing)</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure how your site appears when shared on social media</p>
              </div>
            </div>
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
      <div class="tab-content hidden animate-fade-in" id="tab-maintenance">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                <i data-feather="tool" class="w-5 h-5 text-orange-600 dark:text-orange-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Maintenance Mode</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Control site maintenance and scheduled downtime</p>
              </div>
            </div>
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
      <div class="tab-content hidden animate-fade-in" id="tab-advanced">
        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                <i data-feather="bar-chart-2" class="w-5 h-5 text-teal-600 dark:text-teal-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Analytics & Tracking</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure analytics and tracking codes</p>
              </div>
            </div>
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

        <div class="card hover:shadow-lg transition-shadow duration-300">
          <div class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                <i data-feather="code" class="w-5 h-5 text-slate-600 dark:text-slate-400"></i>
              </div>
              <div>
                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Custom Code</h6>
                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Add custom CSS and JavaScript</p>
              </div>
            </div>
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

    <!-- Enhanced Form Actions -->
    <div class="sticky bottom-0 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 -mx-4 -mb-4 px-6 py-4 mt-8 rounded-b-xl shadow-lg">
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-slate-600 dark:text-slate-400">
          <i data-feather="info" class="w-4 h-4 inline mr-1"></i>
          <span>Changes will be applied immediately after saving</span>
        </div>
        <div class="flex items-center gap-3">
          <button type="button" class="btn btn-secondary group" onclick="window.location.reload()">
            <i data-feather="refresh-cw" class="w-4 h-4 mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
            Reset
          </button>
          <button type="submit" class="btn btn-primary group relative overflow-hidden">
            <span class="relative z-10 flex items-center">
              <i data-feather="save" class="w-4 h-4 mr-2"></i>
              Save Settings
            </span>
            <span class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
          </button>
        </div>
      </div>
    </div>
  </form>

  @push('styles')
  <style>
    /* Enhanced Tab Navigation */
    .tab-button {
      @apply relative px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg transition-all duration-300;
      @apply hover:bg-slate-100 dark:hover:bg-slate-700/50;
      @apply focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2;
    }
    
    .tab-button-content {
      @apply flex items-center gap-2 relative z-10;
    }
    
    .tab-indicator {
      @apply absolute bottom-0 left-0 right-0 h-0.5 bg-primary-500 rounded-full transform scale-x-0 transition-transform duration-300;
    }
    
    .tab-button.active {
      @apply text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20;
    }
    
    .tab-button.active .tab-indicator {
      @apply scale-x-100;
    }
    
    .tab-content {
      @apply hidden;
      animation: fadeOut 0.2s ease-out;
    }
    
    .tab-content.active {
      @apply block;
      animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes fadeOut {
      from {
        opacity: 1;
      }
      to {
        opacity: 0;
      }
    }
    
    .animate-fade-in {
      animation: fadeIn 0.3s ease-in;
    }
    
    .animate-slide-down {
      animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* Enhanced Form Inputs */
    .enhanced-input {
      @apply transition-all duration-200;
      @apply focus:ring-2 focus:ring-primary-500 focus:border-primary-500;
      @apply hover:border-slate-400 dark:hover:border-slate-500;
    }
    
    .enhanced-input:valid:not(:placeholder-shown) {
      @apply border-emerald-300 dark:border-emerald-700;
    }
    
    .enhanced-input:valid:not(:placeholder-shown) ~ .input-valid-icon {
      @apply block;
    }
    
    /* File Upload Area */
    .file-upload-area {
      @apply relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8;
      @apply bg-slate-50 dark:bg-slate-800/50;
      @apply transition-all duration-300;
      @apply hover:border-primary-400 dark:hover:border-primary-600;
      @apply hover:bg-primary-50/50 dark:hover:bg-primary-900/10;
      cursor: pointer;
    }
    
    .file-upload-area.dragover {
      @apply border-primary-500 bg-primary-100 dark:bg-primary-900/30;
      @apply scale-105;
    }
    
    .file-upload-content {
      @apply text-center;
    }
    
    .file-upload-icon {
      @apply mx-auto mb-4;
    }
    
    .file-upload-text {
      @apply text-sm text-slate-600 dark:text-slate-400 mb-1;
    }
    
    .file-upload-hint {
      @apply text-xs text-slate-500 dark:text-slate-500 mb-1;
    }
    
    .file-upload-recommendation {
      @apply text-xs text-primary-600 dark:text-primary-400 font-medium;
    }
    
    /* Enhanced Cards */
    .card {
      @apply transition-all duration-300;
    }
    
    .card:hover {
      @apply shadow-md;
    }
    
    /* Character Counter */
    #description-count {
      @apply transition-colors duration-200;
    }
    
    #description-count.warning {
      @apply text-amber-600 dark:text-amber-400;
    }
    
    #description-count.danger {
      @apply text-red-600 dark:text-red-400;
    }
    
    /* Responsive Improvements */
    @media (max-width: 640px) {
      .tab-button {
        @apply px-3 py-2 text-xs;
      }
      
      .tab-button-content span {
        @apply hidden sm:inline;
      }
    }
    
    /* Loading State */
    .btn-loading {
      @apply opacity-75 cursor-not-allowed;
      pointer-events: none;
    }
    
    .btn-loading i {
      @apply animate-spin;
    }
    
    /* Smooth Scrolling */
    html {
      scroll-behavior: smooth;
    }
  </style>
  @endpush

  @push('scripts')
  <script>
    // Enhanced Tab Switching with Animations
    document.querySelectorAll('.tab-button').forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const tabId = this.getAttribute('data-tab');
        switchTab(tabId, this);
      });
      
      // Keyboard navigation
      button.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          const tabId = this.getAttribute('data-tab');
          switchTab(tabId, this);
        }
      });
    });
    
    function switchTab(tabId, button) {
      // Remove active class from all buttons and contents
      document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
        btn.setAttribute('aria-selected', 'false');
      });
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
        content.classList.add('hidden');
      });
      
      // Add active class to clicked button and corresponding content
      button.classList.add('active');
      button.setAttribute('aria-selected', 'true');
      const content = document.getElementById('tab-' + tabId);
      if (content) {
        setTimeout(() => {
          content.classList.remove('hidden');
          content.classList.add('active');
          // Scroll to top of content
          content.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 50);
      }
      
      // Update Feather icons after tab switch
      if (typeof feather !== 'undefined') {
        feather.replace();
      }
    }

    // Enhanced Image Preview with File Validation
    function previewImage(input, previewId, uploadAreaId) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = input.id === 'favicon' ? 1024 * 1024 : 2 * 1024 * 1024; // 1MB for favicon, 2MB for others
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/webp', 'image/x-icon'];
        
        // Validate file type
        if (!validTypes.includes(file.type)) {
          showNotification('Invalid file type. Please upload PNG, JPG, SVG, WEBP, or ICO.', 'error');
          input.value = '';
          return;
        }
        
        // Validate file size
        if (file.size > maxSize) {
          showNotification(`File size exceeds limit. Max size: ${maxSize / (1024 * 1024)}MB`, 'error');
          input.value = '';
          return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById(previewId);
          if (preview) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
            preview.classList.add('animate-fade-in');
          }
          
          // Update upload area
          if (uploadAreaId) {
            const uploadArea = document.getElementById(uploadAreaId);
            if (uploadArea) {
              uploadArea.classList.add('border-primary-400', 'bg-primary-50/50');
              setTimeout(() => {
                uploadArea.classList.remove('border-primary-400', 'bg-primary-50/50');
              }, 2000);
            }
          }
        };
        reader.readAsDataURL(file);
      }
    }
    
    // File Upload Drag and Drop
    document.querySelectorAll('.file-upload-area').forEach(area => {
      const input = area.querySelector('input[type="file"]');
      if (!input) return;
      
      // Click to upload
      area.addEventListener('click', () => input.click());
      
      // Drag and drop
      area.addEventListener('dragover', (e) => {
        e.preventDefault();
        area.classList.add('dragover');
      });
      
      area.addEventListener('dragleave', () => {
        area.classList.remove('dragover');
      });
      
      area.addEventListener('drop', (e) => {
        e.preventDefault();
        area.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
          input.files = files;
          const previewId = input.id === 'logo' ? 'logo-preview' : 
                           input.id === 'favicon' ? 'favicon-preview' : 'og-image-preview';
          previewImage(input, previewId, area.id);
        }
      });
    });
    
    // Character Counter for Description
    const descriptionTextarea = document.getElementById('website_description');
    const descriptionCount = document.getElementById('description-count');
    
    if (descriptionTextarea && descriptionCount) {
      function updateDescriptionCount() {
        const length = descriptionTextarea.value.length;
        descriptionCount.textContent = `${length} characters`;
        
        descriptionCount.classList.remove('warning', 'danger');
        if (length > 500) {
          descriptionCount.classList.add('danger');
        } else if (length > 400) {
          descriptionCount.classList.add('warning');
        }
      }
      
      descriptionTextarea.addEventListener('input', updateDescriptionCount);
      updateDescriptionCount(); // Initial count
    }
    
    // Enhanced Form Validation Feedback
    document.querySelectorAll('.enhanced-input').forEach(input => {
      input.addEventListener('blur', function() {
        if (this.validity.valid && this.value.trim() !== '') {
          this.classList.add('border-emerald-300', 'dark:border-emerald-700');
          const icon = this.parentElement.querySelector('.input-valid-icon');
          if (icon) icon.classList.remove('hidden');
        } else if (this.hasAttribute('required') && !this.validity.valid) {
          this.classList.add('border-red-300', 'dark:border-red-700');
        }
      });
      
      input.addEventListener('input', function() {
        if (this.classList.contains('border-red-300') || this.classList.contains('border-red-700')) {
          this.classList.remove('border-red-300', 'border-red-700');
        }
      });
    });
    
    // Form Submission with Loading State
    const form = document.getElementById('site-settings-form');
    if (form) {
      form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
          submitBtn.classList.add('btn-loading');
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 mr-2 animate-spin"></i>Saving...';
          if (typeof feather !== 'undefined') {
            feather.replace();
          }
        }
      });
    }
    
    // Show Notification Function
    function showNotification(message, type = 'info') {
      const notification = document.createElement('div');
      notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg max-w-sm animate-slide-down ${
        type === 'error' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' :
        type === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' :
        'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800'
      }`;
      notification.innerHTML = `
        <div class="flex items-center gap-3">
          <i data-feather="${type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info'}" 
             class="w-5 h-5 ${type === 'error' ? 'text-red-600' : type === 'success' ? 'text-emerald-600' : 'text-blue-600'}"></i>
          <p class="text-sm font-medium ${type === 'error' ? 'text-red-900 dark:text-red-100' : type === 'success' ? 'text-emerald-900 dark:text-emerald-100' : 'text-blue-900 dark:text-blue-100'}">${message}</p>
          <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-slate-400 hover:text-slate-600">
            <i data-feather="x" class="w-4 h-4"></i>
          </button>
        </div>
      `;
      document.body.appendChild(notification);
      if (typeof feather !== 'undefined') {
        feather.replace();
      }
      setTimeout(() => notification.remove(), 5000);
    }

    // Enhanced Delete Functions with Better UX
    async function deleteLogo() {
      if (!confirm('Are you sure you want to delete the logo? This action cannot be undone.')) return;
      
      try {
        showNotification('Deleting logo...', 'info');
        const response = await fetch('{{ route("admin.site-settings.delete-logo") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          showNotification('Logo deleted successfully', 'success');
          setTimeout(() => location.reload(), 1000);
        } else {
          showNotification(data.message || 'Failed to delete logo', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while deleting the logo', 'error');
      }
    }

    async function deleteFavicon() {
      if (!confirm('Are you sure you want to delete the favicon? This action cannot be undone.')) return;
      
      try {
        showNotification('Deleting favicon...', 'info');
        const response = await fetch('{{ route("admin.site-settings.delete-favicon") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          showNotification('Favicon deleted successfully', 'success');
          setTimeout(() => location.reload(), 1000);
        } else {
          showNotification(data.message || 'Failed to delete favicon', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while deleting the favicon', 'error');
      }
    }

    async function deleteOgImage() {
      if (!confirm('Are you sure you want to delete the OG image? This action cannot be undone.')) return;
      
      try {
        showNotification('Deleting OG image...', 'info');
        const response = await fetch('{{ route("admin.site-settings.delete-og-image") }}', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });
        
        const data = await response.json();
        if (data.success) {
          showNotification('OG image deleted successfully', 'success');
          setTimeout(() => location.reload(), 1000);
        } else {
          showNotification(data.message || 'Failed to delete OG image', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while deleting the OG image', 'error');
      }
    }
    
    // Enhanced Color Picker Sync with Live Preview
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
      const textInputId = colorInput.id + '_text';
      const textInput = document.getElementById(textInputId);
      const previewId = colorInput.id.replace('_color', '_color_preview');
      const preview = document.getElementById(previewId);
      
      if (textInput) {
        // Color picker to text input
        colorInput.addEventListener('input', function() {
          textInput.value = this.value;
          if (preview) {
            preview.style.backgroundColor = this.value;
          }
        });
        
        // Text input to color picker
        textInput.addEventListener('input', function() {
          if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(this.value)) {
            colorInput.value = this.value;
            if (preview) {
              preview.style.backgroundColor = this.value;
            }
          }
        });
      }
    });
    
    // Auto-save Indicator (Visual feedback)
    let saveTimeout;
    form?.addEventListener('input', function() {
      clearTimeout(saveTimeout);
      const indicator = document.querySelector('.auto-save-indicator');
      if (indicator) {
        indicator.classList.remove('hidden');
        saveTimeout = setTimeout(() => {
          indicator.classList.add('hidden');
        }, 2000);
      }
    });
    
    // Initialize Everything
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Feather icons
      if (typeof feather !== 'undefined') {
        feather.replace();
      }
      
      // Add smooth scroll behavior
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
              target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
          }
        });
      });
      
      // Focus management for accessibility
      const firstInput = form?.querySelector('input:not([type="hidden"]), textarea, select');
      if (firstInput && !firstInput.value) {
        // Don't auto-focus if there's existing data
      }
    });
    
    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
      // Ctrl/Cmd + S to save
      if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        if (form) {
          form.requestSubmit();
        }
      }
    });
  </script>
  @endpush
</x-admin-layout>

