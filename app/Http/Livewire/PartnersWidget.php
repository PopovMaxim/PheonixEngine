<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PartnersWidget extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

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
