<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Auth\App\Services\AuthService;

class LogoutController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();

        return redirect(config('auth-module.redirects.logout', route('auth.login')))
            ->with('success', 'You have been logged out successfully.');
    }
}
