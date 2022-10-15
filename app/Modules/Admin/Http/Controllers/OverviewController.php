<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\SupportTickets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Refill\Payments\WestWallet\Gateway as Crypto;
use App\Modules\Robots\Entities\Subscribe;

class OverviewController extends Controller
{
    public function index()
    {
        $users_count = User::count();

        $subscribes_count = Subscribe::query()->where('details->expired_at', '>=', now())->count();
        
        $sells_sum = Subscribe::query()->where('type', 'subscribe')->where('status', 'completed')->sum('amount');

        $tickets_count = SupportTickets::query()->where('status', '<>', 'closed')->count();

        return view('admin::overview.index')
            ->with([
                'sells_sum' => number_format($sells_sum / 100, 2) . ' PX',
                'users_count' => $users_count,
                'tickets_count' => $tickets_count,
                'subscribes_count' => $subscribes_count,
            ]);
    }

    public function westwalletBalance()
    {
        $gateway = new Crypto();

        $balances = $gateway->client->walletBalances();

        return number_format($balances['USDTTRC'], 2);
    }

}
