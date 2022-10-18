@extends('transfer::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/maskMoney/jquery.maskMoney.min.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#amount').maskMoney();
        })
    </script>
    
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
@endpush

@push('css')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet" />
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/refill"><i class="fa fa-arrow-left text-muted me-2"></i></a> Пополнение баланса', 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                            <b>Монета</b> <span class="ms-3 d-flex align-items-center"><img src="{{ asset($gateway->data['icon']) }}" class="me-1" style="width: 24px; height: 24px;"> {{ $gateway->data['title'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Сеть</b> {{ $gateway->data['network'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Подтверждения</b> {{ $gateway->data['min_confirmations'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Минимальная сумма</b> {{ $gateway->data['min_amount'] }} {{ $gateway->data['abbr'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Комиссия платформы</b> {{ $gateway->data['processing_comission'] }} {{ $gateway->data['abbr'] }}</span>
                        </div>
                        @if ($gateway->data['network_comission'])
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Комиссия сети</b> {{ $gateway->data['network_comission'] }} {{ $gateway->data['abbr'] }}</span>
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            @if ($tx)
                                <a class="btn btn-primary w-100" href="{{ route('refill.pay', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]) }}">Перейти к заявке</a>
                            @else
                                <form onsubmit="return confirm('Обязательно ознакомьтесь с минимальной суммой пополнения для выбранного способа!');" method="post" class="w-100" action="{{ route('refill.pay', ['type' => $gateway->data['type'], 'currency' => $gateway->data['key']]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Получить адрес</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                @include('refill::components.faq')
            </div>
        </div>
    </div>
@endsection
