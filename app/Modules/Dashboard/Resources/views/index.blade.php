@extends('dashboard::layouts.master')

@push('js')
<script src="{{ asset('assets/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script>
    var countDownDate = new Date("{{ $quick_bonus['quick_bonus_end'] }}").getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (hours < 10) { hours = '0' + hours; }
        if (minutes < 10) { minutes = '0' + minutes; } 
        if (seconds < 10) { seconds = '0' + seconds; } 
        
        document.getElementById("days").innerHTML = days;
        document.getElementById("hours").innerHTML = hours;
        document.getElementById("minutes").innerHTML = minutes;
        document.getElementById("seconds").innerHTML = seconds;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("days").innerHTML = 0;
            document.getElementById("hours").innerHTML = '00';
            document.getElementById("minutes").innerHTML = '00';
            document.getElementById("seconds").innerHTML = '00';
        }
    }, 1000);
</script>
<script>Dashmix.helpersOnLoad(['jq-easy-pie-chart']);</script>
@endpush

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-4">
                Информационная панель
            </h1>
        </div>
    </div>
</div>
<div class="content content-full">
    <div class="row items-push">
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->partners_count }}</div>
                    <div class="text-muted mb-3">Мои партнёры</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-percent fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->partners_activation_percentage }}%</div>
                    <div class="text-muted mb-3">Процент активаций</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-chart-line fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->total_earned }} {{ config('app.internal-currency') }}</div>
                    <div class="text-muted mb-3">Всего начислено</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full">
                    <div class="item rounded-3 bg-body mx-auto my-3">
                        <i class="fa fa-wallet fa-lg text-primary"></i>
                    </div>
                    <div class="fs-1 fw-bold">{{ request()->user()->formatted_balance }}</div>
                    <div class="text-muted mb-3">Текущий баланс</div>
                </div>
            </div>
        </div>
    </div>
    @if ($quick_bonus['quick_bonus_end']->addDays(2) >= now() || ($quick_bonus['current_percent'] >= 100 && !request()->user()->quick_bonus_accepted))
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">Быстрый бонус</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <h4>Правила и условия акции</h4>
                        <p>
                            Чтобы получить бонус в 10,000.00 {{ config('app.internal-currency') }}, Вам необходимо набрать объём<br/>
                            личных продаж в 100,000.00 {{ config('app.internal-currency') }} в течении 30 дней с момента регистрации.
                        </p>
                        <p class="text-center">До окончания действия акции осталось:</p>
                        <div class="d-flex justify-content-center text-center mb-3">
                            <div class="me-5">
                                <div id="days" class="display-5">*</div>
                                <div class="text-muted">ДНИ</div>
                            </div>
                            <div class="me-5">
                                <div id="hours" class="display-5">*</div>
                                <div class="text-muted">ЧАСЫ</div>
                            </div>
                            <div class="me-5">
                                <div id="minutes" class="display-5">*</div>
                                <div class="text-muted">МИНУТЫ</div>
                            </div>
                            <div>
                                <div id="seconds" class="display-5">*</div>
                                <div class="text-muted">СЕКУНДЫ</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h4>Ваш прогресс</h4>

                            <div class="js-pie-chart pie-chart" data-percent="{{ $quick_bonus['current_percent'] }}" data-line-width="5" data-size="120" data-bar-color="#6849ad" data-track-color="#e9e9e9">
                                <span>{{ $quick_bonus['current_percent'] }}%</span>
                            </div>

                            <div class="block-content">
                                <p class="text-uppercase fs-sm fw-bold">
                                    {{ $quick_bonus['current_amount'] }} / {{ $quick_bonus['min_amount'] }} {{ config('app.internal-currency') }}
                                </p>
                                @if ($quick_bonus['current_percent'] >= 100)
                                    <form method="post" action="{{ route('accept-quick-bonus') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm mb-3">Забрать бонус</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row items-push">
        <div class="col-xl-6">
            @livewire('partners-widget')
        </div>
        <div class="col-xl-6">
            @livewire('operations-history')
        </div>
    </div>

    @livewire('traders-quotes')
</div>
@endsection
