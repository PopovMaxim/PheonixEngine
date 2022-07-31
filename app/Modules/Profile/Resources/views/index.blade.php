@extends('profile::layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
    </script>
@endpush

@section('content')
    <div class="bg-transparent">
        <div class="content content-full">
            <div class="pt-5 py-4 text-center">
                <h1 class="fw-bold my-2 text-dark">Редактирование профиля</h1>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        @livewire('update-profile')
    </div>
@endsection
