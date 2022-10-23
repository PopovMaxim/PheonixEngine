<?php

namespace App\Notifications;

use App\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalSuccessfull extends Notification implements ShouldQueue
{
    use Queueable;

    public $id;
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
        return ['database', TelegramChannel::class];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'type' => 'withdrawal.successfull',
            'text' => "Выплата на сумму {$this->sum} успешно исполнена."
        ];
    }

    public function toTelegram($notifiable)
    {
        return [
            'message' => "Выплата на сумму {$this->sum} успешно исполнена."
        ];
    }
    
    public function viaQueues()
    {
        return [
            'database' => 'mail',
            TelegramChannel::class => 'mail',
        ];
    }
}
