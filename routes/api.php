<?php

use App\Models\User;
use App\Modules\Profile\Entities\Activity;
use App\Modules\Robots\Entities\BrokerAccounts;
use App\Modules\Robots\Entities\Product;
use App\Modules\Robots\Entities\ProductKeys;
use App\Modules\Robots\Entities\Subscribe;
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

Route::prefix('v1/telegram')->group(function () {
    Route::post('connect/{hash?}/{telegram_id?}', function (Request $request, $hash = null, $telegram_id = null) {
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
                'user' => [
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
                ]
            ];
        }
    });

    Route::get('list', function () {
        return User::query()
            ->select('telegram_id')
            ->distinct('telegram_id')
            ->get()
            ->pluck('telegram_id');
    });
});

Route::prefix('v1/expert')->group(function () {
    Route::post('identify', function (Request $request)
    {
        if (!$request->has('data')) {
            return base64_encode(json_encode([
                'status' => 0,
                'message' => 'Неправильные входные параметры.'
            ]));
        }

        $data = json_decode(base64_decode($request->input('data')), true);

        if (isset($data['activation_code']) && strlen($data['activation_code']) && !is_null($data['activation_code']) && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $data['activation_code']) !== 1) {
            return base64_encode(json_encode([
                'status' => 0,
                'message' => 'Неправильный формат ключа активации...'
            ]));
        }

        if (!is_null($data['account_number'])) {
            $account = BrokerAccounts::query()
                ->whereAccountNumber($data['account_number'])
                ->where('expires_at', '>', now())
                ->whereDeletedAt(null)
                ->first();

            if (is_null($account)) {
                $account = BrokerAccounts::query()
                    ->whereAccountNumber($data['account_number'])
                    ->delete();

                if (strlen($data['activation_code'])) {
                    $key = ProductKeys::query()
                        ->whereAccountNumber($data['account_number'])
                        ->whereActivationKey($data['activation_code'])
                        ->where('key', $data['ea_name'])
                        ->whereAlreadyActivated(0)
                        ->first();

                    if ($key) {
                        $account = BrokerAccounts::create([
                            'user_id' => $key['user_id'],
                            'account_name' => $data['account_name'],
                            'account_number' => $data['account_number'],
                            'account_company' => $data['account_company'],
                            'ea_name' => $data['ea_name'],
                            'ea_version' => $data['ea_version'],
                            'status' => 1,
                            'expires_at' => now()->parse($key['subscribe']['details']['expired_at'])->format('Y-m-d H:i:s')
                        ]);
                        
                        if ($account) {
                            $key->update([
                                'already_activated' => 1
                            ]);
                        }

                        $product = Product::query()
                            ->where('key', $data['ea_name'])
                            ->where('version', $data['ea_version'])
                            ->first();

                        return base64_encode(json_encode([
                            'account_number' => $account['account_number'],
                            'status' => $account['status'],
                            'support_date_end' => $product['support_date_end'] ?? null,
                            'expires_at' => $account['expires_at']->format('Y-m-d H:i:s'),
                            'activated_at' => $account['created_at']->format('Y-m-d H:i:s'),
                        ]));
                    } else {
                        return base64_encode(json_encode([
                            'status' => 0,
                            'message' => "Ключ активации не соответствует номеру счёта {$data['account_number']}"
                        ]));
                    }
                } else {
                    return base64_encode(json_encode([
                        'status' => 0,
                        'message' => "Ключ активации не найден."
                    ]));
                }

                return base64_encode(json_encode([
                    'status' => 0,
                    'message' => "Номер счёта {$data['account_number']} не зарегистрирован."
                ]));
            }

            $product = Product::query()
                ->where('key', $data['ea_name'])
                ->where('version', $data['ea_version'])
                ->first();

            return base64_encode(json_encode([
                'account_number' => $account['account_number'],
                'status' => $account['status'],
                'support_date_end' => $product['support_date_end'] ?? null,
                'expires_at' => $account['expires_at']->format('Y-m-d H:i:s'),
                'activated_at' => $account['created_at']->format('Y-m-d H:i:s'),
            ]));
        }
    });
});

Route::prefix('v1/subscribes')->group(function () {
    Route::get('users-by-tariff-{tariff}', function (Request $request, $tariff)
    {
        if (!is_null($tariff)) {
            $subscribes = Subscribe::query()
                ->with('user')
                ->where('type', 'subscribe')
                ->where('details->tariff', $tariff)
                ->distinct('user_id')
                ->get()
                ->map(function ($s) {
                    return [
                        'nickname' => $s['user']['nickname'],
                        'telegram_id' => $s['user']['telegram_id'],
                        'expired_at' => $s['details']['expired_at'],
                    ];
                });

            return $subscribes;
        }
    });
});