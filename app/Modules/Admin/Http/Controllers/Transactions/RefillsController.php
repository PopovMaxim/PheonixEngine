<?php

namespace App\Modules\Admin\Http\Controllers\Transactions;

use App\Modules\Refill\Entities\Refill;
use App\Modules\Refill\Payments\WestWallet\Gateway;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RefillsController extends Controller
{
    public function index()
    {
        $page_name = 'Список пополнений';

        $transactions = Refill::query()
            ->where([
                'type' => 'refill'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin::transactions.refills.index')
            ->with([
                'page_name' => $page_name,
                'transactions' => $transactions
            ]);
    }

    public function read(Request $request, $uuid)
    {
        $tx = Refill::findOrFail($uuid);

        if ($tx['details']['gateway']['type'] == 'crypto') {
            $this->gateway = new Gateway($tx['details']['gateway']['currency']);
        }

        return view('admin::transactions.refills.read')
            ->with([
                'tx' => $tx,
                'gateway' => $this->gateway
            ]);
    }

    public function edit(Request $request, $uuid)
    {
        $tx = Refill::findOrFail($uuid);

        if ($tx['details']['gateway']['type'] == 'crypto') {
            $this->gateway = new Gateway($tx['details']['gateway']['currency']);
        }

        if ($request->isMethod('post')) {
            $params = [];

            if ($request->has('status')) {
                $params['status'] = $request->input('status');
            }

            if ($request->has('amount')) {
                $params['amount'] = intval(str_replace([',', '.'], '', $request->input('amount')));
            }

            if ($request->has('details.gateway.type')) {
                $params['details']['gateway']['type'] = $request->input('details.gateway.type');
            }

            if ($request->has('details.gateway.currency')) {
                $params['details']['gateway']['currency'] = $request->input('details.gateway.currency');
            }

            if ($request->has('details.gateway.amount')) {
                $params['details']['gateway']['amount'] = $request->input('details.gateway.amount');
            }

            if ($request->has('details.gateway.fee')) {
                $params['details']['gateway']['fee'] = $request->input('detailsgateway.fee');
            }

            if ($request->has('details.gateway.blockchain_hash')) {
                $params['details']['gateway']['blockchain_hash'] = $request->input('details.gateway.blockchain_hash');
            }

            if ($request->has('details.gateway.address')) {
                $params['details']['gateway']['address'] = $request->input('details.gateway.address');
            }

            if ($request->has('details.gateway.rate')) {
                $params['details']['gateway']['rate'] = $request->input('details.gateway.rate');
            }

            $tx->update($params);
        }

        return view('admin::transactions.refills.edit')
            ->with([
                'tx' => $tx,
                'gateway' => $this->gateway
            ]);
    }
}
