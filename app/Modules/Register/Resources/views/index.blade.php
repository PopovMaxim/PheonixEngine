@extends('register::layouts.master')

@push('js')
@endpush

@push('css')
    <style>
        body {
            background-image: url('{{ asset("assets/media/welcome/hero2.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top;
        }
    </style>
@endpush

@section('content')
<div class="bg-primary-dark-op">
    <div class="hero-static d-flex align-items-center justify-content-center">
        <div class="block block-rounded w-100 overflow-hidden p-3"style="max-width: 450px;">
            <div class="block-content block-content-full">
                <div class="mb-2 text-center">
                    <a class="fw-bold fs-1" href="{{ route('register') }}">
                        <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid w-50 mb-5" />
                    </a>
                    <p class="text-uppercase fw-bold fs-sm text-muted">Регистрация</p>
                </div>
                <form action="{{ route('register', ['sponsor' => $sponsor, 'leg' => $leg]) }}" method="POST">
                    @csrf
                    <input hidden type="email" />
                    <input hidden type="password" />
                    <input hidden type="password_confirmation" />
                    <div class="mb-4">
                        <input type="email" class="form-control form-control-alt @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Электронная почта">
                        @error('email')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-alt @error('nickname') is-invalid @enderror" id="nickname" name="nickname" value="{{ old('nickname') }}" placeholder="Никнейм">
                        @error('nickname')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-alt @error('invite_hash') is-invalid @enderror" id="invite_hash" name="invite_hash" value="{{ $sponsor ?? old('invite_hash') }}" placeholder="Код приглашения (если есть)">
                        @error('invite_hash')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control form-control-alt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Пароль">
                        @error('password')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control form-control-alt @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Подтверждение пароля">
                        @error('password_confirmation')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input @error('password_confirmation') is-invalid @enderror" type="checkbox" value="1" id="agreement" name="agreement">
                            <label class="form-check-label" for="agreement">Я согласен/согласна с <a href="{{ route('privacy-policy') }}" target="_blank">политикой конфиденциальности</a> и <a href="{{ route('license-agreement') }}" target="_blank">лицензионным соглашением</a>.</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn w-100 btn-hero btn-primary">
                            <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Зарегистрироваться
                        </button>
                    </div>
                    <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                        <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                            <i class="fa fa-arrow-left opacity-50 me-1"></i> Назад
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
