@extends('refill::layouts.master')

@push('js')
    @if (in_array($tx['status'], ['new', 'pending']))
        <script src="{{ asset('assets/js/plugins/clipboardjs/clipboard.min.js') }}"></script>
        <script>
            $(function() {
                var options = {
                    html: true,
                    content: $('[data-name="popover-content"]')
                }

                var qrCode = document.getElementById('qrCode')
                var popover = new bootstrap.Popover(qrCode, options)
            })
        </script>
        <script>
            $(function() {
                var clipboard = new ClipboardJS('.copy');
                clipboard.on('success', function(e) {
                    tooltip = new bootstrap.Tooltip($(e.trigger), {
                        placement: 'top',
                        trigger: 'click',
                        title: 'Скопировано',
                    })

                    tooltip.show()

                    setTimeout(() => {
                        tooltip.dispose()
                    }, 2000)

                    e.clearSelection()
                })
            })
        </script>
    @endif
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/refill"><i class="fa fa-arrow-left text-muted me-2"></i></a> Пополнение баланса', 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="border-bottom py-3">
                            <div class="d-flex flex-row justify-content-between  align-items-center">
                                <div>
                                    <div>ID платежа</div>
                                    <small><b>{{ $tx['id'] }}</b></small>
                                </div>
                                <div class="d-flex flex-column">
                                    <a class="copy" data-clipboard-text="{{ $tx['id'] }}"><i class="fa fa-copy" style="font-size: 20px;"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Статус</b> {!! $tx['html_status'] !!}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Монета</b> <span class="ms-3 d-flex align-items-center"><img src="{{ asset($gateway->data['icon']) }}" class="me-1" style="width: 24px; height: 24px;"> {{ $gateway->data['title'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Сеть</b> {{ $gateway->data['network'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Подтверждения</b> {{ $tx['details']['gateway']['blockchain_confirmations'] ?? 0 }} / {{ $gateway->data['min_confirmations'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Минимальная сумма</b> {{ $gateway->data['min_amount'] }} {{ $gateway->data['abbr'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Комиссия шлюза</b> {{ $gateway->data['processing_comission'] }} {{ $gateway->data['abbr'] }}</span>
                        </div>
                        @if ($gateway->data['network_comission'])
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Комиссия сети</b> {{ $gateway->data['network_comission'] }} {{ $gateway->data['abbr'] }}</span>
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Полученная сумма</b> <div>{!! $tx['details']['gateway']['amount'] ?? 0 !!} {{ $gateway->data['abbr'] }}</div></span>
                        </div>

                        @if (isset($tx['details']['gateway']['rate']))
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Текущая цена:</b> <div>{!! number_format($tx['details']['gateway']['rate'], 2) ?? 0 !!} {{ config('app.external-currency') }}</div></span>
                            </div>
                        @endif

                        @if (in_array($tx['status'], ['new', 'pending']))
                            <div class="border-bottom py-3">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div>
                                        <div>Адрес</div>
                                        <small><b>{{ $tx['details']['gateway']['address'] }}</b></small>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="#" id="qrCode" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true"><i class="fa fa-qrcode" style="font-size: 20px;"></i></a>
                                        <div hidden><div data-name="popover-content">{!! \QrCode::size(160)->generate($tx['details']['gateway']['address']) !!}</div></div>
                                        <a class="copy" data-clipboard-text="{{ $tx['details']['gateway']['address'] }}"><i class="fa fa-copy" style="font-size: 20px;"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                        
                        @if (in_array($tx['status'], ['new']))
                            <div class="border-top py-3">
                                <form method="post" action="{{ route('refill.cancel', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]) }}">
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
