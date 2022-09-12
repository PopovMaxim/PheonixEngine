<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class LeaderPullController extends Controller
{
    public function index(Request $request)
    {
        $pull = $request->user()->getLeaderPull();

        $current_pull = $request->user()->getCurrentLeaderPull();

        return view('network::leader-pull.index')
            ->with([
                'pull' => $pull,
                'current_pull' => $current_pull
            ]);
    }
}
