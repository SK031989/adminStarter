<?php

namespace Modules\Auth\App\Observers;

use Illuminate\Support\Facades\Log;
use Modules\Auth\App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        Log::info("UserObserver: new user created [{$user->email}] tenant={$user->tenant_id}");
    }

    public function updated(User $user): void
    {
        $dirty = array_keys($user->getDirty());

        // Don't log password changes in plaintext
        if (in_array('password', $dirty)) {
            Log::info("UserObserver: user [{$user->email}] changed password.");
            return;
        }

        Log::info("UserObserver: user [{$user->email}] updated fields: " . implode(', ', $dirty));
    }

    public function deleting(User $user): void
    {
        Log::warning("UserObserver: user [{$user->email}] is being deleted (id={$user->id}).");
    }

    public function deleted(User $user): void
    {
        Log::info("UserObserver: user [{$user->email}] soft-deleted.");
    }

    public function restored(User $user): void
    {
        Log::info("UserObserver: user [{$user->email}] restored.");
    }
}
