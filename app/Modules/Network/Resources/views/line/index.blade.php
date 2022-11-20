@extends('network::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-4">
                Линейный маркетинг
            </h1>
        </div>
    </div>
</div>
<div class="content content-full">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <a href="#" data-bs-toggle="tooltip" data-bs-title="На графике отображаются только активные партнёры"><i class="fa fa-question-circle"></i></a> График роста команды
            </h3>
            <div class="block-options">
                <div class="block-options-item">
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $current_tariff_line['title'] }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown-default-outline-primary">
                            @foreach ($tariff_lines as $line)
                                <a class="dropdown-item @if ($current_tariff_line['id'] == $line['id']) disabled @endif" href="{{ route('network.line', ['level_depth' => $level ?? 1, 'tariff_line' => $line['id']]) }}">{{ $line['title'] }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Уровень {{ $level }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown-default-outline-primary">
                            @for($i = 1; $i <= 10; $i++)
                                <a class="dropdown-item @if ($lines < $i) disabled @endif @if ($level == $i) fw-bold @endif" href="{{ route('network.line', ['level_depth' => $i ?? 1, 'tariff_line' => $current_tariff_line['id']]) }}">Уровень {{ $i }}</a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
                        Активные партнёры
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
        </div>
    </div>
    <h2 class="content-heading pt-0">
        Партнёры на уровне {{ $level }}
    </h2>
    <div class="block block-rounded h-100 mb-0">
        <div class="block-content d-flex justify-content-between flex-column">
            <table class="table table-bordered table-striped table-vcenter fs-sm">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell text-center" style="width: 32px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Партнёры</th>
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
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                            <td class="d-none d-sm-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Сейчас у Вас нет ни одного партнёра на уровне {{ $level }}...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $partners->links() !!}
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
                            backgroundColor: "#6849ad",
                            borderColor: "#6849ad",
                            pointBackgroundColor: "#6849ad",
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