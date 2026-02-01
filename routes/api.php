<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\ProductController;

Route::middleware(['throttle:api'])->group(function () {
    // Auth Routes
    Route::post('/login', [LoginApiController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginApiController::class, 'logout']);
        
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    /**
     * Product API Routes
     */
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
