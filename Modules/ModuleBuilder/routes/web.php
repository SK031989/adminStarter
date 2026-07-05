<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleBuilder\App\Http\Controllers\GeneratedModuleController;
use Modules\ModuleBuilder\App\Http\Controllers\ModuleBuilderController;
use Modules\ModuleBuilder\App\Http\Controllers\ModuleFieldController;

use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

/*
|--------------------------------------------------------------------------
| ModuleBuilder Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', EnsureUserIsAdmin::class])
    ->prefix('admin/module-builder')
    ->name('module-builder.')
    ->group(function () {

        Route::get('/',       [ModuleBuilderController::class, 'index'])->name('index');
        Route::get('/create', [ModuleBuilderController::class, 'create'])->name('create');
        Route::post('/',      [ModuleBuilderController::class, 'store'])->name('store');

        Route::resource('/', ModuleBuilderController::class)
            ->parameters(['' => 'moduleBuilder'])
            ->except(['index', 'create', 'store']);

        // ── Field Management ──────────────────────────────────────────────────
        Route::prefix('{moduleBuilder}/fields')
            ->name('fields.')
            ->group(function () {
                Route::post('/',            [ModuleFieldController::class, 'store'])->name('store');
                Route::put('/{field}',      [ModuleFieldController::class, 'update'])->name('update');
                Route::delete('/{field}',   [ModuleFieldController::class, 'destroy'])->name('destroy');
                Route::post('/reorder',     [ModuleFieldController::class, 'reorder'])->name('reorder');
            });

        // ── Code Generation ───────────────────────────────────────────────────
        Route::post('{moduleBuilder}/generate', [GeneratedModuleController::class, 'generate'])
            ->name('generate');
        Route::get('{moduleBuilder}/preview', [GeneratedModuleController::class, 'preview'])
            ->name('preview');
    });
