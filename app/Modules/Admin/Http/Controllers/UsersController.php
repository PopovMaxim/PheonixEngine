<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        return view('admin::create');
    }


    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function destroy($id)
    {
        //
    }
}
