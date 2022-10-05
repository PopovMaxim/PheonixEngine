@extends('transactions::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    История
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        {{--@forelse ($transactions as $transaction)
            <a class="block block-rounded block-link-shadow border-start border-{{ $transaction['direction'] == 'inner' ? 'success' : 'danger' }} border-3" href="{{ route('transactions.read', ['id' => $transaction['id']]) }}">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fs-lg fw-semibold mb-0">
                            {{ $transaction['formatted_amount'] }}
                        </p>
                        <p class="text-muted mb-0">
                            {{ $transaction['translated_type'] }}
                        </p>
                    </div>
                    <div class="ms-3">
                        <i class="fa fa-arrow-{{ $transaction['direction'] == 'inner' ? 'left' : 'right' }} text-{{ $transaction['direction'] == 'inner' ? 'success' : 'danger' }}"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light d-flex justify-content-between">
                    <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                    <span class="fs-sm text-muted">{{ $transaction['id'] }}</span>
                </div>
            </a>
        @empty
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <p>На данный момент список транзакций пуст...</p>
                </div>
            </div>
        @endforelse--}}

        @if ($transactions)
            @livewire('operations-history', ['limit' => 15, 'min_height' => 'auto', 'header' => false])
        @else
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <p>На данный момент история начислений пуста...</p>
                </div>
            </div>
        @endif
    </div>
@endsection