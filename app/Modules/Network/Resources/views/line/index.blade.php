@extends('network::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-3">
                Линейный маркетинг
            </h1>
        </div>
    </div>
</div>
<div class="content content-full">
    @php
        $subscribe = request()->user()->getCurrentSubscribe();

        $lines = $subscribe['line_marketing'] ?? 0;
    @endphp

    <div class="block block-rounded">
        <ul class="nav nav-tabs nav-tabs-alt d-flex justify-content-center" role="tablist">
            <li class="nav-item" @if ($lines < 1)data-bs-toggle="tooltip" data-bs-title="Уровень 1 доступен при подписке на тарифы: Start, Medium, Business"@endif>
                <a @if ($lines >= 1)href="{{ route('network.line') }}"@endif class="nav-link @if ($level == 1) active @endif @if ($lines < 1) disabled @endif">@if ($lines < 1)<i class="fa fa-lock"></i>@endif Уровень 1</a>
            </li>
            <li class="nav-item" @if ($lines < 5)data-bs-toggle="tooltip" data-bs-title="Уровень 2 доступен при подписке на тарифы: Medium, Business"@endif>
                <a @if ($lines >= 5)href="{{ route('network.line', ['level_depth' => 2]) }}"@endif class="nav-link @if ($level == 2) active @endif @if ($lines < 5) disabled @endif">@if ($lines < 5)<i class="fa fa-lock"></i>@endif Уровень 2</a>
            </li>
            <li class="nav-item" @if ($lines < 5)data-bs-toggle="tooltip" data-bs-title="Уровень 3 доступен при подписке на тарифы: Medium, Business"@endif>
                <a @if ($lines >= 5)href="{{ route('network.line', ['level_depth' => 3]) }}"@endif class="nav-link @if ($level == 3) active @endif @if ($lines < 5) disabled @endif">@if ($lines < 5)<i class="fa fa-lock"></i>@endif Уровень 3</a>
            </li>
            <li class="nav-item" @if ($lines < 5)data-bs-toggle="tooltip" data-bs-title="Уровень 4 доступен при подписке на тарифы: Medium, Business"@endif>
                <a @if ($lines >= 5)href="{{ route('network.line', ['level_depth' => 4]) }}"@endif class="nav-link @if ($level == 4) active @endif @if ($lines < 5) disabled @endif">@if ($lines < 5)<i class="fa fa-lock"></i>@endif Уровень 4</a>
            </li>
            <li class="nav-item" @if ($lines < 5)data-bs-toggle="tooltip" data-bs-title="Уровень 5 доступен при подписке на тарифы: Medium, Business"@endif>
                <a @if ($lines >= 5)href="{{ route('network.line', ['level_depth' => 5]) }}"@endif class="nav-link @if ($level == 5) active @endif @if ($lines < 5) disabled @endif">@if ($lines < 5)<i class="fa fa-lock"></i>@endif Уровень 5</a>
            </li>
            <li class="nav-item" @if ($lines < 10)data-bs-toggle="tooltip" data-bs-title="Уровень 6 доступен при подписке на тарифы: Business"@endif>
                <a @if ($lines == 10)href="{{ route('network.line', ['level_depth' => 6]) }}"@endif class="nav-link @if ($level == 6) active @endif @if ($lines < 10) disabled @endif">@if ($lines < 10)<i class="fa fa-lock"></i>@endif Уровень 6</a>
            </li>
            <li class="nav-item" @if ($lines < 10)data-bs-toggle="tooltip" data-bs-title="Уровень 7 доступен при подписке на тарифы: Business"@endif>
                <a @if ($lines == 10)href="{{ route('network.line', ['level_depth' => 7]) }}"@endif class="nav-link @if ($level == 7) active @endif @if ($lines < 10) disabled @endif">@if ($lines < 10)<i class="fa fa-lock"></i>@endif Уровень 7</a>
            </li>
            <li class="nav-item" @if ($lines < 10)data-bs-toggle="tooltip" data-bs-title="Уровень 8 доступен при подписке на тарифы: Business"@endif>
                <a @if ($lines == 10)href="{{ route('network.line', ['level_depth' => 8]) }}"@endif class="nav-link @if ($level == 8) active @endif @if ($lines < 10) disabled @endif">@if ($lines < 10)<i class="fa fa-lock"></i>@endif Уровень 8</a>
            </li>
            <li class="nav-item" @if ($lines < 10)data-bs-toggle="tooltip" data-bs-title="Уровень 9 доступен при подписке на тарифы: Business"@endif>
                <a @if ($lines == 10)href="{{ route('network.line', ['level_depth' => 9]) }}"@endif class="nav-link @if ($level == 9) active @endif @if ($lines < 10) disabled @endif">@if ($lines < 10)<i class="fa fa-lock"></i>@endif Уровень 9</a>
            </li>
            <li class="nav-item" @if ($lines < 10)data-bs-toggle="tooltip" data-bs-title="Уровень 10 доступен при подписке на тарифы: Business"@endif>
                <a @if ($lines == 10)href="{{ route('network.line', ['level_depth' => 10]) }}"@endif class="nav-link @if ($level == 10) active @endif @if ($lines < 10) disabled @endif">@if ($lines < 10)<i class="fa fa-lock"></i>@endif Уровень 10</a>
            </li>
        </ul>
        <div class="block-content block-content-full border-bottom">
            <div class="row text-center">
                <div class="col-lg-4 py-3">
                    <div class="fs-1 fw-light text-dark mb-0">
                        {{ $total_partners }} чел.
                    </div>
                    <div class="fs-sm fw-bold text-muted text-uppercase">
                        Количество партнёров
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="fs-1 fw-light text-dark mb-0">
                        {{ $total_activated_partners }} чел.
                    </div>
                    <div class="fs-sm fw-bold text-muted text-uppercase">
                        Активированные партнёры
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="fs-1 fw-light text-dark mb-0">
                        {{ $partners_activation_percentage }} %
                    </div>
                    <div class="fs-sm fw-bold text-muted text-uppercase">
                        Процент активаций
                    </div>
                </div>
            </div>

            <div style="height: 400px;">
                <canvas id="chart" height="400"></canvas>
            </div>

            <table class="table table-bordered table-striped table-vcenter fs-sm mt-3">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell text-center" style="width: 32px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="text-center" style="width: 15%;">Тариф</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Партнёры</th>
                        {{--<th class="text-center" style="width: 20%;">Объём</th>--}}
                        <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Дата активации</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $partner)
                        <tr>
                            <td class="d-none d-sm-table-cell text-center">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="Аватар участника {{ $partner['nickname'] }}">
                            </td>
                            <td>{{ $partner['nickname'] }} <div class="fs-xs text-muted">Спонсор: {{ $partner['sponsor']['nickname'] }}</div></td>
                            <td class="text-center">{{ $partner['current_subscribe_title'] }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                            {{--<td class="text-center">{{ $partner['total_value'] }}</td>--}}
                            <td class="d-none d-sm-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Сейчас у Вас нет ни одного партнёра на уровне {{ $level }}...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $partners->links() }}
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script>
        var chart_payload = JSON.parse(@json($chart));

        function initChart() {
            Chart.defaults.color = "#818d96",
            Chart.defaults.scale.beginAtZero = 0,
            Chart.defaults.elements.point.radius = 3,
            Chart.defaults.elements.point.hoverRadius = 5,
            Chart.defaults.plugins.tooltip.radius = 3,
            Chart.defaults.plugins.legend.display = 1;

            new Chart(document.getElementById("chart"), {
                type: "line",
                data: {
                    labels: chart_payload.activation.dates,
                    datasets: [
                        {
                            label: "Регистрации",
                            fill: false,
                            backgroundColor: "#2770dd",
                            borderColor: "#2770dd",
                            pointBackgroundColor: "#2770dd",
                            data: chart_payload.registration.values
                        }, {
                            label: "Активации",
                            fill: false,
                            backgroundColor: "#5fc520",
                            borderColor: "#5fc520", 
                            pointBackgroundColor: "#5fc520",
                            data: chart_payload.activation.values
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Даты'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Партнёры'
                            },
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return value.toFixed(0);
                                }
                            },
                            suggestedMin: 0,
                            suggestedMax: Math.max(chart_payload.activation.max, chart_payload.registration.max)
                        },
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (t) {
                                    return t.parsed.y + " чел."
                                }
                            }
                        }
                    }
                }
            })
        }

        initChart()
    </script>
@endpush