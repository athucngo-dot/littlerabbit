<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/new-arrivals', [ProductController::class, 'newArrivalsPage'])->name('products.new-arrivals');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::post('/products/{product}/reviews', [\App\Http\Controllers\ProductController::class, 'storeReview'])
    ->name('products.reviews.store');

Route::get('/', function () {
    return view('pages/home');
});

Route::get('/contact', function () {
    return view('pages/contact');
});

Route::get('/about', function () {
    return view('pages/about');
});