<?php

namespace Modules\Auth\App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Repositories\UserRepository;

class ProfileService
{
    public function __construct(protected UserRepository $userRepo) {}

    /**
     * Update user profile information.
     */
    public function updateProfile(User $user, array $data): User
    {
        $payload = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ];

        // If email changed, reset verification
        if ($user->email !== $data['email']) {
            $payload['email_verified_at'] = null;
        }

        // Handle avatar upload
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $payload['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        return $this->userRepo->update($user, $payload);
    }

    /**
     * Delete user avatar.
     */
    public function deleteAvatar(User $user): User
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return $user->fresh();
    }

    /**
     * Delete the user's account (soft delete).
     */
    public function deleteAccount(User $user, string $password): bool
    {
        if (!Hash::check($password, $user->password)) {
            throw new \Illuminate\Validation\ValidationException(
                \Illuminate\Validation\Validator::make([], []),
            );
        }

        return $this->userRepo->delete($user);
    }
}
