<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateProfile extends Component
{
    public $city = 'Норильск';
    public $country = 'russia';
    public $lastname;
    public $firstname;
    public $patronymic;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    private $cities;

    protected $listeners = [
        'selectedCity',
    ];

    public function hydrate()
    {
        $this->emit('select_city');
    }

    public function selectedCity($item)
    {
        $this->city = $item;
    }

    public function boot(Request $request)
    {
        $this->lastname = $request->user()->lastname;
        $this->firstname = $request->user()->firstname;
        $this->patronymic = $request->user()->patronymic;
        $this->city = $request->user()->city;
        
        if (!is_null($request->user()->country)) {
            $this->country = $request->user()->country;
        }

        $this->cities = json_decode(Storage::get('countries/russia.json'), true);

        $grouped_by_region = [];

        foreach ($this->cities as $city)
        {
            $grouped_by_region[$city['region']][] = $city['city'];
        }

        $this->cities = $grouped_by_region;
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

        if (!empty(trim($this->city)))
        {
            $params['city'] = $this->city;
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
        }
    }

    public function render()
    {
        return view('livewire.update-profile')
            ->with([
                'cities' => $this->cities
            ]);
    }
}