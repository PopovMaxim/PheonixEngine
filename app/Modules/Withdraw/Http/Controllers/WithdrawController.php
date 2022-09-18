<?php

namespace App\Modules\Withdraw\Http\Controllers;

use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $withdraw_request = $request
            ->user()
            ->transactions()
            ->whereType('withdrawal')
            ->whereStatus('pending')
            ->first();

        return view('withdraw::index')
            ->with([
                'withdraw_request' => $withdraw_request
            ]);
    }

    public function request(Request $request)
    {
        $withdraw_request = $request
            ->user()
            ->transactions()
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
            }]
        ], [
            'amount.required' => 'Введите сумму.',
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
