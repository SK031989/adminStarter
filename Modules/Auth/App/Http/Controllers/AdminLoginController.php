<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\App\Services\AuthService;
use Modules\Auth\App\Models\LoginActivity;

class AdminLoginController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Show the super admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return view('auth-module::admin-login');
    }

    /**
     * Handle super admin login request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        
        // Find user first to verify admin status
        $userRepo = app(\Modules\Auth\App\Repositories\UserRepository::class);
        $user = $userRepo->findByEmail($credentials['email']);

        if (!$user || !$user->isAdmin()) {
            LoginActivity::record('admin_login_failed', 'failed', $user?->id, $user?->tenant_id);
            throw ValidationException::withMessages([
                'email' => ['Access denied. This login is reserved for Super Administrators.'],
            ]);
        }

        $this->authService->login($credentials, $request->boolean('remember'));
        
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Logged in as Super Admin.');
    }
}
