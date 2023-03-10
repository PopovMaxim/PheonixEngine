<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Tariffs\Entities\TariffLines;

class Tariffs extends Component
{
    public $line;
    public $accept;
    public $tariff;
    public $tariffs;
    public $tariff_line;
    public $open_description = false;
    public $show_terms = false;

    public function mount($line)
    {
        $this->line = $line;
        $this->tariffs = Tariff::query()->where('tariff_line', $this->line)->whereStatus(1)->get()->keyBy('id');
        $this->tariff_line = TariffLines::find($this->line);
    }

    public function selectTariff($tariff)
    {
        $this->tariff = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id')->get($tariff);

        $title = $tariff['title'];
        $price = number_format($tariff['result_price'], 2, '', '');

        if (request()->user()->raw_balance < $price)
        {
            return session()->flash('status', [
                'type' => 'danger',
                'message' => "На балансе лицевого счёта недостаточно средств для оформления подписки на тариф <b>{$title}</b>..."
            ]);
        }

        $this->dispatchBrowserEvent('selectTariff');
    }

    public function openDescription($tariff)
    {
        $this->tariff = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id')->get($tariff);
        $this->dispatchBrowserEvent('openDescription');
    }

    public function openTerms($tariff)
    {
        $this->tariff = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id')->get($tariff);

        $title = $this->tariff['title'];
        $price = number_format($this->tariff['result_price'], 2, '', '');

        if (request()->user()->raw_balance < $price)
        {
            return redirect()
                ->route('tariffs')
                ->with('status', [
                    'title' => 'Оформление подписки',
                    'type' => 'error',
                    'text' => "На балансе лицевого счёта недостаточно средств для оформления подписки на тариф <b>{$title}</b>..."
                ]);
        }

        $this->show_terms = true;
    }

    public function submit(Request $request)
    {
        $this->validate([
            'accept' => 'accepted'
        ], [
            'accept.accepted' => 'Вы должны согласиться с лицензионным соглашением.'
        ]);

        $tariff = $this->tariff;

        $price = number_format($tariff['result_price'], 2, '', '');

        $period = $tariff['period'];
        $title = $tariff['title'];

        if (!$tariff['status'])
        {
            return session()->flash('status', [
                'type' => 'danger',
                'message' => "Вы не можете совершить подписку, т.к. сейчас указанный тариф не активен."
            ]);
        }

        if ($request->user()->raw_balance < $price)
        {
            return session()->flash('status', [
                'type' => 'danger',
                'message' => "На балансе лицевого счёта недостаточно средств для оформления подписки на тариф <b>{$title}</b>..."
            ]);
        }

        $tx = $request->user()->transactions->create([
            'type' => 'subscribe',
            'status' => 'completed',
            'amount' => $price,
            'user_id' => $request->user()->id,
            'details' => [
                'tariff' => $tariff['id'],
                'line' => $tariff['tariff_line'],
                'expired_at' => now()->parse($period)
            ],
            'direction' => 'outer',
        ]);

        if (is_null($request->user()->activated_at))
        {
            $request->user()->update([
                'activated_at' => now()
            ]);
        }

        $this->emitTo('topbar-balance', '$refresh');

        // Accural line marketing bonuses
        $request->user()->calcLineMarketing($tariff, $tx);

        return redirect()
            ->route('subscribes.read', ['uuid' => $tx['id']])
            ->with([
                'status' => [
                    'title' => 'Оформление подписки',
                    'type' => 'success',
                    'text' => "Вы успешно подписались на тариф <b>{$title}</b>."
                ]
            ]);
    
        // Update binary total value
        /*$request->user()->node->update([
            'total_value' => $request->user()->node['total_value'] + $tariff_price
        ]);*/

    }

    public function render()
    {
        if ($this->show_terms)
        {
            return view('livewire.tariffs.terms', [
                'breadcrumbs' => [
                    [
                        'title' => 'Продукты',
                        'url' => route('tariffs', ['id' => $this->tariff['tariff_line']])
                    ],
                    [
                        'title' => $this->tariff['line']['title'],
                        'url' => route('tariffs', ['id' => $this->tariff['tariff_line']])
                    ],
                    [
                        'title' => $this->tariff['title'],
                        'active' => true
                    ]
                ]
            ]);
        }

        return view('livewire.tariffs.list');
    }
}
