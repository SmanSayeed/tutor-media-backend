<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::middleware('guest:client')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::get('login/{provider}', [AuthController::class, 'redirectToProvider']);
        Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
        Route::post('send-otp', [AuthController::class, 'sendOtp']);
        Route::post('verify-email-or-phone', [AuthController::class, 'verifyEmailOrPhone']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    });

    Route::group(['middleware' => 'auth:client'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
    });
});
