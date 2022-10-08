@extends('network::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Мои партнёры
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-full">
        @livewire('team-growth-chart')

        {{--
        <div class="row">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ссылки на приглашение партнёров</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center p-3" style="min-height: 85px;">
                                <div>
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Ссылка на регистрацию
                                    </p>
                                    <p class="text-dark-75 fs-sm mb-0 d-none d-md-block">
                                        Партнёр будет зарегистрирован в выбранную ногу согласно настройкам.
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}/left">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between p-3" style="min-height: 85px;">
                                <div>
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Регистрация в левую ногу
                                    </p>
                                    <p class="text-dark-75 fs-sm mb-0 d-none d-md-block">
                                        Партнёр будет принудительно зарегистрирован в левую ногу.
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a class="block block-rounded bg-light mb-0 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}/right">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between p-3" style="min-height: 85px;">
                                <div>
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Регистрация в правую ногу
                                    </p>
                                    <p class="text-dark-75 fs-sm mb-0 d-none d-md-block">
                                        Партнёр будет принудительно зарегистрирован в правую ногу.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @livewire('update-partner-register-side')
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Ссылкf на приглашение партнёров</h3>
            </div>
            <div class="block-content block-content-full">
                <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}">
                    <div class="block-content block-content-sm block-content-full d-flex align-items-center p-3" style="min-height: 85px;">
                        <div>
                            <p class="text-dark fs-5 fw-light mb-0">
                                Ссылка на регистрацию
                                <div class="fs-sm text-muted">(нажмите чтобы скопировать)</div>
                            </p>
                            <p class="text-dark-75 fs-sm mb-0 d-none d-md-block">
                                После регистрации по этой ссылке, партнёр попадёт в Вашу структуру.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        --}}

        @if (request()->user()->sponsor)
            <h2 class="content-heading">
                <i class="fa fa-angle-right text-muted me-1"></i> Мой спонсор
            </h2>

            <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fs-lg fw-semibold mb-0 d-flex align-items-center">
                            <img class="img-avatar img-avatar-thumb me-3" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                            {{ request()->user()->sponsor->nickname }}
                        </p>
                    </div>
                    <div class="ms-3">
                    </div>
                </div>
            </a>
        @endif

        @livewire('partners-widget')
    </div>
@endsection
