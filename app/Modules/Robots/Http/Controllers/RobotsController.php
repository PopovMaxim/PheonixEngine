<?php

namespace App\Modules\Robots\Http\Controllers;

use App\Models\User;
use App\Modules\Robots\Entities\BrokerAccounts;
use App\Modules\Robots\Entities\ProductKeys;
use App\Modules\Robots\Entities\Subscribe;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Tariffs\Entities\TariffLines;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class RobotsController extends Controller
{
    public function index(Request $request)
    {
        $tariffs = Tariff::query()->get()->keyBy('id');
        $subscribes = $request->user()->transactions()->whereType('subscribe')->orderBy('created_at', 'desc')->paginate(5);

        return view('robots::index')
            ->with([
                'tariffs' => $tariffs,
                'subscribes' => $subscribes
            ]);
    }

    public function read(Request $request, $uuid)
    {
        $subscribe = Subscribe::findOrFail($uuid);

        if ($request->isMethod('post')) {
            $request->validate([
                'account_number' => ['required', 'numeric', function ($attribute, $value, $fail) use ($request) {
                    $response = Http::get("https://my.roboforex.com/api/partners/tree", [
                        'account_id' => config('app.roboforex.account-id'),
                        'api_key' => config('app.roboforex.api-key'),
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

            if (!$request->input('accepted')) {
                $breadcrumbs = [
                    [
                        'title' => 'Подписки',
                        'url' => route('subscribes')
                    ],
                    [
                        'title' => 'Управление подпиской',
                        'url' => route('subscribes.read', ['uuid' => $uuid])
                    ],
                    [
                        'title' => 'Соглашение об использовании',
                        'active' => true
                    ],
                ];

                return view('robots::terms')
                    ->with([
                        'back' => route('subscribes.read', ['uuid' => $uuid]),
                        'subscribe' => $subscribe,
                        'breadcrumbs' => $breadcrumbs,
                    ]);
            } else {
                if (!ProductKeys::query()->where('subscribe_id', $uuid)->count()) {
                    ProductKeys::create([
                        'user_id' => $request->user()->id,
                        'account_number' => $request->input('account_number'),
                        'activation_key' => \Str::uuid(),
                        'key' => $subscribe['tariff']['line']['details']['key'],
                        'subscribe_id' => $uuid
                    ]);

                    return back();
                }
            }
        }

        $account_number = null;

        $product_key = $subscribe->productKey($uuid);

        if ($product_key) {
            $account_number = BrokerAccounts::query()
                ->whereUserId($request->user()->id)
                ->whereAccountNumber($product_key['account_number'] ?? null)
                ->first();
        }

        $breadcrumbs = [
            [
                'title' => 'Подписки',
                'url' => route('subscribes')
            ],
            [
                'title' => 'Управление подпиской',
                'active' => true
            ],
        ];

        return view('robots::read')
            ->with([
                'uuid' => $uuid,
                'product_key' => $product_key,
                'subscribe' => $subscribe,
                'breadcrumbs' => $breadcrumbs,
                'account_number' => $account_number ?? null
            ]);
    }
}
