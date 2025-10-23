<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Api\CartApiController;

Route::get('/', function () {
    return view('pages/home');
});

Route::get('/auth', [CustomerAuthController::class, 'showLoginRegisterForm'])->name('customer.login-register');
Route::post('/auth/login', [CustomerAuthController::class, 'login']);
Route::get('/auth/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
Route::post('/auth/register', [CustomerAuthController::class, 'register']);

Route::get('/baby-toddler-kids-clothings', [ProductController::class, 'allItemsPage'])->name('products.all-items');
Route::get('/new-arrivals', [ProductController::class, 'newArrivalsPage'])->name('products.new-arrivals');
Route::get('/deals', [ProductController::class, 'dealsPage'])->name('products.deals');
Route::get('/accessories', [ProductController::class, 'accessoriesPage'])->name('products.accessories');

Route::get('{ageGroup}/{gender}', [ProductController::class, 'listByAgeAndGender'])
    ->where([
        'ageGroup' => 'baby|toddler|kid',
        'gender' => 'boy|girl|unisex',
    ])
    ->name('products.byAgeAndGender');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])
    ->name('products.reviews.store');

// keep the cart routes within web middleware to have session and cookie support
// make it API-like to be easier extended to API app (with Sanctum authentication) later
Route::middleware(['web'])->prefix('cart')->group(function () {
    Route::post('add', [CartApiController::class, 'add'])->name('cart.add');
});
/*
* Static pages
*/
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