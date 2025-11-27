<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::get('/', function () {
                return redirect()->route('admin.dashboard');
            });
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            // Auth api routes
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api/v1/auth.php'));

            // Tutor api routes
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api/v1/tutor.php'));

            // Guardian api routes
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api/v1/guardian.php'));
        }
    )
    ->withMiddleware()
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if (($request->wantsJson() || $request->is('api/*'))) {

                $messages = collect($exception->errors())->mapWithKeys(function ($messages, $field) {
                    return [$field => $messages[0]];
                })->toArray();

                return response()->json([
                    'statusCode' => 422,
                    'message' => $exception->getMessage(),
                    'errors' => $messages,
                ], 422);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (($request->is('api/*') || $request->wantsJson()) && $e->getStatusCode() === 404) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Record not found.',
                ], 404);
            }
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'statusCode' => 401,
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        });
        $exceptions->render(function (RouteNotFoundException $exception, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'statusCode' => 401,
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        });

    })->create();
