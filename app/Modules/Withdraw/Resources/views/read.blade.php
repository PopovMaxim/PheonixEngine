@extends('withdraw::layouts.master')

@push('js')
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/withdraw"><i class="fa fa-arrow-left text-muted me-2"></i></a> Детали вывода', 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="border-bottom pb-3">
                            <div class="d-flex flex-row justify-content-between  align-items-center">
                                <div>
                                    <div>ID вывода</div>
                                    <small><b>{{ $tx['id'] }}</b></small>
                                </div>
                                <div class="d-flex flex-column">
                                    <a class="copy" data-clipboard-text="{{ $tx['id'] }}"><i class="fa fa-copy" style="font-size: 20px;"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Статус</b> {!! $tx['html_status'] !!}
                        </div>

                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Сумма</b> <div>{!! $tx['formatted_amount'] !!}</div>
                        </div>

                        @if (isset($tx['details']['gateway']['blockchain_confirmations']))
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Подтверждения</b> {{ $tx['details']['gateway']['blockchain_confirmations'] ?? 0 }} / {{ $gateway->data['min_confirmations'] }}</span>
                            </div>
                        @endif

                        <div class="border-bottom py-3">
                            <div>
                                <div>
                                    <div>Адрес</div>
                                    <small><b>{{ $tx['details']['gateway']['address'] }}</b></small>
                                </div>
                            </div>
                        </div>

                        @if (isset($tx['details']['gateway']['blockchain_hash']))
                            <div class="border-bottom py-3">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <div>Hash</div>
                                        <small><b>{{ $tx['details']['gateway']['blockchain_hash'] }}</b></small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (in_array($tx['status'], ['pending']))
                            <div class="border-top py-3">
                                <form onsubmit="return confirm('Вы уверены, что хотите отменить заявку на вывод?');" method="post" action="{{ route('withdraw.cancel') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Отменить заявку</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <h4>Часто задаваемые вопросы</h4>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_1">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_1" aria-expanded="true" aria-controls="text_1">Что делать если вывел не на тот адрес?</a>
                        </div>
                        <div id="text_1" class="collapse" role="tabpanel" aria-labelledby="header_1" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>К сожалению, криптовалютные операции невозможно отменить, следовательно, отправленную сумму нельзя вернуть.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_2">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_2" aria-expanded="true" aria-controls="text_2">Заявка исполнена, но криптовалюта так и не поступила на мой баланс.</a>
                        </div>
                        <div id="text_2" class="collapse" role="tabpanel" aria-labelledby="header_2" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Возможно, нужно ещё немного подождать. Если всё же прошло достаточное количество времени, а криптовалюта так и не поступила на Ваш кошелёк, то обратитесь в нашу техническую поддержку, опишите проблему и сообщите ID вывода.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_3">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_3" aria-expanded="true" aria-controls="text_3">На какой кошелёк я могу осуществить вывод?</a>
                        </div>
                        <div id="text_3" class="collapse" role="tabpanel" aria-labelledby="header_3" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>На данный момент выводы выполняются на криптокошельки USDT TRC-20 принадлежащие к сети TRON. Отправка криптовалюты на кошелёк в другой сети или сторонние контракты - равноценна потере выводимой криптовалюты.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_4">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_4" aria-expanded="true" aria-controls="text_4">Есть ли комиссия на вывод криптовалюты?</a>
                        </div>
                        <div id="text_4" class="collapse" role="tabpanel" aria-labelledby="header_4" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Комиссия на вывод составляет 0.25%, она взымается процессингом на обслуживание проведения транзакции.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_5">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_5" aria-expanded="true" aria-controls="text_5">Какой регламент у заявок на вывод?</a>
                        </div>
                        <div id="text_5" class="collapse" role="tabpanel" aria-labelledby="header_5" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Заявки на вывод исполняются каждый понедельник в 20:00 по Московскому времени.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection