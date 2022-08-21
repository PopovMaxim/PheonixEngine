<?php

namespace App\Modules\Robots\Http\Controllers;

use App\Models\User;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RobotsController extends Controller
{
    public function index(Request $request)
    {
        $tariffs = Tariff::$tariffs;
        $subscribes = $request->user()->transactions()->whereType('subscribe')->orderBy('created_at', 'desc')->paginate(5);

        return view('robots::index')
            ->with([
                'tariffs' => $tariffs,
                'subscribes' => $subscribes
            ]);
    }
}
