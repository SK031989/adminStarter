<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\App\Services\AuthService;

class LoginController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Show the login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->intended(config('auth-module.redirects.login', '/dashboard'));
        }

        return view('auth-module::login');
    }

    /**
     * Handle login form submission.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        
        $userRepo = app(\Modules\Auth\App\Repositories\UserRepository::class);
        $user = $userRepo->findByEmail($credentials['email']);

        if ($user && $user->isAdmin()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Super Administrators must log in through the admin route.'],
            ]);
        }

        $authenticatedUser = $this->authService->login($credentials, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(config('auth-module.redirects.login', '/dashboard'))
            ->with('success', "Welcome back, {$authenticatedUser->first_name}!");
    }
}
