<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\CustomerAuthController;

Route::get('/', function () {
    return view('pages/home');
});

Route::get('/auth', [CustomerAuthController::class, 'showLoginRegisterForm'])->name('customer.login-register');
Route::post('/auth/login', [CustomerAuthController::class, 'login']);
Route::get('/auth/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
Route::post('/auth/register', [CustomerAuthController::class, 'register']);

//Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');

Route::get('/new-arrivals', [ProductController::class, 'newArrivalsPage'])->name('products.new-arrivals');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])
    ->name('products.reviews.store');

Route::get('/contact', function () {
    return view('pages/contact');
});

Route::get('/about', function () {
    return view('pages/about');
});

/**
 * admin routes
 */
// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});