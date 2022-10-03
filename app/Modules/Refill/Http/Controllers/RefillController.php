<?php

namespace App\Modules\Refill\Http\Controllers;

use App\Modules\Refill\Entities\Refill;
use App\Modules\Refill\Payments\WestWallet\Gateway as Crypto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RefillController extends Controller
{
    private $gateway = null;

    public function index(Request $request)
    {
        $refills = Refill::query()
            ->where([
                'user_id' => $request->user()->id,
                'type' => 'refill'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $crypto = Crypto::$currencies;

        usort($crypto, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return view('refill::index')
            ->with([
                'refills' => $refills,
                'crypto' => $crypto,
            ]);
    }

    public function form(Request $request, $type = null, $currency = null, $uuid = null)
    {
        if (is_null($type) || is_null($currency)) {
            return redirect()
                ->route('refill');
        }

        if ($type == 'crypto') {
            $this->gateway = new Crypto($currency);
        }

        $breadcrumbs = [
            [
                'title' => 'Пополнение',
                'url' => route('refill')
            ],
            [
                'title' => trans('refill.' . $this->gateway->type),
                'url' => route('refill')
            ],
            [
                'title' => $this->gateway->data['title'],
                'active' => true
            ],
        ];
                
        $counter = Refill::query()
            ->where([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'details->gateway->type' => $type,
                'details->gateway->currency' => $currency,
            ])->first();

        if ($request->isMethod('post')) {
            if ($counter) {
                return back()
                    ->with('status', [
                        'title' => 'Пополнение баланса',
                        'type' => 'error',
                        'text' => 'У Вас уже есть открытый счёт на оплату по этому направлению. Оплатите или отмените его.'
                    ]);
            }

            $tx = Refill::create([
                'id' => \Str::uuid(),
                'user_id' => $request->user()->id,
                'type' => 'refill',
                'status' => 'pending',
                'direction' => 'inner',
                'amount' => 0,
                'details' => [
                    'gateway' => [
                        'type' => $type,
                        'currency' => $currency
                    ]
                ]
            ]);

            $crypto = $this->gateway->generateAddress(['id' => $tx['id'], 'type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]);

            if ($crypto['error'] == 'ok') {
                $details = $tx['details'];
                $details['gateway']['address'] = $crypto['address'];

                $tx->update(['details' => $details]);

                return redirect()
                    ->route('refill.pay', ['uuid' => $tx['id'], 'type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]);
            }
        }

        return view('refill::form', [
            'breadcrumbs' => $breadcrumbs,
            'gateway' => $this->gateway,
            'counter' => $counter
        ]);
    }

    public function pay(Request $request, $type = null, $currency = null, $uuid = null)
    {
        if ($type == 'crypto') {
            $this->gateway = new Crypto($currency);
        }

        $tx = Refill::query()->where([
            'id' => $uuid,
            'type' => 'refill',
        ])->firstOrFail();

        $breadcrumbs = [
            [
                'title' => 'Пополнение',
                'url' => route('refill')
            ],
            [
                'title' => trans('refill.' . $this->gateway->type),
                'url' => route('refill')
            ],
            [
                'title' => $this->gateway->data['title'],
                'active' => true
            ],
        ];

        return view('refill::pay', [
            'breadcrumbs' => $breadcrumbs,
            'gateway' => $this->gateway,
            'tx' => $tx
        ]);
    }

    public function cancel(Request $request, $type = null, $currency = null, $uuid = null)
    {
        $tx = Refill::query()
            ->where([
                'id' => $uuid,
                'user_id' => $request->user()->id
            ])->firstOrFail();

        $tx->update([
            'status' => 'canceled'
        ]);

        return redirect()
            ->route('refill.pay', ['uuid' => $tx['id'], 'type' => $tx['details']['type'], 'currency' => $tx['details']['currency']])
            ->with('status', [
                'type' => 'success',
                'title' => 'Отмена заявки',
                'text' => 'Заявка на отмену пополнения баланса по данному направлению успешно отменена.'
            ]);
    }

    public function ipn(Request $request, $type, $uuid)
    {
        if ($type == 'crypto') {
            $this->gateway = new Crypto;
        }

        if ($this->gateway) {

            $data = $request->all();

            /*$data = [
                "id" => 123123,
                "amount" => 100,
                "address" => "TVd1bWoSfN1ftJ7P5eTYJ9zPF4iG2FmsEY",
                "dest_tag" => "",
                "label" => "65fafebc-ff61-4d9b-bf75-9cee064811d2",
                "currency" => "USDTTRC",
                "status" => "completed",
                "blockchain_confirmations" => 1,
                "fee" => "0",
                "blockchain_hash" => "72648cefcc47b4371f28dc3328bc863918913eebf81b40d4a97d577b96c1ce53"
            ];*/

            \Log::info(json_encode($data));

            $this->gateway->ipn($data, $uuid);
        }
    }
}
