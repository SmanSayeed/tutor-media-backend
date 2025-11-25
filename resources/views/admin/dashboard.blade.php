<!-- In resources/views/admin/dashboard.blade.php -->
<x-admin-layout title="Dashboard">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Analytics</h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Analytics</a>
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
              <span class="flex items-center text-xs font-medium {{ $isCustomerGrowthPositive ? 'text-success' : 'text-danger' }}">
                <i class="h-3 w-3" stroke-width="3px" data-feather="{{ $isCustomerGrowthPositive ? 'arrow-up-right' : 'arrow-down-right' }}"></i>
                {{ number_format(abs($customerGrowth), 1) }}%
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Products -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-info/20 text-info">
            <i data-feather="box" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Total Products</p>
            <div class="flex items-baseline justify-between">
              <h4 class="text-2xl font-semibold">{{ number_format($totalProducts) }}</h4>
              <span class="text-xs text-slate-500">In Stock</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Orders -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-warning/20 text-warning">
            <i data-feather="shopping-bag" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Total Orders</p>
            <div class="flex items-baseline justify-between">
              <h4 class="text-2xl font-semibold">{{ number_format($totalOrders) }}</h4>
              <span class="text-xs text-slate-500">This Month</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Revenue -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-success/20 text-success">
            <i data-feather="dollar-sign" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Total Revenue</p>
            <div class="flex items-baseline justify-between">
              <h4 class="text-2xl font-semibold">৳{{ number_format($totalRevenue, 2) }}</h4>
              <span class="text-xs text-slate-500">This Month: ৳{{ number_format($monthlyRevenue, 2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- Sales Analytics -->
      <div class="lg:col-span-2">
        <div class="card h-full">
          <div class="card-body">
            <div class="flex justify-between items-center mb-6">
              <h6>Sales Analytics</h6>
              <div class="text-sm text-slate-500">Last 6 months</div>
            </div>
            <div id="sales-chart" style="min-height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Top Selling Products -->
      <div>
        <div class="card h-full">
          <div class="card-body">
            <div class="flex justify-between items-center mb-6">
              <h6>Top Selling Products</h6>
              <a href="{{ route('admin.products.index') }}" class="text-sm text-primary hover:underline">View All</a>
            </div>
            <div class="space-y-4">
              @forelse($topProducts as $product)
              <div class="flex items-center gap-3 p-3 border border-neutral-100 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex-shrink-0">
                  <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                  <p class="text-sm text-gray-500">Sold: {{ $product->total_orders ?? 0 }}</p>
                  <div class="flex items-center mt-1">
                    <div class="flex items-center text-amber-400">
                      @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->rating_avg ?? 0))
                          <i class="bx bxs-star text-sm"></i>
                        @elseif($i == ceil($product->rating_avg ?? 0) && ($product->rating_avg ?? 0) - floor($product->rating_avg ?? 0) > 0)
                            <i class='bx bxs-star-half text-sm'></i>
                        @else
                            <i class='bx bx-star text-sm'></i>
                        @endif
                      @endfor
                      <span class="ml-1 text-xs text-gray-500">({{ number_format($product->rating_count ?? 0, 1) }})</span>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-medium text-gray-900">৳{{ number_format($product->sale_price ?? $product->price, 2) }}</p>
                  @if(isset($product->sale_price) && $product->sale_price < $product->price)
                    <p class="text-xs text-gray-500 line-through">৳{{ number_format($product->price, 2) }}</p>
                  @endif
                </div>
              </div>
              @empty
              <div class="text-center py-4 text-slate-500">No products found</div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
      <div class="card-body">
        <div class="flex justify-between items-center mb-6">
          <h6>Recent Orders</h6>
          <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentOrders as $order)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">#{{ $order->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                      <span class="text-primary font-medium">{{ substr($order->user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium">{{ $order->user->name }}</div>
                      <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $order->created_at->format('M d, Y') }}
                  <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  ৳{{ number_format($order->total_amount, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $statusColors = [
                      'pending' => 'bg-yellow-100 text-yellow-800',
                      'processing' => 'bg-blue-100 text-blue-800',
                      'shipped' => 'bg-indigo-100 text-indigo-800',
                      'delivered' => 'bg-green-100 text-green-800',
                      'cancelled' => 'bg-red-100 text-red-800',
                      'completed' => 'bg-green-100 text-green-800',
                    ][$order->status] ?? 'bg-gray-100 text-gray-800';
                  @endphp
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary hover:text-primary-dark">
                    View
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                  No recent orders found
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const chartData = @json($salesChartData);
      const monthNames = @json($monthNames);
      
      const options = {
        series: [{
          name: 'Sales',
          data: chartData
        }],
        chart: {
          type: 'area',
          height: '100%',
          fontFamily: 'Inter, sans-serif',
          toolbar: { show: false },
          zoom: { enabled: false }
        },
        colors: ['#4361ee'],
        dataLabels: { enabled: false },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          categories: monthNames,
          labels: { style: { colors: '#64748b', fontSize: '12px' } },
          axisBorder: { show: false },
          axisTicks: { show: false }
        },
        yaxis: {
          labels: {
            formatter: (value) => '৳' + value.toLocaleString(),
            style: { colors: '#64748b', fontSize: '12px' }
          }
        },
        tooltip: {
          y: { formatter: (value) => '৳' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) },
          theme: 'light',
          style: { fontSize: '12px', fontFamily: 'Inter, sans-serif' }
        },
        grid: {
          borderColor: '#e2e8f0',
          strokeDashArray: 4,
          padding: { top: 0, right: 0, bottom: 0, left: 0 },
          xaxis: { lines: { show: false } },
          yaxis: { lines: { show: true } }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.1,
            stops: [0, 100]
          }
        }
      };

      const chart = new ApexCharts(document.querySelector("#sales-chart"), options);
      chart.render();
      
      // Handle window resize
      let resizeTimer;
      window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
          chart.updateOptions({ chart: { width: '100%' } });
        }, 250);
      });
    });
  </script>
  @endpush
</x-admin-layout>