<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">График роста команды</h3>
        <div class="block-options">
        </div>
    </div>
    <div class="block-content block-content-full border-bottom">
        <div class="row text-center">
        <div class="col-lg-4 py-3">
            <div class="fs-1 fw-light text-dark mb-0">
                {{ request()->user()->partners_count }} чел.
            </div>
            <div class="fs-sm fw-bold text-muted text-uppercase">
                Количество партнёров
            </div>
        </div>
        <div class="col-lg-4 py-3">
            <div class="fs-1 fw-light text-dark mb-0">
                {{ request()->user()->partners_activation_count }} чел.
            </div>
            <div class="fs-sm fw-bold text-muted text-uppercase">
                Активированные партнёры
            </div>
        </div>
        <div class="col-lg-4 py-3">
            <div class="fs-1 fw-light text-dark mb-0">
                {{ request()->user()->partners_activation_percentage }} %
            </div>
            <div class="fs-sm fw-bold text-muted text-uppercase">
                Процент активаций
            </div>
        </div>
        </div>
    </div>
    <div class="block-content block-content-full">
        <canvas id="chart" height="400"></canvas>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script>
        var chart_payload = JSON.parse(@json($chart));

        Dashmix.onLoad(class {
            static initChart() {
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
            static init() {
                this.initChart()
            }
        }.init());
    </script>
@endpush