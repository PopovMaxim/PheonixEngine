@extends('transfer::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/maskMoney/jquery.maskMoney.min.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#amount').maskMoney();
        })
    </script>
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
                            @if ($counter)
                                <a class="btn btn-primary w-100" href="{{ route('refill.pay', ['uuid' => $counter['id'], 'type' => $counter['details']['gateway']['type'], 'currency' => $counter['details']['gateway']['currency']]) }}">Перейти к заявке</a>
                            @else
                                <form method="post" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Получить адрес</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <h4>Часто задаваемые вопросы</h4>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_1">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_1" aria-expanded="true" aria-controls="text_1">Как пополнить мой баланс с помощью криптовалюты?</a>
                        </div>
                        <div id="text_1" class="collapse" role="tabpanel" aria-labelledby="header_1" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Тут должна была быть инструкция, но её тут нет...</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_2">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_2" aria-expanded="true" aria-controls="text_2">Сколько времени занимает проверка платежа?</a>
                        </div>
                        <div id="text_2" class="collapse" role="tabpanel" aria-labelledby="header_2" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Тут должна была быть инструкция, но её тут нет...</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_3">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_3" aria-expanded="true" aria-controls="text_3">Что такое подтверждениe?</a>
                        </div>
                        <div id="text_3" class="collapse" role="tabpanel" aria-labelledby="header_3" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Тут должна была быть инструкция, но её тут нет...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
