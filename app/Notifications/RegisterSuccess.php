<?php

namespace App\Notifications;

use App\Models\TemporaryToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterSuccess extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        TemporaryToken::where('type', 1)->where('user_id', $notifiable->id)->delete();
        $token = new TemporaryToken();
        $token->user_id = $notifiable->id;
        $token->type = 1;
        $token->token = sha1($notifiable->id . now());
        $token->save();
        $url = config('app.front_url') . '/verify/' . $token->token;
        return (new MailMessage)
            ->subject(__('notifications.register_success_subject'))
            ->line(__('notifications.register_success'))
            ->action(__('interface.verify_email'), $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return arrayut
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
