<?php

namespace Modules\Auth\App\Listeners;

use Modules\Auth\App\Events\UserLoggedIn;
use Modules\Auth\App\Events\UserLoggedOut;
use Modules\Auth\App\Events\UserRegistered;

class LogAuthActivity
{
    /**
     * Handle UserRegistered event.
     */
    public function handleRegistered(UserRegistered $event): void
    {
        \Illuminate\Support\Facades\Log::info("New user registered: {$event->user->email} (tenant={$event->user->tenant_id})");
    }

    /**
     * Handle UserLoggedIn event.
     */
    public function handleLoggedIn(UserLoggedIn $event): void
    {
        \Illuminate\Support\Facades\Log::info("User logged in: {$event->user->email} from " . request()->ip());
    }

    /**
     * Handle UserLoggedOut event.
     */
    public function handleLoggedOut(UserLoggedOut $event): void
    {
        \Illuminate\Support\Facades\Log::info("User logged out: {$event->user->email}");
    }
}
