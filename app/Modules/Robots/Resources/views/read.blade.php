@extends('robots::layouts.master')

@push('js')
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
@endpush

@push('css')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet" />
@endpush

@section('content')
    @include('hero', ['title' => '<a href="/subscribes"><i class="fa fa-arrow-left text-muted me-2"></i></a> Управление подпиской', 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                @if (!$product_key)
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <form method="POST">
                                @csrf
                                <div class="block block-rounded">
                                    <div class="block-content">
                                        <div class="p-4">
                                            <div class="mb-4">
                                                <label class="form-label" for="account-number">Номер счёта</label>
                                                <input type="text" class="form-control form-control-alt @error('account_number') is-invalid @enderror" id="account-number" name="account_number" value="{{ old('account_number') }}" placeholder="Введите номер счёта">
                                                @error('account_number')
                                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('accept') is-invalid @enderror" type="checkbox" value="1" id="accept" name="accept">
                                                    <label class="form-check-label" for="accept">Я уверен(а) что хочу активировать данный номер счёта.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                                        <button type="submit" class="btn btn-sm btn-alt-primary">
                                            <i class="fa fa-check opacity-50 me-1"></i> Активировать номер счёта
                                        </button>
                                    </div>
                                </div>
                            </form>
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
                @else
                    <div class="row items-push">
                        <div class="col-md-4">
                            <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fs-lg fw-semibold mb-0">
                                        @if ($account_number)
                                            Активирован
                                        @else
                                            Не активирован
                                        @endif
                                    </p>
                                    <p class="text-muted mb-0">
                                        Текущий статус
                                    </p>
                                </div>
                                <div class="ms-3 item">
                                    <i class="fa fa-2x fa-key text-muted"></i>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fs-lg fw-semibold mb-0">
                                        {{ now()->parse($subscribe['details']['expired_at'])->format('d.m.Y в H:i:s') }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        Дата истечения
                                    </p>
                                </div>
                                <div class="ms-3 item">
                                    <i class="fa fa-2x fa-calendar text-muted"></i>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fs-lg fw-semibold mb-0">
                                        {{ $product_key['account_number'] }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        Номер счёта
                                    </p>
                                </div>
                                <div class="ms-3 item">
                                    <i class="fa fa-2x fa-star text-muted"></i>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="block block-rounded block-themed">
                                <div class="block-header">
                                    <h3 class="block-title text-center">Ключ активации продукта</h3>
                                </div>
                                <div class="block-content pt-0">
                                    <div class="row justify-content-center py-sm-3 py-md-5">
                                        <div class="col-sm-10 col-md-8">
                                            <div class="d-flex justify-content-center">
                                                <a class="bg-gray p-3 rounded text-center fw-bold copy" data-clipboard-text="{{ $product_key['activation_key'] }}" style="cursor: pointer;">
                                                    {{ $product_key['activation_key'] }}
                                                </a>
                                            </div>
                                            <div class="text-muted text-center"><small>Нажмите на код, чтобы скопировать</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <video
                                id="my-video"
                                class="video-js vjs-theme-fantasy vjs-16-9"
                                controls
                                preload="auto"
                                poster="{{ asset('assets/media/covers/install-insider.jpg') }}"
                                data-setup="{}"
                            >
                                <source src="{{ asset('videos/refill.mp4') }}" type="video/mp4" />
                                <p class="vjs-no-js">Для просмотра этого видео включите JavaScript и рассмотрите возможность обновления веб-браузера до
                                    <a href="https://videojs.com/html5-video-support/" target="_blank">поддерживающего HTML5 видео.</a>
                                </p>
                            </video>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
