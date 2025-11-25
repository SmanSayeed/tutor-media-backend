<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Shipping API routes
Route::get('/shipping/districts', [ShippingController::class, 'getDistricts'])
    ->name('shipping.districts');
Route::get('/shipping/default-charge', [ShippingController::class, 'getDefaultCharge'])
    ->name('shipping.default-charge');
Route::post('/shipping/calculate-charge', [ShippingController::class, 'calculateCharge'])
    ->name('shipping.calculate-charge');
