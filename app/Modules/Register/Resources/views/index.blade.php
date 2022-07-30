@extends('register::layouts.master')

@push('js')
@endpush

@section('content')
    <div class="row g-0 justify-content-center bg-body-dark">
        <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0">
            <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6 order-md-1 bg-body-extra-light">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <div class="mb-2 text-center">
                                <a class="link-fx fw-bold fs-1" href="/">
                                    {{ env('APP_NAME') }}
                                </a>
                                <p class="text-uppercase fw-bold fs-sm text-muted">Регистрация</p>
                            </div>
                            <form action="{{ route('register', ['sponsor' => $sponsor, 'leg' => $leg]) }}" method="POST">
                                @csrf
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
                                    <button type="submit" class="btn w-100 btn-hero btn-primary">
                                        <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Зарегистрироваться
                                    </button>
                                </div>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="op_auth_reminder.html">
                                        <i class="fa fa-exclamation-triangle opacity-50 me-1"></i> Забыл пароль
                                    </a>
                                    <a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="{{ route('register') }}">
                                        <i class="fa fa-plus opacity-50 me-1"></i> Вход
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 order-md-0 bg-primary-dark-op d-flex align-items-center">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-white fw-semibold mb-1">
                                        {{ $quote['text'] }}
                                    </p>
                                    <a class="text-white-75 fw-semibold" href="javascript:void(0)">{{ $quote['author'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
