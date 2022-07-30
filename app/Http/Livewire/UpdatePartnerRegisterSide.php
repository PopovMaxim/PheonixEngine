<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdatePartnerRegisterSide extends Component
{
    public $side;

    public function mount(Request $request) {
        $this->side = $request->user()->partners_register_side;

        if (is_null($request->user()->partners_register_side)) {
            $this->side = '';
        }
    }

    public function submit(Request $request)
    {
        if (empty($this->side)) {
            $this->side = null;
        }

        $request->user()->update([
            'partners_register_side' => $this->side
        ]);
    }

    public function updating($name, $value)
    {
        $this->dispatchBrowserEvent('loading');
    }

    public function updated($name, $value)
    {
        $this->dispatchBrowserEvent('updated');
    }

    public function render()
    {
        return view('livewire.update-partner-register-side');
    }
}
