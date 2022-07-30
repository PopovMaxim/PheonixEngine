<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class LineController extends Controller
{
    public function index(Request $request)
    {
        $level_1 = $request
            ->user()
            ->partners;

        $level_1_partners_ids = clone $level_1
            ->get()
            ->pluck('id');

        $level_2 = User::query()
            ->whereIn('sponsor_id', $level_1_partners_ids);

        $level_2_partners_ids = clone $level_2
            ->get()
            ->pluck('id');

        $level_3 = User::query()
            ->whereIn('sponsor_id', $level_2_partners_ids);
            
        $level_3_partners_ids = clone $level_3
            ->get()
            ->pluck('id');

        return view('network::line.index')
            ->with([
                'level_1' => [
                    'count' => count($level_1_partners_ids),
                    'list' => $level_1->paginate(5),
                ],
                'level_2' => [
                    'count' => count($level_2_partners_ids),
                    'list' => $level_2->paginate(5),
                ],
                'level_3' => [
                    'count' => count($level_3_partners_ids),
                    'list' => $level_3->paginate(5),
                ]
            ]);
    }
}
