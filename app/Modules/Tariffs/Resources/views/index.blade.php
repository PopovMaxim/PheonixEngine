@extends('robots::layouts.master')

@section('content')
<div class="content content-boxed">
    @livewire('tariffs', [
        'line' => $line
    ])
</div>
@endsection
