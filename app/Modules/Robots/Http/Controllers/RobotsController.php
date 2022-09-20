<?php

namespace App\Modules\Robots\Http\Controllers;

use App\Models\User;
use App\Modules\Robots\Entities\BrokerAccounts;
use App\Modules\Robots\Entities\ProductKeys;
use App\Modules\Robots\Entities\Subscribe;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class RobotsController extends Controller
{
    public function index(Request $request)
    {
        $tariffs = Tariff::$tariffs;
        $subscribes = $request->user()->transactions()->whereType('subscribe')->orderBy('created_at', 'desc')->paginate(5);

        return view('robots::index')
            ->with([
                'tariffs' => $tariffs,
                'subscribes' => $subscribes
            ]);
    }

    public function read(Request $request, $uuid)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'account_number' => ['required', 'numeric', function ($attribute, $value, $fail) use ($request) {
                    $response = Http::get("https://my.roboforex.com/api/partners/tree", [
                        'account_id' => '30211061',
                        'api_key' => '125ca979b1ef27e6',
                        'referral_account_id' => $request->input('account_number')
                    ]);
        
                    $data = (string) $response;
                    
                    if (strstr($data, 'Not found account')) {
                        $fail('Указанный номер счёта не найден в партнёрской сети.');
                    }
                }],
                'accept' => 'accepted',
            ], [
                'required' => 'Вы не ввели номер счёта.',
                'numeric' => 'Неправильный формат номера счёта.',
            ]);

            ProductKeys::create([
                'user_id' => $request->user()->id,
                'account_number' => $request->input('account_number'),
                'activation_key' => \Str::uuid(),
                'subscribe_id' => $uuid
            ]);
        }

        $subscribe = Subscribe::find($uuid);
        $subscribe->productKey()->associate(ProductKeys::query()->whereSubscribeId($uuid)->first());

        $account_number = null;

        if (!is_null($subscribe->productKey)) {
            $account_number = BrokerAccounts::query()
                ->whereUserId($request->user()->id)
                ->whereAccountNumber($subscribe->productKey['account_number'])
                ->first();
        }

        return view('robots::read')
            ->with([
                'subscribe' => $subscribe,
                'account_number' => $account_number
            ]);
    }
}
