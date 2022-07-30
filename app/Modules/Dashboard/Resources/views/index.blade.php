@extends('dashboard::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-4">
                Информационная панель
            </h1>
        </div>
    </div>
</div>
<div class="content content-full">
    <div class="row items-push">
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->partners_count }}</div>
                    <div class="text-muted mb-3">Мои партнёры</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-percent fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->partners_activation_percentage }}%</div>
                    <div class="text-muted mb-3">Процент активаций</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-chart-line fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">0,00 ₽</div>
                    <div class="text-muted mb-3">Всего начислено</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-wallet fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->formatted_balance }}</div>
                    <div class="text-muted mb-3">Текущий баланс</div>
                </div>
            </div>
        </div>
    </div>

    <div class="block block-rounded block-transparent bg-gd-sea h-100" href="javascript:void(0)">
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
                <p class="fs-lg fw-semibold mb-0 text-white">
                    Партнёрская ссылка
                </p>
                <p class="text-white-75 mb-0">{{ request()->user()->referral_link }}</p>
            </div>
            <div class="ms-3 item">
                <i class="fa fa-2x fa-user-plus text-white-50"></i>
            </div>
        </div>
    </div>

    <div class="row items-push">
        <div class="col-xl-6">
            @livewire('partners-widget')
        </div>
        <div class="col-xl-6">
            @livewire('operations-history')
        </div>
    </div>

    @livewire('traders-quotes')
</div>
@endsection
