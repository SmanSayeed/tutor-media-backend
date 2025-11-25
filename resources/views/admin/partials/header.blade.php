   <!-- Header Starts -->
   <header class="header">
    <div class="container-fluid flex items-center justify-between">
      <!-- Sidebar Toggle & Search Starts -->
      <div class="flex items-center space-x-6 overflow-visible">
        <button class="sidebar-toggle">
          <span class="flex space-x-4">
            <svg
              stroke="currentColor"
              fill="none"
              stroke-width="0"
              viewBox="0 0 24 24"
              height="22"
              width="22"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h8m-8 6h16"
              ></path>
            </svg>
          </span>
        </button>

        <!-- Mobile Search Starts -->
        <div class="sm:hidden">
          <button
            type="button"
            data-trigger="search-modal"
            class="flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-primary-500 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300"
          >
            <i width="22" height="22" data-feather="search"></i>
          </button>
        </div>
        <!-- Mobile Search Ends -->

        <!-- Searchbar Start -->
        <button
          type="button"
          data-trigger="search-modal"
          class="group hidden h-10 w-72 items-center overflow-hidden rounded-sm bg-slate-100 px-3 shadow-sm dark:border-transparent dark:bg-slate-700 sm:flex"
        >
          <i class="text-slate-400" width="1em" height="1em" data-feather="search"></i>
          <span class="ml-2 text-sm text-slate-400">Search</span>
        </button>
        <!-- Searchbar Ends -->
      </div>
      <!-- Sidebar Toggle & Search Ends -->

      <!-- Header Options Starts -->
      <div class="flex items-center">     

        <!-- Theme Toggle Starts -->
        <button
          id="theme-toggle-btn"
          class="px-3 text-slate-500 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500 transition-colors duration-150"
          type="button"
          title="Toggle theme"
        >
          <i class="hidden dark:block" width="24" height="24" data-feather="sun"></i>
          <i class="block dark:hidden" width="24" height="24" data-feather="moon"></i>
        </button>
        <!-- Theme Toggle Ends -->

        <!-- Notification Dropdown Starts -->
        <div class="dropdown -mt-0.5" data-strategy="absolute">
          <div class="dropdown-toggle px-3">
            <button
              class="relative mt-1 flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500"
            >
              <i width="24" height="24" data-feather="bell"></i>
              <span
                class="absolute -right-1 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-danger text-[11px] text-slate-200"
              >
                5
              </span>
            </button>
          </div>

          <div class="dropdown-content mt-3 w-[17.5rem] divide-y divide-slate-200 dark:divide-slate-700 sm:w-80">
            <div class="flex items-center justify-between px-4 py-4">
              <h6 class="text-slate-800 dark:text-slate-300">Notifications</h6>
              <button class="text-xs font-medium text-slate-600 hover:text-primary-500 dark:text-slate-300">
                Clear All
              </button>
            </div>

            <div class="h-80 w-full" data-simplebar>
              <ul>
                <li
                  class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                >
                  <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-500"
                  >
                    <i data-feather="alert-circle" width="20" height="20"></i>
                  </div>

                  <div>
                    <h6 class="text-sm font-normal">New order received</h6>
                    <p class="text-xs text-slate-400">Order #1234 has been placed</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                      <i data-feather="clock" width="1em" height="1em"></i>
                      <span>2 min ago</span>
                    </p>
                  </div>
                </li>

                <li
                  class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                >
                  <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-yellow-100 text-yellow-500"
                  >
                    <i data-feather="alert-triangle" width="20" height="20"></i>
                  </div>

                  <div>
                    <h6 class="text-sm font-normal">High CPU usage</h6>
                    <p class="text-xs text-slate-400">CPU usage is at 92%</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                      <i data-feather="clock" width="1em" height="1em"></i>
                      <span>5 min ago</span>
                    </p>
                  </div>
                </li>

                <li
                  class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                >
                  <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-500"
                  >
                    <i data-feather="check-circle" width="20" height="20"></i>
                  </div>

                  <div>
                    <h6 class="text-sm font-normal">Your order has been shipped</h6>
                    <p class="text-xs text-slate-400">Order #1234 has been shipped</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                      <i data-feather="clock" width="1em" height="1em"></i>
                      <span>10 min ago</span>
                    </p>
                  </div>
                </li>

                <li
                  class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                >
                  <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-danger-100 text-danger-500"
                  >
                    <i data-feather="x-circle" width="20" height="20"></i>
                  </div>

                  <div>
                    <h6 class="text-sm font-normal">Something went wrong</h6>
                    <p class="text-xs text-slate-400">Order #1234 has been placed</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                      <i data-feather="clock" width="1em" height="1em"></i>
                      <span>1 hour ago</span>
                    </p>
                  </div>
                </li>

                <li
                  class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700"
                >
                  <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-500"
                  >
                    <i data-feather="check-circle" width="20" height="20"></i>
                  </div>

                  <div>
                    <h6 class="text-sm font-normal">Your order has been shipped</h6>
                    <p class="text-xs text-slate-400">Order #1234 has been shipped</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                      <i data-feather="clock" width="1em" height="1em"></i>
                      <span>10 min ago</span>
                    </p>
                  </div>
                </li>
              </ul>
            </div>

            <div class="px-4 py-2">
              <button class="btn btn-primary-plain btn-sm w-full" type="button">
                <span>View More</span>
                <i data-feather="arrow-right" width="1rem" height="1rem"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Notification Dropdown Ends -->

        <!-- Profile Dropdown Starts -->
        <div class="dropdown" data-strategy="absolute">
          <div class="dropdown-toggle px-3">
            <button
              class="relative mt-1 flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500"
            >
              <i data-feather="user" width="20" height="20"></i>
            </button>
          </div>
          <div class="dropdown-content mt-3 w-48">
            <ul class="dropdown-list">
              <li class="dropdown-list-item">
                <a href="{{ route('admin.profile') }}" class="dropdown-link">
                  <i data-feather="user" width="16" height="16"></i>
                  <span>My Profile</span>
                </a>
              </li>
              <li class="dropdown-list-item">
                <a href="#" class="dropdown-link">
                  <i data-feather="settings" width="16" height="16"></i>
                  <span>Settings</span>
                </a>
              </li>
              <li class="dropdown-list-item">
                <a href="#" class="dropdown-link">
                  <i data-feather="help-circle" width="16" height="16"></i>
                  <span>Help</span>
                </a>
              </li>
              <li class="dropdown-list-item">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                  @csrf
                  <button type="submit" class="dropdown-link w-full text-left">
                    <i data-feather="log-out" width="16" height="16"></i>
                    <span>Sign Out</span>
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
        <!-- Profile Dropdown Ends -->
      </div>
      <!-- Header Options Ends -->
    </div>
  </header>
  <!-- Header Ends -->