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
                Пополнение баланса
            </h1>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="content-heading pt-0">Криптовалюты</div>
    <div class="row items-push">
        @foreach ($crypto as $currency)
            <div class="col-md-6 col-lg-3">
                <a class="block block-rounded block-link-shadow mb-0" href="{{ route('refill.form', ['type' => $currency['type'], 'currency' => $currency['key']]) }}">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between px-4">
                        <img src="{{ asset($currency['icon']) }}" style="width: 50px; height: 50px;">
                        <div class="fs-4 fw-semibold">{{ $currency['title'] }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="content-heading pt-0">История пополнений</div>

    <div class="block block-rounded h-100 mb-0">
        <div class="block-content d-flex justify-content-between flex-column">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-vcenter fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20%;">Статус</th>
                            <th class="text-center" style="width: 20%;">Способ оплаты</th>
                            <th style="width: 20%;">Валюта</th>
                            <th class="text-center" style="width: 20%;">Сумма</th>
                            <th class="text-center" style="width: 20%;">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($refills as $transaction)
                            <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href = '{{ route('refill.form', ['uuid' => $transaction['id'], 'type' => $transaction['details']['gateway']['type'], 'currency' => $transaction['details']['gateway']['currency']]) }}'">
                                <td class="text-center">{!! $transaction['html_status'] !!}</td>
                                <td class="text-center">{{ $transaction['type'] }}</td>
                                <td><div class="d-flex flex-row align-items-center"><img src="{{ asset($transaction['gateway']->data['icon']) }}" class="me-2" style="width: 30px; height: 30px;" /> <span class="d-none d-sm-block">{{ $transaction['gateway']->data['title'] }}</span></div></td>
                                <td class="text-center" style="width: 20%;">
                                    @if ($transaction['status'] == 'canceled')
                                        0 {{ $transaction['gateway']->data['abbr'] }}
                                    @else
                                        <span class="">
                                            @if (isset($transaction['details']['gateway']['amount']))
                                                {{ $transaction['details']['gateway']['amount'] }} {{ $transaction['gateway']->data['abbr'] }}
                                            @else
                                                <i class="fa fa-circle-notch fa-spin text-primary"></i>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Ни одной транзакции не найдено...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $refills->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
