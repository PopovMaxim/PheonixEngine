<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $partners = $request
            ->user()
            ->partners
            ->limit(5)
            ->get();

        return view('dashboard::index')
            ->with([
                'partners' => $partners,
                'quick_bonus' => $this->quickBonus($request)
            ]);
    }

    private function quickBonus(Request $request)
    {
        $now = now();
        $quick_bonus_start = $request->user()->created_at;
        $quick_bonus_end = $request->user()->created_at->addDays(30);

        $my_sales = $request->user()->transactions()
            ->whereType('line_bonus')
            ->whereBetween('created_at', [$quick_bonus_start, $quick_bonus_end])
            ->get();

        $current_amount = 0;

        foreach ($my_sales as $sale)
        {
            $current_amount += $sale['details']['price'];
        }

        $min_amount = 10000000;

        $current_percent = ($current_amount / $min_amount) * 100;

        return [
            'now' => $now,
            'quick_bonus_end' => $quick_bonus_end,
            'min_amount' => number_format($min_amount / 100, 2),
            'current_amount' => number_format($current_amount / 100, 2),
            'current_percent' => $current_percent
        ];
    }

    public function acceptQuickBonus(Request $request)
    {
        $request->user()->acceptQuickBonus();

        return back();
    }
}
