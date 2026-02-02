<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\v1\ProductApiController as ProductApiControllerV1;

Route::middleware(['throttle:60,1'])->group(function () {
    // Auth Routes
    Route::post('/login', [LoginApiController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginApiController::class, 'logout']);
        
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Cart Routes (Scoped)
        Route::middleware('abilities:cart:manage')->group(function () {
            // Placeholder for CartController
            Route::post('/cart', function() { return response()->json(['message' => 'Item added to cart']); });
        });
    });

    /**
     * Product API Routes
     */
    Route::prefix('v1/products')->group(function () {
         Route::get('/', [ProductApiControllerV1::class, 'index']);
         Route::get('/{id}', [ProductApiControllerV1::class, 'show']);
    });

    Route::prefix('products')->group(function () {
        // Public
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);

        // Protected (Admin only for write operations)
        Route::middleware(['auth:sanctum', 'abilities:admin:all'])->group(function () {
            Route::post('/', [ProductController::class, 'store']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });
    });
});
