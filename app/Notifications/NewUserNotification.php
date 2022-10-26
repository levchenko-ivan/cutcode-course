<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Добро пожаловать!')
                    ->action('Вернуться к нам', url('/'));
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
