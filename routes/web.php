<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\ProductController;
use App\Http\Controllers\Company\CategoryController;
use App\Http\Controllers\Company\OrderController;
use App\Http\Controllers\Company\ReportController;

use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;

Route::get('/', [StorefrontController::class, 'index']);
Route::get('/api/search/suggestions', [StorefrontController::class, 'suggestions']);
Route::get('/product/{id}', [StorefrontController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [StorefrontController::class, 'storeReview'])->name('product.review')->middleware('auth');
Route::get('/flash-deals', [StorefrontController::class, 'flashDeals'])->name('flash-deals');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('/checkout', function() {
    return "Checkout Page (Success)"; // Placeholder for now
})->name('checkout')->middleware('auth');

Auth::routes();

// Super Admin Routes
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:superadmin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Add companies management here
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});

// Company Routes
Route::middleware('auth:web')->group(function () {
    Route::get('/home', [CompanyDashboardController::class, 'index'])->name('home');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/reports/{type}', [ReportController::class, 'download'])->name('reports.download');
});
