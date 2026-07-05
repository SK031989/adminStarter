<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\App\Http\Controllers\ProductApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/products')
    ->name('api.products.')
    ->group(function () {
        Route::apiResource('/', ProductApiController::class)->parameters(['' => 'product']);
    });