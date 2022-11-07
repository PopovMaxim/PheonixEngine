<?php

namespace App\Modules\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Faq\Entities\Categories;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request
            ->user()
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions::index')
            ->with([
                'transactions' => $transactions
            ]);
    }

    public function read(Request $request, $uuid)
    {
        $tx = $request
            ->user()
            ->transactions()
            ->find($uuid);

        $breadcrumbs = [
            [
                'title' => 'Финансы',
                'url' => route('transactions')
            ],
            [
                'title' => 'История',
                'url' => route('transactions')
            ],
            [
                'title' => 'Детали операции',
                'active' => true
            ],
        ];

        $title = '<a href="/transactions"><i class="fa fa-arrow-left text-muted me-2"></i></a> Детали операции';

        if ($tx['type'] == 'subscribe') {
            $faq = Categories::query()
                ->whereIn('key', ['subscribes'])
                ->get();
        }

        return view('transactions::read')
            ->with([
                'tx' => $tx,
                'faq' => $faq ?? [],
                'title' => $title,
                'breadcrumbs' => $breadcrumbs
            ]);
    }
}
