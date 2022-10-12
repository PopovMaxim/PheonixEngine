<?php

namespace App\Modules\Robots\Http\Controllers;

use App\Modules\Robots\Entities\Product;
use App\Modules\Tariffs\Entities\TariffLines;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            [
                'title' => 'Продукты',
                'url' => route('tariffs')
            ],
            [
                'title' => 'Дистрибутивы',
                'active' => true
            ],
        ];

        return view('robots::distribution.index')
            ->with([
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function archive(Request $request, $id)
    {
        $breadcrumbs = [
            [
                'title' => 'Продукты',
                'url' => route('tariffs')
            ],
            [
                'title' => 'Дистрибутивы',
                'url' => route('distribution')
            ],
            [
                'title' => 'Архив',
                'active' => true
            ],
        ];

        return view('robots::distribution.archive')
            ->with([
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function download(Request $request, $id)
    {
        $line = TariffLines::query()->where('id', $id)->where('details->status', 1)->orderBy('order', 'asc')->firstOrFail();

        $product = Product::query()->where('tariff_line', $line['id'])->where('details->release', true)->firstOrFail();

        $path = public_path("downloads/products/{$id}/release/{$product['version']}/distrib.zip");

        return response()->download($path, "[Pheonix] {$line['title']} ver {$product['version']}.zip");
    }
}
