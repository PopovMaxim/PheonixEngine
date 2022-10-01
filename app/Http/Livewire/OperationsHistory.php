<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class OperationsHistory extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $header = true;

    public $limit = 5;

    public $min_height = 375;

    public function render(Request $request)
    {
        $transactions = $request
            ->user()
            ->transactions()
            ->whereNotIn('type', ['refill', 'transfer', 'withdrawal'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->limit);

        return view('livewire.operations-history')
            ->with([
                'transactions' => $transactions,
                'header' => $this->header,
                'min_height' => $this->min_height,
            ]);
    }
}
