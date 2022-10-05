<?php

namespace App\Http\Livewire;

use App\Modules\Profile\Entities\Activity;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Tariffs\Entities\TariffLines;
use Livewire\Component;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class Tariffs extends Component
{
    public $line;
    public $tariff;
    public $tariffs;
    public $tariff_line;
    public $open_description = false;

    public function mount($line)
    {
        $this->line = $line;
        $this->tariffs = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id');
        $this->tariff_line = TariffLines::find($this->line);
    }

    public function selectTariff($tariff)
    {
        $this->tariff = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id')->get($tariff);
        $this->dispatchBrowserEvent('selectTariff');
    }

    public function openDescription($tariff)
    {
        $this->tariff = Tariff::query()->where('tariff_line', $this->line)->get()->keyBy('id')->get($tariff);
        $this->dispatchBrowserEvent('openDescription');
    }

    public function submit(Request $request)
    {
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
        $request->user()->calcLineMarketing($tariff, $tx['id']);

        return redirect()
            ->route('subscribes.read', ['uuid' => $tx['id']])
            ->with([
                'status' => [
                    'title' => 'Оформление подписки',
                    'type' => 'success',
                    'text' => "Вы успешно подписались на тариф <b>{$title}</b>."
                ]
            ]);


        //Activity::storeAction('subscription_tariff_' . $title, $request);

    
        // Update binary total value
        /*$request->user()->node->update([
            'total_value' => $request->user()->node['total_value'] + $tariff_price
        ]);*


        return session()->flash('status', [
            'type' => 'success',
            'message' => "Вы успешно подписались на тариф <b>{$tariff_title}</b>. Управление подпиской доступно в разделе - «Роботы»."
        ]);*/
    }

    public function render()
    {
        return view('livewire.tariffs');
    }
}
