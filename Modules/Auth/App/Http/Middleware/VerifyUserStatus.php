<?php

namespace Modules\Auth\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\App\Enums\UserStatusEnum;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->status !== UserStatusEnum::Active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = match ($user->status) {
                UserStatusEnum::Suspended => 'Your account has been suspended. Please contact support.',
                UserStatusEnum::Inactive  => 'Your account is inactive.',
                UserStatusEnum::Pending   => 'Please verify your email before proceeding.',
                default                   => 'Unauthorized access.',
            };

            return redirect()->route('auth.login')->with('error', $message);
        }

        return $next($request);
    }
}
