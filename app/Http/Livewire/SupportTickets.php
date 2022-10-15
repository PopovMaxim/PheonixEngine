<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportTickets as ModelsSupportTickets;

class SupportTickets extends Component
{
    private $tickets;

    public function boot()
    {
        $this->tickets = ModelsSupportTickets::query()
            ->orderBy('id', 'desc')
            ->where('status', '<>', 'closed')
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.support-tickets')
            ->with([
                'tickets' => $this->tickets
            ]);
    }
}
