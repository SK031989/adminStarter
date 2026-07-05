<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\App\Http\Controllers\ProductController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

// Admin routes (for super admin)
Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/products')
    ->name('admin.products.')
    ->group(function () {
        Route::resource('/', ProductController::class)->parameters(['' => 'product']);
    });

// Tenant routes (for regular users)
Route::middleware(['web', 'auth', 'verified'])
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        Route::resource('/', ProductController::class)->parameters(['' => 'product']);
    });