<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        // Revenue data
        $totalRevenue = Order::where('status', 'completed')
            ->sum('total_amount');
            
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
            
        // Recent Orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();
            
        // Top Selling Products
        $topProducts = Product::withCount(['orderItems as total_orders' => function($query) {
                $query->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->orderBy('total_orders', 'desc')
            ->take(5)
            ->get();
            
        // Monthly Sales Data for Chart
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COALESCE(SUM(total_amount), 0) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
            
        // Format chart data
        $salesChartData = [];
        $monthNames = [];
        
        // Ensure we always have 6 months of data, even if no sales
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            $monthNames[] = $date->format('M Y');
            
            // Find matching sales data or default to 0
            $sale = $monthlySales->first(function ($item) use ($month, $year) {
                return $item->month == $month && $item->year == $year;
            });
            
            $salesChartData[] = $sale ? (float)$sale->total : 0;
        }

        return view('admin.dashboard', [
            'totalCustomers' => $totalCustomers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'salesChartData' => $salesChartData,
            'monthNames' => $monthNames,
        ]);
    }
}
