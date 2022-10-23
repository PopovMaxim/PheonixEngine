<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toTelegram($notifiable);

        if (!is_null($notifiable['telegram_id'])) {
            $notification = (array) $notification;

            try {
                Http::withHeaders(config('telegram.headers'))->post(config('telegram.url'), [
                    'chat_id' => $notifiable['telegram_id'],
                    'message' => $data['message'],
                ]);
            } catch (\Exception $e) {
                \Log::info(json_encode($e));
            }
        }
    }
}