<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\SupportTickets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Refill\Payments\WestWallet\Gateway as Crypto;
use App\Modules\Robots\Entities\Subscribe;
use App\Modules\Transactions\Entities\Transaction;
use App\Modules\Withdraw\Entities\Withdraw;

class OverviewController extends Controller
{
    public function index()
    {
        $except_users = User::whereHas("roles", function($q) {
            $q->whereIn("name", ['manager', 'super_admin', 'support']);
        })->get()->pluck('id') ?? [];

        $users_count = User::role('user')->count();

        $withdrawal_sum = Withdraw::query()
            ->whereNotIn('user_id', $except_users)
            ->where([
                'status' => 'pending',
                'type' => 'withdrawal'
            ])
            ->sum('amount') / 100;

        $bonus_sum = Transaction::query()
            ->whereNotIn('user_id', $except_users)
            ->whereNotIn('type', ['withdrawal', 'refill', 'subscribe', 'transfer'])
            ->where('status', 'completed')
            ->sum('amount') / 100;

        $transfer_sum = Transaction::query()
            ->whereNotIn('user_id', $except_users)
            ->where('type', 'transfer')
            ->where('status', 'completed')
            ->where('direction', 'outer')
            ->sum('amount') / 100;

        $actived_subscribes = Subscribe::query()
            ->whereNotIn('user_id', $except_users)
            ->where('type', 'subscribe')
            ->where('status', 'completed')
            ->where('details->expired_at', '>', now()->format('Y-m-d H:i:s'))
            ->count();

        $expired_subscribes = Subscribe::query()
            ->whereNotIn('user_id', $except_users)
            ->where('type', 'subscribe')
            ->where('status', 'completed')
            ->where('details->expired_at', '<=', now()->format('Y-m-d H:i:s'))
            ->count();

        $total_subscribes = Subscribe::query()
            ->whereNotIn('user_id', $except_users)
            ->where('type', 'subscribe')
            ->where('status', 'completed')
            ->count();

        $new_tickets = SupportTickets::query()
            ->whereNotIn('user_id', $except_users)
            ->where('status', 'new')
            ->count();

        $wait_support_tickets = SupportTickets::query()
            ->whereNotIn('user_id', $except_users)
            ->where('status', 'wait_support')
            ->count();

        $wait_user_tickets = SupportTickets::query()
            ->whereNotIn('user_id', $except_users)
            ->where('status', 'wait_user')
            ->count();

        $closed_tickets = SupportTickets::query()
            ->whereNotIn('user_id', $except_users)
            ->where('status', 'closed')
            ->count();

        $top_5_sellers = User::query()
            ->whereHas('transactions', function ($q) {
                return $q
                    ->where('type', 'line_bonus')
                    ->where('details->level', 1);
            })
            /*->withCount([
                'transactions as bonus_sum' => function ($q) {
                    $q->where('type', 'line_bonus')->where('details->level', 1);
                }
            ])*/
            ->withCount([
                'transactions AS bonus_sum' => function ($q) {
                    $q->select(\DB::raw("SUM(amount) as bonus_sum"))->where('type', 'line_bonus')->where('details->level', 1);
                }
            ])
            ->withCount(['transactions as bonus_count' => function ($q) {
                $q->where('type', 'line_bonus')->where('details->level', 1);
            }])
            ->orderBy('bonus_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin::overview.index')
            ->with([
                'users_count' => $users_count,
                'withdrawal_sum' => number_format($withdrawal_sum, 2),
                'bonus_sum' => number_format($bonus_sum, 2),
                'transfer_sum' => number_format($transfer_sum, 2),
                'actived_subscribes' => $actived_subscribes,
                'expired_subscribes' => $expired_subscribes,
                'total_subscribes' => $total_subscribes,
                'new_tickets' => $new_tickets,
                'wait_support_tickets' => $wait_support_tickets,
                'wait_user_tickets' => $wait_user_tickets,
                'closed_tickets' => $closed_tickets,
                'top_5_sellers' => $top_5_sellers,
            ]);
    }

    public function westwalletBalance()
    {
        $gateway = new Crypto();

        $balances = $gateway->client->walletBalances();

        return number_format($balances['USDTTRC'], 2);
    }

}
