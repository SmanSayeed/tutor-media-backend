<!-- Sidebar Starts -->
<aside class="sidebar">
  <!-- Sidebar Header Starts -->
  <a href="{{ route('admin.dashboard') }}">
    <div class="sidebar-header">
      @php
        $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
        $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
      @endphp
      @if($logoUrl)
        <div class="flex items-center gap-2">
          <img src="{{ $logoUrl }}" alt="{{ $websiteName }}" class="h-8 w-auto object-contain sidebar-logo-icon">
          <div class="sidebar-logo-text">
            <h1 class="flex text-xl">
              <span class="font-bold text-slate-800 dark:text-slate-200">{{ $websiteName }}</span>
            </h1>
          </div>
        </div>
      @else
        <div class="sidebar-logo-text">
          <h1 class="flex text-xl">
            <span class="font-bold text-slate-800 dark:text-slate-200"> tutionmediabd Admin </span>
          </h1>
        </div>
      @endif
    </div>
  </a>
  <!-- Sidebar Header Ends -->

  <!-- Sidebar Menu Starts -->
  <ul class="sidebar-content">
    <!-- Dashboard -->
    <li>
      <a href="{{ route('admin.dashboard') }}"
        class="sidebar-menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="home"></i>
        </span>
        <span class="sidebar-menu-text">Dashboard</span>
      </a>
    </li>

    <!-- Users -->
    <li>
      <a href="{{ route('admin.users') }}"
        class="sidebar-menu {{ request()->routeIs('admin.users', 'admin.user-details') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="user"></i>
        </span>
        <span class="sidebar-menu-text">Customers</span>
      </a>
    </li>

    {{-- Banners --}}
    <li>
      <a href="{{ route('admin.banners.index') }}"
        class="sidebar-menu {{ request()->routeIs('admin.banners*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="image"></i>
        </span>
        <span class="sidebar-menu-text">Banners</span>
      </a>
    </li>

    {{-- Coupons --}}
    <li>
      <a href="{{ route('admin.coupons.index') }}"
        class="sidebar-menu {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="tag"></i>
        </span>
        <span class="sidebar-menu-text">Coupons</span>
      </a>
    </li>

    {{-- Shipping --}}
    <li>
      <a href="javascript:void(0);"
        class="sidebar-menu {{ request()->routeIs('admin.shipping-zones*', 'admin.shipping-settings*', 'admin.advance-payment*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="truck"></i>
        </span>
        <span class="sidebar-menu-text">Shipping</span>
        <span
          class="sidebar-menu-arrow {{ request()->routeIs('admin.shipping-zones*', 'admin.shipping-settings*', 'admin.advance-payment*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="#" class="sidebar-submenu-item">Advance Payment</a>
        </li>
      </ul>
    </li>

    {{-- Site Settings --}}
    <li>
      <a href="{{ route('admin.site-settings.index') }}"
        class="sidebar-menu {{ request()->routeIs('admin.site-settings*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="settings"></i>
        </span>
        <span class="sidebar-menu-text">Site Settings</span>
      </a>
    </li>

  </ul>
  <!-- Sidebar Menu Ends -->
</aside>
<!-- Sidebar Ends -->