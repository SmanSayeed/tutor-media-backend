<x-admin-layout title="User Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <div>
      <h5>User Details</h5>
      <p class="text-sm text-slate-500 dark:text-slate-400">Detailed information about {{ $user->name }}</p>
    </div>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.users') }}">Users</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">User Details</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <div class="space-y-6">
    <!-- User Information Card -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">User Information</h6>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <!-- User Avatar and Basic Info -->
          <div class="flex items-center gap-4">
            <div class="avatar avatar-xl">
              <img class="avatar-img"
                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatar1.png') }}"
                alt="User Avatar" />
            </div>
            <div>
              <h4 class="text-lg font-semibold text-slate-700 dark:text-slate-100">{{ $user->name }}</h4>
              <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
              <div class="mt-2">
                <span class="badge {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                  {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="badge badge-soft-secondary ml-2">{{ ucfirst($user->role) }}</span>
              </div>
            </div>
          </div>

          <!-- User Details -->
          <div class="space-y-3">
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-300">Phone</label>
              <p class="text-sm text-slate-700 dark:text-slate-100">{{ $user->phone ?? 'Not provided' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-300">Timezone</label>
              <p class="text-sm text-slate-700 dark:text-slate-100">{{ $user->timezone ?? 'Not set' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-300">Last Login IP</label>
              <p class="text-sm text-slate-700 dark:text-slate-100">{{ $user->last_login_ip ?? 'Never logged in' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-300">Account Created</label>
              <p class="text-sm text-slate-700 dark:text-slate-100">{{ $user->created_at->format('M d, Y \a\t h:i A') }}
              </p>
            </div>
            <div>
              <label class="text-sm font-medium text-slate-600 dark:text-slate-300">Email Verified</label>
              <p class="text-sm text-slate-700 dark:text-slate-100">
                @if($user->email_verified_at)
                  <span class="text-green-600">✓ Verified</span> on {{ $user->email_verified_at->format('M d, Y') }}
                @else
                  <span class="text-red-600">✗ Not verified</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- User Orders Card -->
    <div class="card">
      <div class="card-header">
        <div class="flex items-center justify-between">
          <h6 class="card-title">Order History ({{ $user->orders->count() }} orders)</h6>
          <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
        </div>
      </div>
      <div class="card-body">
        @if($user->orders->count() > 0)
          <div class="space-y-4">
            @foreach($user->orders->take(5) as $order)
              <div class="flex items-center justify-between p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                <div class="flex-1">
                  <div class="flex items-center gap-3">
                    <div>
                      <h6 class="font-medium text-slate-700 dark:text-slate-100">{{ $order->order_number }}</h6>
                      <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ $order->created_at->format('M d, Y') }} • {{ $order->items->count() }} items
                      </p>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-lg font-semibold text-slate-700 dark:text-slate-100">
                    ${{ number_format($order->total_amount, 2) }}
                  </div>
                  <div class="space-x-2">
                    <span
                      class="badge badge-soft-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'shipped' ? 'warning' : ($order->status === 'confirmed' ? 'primary' : 'secondary')) }}">
                      {{ ucfirst($order->status) }}
                    </span>
                    @if($order->payment_status === 'paid')
                      <span class="badge badge-soft-success">Paid</span>
                    @else
                      <span class="badge badge-soft-warning">{{ ucfirst($order->payment_status) }}</span>
                    @endif
                  </div>
                </div>
                <div class="ml-4">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                    <i data-feather="eye" class="w-4 h-4"></i>
                    View
                  </a>
                </div>
              </div>
            @endforeach

            @if($user->orders->count() > 5)
              <div class="text-center pt-4">
                <a href="{{ route('admin.orders.index') }}?user={{ $user->id }}"
                  class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                  View all {{ $user->orders->count() }} orders →
                </a>
              </div>
            @endif
          </div>
        @else
          <div class="text-center py-8">
            <i data-feather="shopping-bag" class="w-12 h-12 text-slate-400 mx-auto mb-4"></i>
            <p class="text-slate-500 dark:text-slate-400">No orders found for this user</p>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mt-4">View All Orders</a>
          </div>
        @endif
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="card">
      <div class="card-body">
        <div class="flex flex-wrap gap-3">
          <button class="btn btn-primary">
            <i data-feather="edit" class="w-4 h-4 mr-2"></i>
            Edit User
          </button>
          <button class="btn btn-outline-primary">
            <i data-feather="mail" class="w-4 h-4 mr-2"></i>
            Send Email
          </button>
          @if($user->is_active)
            <button class="btn btn-outline-warning">
              <i data-feather="minus-circle" class="w-4 h-4 mr-2"></i>
              Deactivate Account
            </button>
          @else
            <button class="btn btn-outline-success">
              <i data-feather="check-circle" class="w-4 h-4 mr-2"></i>
              Activate Account
            </button>
          @endif
          <button class="btn btn-outline-danger">
            <i data-feather="trash" class="w-4 h-4 mr-2"></i>
            Delete User
          </button>
        </div>
      </div>
    </div>
  </div>
</x-admin-layout>