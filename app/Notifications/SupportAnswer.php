<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportAnswer extends Notification
{
    use Queueable;

    public $ticket_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ответ от тех. поддержки')
            ->greeting("Здравствуйте, {$notifiable['nickname']}!")
            ->line("Вам поступил ответ от технической поддержки.")
            ->action('Перейти к заявке', route('support.show', ['uuid' => $this->ticket_id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'support.answer',
            'text' => "Вам поступил ответ от технической поддержки.",
            'url' => route('support.show', ['uuid' => $this->ticket_id])
        ];
    }
}