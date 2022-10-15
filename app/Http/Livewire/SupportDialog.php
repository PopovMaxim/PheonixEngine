<?php

namespace App\Http\Livewire;

use App\Models\SupportMessages;
use App\Models\SupportTickets;
use Illuminate\Http\Request;
use Livewire\Component;

class SupportDialog extends Component
{
    public $id;

    public $message = '';

    public $rules = [
        'message' => 'required|min:1|max:255',
    ];

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function closeTicket()
    {
        //dd($this->id);
    }

    public function submit(Request $request)
    {
        $this->validate();

        SupportMessages::create([
            'user_id' => $request->user()->id,
            'ticket_id' => $this->id,
            'message' => $this->message
        ]);

        //SupportTickets

        $this->message = '';
    }

    public function clearForm()
    {
        $this->reset();
    }

    public function render()
    {
        $ticket = SupportTickets::find($this->id);

        return view('livewire.support-dialog')
            ->with([
                'id' => $this->id,
                'ticket' => $ticket
            ]);
    }
}
