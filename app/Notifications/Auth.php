<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use hisorange\BrowserDetect\Parser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Auth extends Notification implements ShouldQueue
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
    public function toArray(Request $request, $notifiable)
    {
        $detector = new Parser(null, null);
        $agentString = $_GET['agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Missing';
        $result = $detector->parse($agentString);
        
        return [
            'type' => 'auth',
            'text' => $agentString
        ];
    }

    public function viaQueues()
    {
        return [
            'database' => 'mail',
        ];
    }
}
