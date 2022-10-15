<?php

namespace App\Modules\Support\Http\Controllers;

use App\Models\SupportMessages;
use App\Models\SupportSubjects;
use App\Models\SupportTickets;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTickets::query()
            ->where('user_id', $request->user()->id)
            ->whereNot('status', 'closed')
            ->paginate(10);

        return view('support::index')
            ->with([
                'tickets' => $tickets
            ]);
    }

    public function closed(Request $request)
    {
        $tickets = SupportTickets::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'closed')
            ->paginate(10);

        return view('support::index')
            ->with([
                'tickets' => $tickets
            ]);
    }

    public function close(Request $request, $uuid)
    {
        $ticket = SupportTickets::query()
            ->where([
                'user_id' => $request->user()->id,
                'id' => $uuid
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

    public function create(Request $request)
    {
        $subjects = SupportSubjects::query()
            ->get();

        if ($request->isMethod('post'))
        {
            $request->validate([
                'subject_id' => 'required',
                'text' => 'required|min:10,max:500'
            ], [
                'subject_id.required' => 'Выберите категорию вопроса',
                'text.required' => 'Введите описание вопроса',
                'text.min' => 'Минимальная длина вопроса: 10 символов',
                'text.max' => 'Максимальная длина вопроса: 500 символов'
            ]);

            $ticket = SupportTickets::create([
                'user_id' => $request->user()->id,
                'subject_id' => $request->input('subject_id'),
                'text' => $request->input('text'),
            ]);
            
            SupportMessages::create([
                'user_id' => $request->user()->id,
                'ticket_id' => $ticket['id'],
                'message' => $request->input('text')
            ]);

            return redirect()
                ->route('support.show', ['uuid' => $ticket['id']]);
        }

        return view('support::create')
            ->with([
                'subjects' => $subjects
            ]);
    }

    public function show(Request $request, $uuid)
    {
        $ticket = SupportTickets::query()
            ->where([
                'user_id' => $request->user()->id,
                'id' => $uuid
            ])
            ->firstOrFail();

        return view('support::show')
            ->with([
                'ticket' => $ticket
            ]);
    }
}
