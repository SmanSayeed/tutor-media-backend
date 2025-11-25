<x-admin-layout title="Order List">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Orders Management</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Manage and track all customer orders</p>
            </div>
            <nav aria-label="Breadcrumb" class="flex">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                            <i data-feather="home" class="h-4 w-4"></i>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i data-feather="chevron-right" class="h-4 w-4 text-slate-400 mx-2"></i>
                        <span class="text-slate-700 dark:text-slate-300 font-medium">Orders</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filters and Search Section -->
    <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6 mb-6 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-feather="search" class="h-5 w-5 text-slate-400"></i>
                    </div>
                    <input
                        name="search"
                        value="{{ request('search') }}"
                        type="text"
                        placeholder="Search orders by ID, customer, or status..."
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        aria-label="Search orders"
                    />
                </form>
            </div>

            <!-- Filters and Actions -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <!-- Status Filter -->
                <div class="relative">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        form="filterForm"
                        class="appearance-none bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 pr-8 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        aria-label="Filter by status"
                    >
                        <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i data-feather="chevron-down" class="h-4 w-4 text-slate-400"></i>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="relative">
                    <select
                        name="date_filter"
                        class="appearance-none bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 pr-8 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        aria-label="Filter by date"
                    >
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i data-feather="calendar" class="h-4 w-4 text-slate-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request()->has('search') || request()->has('status'))
        <div class="mt-4 flex flex-wrap gap-2">
            <span class="text-sm text-slate-600 dark:text-slate-400">Active filters:</span>
            @if(request('search'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                    Search: {{ request('search') }}
                    <button type="button" class="ml-1 inline-flex items-center p-0.5 rounded-full text-primary-400 hover:bg-primary-200 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500" onclick="clearFilter('search')">
                        <i data-feather="x" class="h-3 w-3"></i>
                    </button>
                </span>
            @endif
            @if(request('status') && request('status') !== 'all')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200">
                    Status: {{ ucfirst(request('status')) }}
                    <button type="button" class="ml-1 inline-flex items-center p-0.5 rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-500" onclick="clearFilter('status')">
                        <i data-feather="x" class="h-3 w-3"></i>
                    </button>
                </span>
            @endif
        </div>
        @endif
    </div>

    <!-- Hidden form for filters -->
    <form id="filterForm" method="GET" action="{{ route('admin.orders.index') }}" class="hidden">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
    </form>

        <!-- Order Table Starts -->
        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-12 text-center shadow-sm">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700">
                    <i data-feather="package" class="h-10 w-10 text-slate-400 dark:text-slate-500"></i>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-slate-100">No orders found</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                    @if(request()->has('search') || request()->has('status'))
                        No orders match your current search criteria. Try adjusting your filters or search terms.
                    @else
                        No orders have been placed yet. Orders will appear here once customers start making purchases.
                    @endif
                </p>
                @if(request()->has('search') || request()->has('status'))
                <div class="mt-6">
                    <button onclick="clearAllFilters()" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg transition-colors">
                        <i data-feather="x" class="h-4 w-4 mr-2"></i>
                        Clear Filters
                    </button>
                </div>
                @endif
            </div>
        @else
            <!-- Orders Table -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto overflow-y-visible">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" role="table" aria-label="Orders table">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th scope="col" class="relative w-12 px-6 py-4">
                                    <input
                                        class="checkbox absolute left-4 top-1/2 -mt-2"
                                        type="checkbox"
                                        data-check-all
                                        data-check-all-target=".order-checkbox"
                                        aria-label="Select all orders"
                                    />
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/70 transition-colors group" data-sort="order_number">
                                    <div class="flex items-center gap-2">
                                        <span>Order</span>
                                        <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i data-feather="chevron-up" class="h-3 w-3 -mb-1"></i>
                                            <i data-feather="chevron-down" class="h-3 w-3"></i>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/70 transition-colors group" data-sort="payment_status">
                                    <div class="flex items-center gap-2">
                                        <span>Payment</span>
                                        <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i data-feather="chevron-up" class="h-3 w-3 -mb-1"></i>
                                            <i data-feather="chevron-down" class="h-3 w-3"></i>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/70 transition-colors group" data-sort="created_at">
                                    <div class="flex items-center gap-2">
                                        <span>Ordered At</span>
                                        <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i data-feather="chevron-up" class="h-3 w-3 -mb-1"></i>
                                            <i data-feather="chevron-down" class="h-3 w-3"></i>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/70 transition-colors group" data-sort="status">
                                    <div class="flex items-center gap-2">
                                        <span>Status</span>
                                        <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i data-feather="chevron-up" class="h-3 w-3 -mb-1"></i>
                                            <i data-feather="chevron-down" class="h-3 w-3"></i>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors" data-order-id="{{ $order->id }}">
                                    <td class="relative px-6 py-4">
                                        <input
                                            class="checkbox absolute left-4 top-1/2 -mt-2 order-checkbox"
                                            type="checkbox"
                                            value="{{ $order->id }}"
                                            aria-label="Select order {{ $order->order_number }}"
                                        />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="font-semibold text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 transition-colors"
                                                aria-label="View order {{ $order->order_number }}">
                                                #{{ $order->order_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($order->customer && $order->customer->avatar)
                                                    <img src="{{ asset('storage/' . $order->customer->avatar) }}"
                                                        alt="{{ $order->customer->name }} avatar"
                                                        class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-200 dark:ring-slate-600"
                                                        loading="lazy" />
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center ring-2 ring-slate-200 dark:ring-slate-600">
                                                        <span class="text-sm font-medium text-white">
                                                            {{ $order->customer ? strtoupper(substr($order->customer->name, 0, 2)) : 'GU' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">
                                                    {{ $order->customer->name ?? 'Guest User' }}
                                                </p>
                                                <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
                                                    {{ $order->customer->email ?? 'No email' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($order->payment_status === 'paid')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @else
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @endif">
                                            @if($order->payment_status === 'paid')
                                                <i data-feather="check-circle" class="h-3 w-3 mr-1"></i>
                                                Paid
                                            @else
                                                <i data-feather="x-circle" class="h-3 w-3 mr-1"></i>
                                                Unpaid
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900 dark:text-slate-100">
                                            {{ $order->created_at->format('M j, Y') }}
                                        </div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $order->created_at->format('g:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($order->status === 'delivered')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($order->status === 'shipped')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($order->status === 'processing')
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($order->status === 'cancelled')
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @else
                                                bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                                @if($order->status === 'delivered')
                                                    bg-green-400
                                                @elseif($order->status === 'shipped')
                                                    bg-blue-400
                                                @elseif($order->status === 'processing')
                                                    bg-yellow-400
                                                @elseif($order->status === 'cancelled')
                                                    bg-red-400
                                                @else
                                                    bg-gray-400
                                                @endif"></span>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    {{-- Order Action --}}
                                    <td class="px-6 py-4">
                                        <div class="relative" id="order-actions-dropdown-{{ $order->id }}">
                                            <button
                                                id="order-actions-button-{{ $order->id }}"
                                                class="order-actions-btn inline-flex items-center px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors"
                                                type="button"
                                                data-order-id="{{ $order->id }}"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                aria-label="Order actions for {{ $order->order_number }}"
                                            >
                                                <span>Actions</span>
                                                <i data-feather="chevron-down" class="ml-2 h-4 w-4"></i>
                                            </button>

                                            <div id="order-actions-menu-{{ $order->id }}" class="fixed mt-2 w-56 origin-top-right rounded-lg bg-white dark:bg-slate-800 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-[100] divide-y divide-slate-200 dark:divide-slate-700 border border-slate-200 dark:border-slate-700 transition-all duration-200 ease-out opacity-0 scale-95" role="menu" aria-orientation="vertical" aria-labelledby="order-actions-button-{{ $order->id }}" tabindex="-1" style="display: none;">
                                                <div class="py-1" role="none">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors rounded-t-lg" role="menuitem" onclick="closeAllDropdowns()">
                                                        <i data-feather="eye" class="h-4 w-4 text-slate-400"></i>
                                                        <span>View Details</span>
                                                    </a>
                                                </div>

                                                @if($order->status !== 'cancelled' && $order->status !== 'refunded')
                                                <div class="py-1" role="none">
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="processing">
                                                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors w-full text-left" role="menuitem">
                                                            <i data-feather="clock" class="h-4 w-4 text-slate-400"></i>
                                                            <span>Mark as Processing</span>
                                                        </button>
                                                    </form>
                                                    <button type="button" onclick="updateOrderStatus({{ $order->id }}, 'shipped')" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors w-full text-left rounded-none" role="menuitem">
                                                        <i data-feather="truck" class="h-4 w-4 text-slate-400"></i>
                                                        <span>Mark as Shipped</span>
                                                    </button>
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="delivered">
                                                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors w-full text-left" role="menuitem">
                                                            <i data-feather="check-circle" class="h-4 w-4 text-slate-400"></i>
                                                            <span>Mark as Delivered</span>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="py-1" role="none">
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left" role="menuitem" onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                                                            <i data-feather="x-circle" class="h-4 w-4 text-red-400"></i>
                                                            <span>Cancel Order</span>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif

                                                <div class="py-1" role="none">
                                                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors rounded-b-lg" role="menuitem" target="_blank">
                                                        <i data-feather="printer" class="h-4 w-4 text-slate-400"></i>
                                                        <span>Print Invoice</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
            <!-- Order Table Ends -->

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="bg-white dark:bg-slate-800 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="text-sm text-slate-700 dark:text-slate-300">
                            <p class="font-medium">
                                Showing <span class="font-semibold">{{ $orders->firstItem() }}</span> to <span class="font-semibold">{{ $orders->lastItem() }}</span> of <span class="font-semibold">{{ $orders->total() }}</span> orders
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $orders->withQueryString()->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif
        <!-- Order Pagination Ends -->
    </div>
    <!-- Order Listing Ends -->
    @push('scripts')
        <script>
            // Enhanced Orders Management JavaScript
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize tooltips with enhanced styling
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        placement: 'top',
                        trigger: 'hover focus'
                    });
                });

                // Enhanced bulk actions with better UX
                const checkAll = document.querySelector('[data-check-all]');
                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        const checkboxes = document.querySelectorAll('.order-checkbox');
                        const checked = this.checked;

                        checkboxes.forEach(checkbox => {
                            checkbox.checked = checked;
                            // Add visual feedback
                            const row = checkbox.closest('tr');
                            if (checked) {
                                row.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
                            } else {
                                row.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                            }
                        });

                        updateBulkActionsVisibility();
                    });
                }

                // Individual checkbox handling
                document.querySelectorAll('.order-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const row = this.closest('tr');
                        if (this.checked) {
                            row.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
                        } else {
                            row.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                        }
                        updateBulkActionsVisibility();
                        updateCheckAllState();
                    });
                });

                // Enhanced dropdown button click handlers (single handler, no duplicates)
                document.querySelectorAll('.order-actions-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const orderId = parseInt(this.getAttribute('data-order-id'));
                        if (!orderId) {
                            console.error('Order ID not found for button:', this.id);
                            return;
                        }
                        
                        toggleOrderDropdown(orderId, e);
                    });
                    
                    // Keyboard navigation
                    button.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            e.stopPropagation();
                            const orderId = parseInt(this.getAttribute('data-order-id'));
                            if (orderId) {
                                toggleOrderDropdown(orderId, e);
                            }
                        } else if (e.key === 'Escape') {
                            closeAllDropdowns();
                        }
                    });
                });

                // Close dropdowns when clicking outside (with slight delay to avoid conflicts)
                document.addEventListener('click', function(event) {
                    const clickedDropdown = event.target.closest('[id^="order-actions-dropdown-"]');
                    const clickedMenu = event.target.closest('[id^="order-actions-menu-"]');
                    const clickedButton = event.target.closest('.order-actions-btn');
                    
                    // Don't close if clicking on button or menu
                    if (clickedDropdown || clickedMenu || clickedButton) {
                        return;
                    }
                    
                    // Small delay to avoid conflicts with button click handler
                    setTimeout(() => {
                        closeAllDropdowns();
                    }, 10);
                }, true); // Use capture phase

                // Close dropdowns on scroll
                window.addEventListener('scroll', function() {
                    closeAllDropdowns();
                }, true);

                // Ensure dropdowns are properly initialized
                console.log('Dropdown buttons found:', document.querySelectorAll('[id^="order-actions-button-"]').length);
                console.log('Dropdown menus found:', document.querySelectorAll('[id^="order-actions-menu-"]').length);

                // Force re-initialize feather icons after DOM is ready
                setTimeout(() => {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                        console.log('Feather icons re-initialized');
                    }
                }, 100);

                // Keyboard navigation for dropdown menus
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeAllDropdowns();
                    }
                });

                // Table sorting functionality
                document.querySelectorAll('th[data-sort]').forEach(header => {
                    header.addEventListener('click', function() {
                        const sortBy = this.dataset.sort;
                        const currentSort = getUrlParameter('sort');
                        const currentDirection = getUrlParameter('direction') || 'asc';
                        const newDirection = (currentSort === sortBy && currentDirection === 'asc') ? 'desc' : 'asc';

                        // Update URL and reload
                        const url = new URL(window.location);
                        url.searchParams.set('sort', sortBy);
                        url.searchParams.set('direction', newDirection);
                        window.location.href = url.toString();
                    });
                });

                // Filter clearing functionality
                window.clearFilter = function(filterType) {
                    const url = new URL(window.location);
                    if (filterType === 'search') {
                        url.searchParams.delete('search');
                    } else if (filterType === 'status') {
                        url.searchParams.delete('status');
                    }
                    window.location.href = url.toString();
                };

                window.clearAllFilters = function() {
                    const url = new URL(window.location);
                    url.searchParams.delete('search');
                    url.searchParams.delete('status');
                    window.location.href = url.toString();
                };

                // Initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });

            // Enhanced AJAX order status update
            function updateOrderStatus(orderId, status) {
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                const originalDisabled = button.disabled;

                // Enhanced loading state
                button.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Updating...</span>
                    </div>
                `;
                button.disabled = true;
                button.classList.add('cursor-not-allowed', 'opacity-75');

                // Create form data with CSRF token
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
                formData.append('_method', 'PATCH');
                formData.append('status', status);

                // Enhanced fetch with better error handling
                fetch(`/admin/orders/${orderId}/update-status`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Enhanced status update with better targeting
                        const statusRow = document.querySelector(`tr[data-order-id="${orderId}"]`);
                        if (statusRow) {
                            const statusCell = statusRow.querySelector('td:last-child');
                            if (statusCell) {
                                // Update status badge with enhanced styling
                                const statusBadge = statusCell.querySelector('.rounded-full');
                                if (statusBadge) {
                                    // Remove old status classes
                                    statusBadge.className = statusBadge.className.replace(/bg-\w+-\d+/g, '').replace(/dark:bg-\w+-\d+/g, '').replace(/dark:text-\w+-\d+/g, '');

                                    // Add new status classes
                                    const statusClasses = getStatusClasses(data.status_text || status);
                                    statusBadge.className += ' ' + statusClasses.badge;

                                    // Update status text
                                    const statusText = statusBadge.querySelector('span:last-child');
                                    if (statusText) {
                                        statusText.textContent = data.status_text || status.charAt(0).toUpperCase() + status.slice(1);
                                    }

                                    // Update status dot
                                    const statusDot = statusBadge.querySelector('.rounded-full:first-child');
                                    if (statusDot) {
                                        statusDot.className = statusDot.className.replace(/bg-\w+-\d+/g, '');
                                        statusDot.className += ' ' + statusClasses.dot;
                                    }
                                }
                            }
                        }

                        // Update dropdown options
                        updateDropdownOptions(orderId, status);

                        // Close dropdown
                        closeAllDropdowns();

                        // Enhanced success notification
                        showNotification('Order status updated successfully!', 'success');

                        // Add success animation to row
                        const animationRow = document.querySelector(`tr[data-order-id="${orderId}"]`);
                        if (animationRow) {
                            animationRow.classList.add('bg-green-50', 'dark:bg-green-900/20');
                            setTimeout(() => {
                                animationRow.classList.remove('bg-green-50', 'dark:bg-green-900/20');
                            }, 2000);
                        }
                    } else {
                        throw new Error(data.message || 'Failed to update order status');
                    }
                })
                .catch(error => {
                    console.error('Error updating order status:', error);
                    showNotification(error.message || 'An error occurred while updating the order status', 'error');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalHTML;
                    button.disabled = originalDisabled;
                    button.classList.remove('cursor-not-allowed', 'opacity-75');

                    // Re-initialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });
            }

            // Enhanced dropdown options update
            function updateDropdownOptions(orderId, newStatus) {
                const menu = document.getElementById('order-actions-menu-' + orderId);
                if (!menu) return;

                const statusOptions = ['processing', 'shipped', 'delivered'];
                const cancelledOption = menu.querySelector('form input[value="cancelled"]');

                if (newStatus === 'cancelled' || newStatus === 'refunded') {
                    // Hide all status update options with animation
                    statusOptions.forEach(status => {
                        const button = menu.querySelector(`button[onclick*="updateOrderStatus(${orderId}, '${status}'"]`);
                        if (button) {
                            button.style.display = 'none';
                        }
                    });
                    if (cancelledOption) {
                        cancelledOption.closest('form').style.display = 'none';
                    }
                } else {
                    // Show/hide appropriate options with smooth transitions
                    statusOptions.forEach(status => {
                        const button = menu.querySelector(`button[onclick*="updateOrderStatus(${orderId}, '${status}'"]`);
                        if (button) {
                            button.style.display = (status === newStatus) ? 'none' : 'flex';
                            button.style.opacity = (status === newStatus) ? '0.5' : '1';
                        }
                    });
                    if (cancelledOption) {
                        cancelledOption.closest('form').style.display = 'block';
                    }
                }
            }

            // Enhanced notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.notification-toast');
                existingNotifications.forEach(notification => notification.remove());

                // Create enhanced notification
                const notification = document.createElement('div');
                notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg border transition-all duration-300 transform translate-x-full ${
                    type === 'success' ? 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900 dark:border-green-700 dark:text-green-200' :
                    type === 'error' ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900 dark:border-red-700 dark:text-red-200' :
                    'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-200'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <i data-feather="${
                                type === 'success' ? 'check-circle' :
                                type === 'error' ? 'x-circle' : 'info'
                            }" class="h-5 w-5"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">${message}</p>
                        </div>
                        <button type="button" class="flex-shrink-0 ml-2 p-1 rounded-md hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-black/10" onclick="this.parentElement.parentElement.remove()">
                            <i data-feather="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);

                // Re-initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }

            // Utility functions
            function closeAllDropdowns() {
                document.querySelectorAll('[id^="order-actions-menu-"]').forEach(menu => {
                    // Animate out
                    menu.classList.remove('opacity-100', 'scale-100');
                    menu.classList.add('opacity-0', 'scale-95');
                    
                    setTimeout(() => {
                        menu.classList.add('hidden');
                        menu.style.display = 'none';
                    }, 150);
                });
                document.querySelectorAll('[id^="order-actions-button-"]').forEach(button => {
                    button.setAttribute('aria-expanded', 'false');
                });
            }

            function updateBulkActionsVisibility() {
                const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
                const bulkActions = document.getElementById('bulk-actions');
                if (bulkActions) {
                    bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
                }
            }

            function updateCheckAllState() {
                const checkAll = document.querySelector('[data-check-all]');
                const checkboxes = document.querySelectorAll('.order-checkbox');
                const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');

                if (checkAll) {
                    checkAll.checked = checkboxes.length === checkedBoxes.length && checkboxes.length > 0;
                    checkAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;
                }
            }

            function getUrlParameter(name) {
                const url = new URL(window.location);
                return url.searchParams.get(name);
            }

            function getStatusClasses(status) {
                const statusMap = {
                    'delivered': { badge: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', dot: 'bg-green-400' },
                    'shipped': { badge: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', dot: 'bg-blue-400' },
                    'processing': { badge: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', dot: 'bg-yellow-400' },
                    'cancelled': { badge: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', dot: 'bg-red-400' },
                    'pending': { badge: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200', dot: 'bg-gray-400' }
                };
                return statusMap[status.toLowerCase()] || statusMap['pending'];
            }

            // Close dropdown helper
            function closeDropdown(orderId) {
                const menu = document.getElementById('order-actions-menu-' + orderId);
                if (menu) {
                    menu.classList.add('hidden');
                    menu.style.display = 'none';
                }
                const button = document.getElementById('order-actions-button-' + orderId);
                if (button) {
                    button.setAttribute('aria-expanded', 'false');
                }
            }

            // Track if dropdown is currently animating to prevent flicker
            const dropdownAnimating = new Set();

            // Enhanced dropdown toggle with fixed positioning to prevent truncation
            function toggleOrderDropdown(orderId, event) {
                if (event) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                const button = document.getElementById('order-actions-button-' + orderId);
                const menu = document.getElementById('order-actions-menu-' + orderId);

                if (!button || !menu) {
                    console.error('Button or menu not found for order:', orderId);
                    return;
                }

                // Prevent rapid clicks during animation
                if (dropdownAnimating.has(orderId)) {
                    return;
                }

                const isExpanded = button.getAttribute('aria-expanded') === 'true';

                // If clicking the same button, just toggle it
                if (isExpanded) {
                    dropdownAnimating.add(orderId);
                    
                    // Close this menu
                    menu.classList.remove('opacity-100', 'scale-100');
                    menu.classList.add('opacity-0', 'scale-95');
                    
                    setTimeout(() => {
                        menu.classList.add('hidden');
                        menu.style.display = 'none';
                        dropdownAnimating.delete(orderId);
                    }, 200);
                    
                    button.setAttribute('aria-expanded', 'false');
                    return;
                }

                dropdownAnimating.add(orderId);
                
                // Close all other menus first (but not this one)
                document.querySelectorAll('[id^="order-actions-menu-"]').forEach(otherMenu => {
                    if (otherMenu.id !== menu.id) {
                        const otherOrderId = otherMenu.id.replace('order-actions-menu-', '');
                        dropdownAnimating.add(otherOrderId);
                        
                        otherMenu.classList.remove('opacity-100', 'scale-100');
                        otherMenu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            otherMenu.classList.add('hidden');
                            otherMenu.style.display = 'none';
                            dropdownAnimating.delete(otherOrderId);
                        }, 200);
                    }
                });
                
                document.querySelectorAll('[id^="order-actions-button-"]').forEach(otherButton => {
                    if (otherButton.id !== button.id) {
                        otherButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Open this menu
                {
                    // Calculate position for fixed dropdown
                    const buttonRect = button.getBoundingClientRect();
                    const menuWidth = 224; // w-56 = 14rem = 224px
                    const menuHeight = menu.offsetHeight || 300; // Estimate if not visible
                    
                    // Position dropdown below button, aligned to right
                    let top = buttonRect.bottom + 8; // mt-2 = 8px
                    let left = buttonRect.right - menuWidth;
                    
                    // Adjust if dropdown would go off screen
                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;
                    
                    if (left < 8) {
                        left = 8; // Add some margin from left edge
                    }
                    
                    if (left + menuWidth > viewportWidth - 8) {
                        left = viewportWidth - menuWidth - 8; // Add margin from right edge
                    }
                    
                    // If dropdown would go below viewport, show above button instead
                    if (top + menuHeight > viewportHeight - 8) {
                        top = buttonRect.top - menuHeight - 8;
                        // If still doesn't fit, position at bottom of viewport
                        if (top < 8) {
                            top = viewportHeight - menuHeight - 8;
                        }
                    }
                    
                    // Apply position
                    menu.style.position = 'fixed';
                    menu.style.top = top + 'px';
                    menu.style.left = left + 'px';
                    menu.style.right = 'auto';
                    menu.style.bottom = 'auto';
                    
                    // Show menu first (remove hidden, set display)
                    menu.classList.remove('hidden');
                    menu.style.display = 'block';
                    
                    // Force reflow to ensure display is applied before animation
                    void menu.offsetHeight;
                    
                    // Animate in after a tiny delay to prevent flicker
                    setTimeout(() => {
                        menu.classList.remove('opacity-0', 'scale-95');
                        menu.classList.add('opacity-100', 'scale-100');
                        
                        // Remove from animating set after animation completes
                        setTimeout(() => {
                            dropdownAnimating.delete(orderId);
                        }, 200);
                    }, 10);
                    
                    button.setAttribute('aria-expanded', 'true');
                }
            }
        </script>
    @endpush

    @php
        // Status color mapping
        $statusColors = [
            'completed' => 'bg-success-500',
            'delivered' => 'bg-success-500',
            'paid' => 'bg-success-500',
            'pending' => 'bg-warning-500',
            'cancelled' => 'bg-danger-500',
            'failed' => 'bg-danger-500',
            'refunded' => 'bg-danger-500',
            'processing' => 'bg-info-500',
            'shipped' => 'bg-info-500'
        ];
    @endphp
</x-admin-layout>
