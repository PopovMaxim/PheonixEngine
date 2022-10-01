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
            ->paginate(6);

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
                'active' => true
            ],
        ];
                
        $counter = Refill::query()
            ->where([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'details->type' => $type,
                'details->currency' => $currency,
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
                    'type' => $type,
                    'currency' => $currency
                ]
            ]);

            $crypto = $this->gateway->generateAddress($tx['id']);

            if ($crypto['error'] == 'ok') {
                $details = $tx['details'];
                $details['address'] = $crypto['address'];

                $tx->update(['details' => $details]);

                return redirect()
                    ->route('refill.pay', ['uuid' => $tx['id'], 'type' => $tx['details']['type'], 'currency' => $tx['details']['currency']]);
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
}
