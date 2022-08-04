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
        $user = User::find($request->input('user_id'));

        if ($user) {
            return $user['formatted_balance'];
        }

        return [];
    });
});

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('profile/invite-links', function (Request $request) {
        $user = User::find($request->input('user_id'));

        if ($user) {
            return [
                'common' => $user['referral_link'],
                'left' => $user['referral_link'] . '/left',
                'right' => $user['referral_link'] . '/right',
            ];
        }

        return [];
    });
});

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('profile/update-register-side', function (Request $request) {
        $user = User::find($request->input('user_id'));

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
});

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('test', function (Request $request) {
        return $request->all();
    });
});