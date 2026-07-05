<?php

namespace Modules\Auth\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Auth\App\Models\User;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly User $user) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name') . '!')
            ->greeting("Hello {$this->user->first_name}!")
            ->line('Thank you for registering. Your account has been created successfully.')
            ->line('You are now part of our SaaS platform. Here is what you can do next:')
            ->action('Go to Dashboard', url(config('auth-module.redirects.register', '/dashboard')))
            ->line('If you have any questions, feel free to reply to this email.')
            ->salutation('The ' . config('app.name') . ' Team');
    }
}
