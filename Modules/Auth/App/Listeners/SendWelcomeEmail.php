<?php

namespace Modules\Auth\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Auth\App\Events\UserRegistered;
use Modules\Auth\App\Jobs\SendVerificationEmailJob;
use Modules\Auth\App\Jobs\SendWelcomeEmailJob;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'auth-notifications';

    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        // Send welcome email
        SendWelcomeEmailJob::dispatch($user)
            ->onQueue(config('auth-module.queue_name', 'auth-notifications'));

        // Send email verification if required
        if (config('auth-module.registration.email_verification', true)) {
            SendVerificationEmailJob::dispatch($user)
                ->onQueue(config('auth-module.queue_name', 'auth-notifications'));
        }
    }

    public function failed(UserRegistered $event, \Throwable $exception): void
    {
        \Illuminate\Support\Facades\Log::error('SendWelcomeEmail listener failed', [
            'user'  => $event->user->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
