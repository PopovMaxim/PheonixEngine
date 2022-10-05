@extends('robots::layouts.master')

@section('content')
    @livewire('tariffs', [
        'line' => $line
    ])
@endsection
