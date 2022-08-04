<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TopbarBalance extends Component
{
    protected $listeners = [
        '$refresh'
    ];
    
    public function render()
    {
        return view('livewire.topbar-balance');
    }
}
