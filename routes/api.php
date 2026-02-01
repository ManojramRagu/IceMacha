<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Product API Routes
 * 
 * Public Routes:
 * - GET /api/products: List services/products (Pagination + Filter)
 * - GET /api/products/{id}: Show details
 * 
 * Protected Routes (Sanctum):
 * - POST /api/products: Create
 * - PUT /api/products/{id}: Update
 * - DELETE /api/products/{id}: Delete
 */
Route::prefix('products')->group(function () {
    // Public
    Route::get('/', [\App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show']);

    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\ProductController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);
    });
});
