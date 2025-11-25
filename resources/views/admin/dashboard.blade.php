<!-- In resources/views/admin/dashboard.blade.php -->
<x-admin-layout title="Dashboard">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Admin Dashboard</h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Admin Dashboard</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <div class="space-y-6">
    <!-- Overview Section Start -->
    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      <!-- Total Customers -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/20 text-primary">
            <i data-feather="users" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Total Customers</p>
            <div class="flex items-baseline justify-between">
              <h4 class="text-2xl font-semibold">{{ number_format($totalCustomers) }}</h4>
              @php
                $customerGrowth = $totalCustomers > 0 ? (($totalCustomers - ($totalCustomers * 0.9)) / ($totalCustomers * 0.9) * 100) : 0;
                $isCustomerGrowthPositive = $customerGrowth >= 0;
              @endphp
              <span
                class="flex items-center text-xs font-medium {{ $isCustomerGrowthPositive ? 'text-success' : 'text-danger' }}">
                <i class="h-3 w-3" stroke-width="3px"
                  data-feather="{{ $isCustomerGrowthPositive ? 'arrow-up-right' : 'arrow-down-right' }}"></i>
                {{ number_format(abs($customerGrowth), 1) }}%
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</x-admin-layout>