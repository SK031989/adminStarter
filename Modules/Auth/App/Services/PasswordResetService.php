<?php

namespace Modules\Auth\App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Modules\Auth\App\Models\LoginActivity;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Repositories\UserRepository;

class PasswordResetService
{
    public function __construct(protected UserRepository $userRepo) {}

    // -------------------------------------------------------------------------
    // Forgot Password — send reset link
    // -------------------------------------------------------------------------

    /**
     * Send a password reset link to the given email.
     *
     * @throws ValidationException
     */
    public function sendResetLink(string $email): void
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            LoginActivity::record('password_reset_requested', 'success');
            return;
        }

        // Silently succeed even for unknown emails (security best-practice)
        // But log internally if the user was not found
        if ($status === Password::INVALID_USER) {
            \Illuminate\Support\Facades\Log::info("Password reset for unknown email: {$email}");
        }
    }

    // -------------------------------------------------------------------------
    // Reset Password
    // -------------------------------------------------------------------------

    /**
     * Reset the user's password using the provided token.
     *
     * @throws ValidationException
     */
    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $this->userRepo->updatePassword($user, Hash::make($password));

                LoginActivity::record('password_reset', 'success', $user->id, $user->tenant_id);

                \Illuminate\Support\Facades\Event::dispatch(
                    new \Illuminate\Auth\Events\PasswordReset($user)
                );
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // Change Password (authenticated)
    // -------------------------------------------------------------------------

    /**
     * Change password for an authenticated user.
     *
     * @throws ValidationException
     */
    public function changePassword(User $user, string $current, string $newPassword): void
    {
        if (!Hash::check($current, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $this->userRepo->updatePassword($user, Hash::make($newPassword));

        LoginActivity::record('password_changed', 'success', $user->id, $user->tenant_id);
    }
}
