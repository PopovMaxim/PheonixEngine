<?php

namespace App\Http\Livewire;

use App\Models\SupportMessages;
use App\Models\SupportTickets;
use Illuminate\Http\Request;
use Livewire\Component;

class SupportDialog extends Component
{
    public $message = '';

    public $ticket_id;

    public $ticket;

    public $rules = [
        'message' => 'required|min:1|max:255',
    ];

    public function mount()
    {
        $this->ticket = SupportTickets::find($this->ticket_id);
    }

    public function submit(Request $request)
    {
        $this->validate();

        SupportMessages::create([
            'user_id' => $request->user()->id,
            'ticket_id' => $this->ticket['id'],
            'message' => $this->message
        ]);

        $this->message = '';

        if ($this->ticket['user_id'] == $request->user()->id) {
            $this->ticket->update([
                'status' => 'wait_support'
            ]);
        } else {
            $this->ticket->update([
                'status' => 'wait_user'
            ]);
        }
    }

    public function clearForm()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.support-dialog')
            ->with([
                'ticket' => $this->ticket
            ]);
    }
}
