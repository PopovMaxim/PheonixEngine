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
    <div class="content content-full">
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
                <li class="nav-item ms-auto">
                    <a data-bs-toggle="tooltip" data-bs-placement="left" title="Прочитать всё" @if (request()->user()->unreadNotifications()->count()) class="nav-link" href="{{ route('notifications.read-all') }}" @else class="nav-link disabled" @endif>
                        <i class="fas fa-check-to-slot"></i>
                        <span class="visually-hidden">Прочитать всё</span>
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
            <div class="alert alert-warning shadow" role="alert">
                <h3 class="alert-heading fs-4 my-2">Внимание</h3>
                <p class="mb-0">На данный момент здесь нет никакой информации. Приходите позже...</p>
            </div>
        @endforelse
    </div>
@endsection
