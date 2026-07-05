<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\ForgotPasswordController;
use Modules\Auth\App\Http\Controllers\LoginController;
use Modules\Auth\App\Http\Controllers\LogoutController;
use Modules\Auth\App\Http\Controllers\ProfileController;
use Modules\Auth\App\Http\Controllers\RegisterController;
use Modules\Auth\App\Http\Controllers\ResetPasswordController;
use Modules\Auth\App\Http\Controllers\VerificationController;

use Modules\Auth\App\Http\Controllers\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {

    // ── Tenant Authentication (Frontend) ──────────────────────────────────
    Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login',  [LoginController::class, 'login'])->name('auth.login.store');
    Route::get('/auth/login', fn() => redirect()->route('auth.login')); // Legacy redirect
    
    Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('auth.logout');

    // ── Super Admin Authentication (Separate Admin Route) ─────────────────
    Route::get('/admin/login',  [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.store');

    // ── Tenant Registration (Frontend) ────────────────────────────────────
    if (config('auth-module.registration.enabled', true)) {
        Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
        Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.store');
        Route::get('/auth/register', fn() => redirect()->route('auth.register')); // Legacy redirect
    }

    // ── Password Reset ────────────────────────────────────────────────────
    Route::get('/auth/forgot-password',  [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.password.request');
    Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.email');
    
    Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('auth.password.reset');
    Route::post('/auth/reset-password',        [ResetPasswordController::class, 'reset'])->name('auth.password.update');

    // ── Email Verification ────────────────────────────────────────────────
    Route::middleware('auth')->group(function () {
        Route::get('/auth/verify-email',       [VerificationController::class, 'showNotice'])->name('auth.verify.notice');
        Route::get('/auth/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])->name('auth.verify.verify');
        Route::post('/auth/email/verification-notification', [VerificationController::class, 'resend'])
            ->middleware('throttle:6,1')->name('auth.verify.resend');
    });

    // ── Profile Settings (Auth Required) ──────────────────────────────────
    Route::middleware(['auth', 'verified'])->prefix('profile')->name('auth.profile.')->group(function () {
        Route::get('/',                 [ProfileController::class, 'edit'])->name('edit');
        Route::put('/',                 [ProfileController::class, 'update'])->name('update');
        Route::put('/password',         [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/avatar',        [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy');
        Route::delete('/',              [ProfileController::class, 'destroy'])->name('destroy');
    });

    // ── Admin Profile Settings (Admin Required) ───────────────────────────
    Route::middleware(['auth', 'verified', \Modules\Dashboard\App\Http\Middleware\EnsureUserIsAdmin::class])
        ->prefix('admin/profile')
        ->name('admin.profile.')
        ->group(function () {
            Route::get('/',                 [ProfileController::class, 'edit'])->name('edit');
            Route::put('/',                 [ProfileController::class, 'update'])->name('update');
            Route::put('/password',         [ProfileController::class, 'updatePassword'])->name('password.update');
            Route::delete('/avatar',        [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy');
            Route::delete('/',              [ProfileController::class, 'destroy'])->name('destroy');
        });

});
