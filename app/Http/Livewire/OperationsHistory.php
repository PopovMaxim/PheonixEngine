<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class OperationsHistory extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function render(Request $request)
    {
        $transactions = $request
            ->user()
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.operations-history')
            ->with([
                'transactions' => $transactions
            ]);
    }
}
