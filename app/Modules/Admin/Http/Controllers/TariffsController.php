<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Tariffs\Entities\TariffLines;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TariffsController extends Controller
{
    public function index()
    {
        $page_name = 'Тарифы';

        $tariffs = Tariff::query()->orderBy('priority', 'desc')->get();
        $tariff_lines = TariffLines::query()->orderBy('order', 'asc')->get();

        return view('admin::tariffs.index')
            ->with([
                'page_name' => $page_name,
                'tariff_lines' => $tariff_lines,
                'tariffs' => $tariffs
            ]);
    }

    public function create(Request $request)
    {
        $page_name = 'Новый тариф';

        if ($request->isMethod('post')) {
            $request->validate([
                'status' => 'required',
                'key' => 'required',
                'tariff_line' => 'required',
                'price' => 'required',
                'period' => 'required',
                'sale.sum' => 'required_with:sale.variant',
                'title' => 'required',
                'priority' => 'required|numeric',
                'color' => 'required',
            ], [
                'status.required' => 'Выберите статус тарифа',
                'key.required' => 'Введите ключ тарифа',
                'tariff_line.required' => 'Выберите линейку тарифа',
                'price.required' => 'Введите цену тарифа',
                'period.required' => 'Выберите срок действия тарифа',
                'title.required' => 'Введите название тарифа',
                'priority.required' => 'Установите приоритет тарифа',
                'priority.numeric' => 'Значение приоритета может быть только целым числом',
                'color.required' => 'Выберите цвет тарифа',
                'sale.sum.required_with' => 'Укажите величину скидки',
            ]);

            $payload = [];

            $payload['key'] = $request->input('key');
            $payload['color'] = $request->input('color');
            $payload['tariff_line'] = $request->input('tariff_line');
            $payload['price'] = $request->input('price');
            $payload['period'] = $request->input('period');
            $payload['title'] = $request->input('title');
            $payload['status'] = $request->input('status');
            $payload['priority'] = $request->input('priority');

            if ($request->has('description')) {
                $payload['description'] = $request->input('description');
            }

            if (!is_null($request->input('sale.variant'))) {
                $payload['sale'] = $request->input('sale');
            }

            if (!is_null($request->input('ribbon.text'))) {
                $payload['ribbon'] = $request->input('ribbon');
            }

            /*if (!is_null($request->input('color'))) {
                $payload['color'] = $request->input('color');
            }*/

            $tariff = Tariff::create($payload);
        }

        $tariff_lines = TariffLines::get();

        return view('admin::tariffs.create')
            ->with([
                'page_name' => $page_name,
                'tariff_lines' => $tariff_lines,
            ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
