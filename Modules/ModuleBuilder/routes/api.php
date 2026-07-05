<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleBuilder\App\Http\Controllers\GeneratedModuleController;
use Modules\ModuleBuilder\App\Http\Controllers\ModuleBuilderController;
use Modules\ModuleBuilder\App\Http\Controllers\ModuleFieldController;

/*
|--------------------------------------------------------------------------
| ModuleBuilder API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/module-builder')
    ->name('api.module-builder.')
    ->group(function () {

        // ── Modules ──────────────────────────────────────────────────────────
        Route::apiResource('/', ModuleBuilderController::class)
            ->parameters(['' => 'moduleBuilder']);

        // ── Fields ───────────────────────────────────────────────────────────
        Route::apiResource('{moduleBuilder}/fields', ModuleFieldController::class)
            ->parameters(['fields' => 'field'])
            ->shallow();

        Route::post('{moduleBuilder}/fields/reorder', [ModuleFieldController::class, 'reorder'])
            ->name('fields.reorder');

        // ── Generation ───────────────────────────────────────────────────────
        Route::post('{moduleBuilder}/generate', [GeneratedModuleController::class, 'generate'])->name('generate');
        Route::get('{moduleBuilder}/status',    [GeneratedModuleController::class, 'status'])->name('status');
        Route::get('{moduleBuilder}/preview',   [GeneratedModuleController::class, 'preview'])->name('preview');
    });
