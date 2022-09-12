<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    public function create()
    {
        return view('admin::create');
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
