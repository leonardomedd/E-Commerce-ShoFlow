<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Protected routes - User must be authenticated
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Customer routes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    // Admin routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/orders', [AdminController::class, 'orders']);
        Route::put('/admin/orders/{order}', [AdminController::class, 'updateOrder']);

        Route::get('/admin/products', [AdminController::class, 'products']);
        Route::post('/admin/products', [AdminController::class, 'storeProduct']);
        Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct']);
        Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct']);
    });
});

