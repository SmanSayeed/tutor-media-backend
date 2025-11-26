<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = $request->user('admin');
        // if (! $admin && !$request->is('admin/login')) {
        //     return redirect()->route('admin.login');
        // }

        // if ($request->is('admin') || $request->is('admin/')) {
        //     return redirect()->route('admin.dashboard');
        // }

        return $next($request);
    }

    /**
     * Check recursively if the logged-in admin has permission
     * for the current URL.
     *
     * @param  array  $menus
     * @return bool
     */
}
