<?php

namespace Modules\Auth\App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Modules\Auth\App\Events\UserLoggedIn;
use Modules\Auth\App\Events\UserLoggedOut;
use Modules\Auth\App\Models\LoginActivity;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Repositories\UserRepository;

class AuthService
{
    public function __construct(protected UserRepository $userRepo) {}

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    /**
     * Attempt to authenticate the user.
     *
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false): User
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (!$user || !Auth::attempt($credentials, $remember)) {
            LoginActivity::record('login_failed', 'failed', $user?->id, $user?->tenant_id);

            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        if ($user->isSuspended()) {
            Auth::logout();
            LoginActivity::record('login_suspended', 'denied', $user->id, $user->tenant_id);

            throw ValidationException::withMessages([
                'email' => ['Your account has been suspended. Please contact support.'],
            ]);
        }

        // Record login metadata
        $user->recordLogin(request()->ip());

        // Log activity
        LoginActivity::record('login', 'success', $user->id, $user->tenant_id);

        // Fire event
        Event::dispatch(new UserLoggedIn($user));

        return $user;
    }

    // -------------------------------------------------------------------------
    // Logout
    // -------------------------------------------------------------------------

    public function logout(): void
    {
        $user = auth()->user();

        if ($user) {
            LoginActivity::record('logout', 'success', $user->id, $user->tenant_id);
            Event::dispatch(new UserLoggedOut($user));
        }

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    // -------------------------------------------------------------------------
    // Token (API)
    // -------------------------------------------------------------------------

    /**
     * Authenticate for API and return a Sanctum token.
     *
     * @throws ValidationException
     */
    public function loginApi(array $credentials, string $deviceName = 'API'): string
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        if ($user->isSuspended()) {
            throw ValidationException::withMessages([
                'email' => ['Account suspended.'],
            ]);
        }

        $user->recordLogin(request()->ip());
        LoginActivity::record('api_login', 'success', $user->id, $user->tenant_id);

        return $user->createToken($deviceName)->plainTextToken;
    }

    /**
     * Revoke the current API token.
     */
    public function logoutApi(User $user): void
    {
        $user->currentAccessToken()->delete();
        LoginActivity::record('api_logout', 'success', $user->id, $user->tenant_id);
    }
}
