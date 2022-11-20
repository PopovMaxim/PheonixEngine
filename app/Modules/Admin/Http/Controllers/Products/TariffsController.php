<?php

namespace App\Modules\Admin\Http\Controllers\Products;

use App\Modules\Robots\Entities\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Tariffs\Entities\Tariff;
use App\Modules\Tariffs\Entities\TariffLines;

class TariffsController extends Controller
{
    public function index()
    {
        $page_name = 'Тарифы';

        $tariffs = Tariff::query()->orderBy('priority', 'desc')->get();
        $tariff_lines = TariffLines::query()->orderBy('order', 'asc')->get();

        return view('admin::products.tariffs.index')
            ->with([
                'page_name' => $page_name,
                'tariff_lines' => $tariff_lines,
                'tariffs' => $tariffs
            ]);
    }

    public function form(Request $request, $id = null)
    {
        $page_name = 'Новый тариф';

        if (!is_null($id)) {
            $tariff = Tariff::findOrFail($id);

            $page_name = 'Редактирование тарифа ' . $tariff['title'];
        }

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
                //'color' => 'required',
            ], [
                'status.required' => 'Выберите статус тарифа',
                'key.required' => 'Введите ключ тарифа',
                'tariff_line.required' => 'Выберите линейку тарифа',
                'price.required' => 'Введите цену тарифа',
                'period.required' => 'Выберите срок действия тарифа',
                'title.required' => 'Введите название тарифа',
                'priority.required' => 'Установите приоритет тарифа',
                'priority.numeric' => 'Значение приоритета может быть только целым числом',
                //'color.required' => 'Выберите цвет тарифа',
                'sale.sum.required_with' => 'Укажите величину скидки',
            ]);

            $payload = [];

            $payload['key'] = $request->input('key');
            $payload['tariff_line'] = $request->input('tariff_line');
            $payload['price'] = $request->input('price');
            $payload['period'] = $request->input('period');
            $payload['title'] = $request->input('title');
            $payload['status'] = $request->input('status');
            $payload['priority'] = $request->input('priority');

            if ($request->has('description')) {
                $payload['description'] = $request->input('description');
            }

            if (!is_null($request->input('sale'))) {
                $payload['sale'] = $request->input('sale');
            }

            if (!is_null($request->input('ribbon'))) {
                $payload['ribbon'] = $request->input('ribbon');
            }

            if (!is_null($request->input('color'))) {
                $payload['color'] = $request->input('color');
            }

            if (!is_null($request->input('details'))) {
                $payload['details'] = $request->input('details');
            }

            if (!is_null($request->input('additional'))) {
                $payload['details']['additional'] = $request->input('additional');
            }

            if (!is_null($request->input('details.products'))) {
                $payload['details']['products'] = $request->input('details.products');
            }

            if (isset($tariff)) {
                $tariff->update($payload);
            } else {
                Tariff::create($payload);
            }
        }

        $tariff_lines = TariffLines::get();

        $products = Product::query()->distinct('key')->get();

        return view('admin::products.tariffs.form')
            ->with([
                'page_name' => $page_name,
                'tariff' => $tariff ?? null,
                'products' => $products,
                'tariff_lines' => $tariff_lines,
            ]);
    }

    public function delete(Request $request, $id)
    {
        $tariff = Tariff::findOrFail($id);

        $tariff->delete();

        return back();
    }
}
