<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ShippingZoneController;
use App\Http\Controllers\Admin\ShippingSettingsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\SubcategoryController as FrontendSubcategoryController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CustomerProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('register', [LoginController::class, 'register'])->name('register.store');
Route::get('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
Route::post('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password.store');
Route::get('check-email', [LoginController::class, 'check_email'])->name('check-email');
Route::get('reset-password', [LoginController::class, 'reset_password'])->name('reset-password');
Route::post('reset-password', [LoginController::class, 'reset_password'])->name('reset-password.store');

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [FrontendUserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [FrontendUserController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile/update', [FrontendUserController::class, 'update'])->name('user.profile.update');
    Route::get('/dashboard', [FrontendUserController::class, 'dashboard'])->name('user.dashboard');
});

// Admin Authentication Routes (legacy support - redirect to main login)
Route::get('/admin/login', function() {
    return redirect('/login');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('user-details');
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    // Subcategories routes
    Route::prefix('subcategories')->name('subcategories.')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('index');
        Route::get('/create', [SubCategoryController::class, 'create'])->name('create');
        Route::post('/', [SubCategoryController::class, 'store'])->name('store');
        Route::get('/{subcategory}', [SubCategoryController::class, 'show'])->name('show');
        Route::get('/{subcategory}/edit', [SubCategoryController::class, 'edit'])->name('edit');
        Route::put('/{subcategory}', [SubCategoryController::class, 'update'])->name('update');
        Route::delete('/{subcategory}', [SubCategoryController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [SubCategoryController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::patch('/{subCategory}/toggle-status', [SubCategoryController::class, 'toggleStatus'])->name('toggle-status');
    });
    Route::resource('child-categories', ChildCategoryController::class);
    Route::post('/child-categories/bulk-delete', [ChildCategoryController::class, 'bulkDestroy'])->name('child-categories.bulk-destroy');
    Route::patch('/child-categories/{childCategory}/toggle-status', [ChildCategoryController::class, 'toggleStatus'])->name('child-categories.toggle-status');
    Route::resource('products', ProductController::class);
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('get-subcategories');
    Route::get('/get-child-categories', [ProductController::class, 'getChildCategories'])->name('get-child-categories');
    Route::resource('orders', OrderController::class);
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock.update');
    Route::get('/products/{product}/stock', [ProductController::class, 'manageStock'])->name('products.stock');
    Route::get('/products/{product}/images', [ProductController::class, 'manageImages'])->name('products.images');
    Route::post('/products/{product}/images', [ProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::patch('/product-images/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('product-images.primary');
    Route::delete('/product-images/{image}', [ProductController::class, 'deleteImage'])->name('product-images.delete');
    Route::resource('product-variants', ProductVariantController::class);
    Route::delete('/product-variants/bulk-delete', [ProductVariantController::class, 'bulkDestroy'])->name('product-variants.bulk-destroy');
    Route::patch('/product-variants/{variant}/toggle-status', [ProductVariantController::class, 'toggleStatus'])->name('product-variants.toggle-status');
    Route::post('/product-variants/{variant}/stock', [ProductVariantController::class, 'updateStock'])->name('product-variants.stock.update');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::get('/create-brand', [BrandController::class, 'create'])->name('create-brand');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::delete('/brands', [BrandController::class, 'bulkDestroy'])->name('brands.bulk-destroy');
    Route::patch('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

    // Colors
    Route::resource('colors', ColorController::class);
    Route::delete('/colors/bulk-delete', [ColorController::class, 'bulkDestroy'])->name('colors.bulk-destroy');
    Route::patch('/colors/{color}/toggle-status', [ColorController::class, 'toggleStatus'])->name('colors.toggle-status');

    // Sizes
    Route::resource('sizes', SizeController::class);
    Route::delete('/sizes/bulk-delete', [SizeController::class, 'bulkDestroy'])->name('sizes.bulk-destroy');
    Route::patch('/sizes/{size}/toggle-status', [SizeController::class, 'toggleStatus'])->name('sizes.toggle-status');

    // Banners
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::delete('/banners/bulk-delete', [\App\Http\Controllers\Admin\BannerController::class, 'bulkDestroy'])->name('banners.bulk-destroy');
    Route::patch('/banners/{banner}/toggle-status', [\App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::post('/banners/update-order', [\App\Http\Controllers\Admin\BannerController::class, 'updateOrder'])->name('banners.update-order');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Shipping Zones
    Route::resource('shipping-zones', ShippingZoneController::class);
    Route::delete('/shipping-zones/bulk-delete', [ShippingZoneController::class, 'bulkDestroy'])->name('shipping-zones.bulk-destroy');
    Route::patch('/shipping-zones/{zone}/toggle-status', [ShippingZoneController::class, 'toggleStatus'])->name('shipping-zones.toggle-status');
    Route::post('/shipping-zones/{zone}/update-charge', [ShippingZoneController::class, 'updateCharge'])->name('shipping-zones.update-charge');

    // Shipping Settings
    Route::get('/shipping-settings', [ShippingSettingsController::class, 'index'])->name('shipping-settings.index');
    Route::put('/shipping-settings', [ShippingSettingsController::class, 'update'])->name('shipping-settings.update');

    // Advance Payment Settings
    Route::get('advance-payment-settings', [\App\Http\Controllers\AdvancePaymentController::class, 'index'])->name('advance-payment.index');
    Route::post('advance-payment-settings/update', [\App\Http\Controllers\AdvancePaymentController::class, 'update'])->name('advance-payment.update');

    // Site Settings
    Route::get('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::put('/site-settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::delete('/site-settings/logo', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteLogo'])->name('site-settings.delete-logo');
    Route::delete('/site-settings/favicon', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteFavicon'])->name('site-settings.delete-favicon');
    Route::delete('/site-settings/og-image', [\App\Http\Controllers\Admin\SiteSettingController::class, 'deleteOgImage'])->name('site-settings.delete-og-image');
    Route::post('/site-settings/toggle-maintenance', [\App\Http\Controllers\Admin\SiteSettingController::class, 'toggleMaintenanceMode'])->name('site-settings.toggle-maintenance');
});
// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{cart}/update', [CartController::class, 'update'])->name('update');
    Route::delete('/{cart}/remove', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// Checkout and Order routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::post('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy-now');
});

Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon.apply');

Route::post('/shipping/calculate', [CheckoutController::class, 'calculateShipping'])->name('shipping.calculate');
Route::post('/shipping/calculate-charge', [\App\Http\Controllers\ShippingController::class, 'calculateCharge'])->name('shipping.calculate-charge');

Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show')->middleware('auth');

// Category Sidebar and Hero Slider components are registered in AppServiceProvider.php and used in Blade views.

// Categories and subcategories
Route::get('/categories', [\App\Http\Controllers\Frontend\CategoryController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/{category:slug}', [\App\Http\Controllers\Frontend\CategoryController::class, 'show'])
    ->name('categories.show');
Route::get('/categories/{category:slug}/{subcategory:slug}', [FrontendSubcategoryController::class, 'show'])
    ->name('subcategories.show');

// Product routes for frontend
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [CustomerProductController::class, 'index'])->name('index');
    Route::get('/featured', [CustomerProductController::class, 'featured'])->name('featured');
    Route::get('/popular', [CustomerProductController::class, 'popular'])->name('popular');
    Route::get('/new-arrivals', [CustomerProductController::class, 'newArrivals'])->name('new-arrivals');
    Route::get('/search', [CustomerProductController::class, 'search'])->name('search');
    Route::get('/suggest', [CustomerProductController::class, 'suggest'])->name('suggest');
});

Route::get('/product/{slug?}', [CustomerProductController::class, 'show'])->name('products.show');
Route::get('/product/checkout', [CustomerProductController::class, 'checkout'])->name('product.checkout');
Route::get('/product/data/{id}', [CustomerProductController::class, 'getProductData'])->name('product.data');
