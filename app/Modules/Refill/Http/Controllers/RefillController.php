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

        if (!is_null($uuid)) {
            $tx = Refill::query()
                ->whereId($uuid)
                ->where([
                    'user_id' => $request->user()->id,
                ])->first();
        } else {
            $tx = Refill::query()
                ->whereNotIn('status', [
                    'completed',
                    'canceled'
                ])
                ->where([
                    'user_id' => $request->user()->id,
                    'details->gateway->type' => $type,
                    'details->gateway->currency' => $currency,
                ])->first();
        }

        if ($tx) {
            return view('refill::pay', [
                'breadcrumbs' => $breadcrumbs,
                'gateway' => $this->gateway,
                'tx' => $tx,
            ]);
        }        

        return view('refill::form', [
            'breadcrumbs' => $breadcrumbs,
            'gateway' => $this->gateway,
            'tx' => $tx
        ]);
    }

    public function pay(Request $request, $type = null, $currency = null)
    {
        if (is_null($type) || is_null($currency)) {
            return redirect()
                ->route('refill');
        }

        if ($type == 'crypto') {
            $this->gateway = new Crypto($currency);
        }

        $counter = Refill::query()
            ->whereNotIn('status', [
                'completed',
                'canceled'
            ])
            ->where([
                'user_id' => $request->user()->id,
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
                'status' => 'new',
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
                    ->route('refill.form', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]);
            }
        }
    }

    public function cancel(Request $request, $type = null, $currency = null)
    {
        $tx = Refill::query()
        ->whereNotIn('status', [
            'completed',
            'canceled'
        ])
        ->where([
            'type' => 'refill',
            'details->gateway->type' => $type,
            'details->gateway->currency' => $currency,
        ])->firstOrFail();

        $tx->update([
            'status' => 'canceled'
        ]);

        return redirect()
            ->route('refill.pay', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']])
            ->with('status', [
                'type' => 'success',
                'title' => 'Отмена заявки',
                'text' => 'Заявка на отмену пополнения баланса по данному направлению успешно отменена.'
            ]);
    }

    public function ipn(Request $request, $type)
    {
        \Log::info(json_encode($request->all()));

        if ($type == 'crypto') {
            $this->gateway = new Crypto;
        }

        if ($this->gateway) {

            $data = $request->all();

            $this->gateway->ipn($data);
        }
    }
}
