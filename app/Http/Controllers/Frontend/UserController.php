<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Review;
use App\Models\Customer;

class UserController extends Controller
{
    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        // Get order statistics
        $orderStats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_amount'),
        ];

        // Get wishlist count
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();

        // Get pending reviews (orders delivered but not reviewed by this user)
        $reviewedOrderIds = Review::whereHas('customer', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->pluck('order_id')->toArray();

        $pendingReviews = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->whereNotIn('id', $reviewedOrderIds)
            ->with(['items.product'])
            ->limit(3)
            ->get();

        // Get recommended products (based on recent purchases or popular items)
        $recommendedProducts = Product::where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'recentOrders',
            'orderStats',
            'wishlistCount',
            'pendingReviews',
            'recommendedProducts'
        ));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'timezone' => ['nullable', 'string', 'max:50'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'timezone' => $request->timezone,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
}
