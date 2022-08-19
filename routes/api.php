<?php

use App\Models\User;
use App\Modules\Profile\Entities\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/v1/telegram/connect/{hash?}/{telegram_id?}', function (Request $request, $hash = null, $telegram_id = null) {
    if (is_null($hash))
    {
        return [
            'status' => 'error',
            'message' => 'Не указан hash пользователя.',
        ];
    }
    
    if (is_null($telegram_id))
    {
        return [
            'status' => 'error',
            'message' => 'Не указан telegram_id пользователя.',
        ];
    }

    $user = User::query()
        ->where('hash', $hash)
        ->first();

    if (is_null($user))
    {
        return [
            'status' => 'error',
            'message' => "Пользователь с переданным значением hash не распознан.",
        ];
    }

    $save = $user->update([
        'telegram_id' => $telegram_id
    ]);

    if ($save)
    {
        Activity::storeActionByUserId('telegram_connected', $user['id'], $request->ip());

        return [
            'status' => 'success',
            'message' => "Профиль Telegram успешно подключен.",
        ];
    }
});
