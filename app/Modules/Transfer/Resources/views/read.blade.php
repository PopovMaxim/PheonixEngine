@extends('transfer::layouts.master')

@push('js')
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/transfer"><i class="fa fa-arrow-left text-muted me-2"></i></a> Детали перевода', 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="border-bottom py-3">
                            <div class="d-flex flex-row justify-content-between  align-items-center">
                                <div>
                                    <div>ID перевода</div>
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
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            @if ($tx['details']['sender'] != $tx['user_id'])
                                <b>Отправитель</b>
                                <div>{{ $tx['sender']['nickname'] }}</div>
                            @else
                                <b>Получатель</b>
                                <div>{{ $tx['receiver']['nickname'] }}</div>
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
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_1" aria-expanded="true" aria-controls="text_1">Можно ли вернуть перевод?</a>
                        </div>
                        <div id="text_1" class="collapse" role="tabpanel" aria-labelledby="header_1" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Как правило - отмена переводов не производится. Если Вы ошиблись при переводе, то обратитесь в техническую поддержку.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_2">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_2" aria-expanded="true" aria-controls="text_2">Есть ли комиссия за перевод?</a>
                        </div>
                        <div id="text_2" class="collapse" role="tabpanel" aria-labelledby="header_2" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Нет, внутренние переводы комиссией не облагаются.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_3">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_3" aria-expanded="true" aria-controls="text_3">Как быстро будет выполнен мой перевод?</a>
                        </div>
                        <div id="text_3" class="collapse" role="tabpanel" aria-labelledby="header_3" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Внутренние переводы совершаются мгновенно.</p>
                            </div>
                        </div>
                    </div>
                    <div class="block block-transparent mb-0">
                        <div class="block-header ps-0 pt-0" role="tab" id="header_4">
                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_4" aria-expanded="true" aria-controls="text_4">Я получил перевод с иконкой замка, что это означает?</a>
                        </div>
                        <div id="text_4" class="collapse" role="tabpanel" aria-labelledby="header_4" data-bs-parent="#accordion" style="">
                            <div class="block-content ps-0 pt-0 fs-sm">
                                <p>Вы получили защищённый перевод. Средства будут зачислены на Ваш баланс только после ввода секретного кода, который находится у отправителя перевода.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection