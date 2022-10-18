@extends('refill::layouts.master')

@push('js')
    @if (in_array($tx['status'], ['new', 'pending']))
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
    @endif
    
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
                                <form onsubmit="return confirm('Вы уверены, что хотите отменить заявку на пополнение?');" method="post" action="{{ route('refill.cancel', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Отменить заявку</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                @include('refill::components.faq')
            </div>
        </div>
    </div>
@endsection
