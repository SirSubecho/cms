<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('throttle:60,1')->group(function () {
            /* Auth rules */
            Route::get('/user', [AuthController::class, 'user']);
            Route::post('/logout', [AuthController::class, 'logout']);

            /* Customer rules */
            Route::get('/customers/stats', [CustomerController::class, 'stats']);
            Route::apiResource('customers', CustomerController::class);
        });
    });
});

