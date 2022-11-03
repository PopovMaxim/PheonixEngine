<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Modules\Notifications\Entities\Notification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('notifications', function (Request $request) {
        $order = 'desc';

        if ($request->has('reverse') && $request->input('reverse'))
        {
            $order = 'asc';
        }

        $read_state = $request->input('read_state');

        $user = User::query()
            ->where('telegram_id', $request->input('telegram_id'))
            ->first();

        $limit = 10;

        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }

        if ($user) {
            $notifications = Notification::query()
                ->select(['id', 'notifiable_id as user_id', 'data', 'read_at', 'created_at'])
                ->where('notifiable_id', $user['id'])
                ->where('notifiable_type', 'App\Models\User')
                ->orderBy('created_at', $order)
                ->when($read_state, function ($query, $read_state)
                {
                    if ($read_state)
                    {
                        $query->whereNotNull('read_at');
                    }
                    else if (!$read_state)
                    {
                        $query->whereNull('read_at');
                    }
                })
                ->limit($limit)
                ->get();
        }

        return $notifications;
    });
});