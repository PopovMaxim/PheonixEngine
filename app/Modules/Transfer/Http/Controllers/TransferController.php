<?php

namespace App\Modules\Transfer\Http\Controllers;

use App\Models\ConfirmCodes;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \App\Modules\Transactions\Entities\Transaction;
use App\Modules\Transfer\Entities\Transfer;
use App\Notifications\ConfirmCode;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $transfers = Transfer::query()
            ->whereType('transfer')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        $code = ConfirmCodes::query()->where('details->type', 'transfer')->where('details->expired_at', '>', now()->format('Y-m-d H:i:s'))->where('user_id', $request->user()->id)->first();

        return view('transfer::index')
            ->with([
                'transfers' => $transfers,
                'code' => $code
            ]);
    }

    public function read(Request $request, $uuid)
    {
        $breadcrumbs = [
            [
                'title' => 'Переводы',
                'url' => route('transfer')
            ],
            [
                'title' => 'Детали перевода',
                'active' => true
            ],
        ];

        if (!is_null($uuid)) {
            $tx = Transfer::query()
                ->whereId($uuid)
                ->where([
                    'user_id' => $request->user()->id,
                ])->first();
        } else {
            $tx = Transfer::query()
                ->where([
                    'user_id' => $request->user()->id,
                    'type' => 'transfer',
                ])->first();
        }

        return view('transfer::read', [
            'breadcrumbs' => $breadcrumbs,
            'tx' => $tx
        ]);
    }

    public function send(Request $request)
    {
        if ($request->has('send_confirm_code')) {
            $code = ConfirmCodes::query()->where('details->type', 'transfer')->where('details->expired_at', '>', now()->format('Y-m-d H:i:s'))->where('user_id', $request->user()->id)->first();

            if (is_null($code)) {
                ConfirmCodes::query()->where('user_id', $request->user()->id)->where('details->type', 'transfer')->delete();

                $user = $request->user();

                dispatch(function () use ($user) {
                    $random_code = rand(100000, 999999);

                    ConfirmCodes::create([
                        'details' => [
                            'type' => 'transfer',
                            'expired_at' => now()->addSeconds(90)->format('Y-m-d H:i:s')
                        ],
                        'code' => $random_code,
                        'user_id' => $user['id']
                    ]);

                    $user->notify(new ConfirmCode($random_code));
                })->onQueue('mail');

                return back()
                    ->withInput()
                    ->with('status', [
                        'title' => 'Код подтверждения',
                        'type' => 'success',
                        'text' => "Код подтверждения выслан на Вашу электронную почту."
                    ]);
            }
            
            $time = now()->diffInSeconds($code['details']['expired_at']);

            return back()
                ->with('status', [
                    'title' => 'Код подтверждения',
                    'type' => 'error',
                    'text' => "До повторного запроса кода подтверждения осталось: {$time} сек."
                ]);
        }

        $validator = \Validator::make($request->all(), [
            'account_number' => ['required', function ($attribute, $value, $fail) use ($request) {
                if (!\DB::table('users')->whereRaw("lower({$attribute}) = lower(?)", [$value])->count())
                {
                    $fail('Участник с указанным номером лицевого счёта не найден.');
                }
            }],
            'amount' => ['required', function ($attribute, $value, $fail) use ($request) {
                $amount = intval(str_replace([',', '.'], '', $value));
                
                if ($request->user()->raw_balance < $amount)
                {
                    $fail('У Вас недостаточно средств на лицевом счёте.');
                }
            }],
            'confirm_code' => ['required', function ($attribute, $value, $fail) use ($request) {
                if (!ConfirmCodes::query()->where('user_id', $request->user()->id)->where('code', $value)->where('details->expired_at', '>', now()->format('Y-m-d H:i:s'))->count())
                {
                    $fail('Неправильный код подтверждения.');
                }
            }]
        ], [
            'account_number.required' => 'Введите номер лицевого счёта получателя.',
            'confirm_code.required' => 'Вы должны ввести код подтверждения.',
            'amount.required' => 'Введите сумму перевода.',
        ]);

        if ($validator->fails())
        {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $amount = intval(str_replace([',', '.'], '', $request->input('amount')));

        $user = \App\Models\User::query()
            ->whereAccountNumber($request->input('account_number'))
            ->first();

        if ($user['id'] != $request->user()->id) {
            $batch_id = md5($user['email'] . $request->user()->email . now()->timestamp);

            Transaction::insert([[
                'id' => \Str::uuid(),
                'user_id' => $request->user()->id,
                'direction' => 'outer',
                'amount' => $amount,
                'type' => 'transfer',
                'status' => 'completed',
                'batch_id' => $batch_id,
                'details' => json_encode([
                    'sender' => $request->user()->id,
                    'receiver' => $user['id'],
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => \Str::uuid(),
                'user_id' => $user['id'],
                'direction' => 'inner',
                'amount' => $amount,
                'type' => 'transfer',
                'status' => 'completed',
                'batch_id' => $batch_id,
                'details' => json_encode([
                    'sender' => $request->user()->id,
                    'receiver' => $user['id'],
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]]);

            ConfirmCodes::query()->where('user_id', $request->user()->id)->where('details->type', 'transfer')->delete();

            return back()
                ->with('status', [
                    'type' => 'success',
                    'title' => 'Перевод',
                    'text' => 'Перевод успешно осуществлён.'
                ]);
        }

        return back()
            ->with('status', [
                'type' => 'error',
                'title' => 'Перевод',
                'text' => 'Не удалось осуществить перевод. Попробуйте позже, если проблема не исчезнет, то обратитесь в техническую поддержку. Код ошибки: TRANSFER-0001'
            ]);
    }

    public function generateAccountNumber(Request $request)
    {
        if (!$request->user()->account_number)
        {
            $result = $request->user()->update([
                'account_number' => $request->user()->generateAccountNumber()
            ]);

            if ($result)
            {
                return back();
            }
        }
    }
}
