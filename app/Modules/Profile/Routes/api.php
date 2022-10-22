<?php

use App\Models\User;
use Illuminate\Http\Request;

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
    Route::post('profile/balance', function (Request $request) {
        $user = User::query()->where('telegram_id', $request->input('telegram_id'))->first();

        if ($user) {
            return $user['formatted_balance'];
        }

        return [];
    });

    Route::post('profile', function (Request $request) {
        $user = User::query()->where('telegram_id', $request->input('telegram_id'))->first();

        if ($user) {
            return [
                'email' => $user['email'],
                'nickname' => $user['nickname'],
                'balance' => $user['formatted_balance'],
                'lastname' => $user['lastname'],
                'firstname' => $user['firstname'],
                'account_number' => $user['account_number'],
                'last_active_at' => $user['last_active_at'],
                'created_at' => $user['created_at'],
                'country' => $user['country'],
                'city' => $user['city'],
                'partners' => $user['partners']
            ];
        }

        return [];
    });
    
    Route::post('profile/invite-links', function (Request $request) {
        $user = User::query()->where('telegram_id', $request->input('telegram_id'))->first();

        if ($user) {
            return [
                'common' => $user['referral_link'],
                'left' => $user['referral_link'] . '/left',
                'right' => $user['referral_link'] . '/right',
            ];
        }

        return [];
    });
    
    Route::post('profile/update-register-side', function (Request $request) {
        $user = User::query()->where('telegram_id', $request->input('telegram_id'))->first();

        $available = [
            'left',
            'right',
            'sponsor'
        ];
        
        if (!in_array($request->input('side'), $available)) {
            return [];
        }

        if ($user) {
            $user->updateRegisterSide($request->input('side'), null, $user['id'], $request->ip());

            return [
                'state' => 'success'
            ];
        }

        return [];
    });
    
    Route::post('profile/current-register-side', function (Request $request) {
        $user = User::query()->where('telegram_id', $request->input('telegram_id'))->first();

        if ($user) {
            $side = $user['partners_register_side'];

            if (is_null($side))
            {
                return [
                    'side' => 'sponsor'
                ];
            }
            
            return [
                'side' => $side
            ];
        }

        return [];
    });
});