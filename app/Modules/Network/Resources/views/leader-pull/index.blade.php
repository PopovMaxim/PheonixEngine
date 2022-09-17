@extends('network::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script>Dashmix.helpersOnLoad(['jq-easy-pie-chart']);</script>
@endpush

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-3">
                Лидерский пулл
            </h1>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="row items-push">
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fs-lg fw-semibold mb-0">
                            @if (!is_null($current_pull))
                                Пулл #{{ $current_pull['pull'] }}
                            @else
                                Нет
                            @endif
                        </p>
                        <p class="text-muted mb-0">
                            Текущий пулл
                        </p>
                    </div>
                    <div class="ms-3 item">
                        <i class="fa fa-2x fa-crown text-muted"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fs-lg fw-semibold mb-0">
                            @if (!is_null($current_pull))
                                {{ $current_pull['percent'] * 100 }}%
                            @else
                                0%
                            @endif
                        </p>
                        <p class="text-muted mb-0">
                            Вознаграждение
                        </p>
                    </div>
                    <div class="ms-3 item">
                        <i class="fa fa-2x fa-percent text-muted"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <abbr class="fs-lg fw-semibold mb-0 " data-bs-toggle="tooltip" data-bs-title="Прибыль компании объявляется в начале нового календарного месяца.">
                            Не объявлено
                        </abbr>
                        <p class="text-muted mb-0">
                            Ваша прибыль
                        </p>
                    </div>
                    <div class="ms-3 item">
                        <i class="fa fa-2x fa-coins text-muted"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="block block block-themed block-rounded">
        <div class="block-header bg-{{ $pull[0]['color'] }}">
            <h3 class="block-title">Пулл #1 @if ($pull[0]['status'] == 'completed') (выполнен) @endif</h3>
            <div class="block-options">
                <div class="block-options-item"><a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#pull-1-info"><i class="fa fa-question-circle"></i></a></div>
            </div>
        </div>
        <div class="block-content block-content-full text-center">
            <div class="row">
            <div class="col-md-6">
                <p class="fw-medium text-muted mb-2 mb-0">
                    Объём первой линии
                </p>
                <div class="js-pie-chart pie-chart" data-percent="{{ $pull[0]['level_1_percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                    <span>{{ $pull[0]['level_1_percent'] }}%</span>
                </div>
                <p class="fw-medium text-muted mt-2 mb-0">
                    {{ number_format($pull[0]['level_1_sum'] / 100, 2) }} / 100,000.00 {{ config('app.internal-currency') }}
                </p>
            </div>
            <div class="col-md-6">
                <p class="fw-medium text-muted mb-2 mb-0">
                    Объём первой и второй линии
                </p>
                <div class="js-pie-chart pie-chart" data-percent="{{ $pull[0]['level_2_percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                    <span>{{ $pull[0]['level_2_percent'] }}%</span>
                </div>
                <p class="fw-medium text-muted mt-2 mb-0">
                    {{ number_format(($pull[0]['level_1_sum'] + $pull[0]['level_2_sum']) / 100, 2) }} / 300,000.00 {{ config('app.internal-currency') }}
                </p>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="block block block-themed block-rounded">
                <div class="block-header bg-{{ $pull[1]['color'] }}">
                    <h3 class="block-title">Пулл #2 @if ($pull[1]['status'] == 'completed') (выполнен) @endif</h3>
                    <div class="block-options">
                        <div class="block-options-item"><a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#pull-2-info"><i class="fa fa-question-circle"></i></a></div>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2 mb-0">
                                Объём первой линии
                            </p>
                            <div class="js-pie-chart pie-chart" data-percent="{{ $pull[0]['level_1_percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                                <span>{{ $pull[0]['level_1_percent'] }}%</span>
                            </div>
                            <p class="fw-medium text-muted mt-2 mb-0">
                                {{ number_format($pull[0]['level_1_sum'] / 100, 2) }} / 100,000.00 {{ config('app.internal-currency') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2 mb-0">
                                Партнёров с пуллом #1
                            </p>
                            <div class="js-pie-chart pie-chart" data-percent="{{ $pull[1]['percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                                <span>{{ $pull[1]['percent'] }}%</span>
                            </div>
                            <p class="fw-medium text-muted mt-2 mb-0">
                                {{ $pull[1]['count'] }} / 3
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block block-themed block-rounded">
                <div class="block-header bg-{{ $pull[2]['color'] }}">
                    <h3 class="block-title">Пулл #3 @if ($pull[2]['status'] == 'completed') (выполнен) @endif</h3>
                    <div class="block-options">
                        <div class="block-options-item"><a style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#pull-3-info"><i class="fa fa-question-circle"></i></a></div>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2 mb-0">
                                Объём первой линии
                            </p>
                            <div class="js-pie-chart pie-chart" data-percent="{{ $pull[0]['level_1_percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                                <span>{{ $pull[0]['level_1_percent'] }}%</span>
                            </div>
                            <p class="fw-medium text-muted mt-2 mb-0">
                                {{ number_format($pull[0]['level_1_sum'] / 100, 2) }} / 100,000.00 {{ config('app.internal-currency') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2 mb-0">
                                Партнёров с пуллом #2
                            </p>
                            <div class="js-pie-chart pie-chart" data-percent="{{ $pull[2]['percent'] }}" data-line-width="5" data-size="120" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                                <span>{{ $pull[2]['percent'] }}%</span>
                            </div>
                            <p class="fw-medium text-muted mt-2 mb-0">
                                {{ $pull[2]['count'] }} / 3
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="pull-1-info" tabindex="-1" role="dialog" aria-labelledby="pull-1-info" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Пулл #1</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <b>Вознаграждение:</b>
                    <ul class="mt-3">
                        <li>1% от объявленной прибыли компании</li>
                    </ul>

                    <b>Условия выполнения:</b>
                    <ul class="mt-3">
                        <li>Объем с первой линии: 100,000.00 {{ config('app.internal-currency') }}</li>
                        <li>Объем с первой и второй линии: 300,000.00 {{ config('app.internal-currency') }}</li>
                    </ul>

                    <p class="text-muted">Примечание: второе условие также может быть засчитано, если только в первой линии будет достигнут объем в 300,000.00 PH или более.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="pull-2-info" tabindex="-1" role="dialog" aria-labelledby="pull-2-info" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Пулл #2</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <b>Вознаграждение:</b>
                    <ul class="mt-3">
                        <li>2% от объявленной прибыли компании</li>
                    </ul>

                    <b>Условия выполнения:</b>
                    <ul class="mt-3">
                        <li>Объем с первой линии: 100,000.00 {{ config('app.internal-currency') }}</li>
                        <li>3 лично приглашенных партнёра, закрывших пулл #1</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="pull-3-info" tabindex="-1" role="dialog" aria-labelledby="pull-2-info" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Пулл #3</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <b>Вознаграждение:</b>
                    <ul class="mt-3">
                        <li>3% от объявленной прибыли компании</li>
                    </ul>

                    <b>Условия выполнения:</b>
                    <ul class="mt-3">
                        <li>Объем с первой линии: 100,000.00 {{ config('app.internal-currency') }}</li>
                        <li>3 лично приглашенных партнёра, закрывших пулл #2</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
    </script>
@endpush