<?php

namespace App\Modules\Admin\Http\Controllers;

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
