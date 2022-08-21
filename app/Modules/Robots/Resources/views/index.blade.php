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
            <div class="block-content block-content-full">
                <div class="d-md-flex justify-content-md-between align-items-md-center">
                    <div class="p-1 p-md-3">
                        <h3 class="h4 fw-bold mb-1">Тариф: {{ $tariffs[$subscribe['details']['tariff']]['title'] }}</h3>
                        <p class="fs-sm text-muted mb-0">
                             Истекает {{ now()->parse($subscribe['details']['expired_at'])->format('d.m.Y в H:i:s') }}
                        </p>
                    </div>
                    <div class="p-1 p-md-3">
                        <a class="btn btn-sm btn-alt-primary rounded-pill px-3 me-1 my-1" href="#">
                            <i class="fa fa-wrench opacity-50 me-1"></i> Управление
                        </a>
                        <a class="btn btn-sm btn-alt-secondary rounded-pill px-3 me-1 my-1" href="#">
                            <i class="fa fa-headset opacity-50 me-1"></i> Поддержка
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
</div>
@endsection
