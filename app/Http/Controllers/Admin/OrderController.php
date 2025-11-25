<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items'])
            ->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('payment_status', 'like', "%{$search}%")
                  ->orWhere('total_amount', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        // Get order statuses for filter
        $statuses = Order::select('status')
            ->distinct()
            ->pluck('status')
            ->filter()
            ->values();

        return view('admin.orders', compact('orders', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.order');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Eager load relationships
        $order = Order::with([
            'customer',
            'items.product.images',
            'items.variant.size',
        ])->findOrFail($id);

        // Status colors for the view
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

        return view('admin.order-details', compact('order', 'statusColors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled,refunded',
            'notes' => 'nullable|string|max:1000'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus,
            'admin_notes' => $request->notes,
            $this->getStatusTimestampField($newStatus) => now()
        ]);

        // Here you can add notifications, emails, etc.

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
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

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'status_text' => ucfirst($newStatus),
                'status_color' => $statusColors[$newStatus] ?? 'bg-slate-500'
            ]);
        }

        return back()->with('success', 'Order status updated successfully');
    }

    protected function getStatusTimestampField($status)
    {
        return [
            'shipped' => 'shipped_at',
            'delivered' => 'delivered_at',
            'cancelled' => 'cancelled_at'
        ][$status] ?? null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
