<?php

namespace App\Modules\Register\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\TradersQuotes;
use App\Models\User;


class RegisterController extends Controller
{
    public function index(Request $request, $sponsor = null, $leg = null)
    {
        if (is_null($sponsor)) {
            return redirect()
                ->route('login');
        }

        $sponsor_query = User::query()
            ->where('hash', $sponsor)
            ->first();

        if (is_null($sponsor_query)) {
            return redirect()
                ->route('login');
        }

        if (!is_null($leg) && !in_array($leg, ['left', 'right'])) {
            return redirect()
                ->route('login');
        }

        $random_quote = TradersQuotes::random();

        if ($request->isMethod('post')) {
            $request->validate([
                'email' => ['required', 'email', 
                    function ($attribute, $value, $fail) {
                        $query = DB::table('users');
                        $column = $query->getGrammar()->wrap($attribute);
                        if ($query->whereRaw("lower({$column}) = lower(?)", [$value])->count()) {
                            $fail('Вы не можете использовать сочетание введённых данных.');
                        }
                    },
                ],
                'nickname' => ['required', 
                    function ($attribute, $value, $fail) {
                        $query = DB::table('users');
                        $column = $query->getGrammar()->wrap($attribute);
                        if ($query->whereRaw("lower({$column}) = lower(?)", [$value])->count()) {
                            $fail('Вы не можете использовать этот никнейм.');
                        }
                    },
                ],
                'password' => ['required', 'confirmed'],
                'password_confirmation' => ['required'],
            ], [
                'email.required' => 'Вы не ввели электронную почту.',
                'email.email' => 'Неправильный формат электронной почты.',
                'password.required' => 'Вы не ввели пароль.',
                'password_confirmation.required' => 'Вы не ввели пароль.'
            ]);

            $email = strtolower($request->input('email'));
            $nickname = $request->input('nickname');
            $password = $request->input('password');

            $create = User::create([
                'email' => $email,
                'nickname' => $nickname,
                'hash' => md5($email . now()->timestamp),
                'password' => Hash::make($password),
                'sponsor_id' => $sponsor_query['id'],
                'account_number' => User::generateAccountNumber()
            ]);
            
            //$create->addToBinaryTree($leg);

            $create->notify(new \App\Notifications\Register);
            $create->notify(new \App\Notifications\SettingsUpdate);
            $sponsor_query->notify(new \App\Notifications\RegisterPartner($nickname));
            //$create->notify(new \App\Notifications\AddToBinary);

            if ($create && Auth::attempt(['email' => $email, 'password' => $password])) {
                $request->session()->regenerate();
     
                return redirect()->route('dashboard');
            }

            return back()->withErrors([
                'email' => 'Что-то пошло не так...',
            ])->onlyInput('email');
        }

        return view('register::index')
            ->with([
                'quote' => $random_quote,
                'sponsor' => $sponsor,
                'leg' => $leg
            ]);
    }
}
