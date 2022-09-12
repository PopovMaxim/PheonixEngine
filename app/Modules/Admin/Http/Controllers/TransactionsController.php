<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    public function index()
    {
        $page_name = 'Операции';

        $transactions = Transaction::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin::transactions.index')
            ->with([
                'page_name' => $page_name,
                'transactions' => $transactions
            ]);
    }

    public function create()
    {
        return view('admin::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
