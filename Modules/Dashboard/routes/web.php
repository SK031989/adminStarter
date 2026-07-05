<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;
use Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['web', EnsureUserIsAdmin::class])->group(function () {
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/privacy-policy',  [DashboardController::class, 'privacyPolicy'])->name('admin.privacy-policy');
    Route::get('/admin/terms-of-service', [DashboardController::class, 'termsOfService'])->name('admin.terms-of-service');
    Route::get('/admin/support',          [DashboardController::class, 'support'])->name('admin.support');
    Route::get('/admin/settings',         [DashboardController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings',        [DashboardController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/admin/users',            [DashboardController::class, 'users'])->name('admin.users.index');

    // Roles & Permissions management
    Route::get('/admin/roles',            [DashboardController::class, 'rolesList'])->name('admin.roles.index');
    Route::get('/admin/roles/create',     [DashboardController::class, 'roleCreate'])->name('admin.roles.create');
    Route::post('/admin/roles',           [DashboardController::class, 'roleStore'])->name('admin.roles.store');
    Route::get('/admin/roles/{role}/edit', [DashboardController::class, 'roleEdit'])->name('admin.roles.edit');
    Route::put('/admin/roles/{role}',      [DashboardController::class, 'roleUpdate'])->name('admin.roles.update');
    Route::delete('/admin/roles/{role}',   [DashboardController::class, 'roleDestroy'])->name('admin.roles.destroy');

    // User Role assignment
    Route::put('/admin/users/{user}/role', [DashboardController::class, 'updateUserRole'])->name('admin.users.role.update');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/privacy-policy',  [DashboardController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/terms-of-service', [DashboardController::class, 'termsOfService'])->name('terms-of-service');
    Route::get('/support',          [DashboardController::class, 'support'])->name('support');
});
