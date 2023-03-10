@extends('notifications::layouts.master')

@push('js')
@endpush

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Уведомления
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <div class="block block-rounded">
            <ul class="nav nav-tabs nav-tabs-block">
                <li class="nav-item">
                    <a href="{{ route('notifications') }}" class="nav-link @if(\Route::current()->getName() == 'notifications') active @endif">
                        Не прочитанные
                        @if (request()->user()->unreadNotifications()->count())
                            &nbsp;<span class="badge bg-warning">{{ request()->user()->unreadNotifications()->count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('notifications.readed') }}" class="nav-link @if(\Route::current()->getName() == 'notifications.readed')) active @endif">Прочитанные</a>
                </li>
                <li class="nav-item ms-auto d-flex flex-row align-items-center">
                    <a data-bs-toggle="tooltip" data-bs-placement="left" title="Прочитать всё" @if (request()->user()->unreadNotifications()->count()) class="nav-link" href="{{ route('notifications.read-all') }}" @else class="nav-link text-muted" @endif>
                        <div class="d-flex flex-row align-items-center">
                            <i class="fas fa-check-to-slot"></i>
                            <span class="ms-2 d-none d-sm-block">Прочитать всё</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        @forelse ($notifications as $notification)
            <div class="block block-rounded">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fw-normal mb-0">
                            {!! $notification['data']['text'] !!}
                        </p>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <span
                        class="fs-sm text-muted"><strong>{{ $notification['created_at']->format('d.m.Y в H:i:s') }}</strong></span>
                </div>
            </div>
        @empty
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <p>На данный момент здесь нет никакой информации...</p>
                </div>
            </div>
        @endforelse

        {{ $notifications->links() }}
    </div>
@endsection
