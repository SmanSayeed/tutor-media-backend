<?php

use Illuminate\Auth\AuthenticationException;

class Handler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // If request expects JSON or comes from API guard (sanctum/client)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }
    }
}
