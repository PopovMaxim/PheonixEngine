<?php

namespace App\Modules\Support\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SupportController extends Controller
{
    public function index()
    {
        return view('support::index');
    }

    public function create()
    {
        return view('support::create');
    }

    public function show($id)
    {
        return view('support::show');
    }
}
