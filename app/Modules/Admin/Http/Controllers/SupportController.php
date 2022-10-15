<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\SupportTickets;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SupportController extends Controller
{
    public function index(Request $request, $uuid = null)
    {
        $page_name = 'Техническая поддержка';

        $tickets = SupportTickets::query()
            ->orderBy('id', 'desc')
            ->where('status', '<>', 'closed')
            ->paginate(20);

        return view('admin::support.tickets.index')
            ->with([
                'page_name' => $page_name,
                'tickets' => $tickets
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
