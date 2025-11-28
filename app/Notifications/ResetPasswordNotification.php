<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $minutes = config(sprintf('auth.passwords.%s.expire', config('auth.defaults.passwords')));

        return (new MailMessage)
            ->subject('Reset Password • Puskesmas Sukaraja')
            ->markdown('emails.password-reset', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'minutes' => $minutes,
            ]);
    }
}
