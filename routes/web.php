<?php

use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;

// Halaman Home
Route::get('/', [HomeController::class, 'index']);

// Halaman Products dengan route prefix
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/home-care', [ProductController::class, 'homeCare']);
    Route::get('/baby-kid', [ProductController::class, 'babyKid']);
});

// Halaman User dengan route parameter
Route::get('/user/{id}/name/{name}', [UserController::class, 'profile']);

// Halaman Penjualan
Route::get('/sales', [SalesController::class]);

// Halaman Level
Route::resource('/level', LevelController::class, ['only' => ['index']]);
