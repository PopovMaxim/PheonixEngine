@extends('login::layouts.master')

@push('js')
@endpush

@section('content')
    <div class="hero-static d-flex align-items-center justify-content-center bg-body-extra-light">
        <div class="p-3" style="max-width: 450px; width: 100%;">

            <div class="text-center">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid w-75 mb-4" />
                </a>
                <p class="text-uppercase fw-bold fs-sm text-muted">Восстановление пароля</p>
            </div>

            <div class="justify-content-center">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="py-3">
                        <input type="text" class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror" id="email" name="email" placeholder="Электронная почта">
                        @error('email')
                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn w-100 btn-lg btn-hero btn-primary">
                            <i class="fa fa-fw fa-reply opacity-50 me-1"></i> Восстановить пароль
                        </button>
                        <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                            <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                                <i class="fa fa-sign-in-alt opacity-50 me-1"></i> Войти в кабинет
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
