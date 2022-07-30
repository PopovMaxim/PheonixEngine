<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $partners = request()
            ->user()
            ->partners
            ->limit(5)
            ->get();

        return view('dashboard::index')
            ->with([
                'partners' => $partners
            ]);
    }
}
