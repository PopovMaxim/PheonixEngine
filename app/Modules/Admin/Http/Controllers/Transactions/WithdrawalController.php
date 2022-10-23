<?php

namespace App\Modules\Admin\Http\Controllers\Transactions;

use App\Modules\Refill\Payments\WestWallet\Gateway;
use WestWallet\WestWallet\InsufficientFundsException;
use App\Modules\Withdraw\Entities\Withdraw;
use App\Notifications\WithdrawalSuccessfull;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WithdrawalController extends Controller
{
    public function index()
    {
        $page_name = 'Заявки на выплату';

        $transactions = Withdraw::query()
            ->where([
                'type' => 'withdrawal'
            ])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin::transactions.withdrawal.index')
            ->with([
                'page_name' => $page_name,
                'transactions' => $transactions
            ]);
    }

    public function send(Request $request, $uuid)
    {
        $tx = Withdraw::findOrFail($uuid);

        if ($tx['details']['gateway']['type'] == 'crypto') {
            $this->gateway = new Gateway($tx['details']['gateway']['currency']);
        }

        try {
            $amount = ($tx['amount'] * 0.975) / 100;

            $send = $this->gateway->client->createWithdrawal($tx['details']['gateway']['currency'], $amount, $tx['details']['gateway']['address']);
            
            if ($send) {
                $tx->update([
                    'status' => 'completed'
                ]);

                
                $tx['user']->notify(new WithdrawalSuccessfull("{$amount} USDT"));
            }

            return back()
                ->with('status', [
                    'title' => 'Выплата',
                    'type' => 'success',
                    'text' => 'Выплата успешно исполнена.'
                ]);
        } catch(InsufficientFundsException $e) {
            return back()
                ->with('status', [
                    'title' => 'Выплата',
                    'type' => 'error',
                    'text' => 'Не достаточно средств на кошельке для выплат.'
                ]);
        }
    }
}
