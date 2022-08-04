<?php

use Illuminate\Http\Request;
use App\Modules\Transactions\Entities\Transaction;
use App\Modules\Transactions\Transformers\Transaction as TransactionCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('transactions', function (Request $request) {
        $order = 'desc';

        if ($request->has('reverse') && $request->input('reverse'))
        {
            $order = 'asc';
        }

        $status = $request->input('status');

        $transactions = Transaction::query()
            ->where('user_id', $request->input('user_id'))
            ->orderBy('created_at', $order)
            ->get();

        return TransactionCollection::collection($transactions);
    });
});