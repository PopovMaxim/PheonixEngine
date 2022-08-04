@extends('robots::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-4">
                Тарифные планы
            </h1>
        </div>
    </div>
</div>
<div class="content content-boxed">
    @livewire('tariffs')
</div>
@endsection
