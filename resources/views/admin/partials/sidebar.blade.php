<!-- Sidebar Starts -->
<aside class="sidebar">
  <!-- Sidebar Header Starts -->
  <a href="{{ route('home') }}">
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
      <a href="{{ route('admin.dashboard') }}" class="sidebar-menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="home"></i>
        </span>
        <span class="sidebar-menu-text">Dashboard</span>
      </a>
    </li>

    <!-- Users -->
    <li>
      <a href="{{ route('admin.users') }}" class="sidebar-menu {{ request()->routeIs('admin.users', 'admin.user-details') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="user"></i>
        </span>
        <span class="sidebar-menu-text">Customers</span>
      </a>
    </li>

    {{-- Categories --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.categories*', 'admin.subcategories*', 'admin.child-categories*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="file-text"></i>
        </span>
        <span class="sidebar-menu-text">Categories</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.categories*', 'admin.subcategories*', 'admin.child-categories*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.categories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"> Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.subcategories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.subcategories.index') ? 'active' : '' }}">Sub Categories </a>
        </li>
        <li>
          <a href="{{ route('admin.child-categories.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.child-categories.index') ? 'active' : '' }}">Child Categories </a>
        </li>
      </ul>
    </li>
    <!-- ecommnerce -->
    <li>
       <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.products*', 'admin.product-variants*', 'admin.brands*', 'admin.colors*', 'admin.sizes*', 'admin.create-brand') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="shopping-bag"></i>
        </span>
        <span class="sidebar-menu-text">Products</span>
         <span class="sidebar-menu-arrow {{ request()->routeIs('admin.products*', 'admin.product-variants*', 'admin.brands*', 'admin.colors*', 'admin.sizes*', 'admin.create-brand') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
       <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.products.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"> Products List </a>
          </li>
          <li>
            <a href="{{ route('admin.product-variants.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.product-variants*') ? 'active' : '' }}"> Product Variants </a>
          </li>
         <li>
           <a href="{{ route('admin.brands') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.brands') ? 'active' : '' }}"> Brands </a>
         </li>
         <li>
           <a href="{{ route('admin.colors.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.colors*') ? 'active' : '' }}"> Colors </a>
         </li>
         <li>
           <a href="{{ route('admin.sizes.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.sizes*') ? 'active' : '' }}"> Sizes </a>
         </li>
         <li>
           <a href="{{ route('admin.products.create') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"> Create New Product </a>
         </li>
         <li>
           <a href="{{ route('admin.create-brand') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.create-brand') ? 'active' : '' }}"> Create Brand </a>
         </li>
       </ul>
    </li>

    {{-- Banners --}}
    <li>
      <a href="{{ route('admin.banners.index') }}" class="sidebar-menu {{ request()->routeIs('admin.banners*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="image"></i>
        </span>
        <span class="sidebar-menu-text">Banners</span>
      </a>
    </li>

    {{-- Coupons --}}
    <li>
      <a href="{{ route('admin.coupons.index') }}" class="sidebar-menu {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="tag"></i>
        </span>
        <span class="sidebar-menu-text">Coupons</span>
      </a>
    </li>

    {{-- Orders --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="package"></i>
        </span>
        <span class="sidebar-menu-text">Orders</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.orders*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.orders.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"> Orders List </a>
        </li>
      </ul>
    </li>

    {{-- Shipping --}}
    <li>
      <a href="javascript:void(0);" class="sidebar-menu {{ request()->routeIs('admin.shipping-zones*', 'admin.shipping-settings*', 'admin.advance-payment*') ? 'active' : '' }}">
        <span class="sidebar-menu-icon">
          <i data-feather="truck"></i>
        </span>
        <span class="sidebar-menu-text">Shipping</span>
        <span class="sidebar-menu-arrow {{ request()->routeIs('admin.shipping-zones*', 'admin.shipping-settings*', 'admin.advance-payment*') ? 'rotate' : '' }}">
          <i data-feather="chevron-right"></i>
        </span>
      </a>
      <ul class="sidebar-submenu">
        <li>
          <a href="{{ route('admin.shipping-zones.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.shipping-zones*') ? 'active' : '' }}"> Shipping Zones </a>
        </li>
        <li>
          <a href="{{ route('admin.shipping-settings.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.shipping-settings*') ? 'active' : '' }}"> Shipping Settings </a>
        </li>
        <li>
            <a href="{{ route('admin.advance-payment.index') }}" class="sidebar-submenu-item {{ request()->routeIs('admin.advance-payment*') ? 'active' : '' }}"> Advance Payment </a>
        </li>
      </ul>
    </li>

    {{-- Site Settings --}}
    <li>
      <a href="{{ route('admin.site-settings.index') }}" class="sidebar-menu {{ request()->routeIs('admin.site-settings*') ? 'active' : '' }}">
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
