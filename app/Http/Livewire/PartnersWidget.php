<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PartnersWidget extends Component
{
    public $ready_to_load = false;

    protected $listeners = ['refresh_partners_list' => '$refresh'];

    public function loadPartners()
    {
        $this->ready_to_load = true;
    }

    public function render($limit = 5)
    {
        $partners = request()
            ->user()
            ->partners
            ->paginate($limit);

        return view('livewire.partners-widget')
            ->with([
                'partners' => $partners
            ]);
    }
}
