<x-admin-layout title="Customer List">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Customer List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Ecommerce</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Customer List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Customers List Starts -->
  <div class="space-y-4">
    <!-- Customer Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Customer Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search" />
      </form>
      <!-- Customer Search Ends -->

      <!-- Customer Action Starts -->
      <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
        <div class="flex items-center gap-x-4">
          <div class="dropdown" data-placement="bottom-end">
            <div class="dropdown-toggle">
              <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                <i class="w-4" data-feather="filter"></i>
                <span class="hidden sm:inline-block">Filter</span>
                <i class="w-4" data-feather="chevron-down"></i>
              </button>
            </div>
            <div class="dropdown-content w-72 !overflow-visible">
              <ul class="dropdown-list space-y-4 p-4">
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Occupation</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select a Occupation</option>
                    <option value="1">Frontend Developer</option>
                    <option value="2">Full Stack Developer</option>
                    <option value="3">Web Developer</option>
                  </select>
                </li>

                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Status</h2>
                  <select class="select">
                    <option value="">Select to Status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    <option value="2">Prospect</option>
                    <option value="2">Suspended</option>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
            <i class="h-4" data-feather="upload"></i>
            <span class="hidden sm:inline-block">Export</span>
          </button>
        </div>      
      </div>
      <!-- Customer Action Ends -->
    </div>
    <!-- Customer Header Ends -->

    <!-- Customer Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".customer-checkbox" />
            </th>
            <th class="w-[45%] uppercase">Customer</th>
            <th class="w-[15%] uppercase">Phone</th>
            <th class="w-[15%] uppercase">Last Ordered at</th>
            <th class="w-[15%] uppercase">Status</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
          <tr>
            <td>
              <input class="checkbox customer-checkbox" type="checkbox" />
            </td>
            <td>
              <div class="flex items-center gap-3">
                <div class="avatar avatar-circle">
                  <img class="avatar-img" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar1.png') }}" alt="Avatar" />
                </div>

                <div>
                  <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                    {{ $user->name }}
                  </h6>
                  <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                </div>
              </div>
            </td>
            <td>{{ $user->phone ?? 'N/A' }}</td>
            <td>{{ $user->orders->first()?->created_at?->format('d M Y') ?? 'No orders' }}</td>
            <td>
              <div class="badge {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
              </div>
            </td>
            <td>
              <div class="flex justify-end">
                <div class="dropdown" data-placement="bottom-start">
                  <div class="dropdown-toggle">
                    <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                  </div>
                  <div class="dropdown-content">
                    <ul class="dropdown-list">
                      <li class="dropdown-list-item">
                        <a href="{{ route('admin.user-details', $user->id) }}" class="dropdown-link">
                          <i class="h-5 text-slate-400" data-feather="eye"></i>
                          <span>View</span>
                        </a>
                      </li>
                      <li class="dropdown-list-item">
                        <a href="javascript:void(0)" class="dropdown-link">
                          <i class="h-5 text-slate-400" data-feather="trash"></i>
                          <span>Delete</span>
                        </a>
                      </li>
                      <li class="dropdown-list-item">
                        <a href="javascript:void(0)" class="dropdown-link">
                          <i class="h-5 text-slate-400" data-feather="minus-circle"></i>
                          <span>{{ $user->is_active ? 'Deactivate' : 'Activate' }}</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-8">
              <p class="text-slate-500 dark:text-slate-400">No users found</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Customer Table Ends -->

    <!-- Customer Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
      </p>
      <!-- Pagination -->
      <nav class="pagination">
        <ul class="pagination-list">
          @if ($users->onFirstPage())
            <li class="pagination-item disabled">
              <span class="pagination-link pagination-link-prev-icon">
                <i data-feather="chevron-left" width="1em" height="1em"></i>
              </span>
            </li>
          @else
            <li class="pagination-item">
              <a class="pagination-link pagination-link-prev-icon" href="{{ $users->previousPageUrl() }}">
                <i data-feather="chevron-left" width="1em" height="1em"></i>
              </a>
            </li>
          @endif

          @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
              <li class="pagination-item active">
                <span class="pagination-link">{{ $page }}</span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach

          @if ($users->hasMorePages())
            <li class="pagination-item">
              <a class="pagination-link pagination-link-next-icon" href="{{ $users->nextPageUrl() }}">
                <i data-feather="chevron-right" width="1em" height="1em"></i>
              </a>
            </li>
          @else
            <li class="pagination-item disabled">
              <span class="pagination-link pagination-link-next-icon">
                <i data-feather="chevron-right" width="1em" height="1em"></i>
              </span>
            </li>
          @endif
        </ul>
      </nav>
    </div>
    <!-- Customer Pagination Ends -->
  </div>
  <!-- Customers List Ends -->
</x-admin-layout>