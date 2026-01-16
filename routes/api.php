<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/products/all-items', [ProductApiController::class, 'allItems'])->name('api.products.allItems');
Route::get('/products/new-arrivals', [ProductApiController::class, 'newArrivals'])->name('api.products.new-arrivals');
Route::get('/products/deals', [ProductApiController::class, 'deals'])->name('api.products.deals');
Route::get('/products/accessories', [ProductApiController::class, 'accessories'])->name('api.products.accessories');
Route::get('/products/category/{categorySlug}', [ProductApiController::class, 'listByCategory'])->name('api.products.byCategory');
Route::get('/products/deal/{dealSlug}', [ProductApiController::class, 'listByDeal'])->name('api.products.byDeal');
Route::get('/products/search', [ProductApiController::class, 'search'])->name('api.products.search');

Route::get('products/{ageGroup}/{gender}', [ProductApiController::class, 'listByAgeAndGender'])
    ->where([
        'ageGroup' => 'baby|toddler|kid',
        'gender' => 'boy|girl|unisex',
    ])
    ->name('api.products.byAgeAndGender');

Route::get('/products/{product:slug}/reviews', [ReviewApiController::class, 'index']);
Route::middleware('auth:sanctum')->post('/products/{product:slug}/reviews', [ReviewApiController::class, 'store']);

// Stripe webhook endpoint
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
