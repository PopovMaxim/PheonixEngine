<?php

namespace App\Modules\Transactions\Http\Controllers;

use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request
            ->user()
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('transactions::index')
            ->with([
                'transactions' => $transactions
            ]);
    }
}
