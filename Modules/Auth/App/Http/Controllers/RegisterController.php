<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\RegisterRequest;
use Modules\Auth\App\Services\RegistrationService;

class RegisterController extends Controller
{
    public function __construct(protected RegistrationService $registrationService) {}

    /**
     * Show the registration form.
     */
    public function showRegistrationForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect(config('auth-module.redirects.register', '/dashboard'));
        }

        return view('auth-module::register');
    }

    /**
     * Handle registration form submission.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->registrationService->register($request->validated());

        // Auto-login after registration
        if (config('auth-module.registration.auto_login', true)) {
            auth()->login($user);
        }

        $redirect = config('auth-module.registration.email_verification', true)
            ? route('auth.verify.notice')
            : config('auth-module.redirects.register', '/dashboard');

        return redirect($redirect)
            ->with('success', 'Your account has been created successfully! Welcome aboard.');
    }
}
