<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PromoController extends Controller
{
    public function index()
    {
        return view('network::promo.index');
    }
}
