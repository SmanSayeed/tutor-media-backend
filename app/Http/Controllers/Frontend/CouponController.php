<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to apply coupons.'], 401);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->is_active || ($coupon->expires_at && $coupon->expires_at->isPast())) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.'], 404);
        }

        $cartItems = Cart::where('user_id', Auth::id())
                         ->where('is_active', true)
                         ->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
        }
        
        $subtotal = $cartItems->sum('total_price');

        $discountAmount = 0;
        if ($coupon->type === 'percent') {
            $discountAmount = ($subtotal * $coupon->value) / 100;
        } else {
            $discountAmount = $coupon->value;
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'discount' => $discountAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => number_format($discountAmount, 2),
            'new_total' => number_format($subtotal - $discountAmount, 2),
        ]);
    }
}