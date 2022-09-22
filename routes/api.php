<?php

use App\Models\User;
use App\Modules\Profile\Entities\Activity;
use App\Modules\Robots\Entities\BrokerAccounts;
use App\Modules\Robots\Entities\Product;
use App\Modules\Robots\Entities\ProductKeys;
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

Route::get('test', function (Request $request) {
    return base64_encode(json_encode([
        'account_name' => 'Test',
        'account_number' => '21325839',
        'account_company' => 'Roboforex',
        'ea_name' => 'PHEONIX_INSIDER',
        'ea_version' => '1.0',
        'activation_code' => '53ccaaec-090b-400a-9c70-79f1225e9019'
    ]));
});

Route::prefix('v1/expert')->group(function () {
    Route::get('identify', function (Request $request)
    {
        //$data = 'eyJhY2NvdW50X25hbWUiOiJUZXN0IiwiYWNjb3VudF9udW1iZXIiOiIyMTMyNTgzOSIsImFjY291bnRfY29tcGFueSI6IlJvYm9mb3JleCIsImVhX25hbWUiOiJQSEVPTklYX0lOU0lERVIiLCJlYV92ZXJzaW9uIjoiMS4wIiwiYWN0aXZhdGlvbl9jb2RlIjoiNTNjY2FhZWMtMDkwYi00MDBhLTljNzAtNzlmMTIyNWU5MDE5In0=';

        if (!$request->has('data')) {
            return [
                'status' => 0,
                'message' => 'Empty Data...'
            ];
        }

        $data = json_decode(base64_decode($request->input('data')), true);

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

                if (!is_null($data['activation_code'])) {
                    $key = ProductKeys::query()
                        ->whereAccountNumber($data['account_number'])
                        ->whereActivationKey($data['activation_code'])
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
                            'expires_at' => now()->parse($key->subscribe['details']['expired_at'])->format('Y-m-d H:i:s')
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

                        return [
                            'account_number' => $account['account_number'],
                            'status' => $account['status'],
                            'support_date_end' => $product['support_date_end'] ?? null,
                            'expires_at' => $account['expires_at']
                        ];
                    }
                } else {
                    return [
                        'status' => 0,
                        'message' => "Ключ активации не найден или не соответствует номеру счёта {$data['account_number']}."
                    ];
                }

                return [
                    'status' => 0,
                    'message' => "Номер счёта {$data['account_number']} не зарегистрирован."
                ];
            }

            $product = Product::query()
                ->where('key', $data['ea_name'])
                ->where('version', $data['ea_version'])
                ->first();

            return [
                'account_number' => $account['account_number'],
                'status' => $account['status'],
                'support_date_end' => $product['support_date_end'] ?? null,
                'expires_at' => $account['expires_at']
            ];
        }
    });
});