<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TradersQuotes as TQ;

class TradersQuotes extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $random_quote = TQ::random();

        return view('livewire.traders-quotes')
            ->with([
                'quote' => $random_quote
            ]);
    }
}
