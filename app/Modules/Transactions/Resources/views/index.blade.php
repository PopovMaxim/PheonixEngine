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