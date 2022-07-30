@extends('network::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/clipboardjs/clipboard.min.js') }}"></script>

    <script>
        var clipboard = new ClipboardJS('.copy');

        clipboard.on('success', function(e) {
            console.info('Action:', e.action);
            console.info('Text:', e.text);
            console.info('Trigger:', e.trigger);

            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });
    </script>
@endpush

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-2">
                    Мои партнёры
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-full">
        @livewire('team-growth-chart')

        <div class="row">
            <div class="col-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ссылки на приглашение партнёров</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Ссылка на регистрацию
                                    </p>
                                    <p class="text-dark-75 mb-0">
                                        {{ request()->user()->referral_link }}
                                    </p>
                                </div>
                                <div class="item">
                                    <i class="fas fa-2x fa-copy text-primary"></i>
                                </div>
                            </div>
                        </a>
                        <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}/left">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Принудительная регистрация в левую ногу
                                    </p>
                                    <p class="text-dark-75 mb-0">
                                        {{ request()->user()->referral_link }}/left
                                    </p>
                                </div>
                                <div class="item">
                                    <i class="fas fa-2x fa-copy text-primary"></i>
                                </div>
                            </div>
                        </a>
                        <a class="block block-rounded bg-light mb-2 copy" href="javascript:void(0)" data-clipboard-text="{{ request()->user()->referral_link }}/right">
                            <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <p class="text-dark fs-5 fw-light mb-0">
                                        Принудительная регистрация в правую ногу
                                    </p>
                                    <p class="text-dark-75 mb-0">
                                        {{ request()->user()->referral_link }}/right
                                    </p>
                                </div>
                                <div class="item">
                                    <i class="fas fa-2x fa-copy text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                @livewire('update-partner-register-side')
            </div>
        </div>

        @if (request()->user()->sponsor)
            <h2 class="content-heading">
                <i class="fa fa-angle-right text-muted me-1"></i> Мой спонсор
            </h2>

            <a class="block block-rounded block-link-shadow border-start @if (is_null(request()->user()->sponsor->activated_at)) border-danger @else border-success @endif border-3" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                    <p class="fs-lg fw-semibold mb-0">
                        {{ request()->user()->sponsor->nickname }}
                    </p>
                    <p class="text-muted mb-0">
                        @if (is_null(request()->user()->sponsor->activated_at))
                            <span class="badge bg-danger">Не активирован</span>
                        @else
                            <span class="badge bg-success">Активирован</span>
                        @endif
                    </p>
                    </div>
                    <div class="ms-3">
                        <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/avatar15.jpg') }}" alt="">
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <span class="fs-sm text-muted">Дата регистрации <strong>{{ request()->user()->sponsor->created_at->format('d-m-Y') }}</strong></span>
                </div>
            </a>
        @endif

        @if ($partners->total())
            @livewire('partners-widget')
        @endif
    </div>
@endsection
