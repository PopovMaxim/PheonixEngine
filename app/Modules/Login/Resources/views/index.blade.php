@extends('login::layouts.master')

@push('js')
@endpush

@push('css')
    <style>
        body {
            background-image: url('assets/media/welcome/hero2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top;
        }
    </style>
@endpush

@section('content')
<div class="bg-primary-dark-op">
    <div class="row g-0 justify-content-center">
        <div class="hero-static col-sm-10 col-md-8 col-xl-2 d-flex align-items-center p-2 px-sm-0">
            <div class="block block-rounded w-100 mb-0 overflow-hidden">
                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                    <div class="mb-2 text-center">
                        <a class="fw-bold fs-1" href="{{ route('login') }}">
                            <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid w-50 mb-5" />
                        </a>
                        <p class="text-uppercase fw-bold fs-sm text-muted">Вход</p>
                    </div>
                    <form action="{{ route('login.authorize') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="email" class="form-control form-control-alt @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Электронная почта">
                            @error('email')
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
                            <button type="submit" class="btn w-100 btn-hero btn-primary">
                                <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Войти
                            </button>
                        </div>
                        <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                            <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="{{ route('password.request') }}">
                                <i class="fa fa-exclamation-triangle opacity-50 me-1"></i> Забыл пароль
                            </a>
                            
                            <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="{{ route('register') }}">
                                <i class="fa fa-user opacity-50 me-1"></i> Регистрация
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection