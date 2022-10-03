<?php

namespace App\Modules\Transfer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \App\Modules\Transactions\Entities\Transaction;
use App\Modules\Transfer\Entities\Transfer;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $transfers = Transfer::query()
            ->whereType('transfer')
            ->where('user_id', $request->user()->id)
            ->paginate();

        return view('transfer::index')
            ->with([
                'transfers' => $transfers
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
            }]
        ], [
            'account_number.required' => 'Введите номер лицевого счёта получателя.',
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

        $batch_id = md5($user['email'] . $request->user()->email . now()->timestamp);

        $result = Transaction::insert([[
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

        if ($result)
        {
            return back()
                ->with('request_status', [
                    'type' => 'success',
                    'text' => 'Перевод успешно осуществлён.'
                ]);
        }

        return back()
            ->with('request_status', [
                'type' => 'danger',
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
