<?php

namespace App\Modules\Notifications\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->unreadNotifications()->paginate(15);

        return view('notifications::index')
            ->with([
                'notifications' => $notifications
            ]);
    }

    public function noty(Request $request)
    {
        $request->user()->notify(new \App\Notifications\Register);
        $request->user()->notify(new \App\Notifications\Auth);
        $request->user()->notify(new \App\Notifications\AddToBinary);
        $request->user()->notify(new \App\Notifications\SettingsUpdate);
        $request->user()->notify(new \App\Notifications\RegisterPartner);
        $request->user()->notify(new \App\Notifications\TransferReceived);
        $request->user()->notify(new \App\Notifications\TransferSuccessfull);
        $request->user()->notify(new \App\Notifications\WithdrawalSuccessfull);
        $request->user()->notify(new \App\Notifications\RefillSuccessfull);
    }

    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()
            ->with('status', [
                'title' => 'Успешно',
                'type' => 'success',
                'text' => 'Все уведомления помечены как прочитанные.'
            ]);
    }

    public function readed(Request $request)
    {
        $notifications = $request->user()->notifications()->whereNotNull('read_at')->paginate(15);

        return view('notifications::index')
            ->with([
                'notifications' => $notifications
            ]);
    }
}
