<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReviewApiController;

Route::get('/products/all-items', [ProductApiController::class, 'allItems'])->name('api.products.allItems');
Route::get('/products/new-arrivals', [ProductApiController::class, 'newArrivals']);
Route::get('/products/deals', [ProductApiController::class, 'deals']);
Route::get('/products/accessories', [ProductApiController::class, 'accessories'])->name('api.products.accessories');

Route::get('products/{ageGroup}/{gender}', [ProductApiController::class, 'listByAgeAndGender'])
    ->where([
        'ageGroup' => 'baby|toddler|kid',
        'gender' => 'boy|girl|unisex',
    ])
    ->name('api.products.byAgeAndGender');

Route::get('/products/{product:slug}/reviews', [ReviewApiController::class, 'index']);
Route::middleware('auth:sanctum')->post('/products/{product:slug}/reviews', [ReviewApiController::class, 'store']);
