<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReviewApiController;

Route::get('/products/new-arrivals', [ProductApiController::class, 'newArrivals']);
Route::get('/products/deals', [ProductApiController::class, 'deals']);

Route::get('/products/{product:slug}/reviews', [ReviewApiController::class, 'index']);
Route::middleware('auth:sanctum')->post('/products/{product:slug}/reviews', [ReviewApiController::class, 'store']);
