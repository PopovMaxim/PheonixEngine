<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use hisorange\BrowserDetect\Parser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmCode extends Notification implements ShouldQueue
{
    use Queueable;

    public $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $detector = new Parser(null, null);
        $agentString = $_GET['agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Missing';
        $result = $detector->parse($agentString);

        $mail = (new MailMessage)
            ->subject('Код подтверждения')
            ->greeting("Здравствуйте, {$notifiable['nickname']}!")
            ->line("Ваш код подтверждения: <b>{$this->code}</b>")
            ->line('Вы получили это сообщение так как запросили код подтверждения для совершения операции в личном кабинете '.env('APP_NAME').'. Если Вы не запрашивали код подтверждения, то, обязательно обратитесь в техническую поддержку.');

        if ($result && $agentString != 'Missing') {
            $mail = $mail->line('Устройство: ' . $result->userAgent());
        }

        return $mail;
    }

    public function viaQueues()
    {
        return [
            'mail' => 'mail',
        ];
    }
}
