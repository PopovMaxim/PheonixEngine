<?php

namespace App\Modules\Login\Http\Controllers;

use App\Rules\IExists;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TradersQuotes;
use App\Models\User;
use App\Modules\Profile\Entities\Activity;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $random_quote = TradersQuotes::random();

        return view('login::index')
            ->with([
                'quote' => $random_quote
            ]);
    }

    public function authorize(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', new IExists('users', 'Предоставленные учетные данные не соответствуют нашим записям.')],
            'password' => ['required'],
        ], [
            'email.required' => 'Вы не ввели электронную почту.',
            'email.email' => 'Неправильный формат электронной почты.',
            'password.required' => 'Вы не ввели пароль.'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::query()
            ->whereRaw("lower(email) = lower(?)", [$email])
            ->first();

        if ($user && Hash::check($password, $user['password']))
        {
            Activity::storeActionByUserId('auth', $user['id'], $request->ip());

            if (Auth::login($user))
            {
                $request->session()->regenerate();
     
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Предоставленные учетные данные не соответствуют нашим записям.',
        ])->onlyInput('email');
    }
}
