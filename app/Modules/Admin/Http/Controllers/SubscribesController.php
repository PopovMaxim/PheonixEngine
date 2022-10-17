<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Robots\Entities\Subscribe;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscribesController extends Controller
{
    public function index()
    {
        $page_name = 'Подписки';

        $subscribes = Transaction::query()
            ->whereType('subscribe')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $tariffs = Tariff::$tariffs;

        return view('admin::subscribes.index')
            ->with([
                'tariffs' => $tariffs,
                'page_name' => $page_name,
                'subscribes' => $subscribes
            ]);
    }

    public function edit(Request $request, $uuid)
    {
        $subscribe = Subscribe::findOrFail($uuid);

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

            $subscribe->update($params);
        }

        return view('admin::subscribes.edit')
            ->with([
                'subscribe' => $subscribe
            ]);
    }
}
