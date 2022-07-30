<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PartnersController extends Controller
{
    public function index(Request $request)
    {
        $partners = $request
            ->user()
            ->partners
            ->paginate(5);

        return view('network::partners.index')
            ->with([
                'partners' => $partners
            ]);
    }
}
