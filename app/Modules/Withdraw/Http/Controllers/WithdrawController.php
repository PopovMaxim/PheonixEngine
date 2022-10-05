<?php

namespace App\Modules\Withdraw\Http\Controllers;

use App\Modules\Transactions\Entities\Transaction;
use App\Modules\Refill\Payments\WestWallet\Gateway as Crypto;
use App\Modules\Withdraw\Entities\Withdraw;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WithdrawController extends Controller
{
    public $gateway = null;

    public function index(Request $request)
    {
        $withdraw_request = Withdraw::query()
            ->where('user_id', $request->user()->id)
            ->whereType('withdrawal')
            ->whereStatus('pending')
            ->first();

        if ($withdraw_request) {
            $this->gateway = new Crypto($withdraw_request['details']['gateway']['currency']);
        }

        $withdrawals = Withdraw::query()
            ->whereType('withdrawal')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    

        return view('withdraw::index')
            ->with([
                'withdrawals' => $withdrawals,
                'gateway' => $this->gateway,
                'withdraw_request' => $withdraw_request,
            ]);
    }

    public function read(Request $request, $uuid)
    {
        $breadcrumbs = [
            [
                'title' => 'Вывод',
                'url' => route('withdraw')
            ],
            [
                'title' => 'Детали вывода',
                'active' => true
            ],
        ];
        if (!is_null($uuid)) {
            $tx = Withdraw::query()
                ->whereId($uuid)
                ->where([
                    'type' => 'withdrawal',
                    'user_id' => $request->user()->id,
                ])->first();
        } else {
            $tx = Withdraw::query()
                ->where([
                    'type' => 'withdrawal',
                    'user_id' => $request->user()->id,
                ])->first();
        }
        
        $this->gateway = new Crypto($tx['details']['gateway']['currency']);

        return view('withdraw::read', [
            'breadcrumbs' => $breadcrumbs,
            'gateway' => $this->gateway,
            'tx' => $tx
        ]);
    }

    public function request(Request $request)
    {
        $withdraw_request = Withdraw::query()
            ->where('user_id', $request->user()->id)
            ->whereType('withdrawal')
            ->whereStatus('pending')
            ->first();

        if ($withdraw_request) {
            return back();
        }

        $validator = \Validator::make($request->all(), [
            'amount' => ['required', function ($attribute, $value, $fail) use ($request) {
                $amount = intval(str_replace([',', '.'], '', $value));
                
                if ($request->user()->raw_balance < $amount)
                {
                    $fail('У Вас недостаточно средств на лицевом счёте.');
                }
            }],
            'address' => 'required|regex:/^[T][a-km-zA-HJ-NP-Z1-9]{25,34}$/i'
        ], [
            'address.required' => 'Вы не ввели адрес криптокошелька.',
            'amount.required' => 'Вы не ввели сумму вывода.',
        ]);

        if ($validator->fails())
        {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $amount = intval(str_replace([',', '.'], '', $request->input('amount')));

        $withdraw = Transaction::create([
            'user_id' => $request->user()->id,
            'type' => 'withdrawal',
            'amount' => $amount,
            'direction' => 'outer',
            'status' => 'pending',
            'details' => [
                'gateway' => [
                    'type' => 'crypto',
                    'currency' => 'USDTTRC',
                    'address' => $request->input('address')
                ]
            ]
        ]);

        return back();
    }

    public function cancel(Request $request)
    {
        $request
            ->user()
            ->transactions()
            ->whereType('withdrawal')
            ->whereStatus('pending')
            ->update([
                'status' => 'canceled'
            ]);

        return back();
    }
}
