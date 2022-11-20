<?php

namespace App\Modules\Admin\Http\Controllers\Products;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Tariffs\Entities\TariffLines;

class LineController extends Controller
{
    public function form(Request $request, $id = null)
    {
        $page_name = 'Новая линейка';

        if (!is_null($id)) {
            $line = TariffLines::findOrFail($id);

            $page_name = 'Редактирование линейки ' . $line['title'];
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'details.status' => 'required',
                'details.design' => 'required',
                'details.key' => 'required',
                'details.slug' => 'required',
                'title' => 'required',
            ], [
                'details.status.required' => 'Выберите статус тарифа',
                'details.design.required' => 'Выберите шаблон',
                'details.key.required' => 'Введите ключ линейки',
                'details.slug.required' => 'Введите slug линейки',
                'title.required' => 'Введите название',
            ]);

            $payload = [];

            $payload['title'] = $request->input('title');
            $payload['description'] = $request->input('description') ?? null;
            $payload['order'] = $request->input('order') ?? 0;
            $payload['details'] = $request->input('details') ?? [];
            
            if (isset($line)) {
                $line->update($payload);
            } else {
                TariffLines::create($payload);
            }

            return redirect()
                ->back();
        }

        return view('admin::products.lines.form')
            ->with([
                'page_name' => $page_name,
                'line' => $line ?? null
            ]);
    }

    public function delete(Request $request, $id)
    {
        $line = TariffLines::findOrFail($id);

        $line->delete();

        return back();
    }
}
