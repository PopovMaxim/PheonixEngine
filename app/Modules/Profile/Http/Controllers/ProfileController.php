<?php

namespace App\Modules\Profile\Http\Controllers;

use App\Modules\Profile\Entities\Activity;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile::index');
    }

    public function activityLog(Request $request)
    {
        $logs = Activity::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('profile::activity-log')
            ->with([
                'logs' => $logs
            ]);
    }
}
