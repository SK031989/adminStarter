<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Services\AuthService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('api')->prefix('v1/auth')->group(function () {

    // ── Login ────────────────────────────────────────────────────────────
    Route::post('/login', function (Request $request, AuthService $authService) {
        $credentials = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'device_name' => ['string'],
        ]);

        $token = $authService->loginApi($credentials, $credentials['device_name'] ?? 'API');

        return response()->json([
            'token' => $token,
            'message' => 'Logged in successfully.'
        ]);
    })->name('api.auth.login');

    // ── Authenticated User & Logout ──────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::get('/user', function (Request $request) {
            return response()->json([
                'user' => $request->user()
            ]);
        })->name('api.auth.user');

        Route::post('/logout', function (Request $request, AuthService $authService) {
            $authService->logoutApi($request->user());

            return response()->json([
                'message' => 'Token revoked and logged out.'
            ]);
        })->name('api.auth.logout');

    });

});
