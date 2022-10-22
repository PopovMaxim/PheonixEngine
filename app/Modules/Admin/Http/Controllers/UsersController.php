<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $page_name = 'Пользователи';

        $users = User::query()
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin::users.index')
            ->with([
                'page_name' => $page_name,
                'users' => $users
            ]);
    }

    public function auth(Request $request, $id)
    {
        $request->session()->put('previous_id', $request->user()->id);
        Auth::loginUsingId($id);

        return redirect(route('dashboard'));
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('previous_id')) {
            Auth::loginUsingId($request->session()->get('previous_id'));
            $request->session()->forget('previous_id');
        }

        return redirect(route('admin.users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $page_name = "{$user['nickname']}";

        $countries = json_decode(Storage::disk('public')->get('countries.json'), true);

        return view('admin::users.edit')
            ->with([
                'page_name' => $page_name,
                'countries' => $countries,
                'user' => $user
            ]);
    }

    public function show($id)
    {
        return view('admin::users.show');
    }

    public function create()
    {
        return view('admin::create');
    }

    public function destroy($id)
    {
        //
    }

    public function balance()
    {
        $total = 0;

        $users = User::role('user')->get();

        foreach ($users as $user) {
            $total += $user['raw_balance'];
        }

        return number_format($total / 100, 2);
    }

}
