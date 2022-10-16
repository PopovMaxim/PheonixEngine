@extends('refill::layouts.master')

@push('js')
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
@endpush

@push('css')
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/admin/transactions/refills"><i class="fa fa-arrow-left text-muted me-2"></i></a> Пополнение баланса', 'breadcrumbs' => [
        [
            'title' => 'Панель администратора'
        ],
        [
            'title' => 'Операции'
        ],
        [
            'title' => 'Список пополнений'
        ],
    ]])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-8">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <b>Пользователь</b>
                            <a href="{{ route('admin.users.read', ['id' => $tx['user']['id']]) }}">
                                <div class="d-flex flex-row my-3">
                                    <div class="me-2">
                                        <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                    </div>
                                    <div>
                                        {{ $tx['user']['nickname'] }}
                                        <div class="text-muted fs-sm">
                                            ФИО: {{ $tx['user']['full_name'] }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Статус</b> {!! $tx['html_status'] !!}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Дата создания</b> {!! $tx['created_at'] !!}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Дата изменения</b> {!! $tx['updated_at'] !!}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Монета</b> <span class="ms-3 d-flex align-items-center"><img src="{{ asset($gateway->data['icon']) }}" class="me-1" style="width: 24px; height: 24px;"> {{ $gateway->data['title'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Сеть</b> {{ $gateway->data['network'] }}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Подтверждения</b> {{ $tx['details']['gateway']['blockchain_confirmations'] ?? 0 }} / {{ $gateway->data['min_confirmations'] }}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Минимальная сумма</b> {{ $gateway->data['min_amount'] }} {{ $gateway->data['abbr'] }}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Комиссия шлюза</b> {{ $gateway->data['processing_comission'] }} {{ $gateway->data['abbr'] }}
                        </div>
                        @if ($gateway->data['network_comission'])
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Комиссия сети</b> {{ $gateway->data['network_comission'] }} {{ $gateway->data['abbr'] }}
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Полученная сумма</b> <div>{!! $tx['details']['gateway']['amount'] ?? 0 !!} {{ $gateway->data['abbr'] }}</div>
                        </div>

                        @if (isset($tx['details']['gateway']['rate']))
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Текущая цена:</b> <div>{!! number_format($tx['details']['gateway']['rate'], 2) ?? 0 !!} {{ config('app.external-currency') }}</div>
                            </div>
                        @endif
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
                        
                        <div class="border-top py-3">
                            <form method="post" action="{{ route('refill.cancel', ['type' => $tx['details']['gateway']['type'], 'currency' => $tx['details']['gateway']['currency']]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Отменить заявку</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
@endsection
