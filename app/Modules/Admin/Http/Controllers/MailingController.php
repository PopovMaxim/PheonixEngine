<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Models\SupportTickets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Robots\Entities\Subscribe;
use App\Notifications\Mailing;

class MailingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->get();

            $data = $request->all();

            dispatch(function () use ($users, $data) {
                \Notification::send($users, new Mailing($data['subject'], $data['text']));
            })->onQueue('mail');
        }
        return view('admin::mailing.index');
    }
}
