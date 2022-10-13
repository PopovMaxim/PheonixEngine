@extends('robots::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Мои подписки
                </h1>
            </div>
        </div>
    </div>
    
    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                @forelse ($subscribes as $subscribe)
                    <div class="block block-rounded block-fx-pop">
                        @if (now()->parse($subscribe['details']['expired_at'])->timestamp <= now()->addMonth()->timestamp && now()->parse($subscribe['details']['expired_at'])->timestamp > now()->timestamp)
                            <div class="block-content block-content-full bg-warning text-light">
                                <i class="fa fa-exclamation-triangle"></i> Подписка истекает через: {{ now()->diffInDays(now()->parse($subscribe['details']['expired_at'])) }} дн.
                            </div>
                        @elseif (now()->parse($subscribe['details']['expired_at'])->timestamp < now()->timestamp)
                            <div class="block-content block-content-full bg-danger text-light">
                                <i class="fa fa-times"></i> Подписка истекла
                            </div>
                        @endif
                        <div class="block-content block-content-full ribbon ribbon-modern ribbon-primary ribbon-left">
                            <div class="d-md-flex justify-content-md-between align-items-md-center">
                                <div class="mt-3">
                                    <div class="ribbon-box text-uppercase">{{ $tariffs->get($subscribe['details']['tariff'])->line['title'] }}</div>
                                    <div class="p-1 p-md-3">
                                        <h3 class="h4 fw-bold mb-1">Тариф: {{ $tariffs[$subscribe['details']['tariff']]['title'] }}</h3>
                                        <p class="fs-sm text-muted mb-0">
                                            Истекает {{ now()->parse($subscribe['details']['expired_at'])->format('d.m.Y в H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="p-1 p-md-3">
                                    <a class="btn btn-sm btn-alt-primary rounded-pill px-3 me-1 my-1" href="{{ route('subscribes.read', ['uuid' => $subscribe['id']]) }}">
                                        <i class="fa fa-wrench opacity-50 me-1"></i> Управление
                                    </a>
                                    {{--
                                    <a class="btn btn-sm btn-alt-secondary rounded-pill px-3 me-1 my-1" href="#">
                                        <i class="fa fa-headset opacity-50 me-1"></i> Поддержка
                                    </a>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="block block-rounded">
                        <div class="block-content text-center">
                            <p>На данный момент у Вас нет активных подписок...</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="col-md-5">
                <div>
                    <h4>Часто задаваемые вопросы</h4>
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="block block-transparent mb-0">
                            <div class="block-header ps-0 pt-0" role="tab" id="h1">
                                <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#q1" aria-expanded="true" aria-controls="q1">Как зарегистрироваться на Roboforex?</a>
                            </div>
                            <div id="q1" class="collapse" role="tabpanel" aria-labelledby="h1" data-bs-parent="#accordion" style="">
                                <div class="block-content ps-0 pt-0 fs-sm pb-3">
                                    <a href="{{ asset('pdf/robo-register.pdf') }}" target="_black"><i class="fa fa-external-link"></i> Открыть инструкцию</a>
                                </div>
                            </div>
                        </div>
                        <div class="block block-transparent mb-0">
                            <div class="block-header ps-0 pt-0" role="tab" id="h2">
                                <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#q2" aria-expanded="true" aria-controls="q2">Как создать новый аккаунт на Roboforex в партнёрской сети Pheonix?</a>
                            </div>
                            <div id="q2" class="collapse" role="tabpanel" aria-labelledby="h2" data-bs-parent="#accordion" style="">
                                <div class="block-content ps-0 pt-0 fs-sm pb-3">
                                    <a href="{{ asset('pdf/robo-new-acc-register.pdf') }}" target="_black"><i class="fa fa-external-link"></i> Открыть инструкцию</a>
                                </div>
                            </div>
                        </div>
                        <div class="block block-transparent mb-0">
                            <div class="block-header ps-0 pt-0" role="tab" id="h3">
                                <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#q3" aria-expanded="true" aria-controls="q3">Как создать счёт для Insider 1.61?</a>
                            </div>
                            <div id="q3" class="collapse" role="tabpanel" aria-labelledby="h3" data-bs-parent="#accordion" style="">
                                <div class="block-content ps-0 pt-0 fs-sm pb-3">
                                    <a href="{{ asset('pdf/robo-insider-acc-register.pdf') }}" target="_black"><i class="fa fa-external-link"></i> Открыть инструкцию</a>
                                </div>
                            </div>
                        </div>
                        <div class="block block-transparent mb-0">
                            <div class="block-header ps-0 pt-0" role="tab" id="h3">
                                <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#q4" aria-expanded="true" aria-controls="q4">Как открыть счёт Roboforex MT4 ProCent?</a>
                            </div>
                            <div id="q4" class="collapse" role="tabpanel" aria-labelledby="h4" data-bs-parent="#accordion" style="">
                                <div class="block-content ps-0 pt-0 fs-sm pb-3">
                                    <a href="{{ asset('pdf/robo-procent-register.pdf') }}" target="_black"><i class="fa fa-external-link"></i> Открыть инструкцию</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
