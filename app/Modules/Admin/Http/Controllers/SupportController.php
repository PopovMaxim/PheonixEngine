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

        if (!is_null($uuid)) {
            $ticket = SupportTickets::find($uuid);
        }

        return view('admin::support.tickets.index')
            ->with([
                'page_name' => $page_name,
                'ticket' => $ticket ?? null
            ]);
    }

    public function close($id)
    {
        $ticket = SupportTickets::query()
            ->where([
                'id' => $id
            ])
            ->update([
                'status' => 'closed'
            ]);

    
        return back()
            ->with('status', [
                'title' => 'Техническая поддержка',
                'type' => 'success',
                'text' => 'Заявка в техническую поддержку успешно закрыта.'
            ]);
    }
}
