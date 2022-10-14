<?php

namespace App\Http\Livewire;

use App\Modules\Profile\Entities\Activity;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Countries\Package\Countries;

class UpdateProfile extends Component
{
    public $country;
    public $countries = [];
    public $lastname;
    public $firstname;
    public $patronymic;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $listeners = [
        'selectCountry',
    ];

    public function selectCountry($item)
    {
        $this->country = $item;
    }


    public function telegramDisable(Request $request)
    {
        $request->user()->update([
            'telegram_id' => null
        ]);
    }

    public function boot(Request $request)
    {
        $this->countries = json_decode(Storage::get('countries/list.json'), true);

        $this->lastname = $request->user()->lastname;
        $this->firstname = $request->user()->firstname;
        $this->patronymic = $request->user()->patronymic;
        $this->country = $request->user()->country;
    }

    public function submit(Request $request)
    {
        $this->validate([
            'lastname' => 'required|alpha_spaces',
            'firstname' => 'required|alpha_spaces',
            'patronymic' => 'nullable|alpha_spaces',
            'current_password' => ['nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (!Hash::check($value, $request->user()->password)) {
                        return $fail(__('Текущий пароль не совпадает.'));
                    }
                }
            ],
            'new_password' => 'nullable|required_with:current_password|min:6|confirmed',
            'new_password_confirmation' => 'nullable|required_with:new_password,current_password',
        ], [
            'lastname.required' => 'Поле «Фамилия» обязательно для заполнения.',
            'firstname.required' => 'Поле «Имя» обязательно для заполнения.',
            'lastname.alpha_spaces' => 'Поле «Фамилия» должно содержать только буквы и пробелы.',
            'firstname.alpha_spaces' => 'Поле «Имя» должно содержать только буквы и пробелы.',
            'patronymic.alpha_spaces' => 'Поле «Отчество» должно содержать только буквы и пробелы.',
            'new_password.min' => 'Минимальная длина пароля - 6 символов.',
            'new_password.confirmed' => 'Новый пароль не совпадает с подтверждением.',
            'new_password.required_with' => 'Вы должны ввести новый пароль.',
            'new_password_confirmation.required_with' => 'Вы должны подтвердить новый пароль.',
        ]);

        $params = [
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
        ];

        if (!empty(trim($this->patronymic)))
        {
            $params['patronymic'] = $this->patronymic;
        }

        if (!empty(trim($this->new_password)))
        {
            $params['password'] = Hash::make($this->new_password);
        }

        if (!empty(trim($this->country)))
        {
            $params['country'] = $this->country;
        }

        $request->user()->update($params);

        if (isset($params['password'])) {
            //$request->session()->regenerate();

            $this->current_password = null;
            $this->new_password = null;
            $this->new_password_confirmation = null;

            session()->flash('password_update', 'Пароль от личного кабинета успешно изменён.');
            
            Activity::storeAction('update_password', $request);
        } else {
            Activity::storeAction('update_profile_settings', $request);
        }
    }

    public function render()
    {
        return view('livewire.update-profile');
    }
}
