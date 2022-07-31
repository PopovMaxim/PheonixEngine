<div class="block block-rounded">
    <div class="block-content">
        <form method="POST" wire:submit.prevent="submit" autocomplete="off">
            <h2 class="content-heading pt-0">
                <i class="fa fa-fw fa-user-circle text-muted me-1"></i> Ваш профиль
            </h2>
            <div class="row push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Важная информация по Вашей учётной записи. Публичными (в рамках личного кабинета) будут только никнейм и аватар.
                    </p>
                </div>
                <div class="col-lg-8 col-xl-5">
                    <div class="mb-4">
                        <label class="form-label">Никнейм</label>
                        <input type="text" class="form-control" value="{{ request()->user()->nickname }}" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Электронная почта</label>
                        <input type="email" class="form-control" value="{{ request()->user()->email }}" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="lastname"><span class="text-danger">*</span> Фамилия</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" wire:model="lastname" placeholder="Введите свою фамилию..." value="">
                        @error('lastname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="firstname"><span class="text-danger">*</span> Имя</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" wire:model="firstname" placeholder="Введите своё имя..." value="">
                        @error('firstname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="patronymic">Отчество (если есть)</label>
                        <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" name="patronymic" wire:model="patronymic" placeholder="Введите своё отчество..." value="">
                        @error('patronymic')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="country">Страна</label>
                        <select class="form-select" id="country" wire:model="country">
                            <option value="russia">Россия</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="city">Город</label>
                        <select class="form-select js-select2" id="city" wire:model="city" data-placeholder="Выберите город...">
                            <option></option>
                            @foreach ($cities as $key => $value)
                                <optgroup label="{{ $key }}">
                                    @foreach ($value as $city)
                                        <option value="{{ $city }}" >{{ $city }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <h2 class="content-heading pt-0">
                <i class="fa fa-fw fa-asterisk text-muted me-1"></i> Изменение пароля
            </h2>
            <div class="row push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Периодическая смена пароля для входа — это простой способ защитить свою учетную запись.
                    </p>
                </div>
                <div class="col-lg-8 col-xl-5">
                    @if (session()->has('password_update'))
                        <div class="alert alert-success">
                            {{ session('password_update') }}
                        </div>
                    @endif
                    <div class="mb-4">
                        <label class="form-label @error('current_password') is-invalid @enderror" for="current_password">Текущий пароль</label>
                        <input type="password" hidden />
                        <input type="password" class="form-control" id="current_password" name="current_password" wire:model="current_password" autocomplete="off" />
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label" for="new_password">Новый пароль</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" wire:model="new_password" />
                            @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label" for="new_password_confirmation">Подтвердите новый пароль</label>
                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" wire:model="new_password_confirmation">
                            @error('new_password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- Submit -->
            <div class="row push">
                <div class="col-lg-8 col-xl-5 offset-lg-4">
                    <div class="mb-4">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-check-circle opacity-50 me-1"></i> Обновить профиль
                        </button>
                    </div>
                </div>
            </div>
            <!-- END Submit -->
        </form>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            function initCitySelector() {
                $('.js-select2').select2({
                    theme: 'bootstrap-5'
                });
            }

            initCitySelector();

            $('#city').on('change', function (e) {
                livewire.emit('selectedCity', e.target.value)
            });

            window.livewire.on('select_city', () => {
                initCitySelector();
            });

        });
    </script>
@endpush