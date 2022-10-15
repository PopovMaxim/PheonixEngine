@extends('admin::layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            function initSelector() {
                $('.js-select2').select2({
                    theme: 'bootstrap-5'
                });
            }

            initSelector();
        });
    </script>
@endpush

@section('admin.page-actions')
<a class="btn btn-sm btn-alt-primary" href="javascript:void(0)">
    <i class="fa fa-user-plus"></i> Добавить
</a>
@endsection

@section('content')
    @include('hero', ['title' => $page_name, 'breadcrumbs' => [
        [
            'title' => 'Пользователи',
            'url' => route('admin.users')
        ],
        [
            'title' => $user['nickname'],
            'url' => route('admin.users.read', ['id' => $user['id']])
        ],
        [
            'title' => 'Редактирование',
            'active' => true
        ],
    ]])

    <div class="content content-boxed">
        <form method="POST" wire:submit.prevent="submit" autocomplete="off">
            <div class="block block-rounded">
                <div class="block-content">
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-user-circle text-muted me-1"></i> Ваш профиль
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label">Никнейм</label>
                                <input type="text" class="form-control" value="{{ $user['nickname'] }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Электронная почта</label>
                                <input type="email" class="form-control" value="{{ $user['email'] }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="lastname"><span class="text-danger">*</span> Фамилия</label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" wire:model="lastname" placeholder="Введите свою фамилию..." value="{{ $user['lastname'] }}">
                                @error('lastname')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="firstname"><span class="text-danger">*</span> Имя</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" wire:model="firstname" placeholder="Введите своё имя..." value="{{ $user['firstname'] }}">
                                @error('firstname')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="patronymic">Отчество (если есть)</label>
                                <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" name="patronymic" wire:model="patronymic" placeholder="Введите своё отчество..." value="{{ $user['patronymic'] }}">
                                @error('patronymic')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="country">Страна</label>
                                <select class="form-select js-select2" id="country" wire:model.lazy="country" data-placeholder="Выберите город...">
                                    <option></option>
                                    @foreach ($countries as $key => $value)
                                        <option value="{{ $key }}" @if($key == $user['country']) selected="" @endif>{{ $value['name_' . config('app.locale')] ?? $value['name_common'] }}</option>
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
                        <i class="fa fa-fw fa-user-plus text-muted me-1"></i> Реферальная программа
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-8">
                            @if (request()->user()->sponsor)
                                <div class="mb-4">
                                    <label class="form-label">Ваш спонсор</label>
                                    <p class="fw-semibold mb-0 d-flex align-items-center">
                                        <img class="img-avatar img-avatar48 img-avatar-thumb me-3" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                                        {{ request()->user()->sponsor->nickname }}
                                    </p>
                                </div>
                            @endif
                            <div class="mb-4">
                                <label class="form-label">Код для приглашения</label>
                                <div class="fw-bold">{{ request()->user()->hash }}</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label">Ссылка на приглашение</label>
                                    <div class="fw-bold">{{ request()->user()->referral_link }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    @if (request()->user()->telegram_id)
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
                                @if (request()->user()->telegram_id)
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
                                                <button type="button" class="btn btn-sm btn-alt-danger rounded-pill">
                                                    <i class="fa fa-fw fa-pencil-alt opacity-50 me-1"></i> Отсоединить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Submit -->
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="row p-3">
                        <div class="col-lg-8 col-xl-5 offset-lg-4">
                            <button type="submit" class="btn btn-alt-primary mb-0" wire:click="submit">
                                <i class="fa fa-check-circle opacity-50 me-1"></i> Обновить профиль
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END Submit -->
            </div>
    
        </form>
    </div>
@endsection
