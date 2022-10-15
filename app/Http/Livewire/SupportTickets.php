<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportTickets as ModelsSupportTickets;

class SupportTickets extends Component
{
    private $tickets;

    public $statuses = [
        'new' => 'Новый',
        'wait_support' => 'Ожидает ответа поддержки',
        'wait_user' => 'Ожидает ответа пользователя',
        'closed' => 'Закрыт'
    ];

    public function boot()
    {
        $this->tickets = ModelsSupportTickets::query();
    }

    public function render()
    {
        return view('livewire.support-tickets')
            ->with([
                'tickets' => $this->tickets,
                'statuses' => $this->statuses,
            ]);
    }
}
