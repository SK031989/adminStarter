<?php

namespace Modules\Auth\App\Policies;

use Modules\Auth\App\Models\User;

class UserPolicy
{
    /**
     * Admins can do everything.
     */
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'users.view');
    }

    public function view(User $user, User $target): bool
    {
        return $user->id === $target->id
            || $this->hasPermission($user, 'users.view');
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'users.create');
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id
            || $this->hasPermission($user, 'users.update');
    }

    public function delete(User $user, User $target): bool
    {
        // Can't delete yourself
        if ($user->id === $target->id) {
            return false;
        }
        return $this->hasPermission($user, 'users.delete');
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    private function hasPermission(User $user, string $permission): bool
    {
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission);
        }
        return $user->isAdmin();
    }
}
