<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefillSuccessfull extends Notification
{
    use Queueable;

    public $sum;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sum)
    {
        $this->sum = $sum;
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
            ->greeting("Здравствуйте, {$notifiable['nickname']}!")
            ->line("Баланс учётной записи успешно пополнен на {$this->sum}");
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
            'type' => 'refill.successfull',
            'text' => "Баланс учётной записи успешно пополнен на {$this->sum}."
        ];
    }
}