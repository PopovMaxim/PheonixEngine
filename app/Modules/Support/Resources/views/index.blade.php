@extends('support::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="py-4 text-center">
            <h1 class="fw-bold">
                Техническая поддержка
            </h1>
            <a class="btn btn-hero btn-primary" href="{{ route('support.create') }}">
                Создать запрос
            </a>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="block block-rounded">
        <ul class="nav nav-tabs nav-tabs-block">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('support')) active @endif" href="{{ route('support') }}">Открытые</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->is('support/closed')) active @endif" href="{{ route('support.closed') }}">Закрытые</a>
            </li>
        </ul>
    </div>

    @forelse ($tickets as $ticket)
        <a class="block block-rounded block-link-shadow border-start border-{{ $ticket['status_attributes']['color'] }} border-3" href="{{ route('support.show', ['uuid' => $ticket['id']]) }}">
            <div class="block-content block-content-full align-items-md-center justify-content-md-between d-md-flex">
                <div>
                    <p class="text-muted mb-0">
                        {{ $ticket['text'] }}
                    </p>
                </div>
                <div class="ms-md-3">
                    <span class="text-{{ $ticket['status_attributes']['color'] }}">{{ $ticket['status_attributes']['text'] }}</span>
                </div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light d-md-flex justify-content-md-between align-items-md-center">
                @if ($ticket['status'] == 'closed')
                    <div class="fs-sm text-muted">Закрыт <strong>{{ $ticket['updated_at']->format('d.m.Y в H:i') }}</strong></div>
                @else
                    <div class="fs-sm text-muted">Создан <strong>{{ $ticket['created_at']->format('d.m.Y в H:i') }}</strong></div>
                @endif
                <div class="fs-sm text-muted">Категория: {{ $ticket['subject']['title'] }}</div>
            </div>
        </a>
    @empty
        <div class="block block-rounded">
            <div class="block-content text-center">
                <p>В этом разделе нет тикетов...</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
