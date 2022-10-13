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
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Заявка на вывод
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <div class="row d-flex justify-content-between mb-4">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-content">
                        @if (!$withdraw_request)
                            @if(session()->has('request_status'))
                                @php
                                    $session = session('request_status');
                                @endphp
                                <div class="alert alert-{{ $session['type'] }}">{{ $session['text'] }}</div>
                            @endif
                            <form action="{{ route('withdraw.request') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label" for="address">Адрес криптокошелька</label>
                                    <input type="text" class="form-control form-control-alt @error('address') is-invalid @enderror" id="address" name="address" placeholder="Только USDT TRC-20">
                                    @error('address')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="amount">Сумма</label>
                                    <input type="text" class="form-control form-control-alt @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="100.00">
                                    @error('amount')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="amount">Код подтверждения</label>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <input type="text" class="form-control form-control-alt @error('confirm_code') is-invalid @enderror me-lg-4" name="confirm_code" placeholder="Код из почтового сообщения">
                                        <button type="submit" name="send_confirm_code" class="btn btn-outline-primary">Выслать&nbsp;код</button>
                                    </div>
                                    @error('confirm_code')
                                        <div class="text-danger fs-sm mt-1 animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-primary">
                                В настоящее время Ваша заявка на вывод находится в обработке. Заявки исполняются согласно регламенту.
                            </div>
                            <p>
                                Валюта: <br/>
                                <span class="d-flex align-items-center"><img src="{{ asset($gateway->data['icon']) }}" class="me-1" style="width: 24px; height: 24px;"> {{ $gateway->data['title'] }}</span>
                            </p>
                            <p>
                                Адрес криптокошелька: <br/>
                                <b>{{ $withdraw_request['obfuscated_address'] }}</b>
                            </p>
                            <p>
                                <a href="{{ route('withdraw.read', ['uuid' => $withdraw_request['id']]) }}">Подробнее</a>
                            </p>
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
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_3" aria-expanded="true" aria-controls="text_3">На какой кошелёк я могу получить выплату?</a>
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
                                <p>Комиссия на вывод составляет 0.5%, она взымается процессингом на обслуживание проведения транзакции.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_5">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_5" aria-expanded="true" aria-controls="text_5">Какой регламент у выплат?</a>
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
        
        <div class="content-heading pt-0">История выводов</div>

        <div class="block block-rounded h-100 mb-0">
            <div class="block-content d-flex justify-content-between flex-column">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-vcenter fs-sm">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20%;">Статус</th>
                                <th class="text-left" style="width: 20%;">Валюта</th>
                                <th class="text-center" style="width: 20%;">Сумма</th>
                                <th class="text-center" style="width: 20%;">Адрес</th>
                                <th class="text-center" style="width: 20%;">Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdrawals as $transaction)
                                <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href = '{{ route('withdraw.read', ['uuid' => $transaction['id']]) }}'">
                                    <td class="text-center">{!! $transaction['html_status'] !!}</td>
                                    <td><div class="d-flex flex-row align-items-center"><img src="{{ asset($transaction['gateway']->data['icon']) }}" class="me-2" style="width: 30px; height: 30px;" /> <span class="d-none d-sm-block">{{ $transaction['gateway']->data['title'] }}</span></div></td>
                                    <td class="text-center" style="width: 20%;">
                                        {{ $transaction['formatted_amount'] }}
                                    </td>
                                    <td class="text-center" style="width: 20%;">
                                        {{ $transaction['obfuscated_address'] }}
                                    </td>
                                    <td class="text-center">
                                        <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Ни одного вывода не найдено...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $withdrawals->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
