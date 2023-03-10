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
        /*if (is_null($sponsor)) {
            return redirect()
                ->route('login');
        }*/

        /*
        if (is_null($sponsor_query)) {
            return redirect()
                ->route('login');
        }

        if (!is_null($leg) && !in_array($leg, ['left', 'right'])) {
            return redirect()
                ->route('login');
        }*/


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
                'nickname' => ['required', 'alpha_dash',
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
                'agreement' => ['accepted'],
            ], [
                'agreement.accepted' => 'Вы должны согласиться с политикой конфиденциальности и лицензионным соглашением.',
                'nickname.required' => 'Вы не ввели никнейм.',
                'nickname.alpha_dash' => 'Вы можете использовать только цифры, буквы, дефис и нижнее подчеркивание.',
                'email.required' => 'Вы не ввели электронную почту.',
                'email.email' => 'Неправильный формат электронной почты.',
                'password.required' => 'Вы не ввели пароль.',
                'password_confirmation.required' => 'Вы не ввели пароль.'
            ]);

            $email = strtolower($request->input('email'));
            $nickname = $request->input('nickname');
            $password = $request->input('password');

            $sponsor_query = null;

            if ($request->has('invite_hash'))
            {
                $hash = $request->input('invite_hash');

                $sponsor_query = User::query()
                    ->where('hash', $hash)
                    ->first();
            }

            $payload = [
                'email' => $email,
                'nickname' => $nickname,
                'password' => Hash::make($password),
                'hash' => User::generateHash(),
                'sponsor_id' => $sponsor_query ? $sponsor_query['id'] : config('app.default-partner-id'),
                'account_number' => User::generateAccountNumber()
            ];

            $create = User::create($payload);
            
            //$create->addToBinaryTree($leg);

            $create->notify(new \App\Notifications\Register);
            $create->notify(new \App\Notifications\SettingsUpdate);

            if ($sponsor_query) {
                $sponsor_query->notify(new \App\Notifications\RegisterPartner($nickname));
            }

            //$create->notify(new \App\Notifications\AddToBinary);

            $create->assignRole('user');

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
                'sponsor' => $sponsor,
                'leg' => $leg
            ]);
    }
}
