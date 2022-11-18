<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Robots\Entities\ProductKeys;
use App\Modules\Robots\Entities\Subscribe;
use App\Modules\Tariffs\Entities\Tariff;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscribesController extends Controller
{
    public function index()
    {
        $page_name = 'Подписки';

        $subscribes = Subscribe::query()
            ->whereType('subscribe')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $tariffs = Tariff::$tariffs;

        return view('admin::subscribes.index')
            ->with([
                'tariffs' => $tariffs,
                'page_name' => $page_name,
                'subscribes' => $subscribes
            ]);
    }

    public function edit(Request $request, $uuid, $tab = null)
    {
        $subscribe = Subscribe::findOrFail($uuid);

        if ($request->isMethod('post')) {
            match($tab) {
                null => $this->commonTab($request, $subscribe),
                'key' => $this->keyTab($request, $subscribe),
            };
        }

        return view('admin::subscribes.edit')
            ->with([
                'subscribe' => $subscribe,
                'tab' => $tab
            ]);
    }

    private function commonTab(Request $request, $subscribe)
    {
    }

    private function keyTab(Request $request, $subscribe)
    {
        if (!ProductKeys::query()->where('subscribe_id', $subscribe['id'])->count()) {
            ProductKeys::create([
                'user_id' => $request->user()->id,
                'account_number' => $request->input('account_number'),
                'activation_key' => \Str::uuid(),
                'key' => $subscribe['tariff']['line']['details']['key'],
                'subscribe_id' => $subscribe['id']
            ]);

            return redirect()
                ->back()
                ->with([
                    'status' => [
                        'title' => 'Привязка номера счёта',
                        'type' => 'success',
                        'text' => "Вы успешно привязали номер счёта к подписке."
                    ]
                ]);
        } else {

            if ($subscribe['key']['account']) {
                $subscribe['key']['account']->update([
                    'account_number' => $request->input('account_number')
                ]);
            }

            ProductKeys::query()->where([
                'subscribe_id' => $subscribe['id']
            ])->update([
                'already_activated' => $request->input('already_activated'),
                'account_number' => $request->input('account_number'),
            ]);

            return redirect()
                ->back()
                ->with([
                    'status' => [
                        'title' => 'Редактирование номера счёта',
                        'type' => 'success',
                        'text' => "Вы успешно обновили номер счёта."
                    ]
                ]);
        }
    }
}
