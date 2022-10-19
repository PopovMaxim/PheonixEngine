<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Mailing extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $text;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $text)
    {
        $this->subject = $subject;
        $this->text = $text;
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
            ->subject($this->subject)
            ->greeting("Здравствуйте, {$notifiable['nickname']}!")
            ->line($this->text);
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
            'type' => 'mailing',
            'text' => $this->text,
        ];
    }

    public function viaQueues()
    {
        return [
            'mail' => 'mail',
            'database' => 'mail',
        ];
    }
}