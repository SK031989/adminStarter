<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Models\User;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function showNotice(Request $request): View|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(config('auth-module.redirects.verified', '/dashboard'))
            : view('auth-module::verify');
    }

    /**
     * Verify the email.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('auth-module.redirects.verified', '/dashboard') . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return redirect()->intended(config('auth-module.redirects.verified', '/dashboard') . '?verified=1')
            ->with('success', 'Your email has been verified!');
    }

    /**
     * Resend verification email notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('auth-module.redirects.verified', '/dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A fresh verification link has been sent to your email address.');
    }
}
