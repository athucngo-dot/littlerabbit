<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\CmsAuthController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CmsProductController;
use App\Http\Middleware\AuthenticateCustomer;
use App\Http\Middleware\AuthenticateCms;

/**********************
 * Front site routes
 **********************/

Route::get('/', [HomeController::class, 'homePage'])->name('homepage');

Route::get('/auth', [CustomerAuthController::class, 'showLoginRegisterForm'])->name('customer.login-register');
Route::post('/auth/login', [CustomerAuthController::class, 'login']);
Route::post('/auth/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
Route::post('/auth/register', [CustomerAuthController::class, 'register']);

Route::get('/baby-toddler-kids-clothings', [ProductController::class, 'allItemsPage'])->name('products.all-items');
Route::get('/new-arrivals', [ProductController::class, 'newArrivalsPage'])->name('products.new-arrivals');
Route::get('/deals', [ProductController::class, 'dealsPage'])->name('products.deals');
Route::get('/accessories', [ProductController::class, 'accessoriesPage'])->name('products.accessories');
Route::get('/category/{categorySlug}', [ProductController::class, 'listByCategory'])->name('products.byCategory');
Route::get('/deal/{dealSlug}', [ProductController::class, 'listByDeal'])->name('products.byDeal');

Route::get('{ageGroup}/{gender}', [ProductController::class, 'listByAgeAndGender'])
    ->where([
        'ageGroup' => 'baby|toddler|kid',
        'gender' => 'boy|girl|unisex',
    ])
    ->name('products.byAgeAndGender');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::get('/browse-categories', [CategoryController::class, 'browseCategoriesPage'])->name('categories.browse-categories');


// keep the cart routes within web middleware to have session and cookie support
// make it API-like to be easier extended to API app (with Sanctum authentication) later
Route::middleware(['web'])->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart.index');
    Route::get('cartList', [CartApiController::class, 'cartList'])->name('cart.cart-list');
    Route::post('add', [CartApiController::class, 'add'])->name('cart.add');
    Route::put('updateQuantity', [CartApiController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('remove-item/{productId}/{colorId}/{sizeId}',
        [CartApiController::class, 'removeItem'])->name('cart.removeItem')
        ->whereNumber('productId')
        ->whereNumber('colorId')
        ->whereNumber('sizeId');
});

Route::middleware(['web', AuthenticateCustomer::class])->prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/payment-intent', [CheckoutController::class, 'paymentIntent'])->name('checkout.payment-intent');
    Route::get('/success/{order_number}', [CheckoutController::class, 'paymentSuccess'])->name('checkout.payment-success');
});

/**
 * Dashboard
 */
Route::middleware(['web', AuthenticateCustomer::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mainDashboard'])->name('dashboard.main-dashboard');
});

Route::middleware(['web', AuthenticateCustomer::class])->prefix('customer')->group(function () {
    Route::put('/update-name', [CustomerApiController::class, 'updateName'])->name('customer.update-name');
    Route::put('/update-password', [CustomerApiController::class, 'updatePassword'])->name('customer.update-password');
    Route::get('/addresses', [CustomerApiController::class, 'getAddress'])->name('customer.get-address');
    Route::post('/addresses', [CustomerApiController::class, 'addAddress'])->name('customer.add-address');
    Route::put('/addresses/{id}', [CustomerApiController::class, 'updateAddress'])->name('customer.update-address');
    Route::delete('/addresses/{id}', [CustomerApiController::class, 'deleteAddress'])->name('customer.delete-address');
});

/*
* Static pages
*/
// Contact page
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// About Us page
Route::get('/about', function () {
    return view('pages/about');
})->name('about');

// Shipping and return page
Route::get('/shipping-return', function () {
    return view('pages/shipping-return');
})->name('shipping-return');

// FAQ page
Route::get('/faq', function () {
    return view('pages/faq');
})->name('faq');

// size guide page
Route::get('/size-guide', function () {
    return view('pages/size-guide');
})->name('size-guide');

/**********************
 * CMS admin routes
 **********************/
Route::prefix('cms')->group(function () {
    Route::get('/login', [CmsAuthController::class, 'showLoginForm'])->name('cms.login');
    Route::post('/login', [CmsAuthController::class, 'login'])->name('cms.login-action');
    //Route::post('/logout', [CmsAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['web', AuthenticateCms::class])->prefix('cms')->group(function () {
    Route::get('/products', [CmsProductController::class, 'productList'])->name('cms.products');
});

