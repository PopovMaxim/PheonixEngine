<?php

namespace App\Http\Livewire;

use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Profile\Entities\Activity;
use Livewire\Component;
use Illuminate\Http\Request;

class Tariffs extends Component
{
    public $selectedTariff;

    public $modalVisible = false;

    public function __construct()
    {
        $this->tariffs = Tariff::$tariffs;
    }

    public function openModal($tariff)
    {
        $this->modalVisible = true;
        $this->selectedTariff = $tariff;
        $this->dispatchBrowserEvent('openModal');
    }

    public function submit(Request $request)
    {
        $tariff = $this->selectedTariff;

        if (!in_array($tariff, array_keys($this->tariffs)))
        {
            return session()->flash('status', [
                'type' => 'danger',
                'message' => 'Произошла ошибка, попробуйте ещё раз...'
            ]);
        }

        $tariff_period = $this->tariffs[$tariff]['period'];
        $tariff_price = $this->tariffs[$tariff]['price'];
        $tariff_title = $this->tariffs[$tariff]['title'];

        if ($request->user()->raw_balance < $tariff_price)
        {
            return session()->flash('status', [
                'type' => 'danger',
                'message' => "На балансе лицевого счёта недостаточно средств для оформления подписки на тариф <b>{$tariff_title}</b>..."
            ]);
        }

        $request->user()->transactions->create([
            'type' => 'subscribe',
            'status' => 'completed',
            'amount' => $tariff_price,
            'user_id' => $request->user()->id,
            'details' => [
                'tariff' => $tariff,
                'expired_at' => now()->parse($tariff_period)
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

        Activity::storeAction('subscription_tariff_' . $tariff, $request);

        $this->modalVisible = false;

        // Update binary total value
        /*$request->user()->node->update([
            'total_value' => $request->user()->node['total_value'] + $tariff_price
        ]);*/

        // Accural line marketing bonuses
        $request->user()->calcLineMarketing($tariff_price);

        return session()->flash('status', [
            'type' => 'success',
            'message' => "Вы успешно подписались на тариф <b>{$tariff_title}</b>. Управление подпиской доступно в разделе - «Роботы»."
        ]);
    }

    public function render()
    {
        return view('livewire.tariffs');
    }
}
