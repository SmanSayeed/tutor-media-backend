<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AdminGuestMiddleware;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware([AdminGuestMiddleware::class])->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('register', [LoginController::class, 'register'])->name('register');
    Route::post('register', [LoginController::class, 'register'])->name('register.store');
    Route::get('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
    Route::post('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password.store');
    Route::get('check-email', [LoginController::class, 'check_email'])->name('check-email');
    Route::get('reset-password', [LoginController::class, 'reset_password'])->name('reset-password');
    Route::post('reset-password', [LoginController::class, 'reset_password'])->name('reset-password.store');
});

// Protected Admin Routes
Route::middleware([AdminAuthMiddleware::class])->group(function () {
    // Admin Profile Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('user-details');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Banners
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::delete('/banners/bulk-delete', [\App\Http\Controllers\Admin\BannerController::class, 'bulkDestroy'])->name('banners.bulk-destroy');
    Route::patch('/banners/{banner}/toggle-status', [\App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::post('/banners/update-order', [\App\Http\Controllers\Admin\BannerController::class, 'updateOrder'])->name('banners.update-order');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Site Settings
    Route::get('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::put('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::delete('/site-settings/logo', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteLogo'])->name('site-settings.delete-logo');
    Route::delete('/site-settings/favicon', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteFavicon'])->name('site-settings.delete-favicon');
    Route::delete('/site-settings/og-image', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteOgImage'])->name('site-settings.delete-og-image');
    Route::post('/site-settings/toggle-maintenance', [\App\Http\Controllers\Admin\SiteSettingController::class, 'toggleMaintenanceMode'])->name('site-settings.toggle-maintenance');
});
