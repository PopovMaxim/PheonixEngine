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

        $lines = TariffLines::query()->orderBy('order', 'asc')->where('details->status', 1)->get();

        $products = Product::query();

        return view('robots::distribution.index')
            ->with([
                'lines' => $lines,
                'products' => $products,
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

    public function download($id)
    {
        $product = Product::query()->where('id', $id)->where('details->release', true)->firstOrFail();

        $path = public_path("downloads/products/{$product['id']}/release/{$product['version']}.zip");

        return response()->download($path, "Pheonix {$product['line']['title']} ver {$product['version']}.zip");
    }
}
