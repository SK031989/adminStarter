<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\ResetPasswordRequest;
use Modules\Auth\App\Services\PasswordResetService;

class ResetPasswordController extends Controller
{
    public function __construct(protected PasswordResetService $passwordResetService) {}

    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request, ?string $token = null): View
    {
        return view('auth-module::passwords.reset')->with([
            'token' => $token,
            'email' => $request->input('email')
        ]);
    }

    /**
     * Handle the password reset submission.
     */
    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $this->passwordResetService->resetPassword($request->validated());

        return redirect()->route('auth.login')
            ->with('success', 'Your password has been reset successfully. Please log in with your new password.');
    }
}
