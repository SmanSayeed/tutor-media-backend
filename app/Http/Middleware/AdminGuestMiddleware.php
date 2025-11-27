<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard('admin')->user();

        $isAdmin = $user?->isAdmin();
        $isAdminRoute = $request->is('admin*');

        if ($isAdmin && $isAdminRoute) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
