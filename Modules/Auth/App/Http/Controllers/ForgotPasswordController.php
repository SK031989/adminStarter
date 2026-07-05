<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\App\Services\PasswordResetService;

class ForgotPasswordController extends Controller
{
    public function __construct(protected PasswordResetService $passwordResetService) {}

    /**
     * Show the forgot password form.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth-module::passwords.email');
    }

    /**
     * Handle the request to send reset link.
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request): RedirectResponse
    {
        $this->passwordResetService->sendResetLink($request->input('email'));

        return back()->with('success', 'If your email is registered with us, we have sent you a password reset link.');
    }
}
