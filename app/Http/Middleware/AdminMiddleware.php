<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated in either guard
        $webUser = Auth::user();
        $adminUser = Auth::guard('admin')->user();

        // If user is authenticated in web guard but not admin guard, try to authenticate them in admin guard
        if ($webUser && !$adminUser && $webUser->role === 'admin') {
            Auth::guard('admin')->login($webUser);
            return $next($request);
        }

        // Check if user is authenticated in admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin to access this page.');
        }

        // Check if user has admin role
        $user = Auth::guard('admin')->user();
        if (!$user || $user->role !== 'admin') {
            Auth::guard('admin')->logout();
            return redirect()->route('home')->with('error', 'You do not have admin privileges.');
        }

        // Check if user account is active
        if (!$user->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('home')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
