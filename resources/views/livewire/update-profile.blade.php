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

            <h2 class="content-heading pt-0">
                <i class="fa fa-fw fa-share-alt text-muted me-1"></i> Связи
            </h2>
            <div class="row push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Вы можете подключить свою учетную запись к сторонним сетям, чтобы получить дополнительные функции.
                    </p>
                </div>
                <div class="col-lg-8 col-xl-7">
                    @if (!request()->user()->telegram_id)
                        <div class="row mb-4">
                            <div class="col-sm-10 col-md-8 col-xl-6">
                                <a class="btn w-100 btn-alt-primary text-start" target="_blank" href="{{ url('https://t.me/PheonixTechBot?start=' . request()->user()->hash) }}">
                                    <i class="fab fa-fw fa-telegram opacity-50 me-1"></i> Подключить к Telegram
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-sm-10 col-md-8 col-xl-6">
                                <div class="btn w-100 btn-alt-primary bg-white d-flex align-items-center justify-content-between">
                                    <span>
                                        <i class="fab fa-fw fa-telegram me-1"></i> Telegram подключен
                                    </span>
                                    <i class="fa fa-fw fa-check me-1"></i>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-xl-6 mt-1 d-md-flex align-items-md-center fs-sm">
                                <form method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-alt-danger rounded-pill" wire:click="telegramDisable">
                                        <i class="fa fa-fw fa-pencil-alt opacity-50 me-1"></i> Отсоединить
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
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