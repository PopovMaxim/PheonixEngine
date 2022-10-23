@extends('passwordreset::layouts.master')

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
                <div class="text-center">
                    <a class="fw-bold fs-1" href="{{ route('register') }}">
                        <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid w-50 mb-5" />
                    </a>
                    <p class="text-uppercase fw-bold fs-sm text-muted">Восстановление пароля</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="password" name="password" hidden />
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <input type="hidden" name="email" value="{{ request()->get('email') }}" />

                    <div class="py-3">
                        <input type="password" class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Новый пароль">
                        @error('password')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="pb-3">
                        <input type="password" class="form-control form-control-lg form-control-alt @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Подтвердите новый пароль">
                        @error('password_confirmation')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn w-100 btn-lg btn-hero btn-primary">
                            <i class="fa fa-fw fa-reply opacity-50 me-1"></i> Обновить пароль
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
