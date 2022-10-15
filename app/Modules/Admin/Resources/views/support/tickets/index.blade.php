@extends('admin::layouts.master')

@push('css')
    <style>
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-maxlength'])
    </script>
@endpush

@section('content')
    @if (!request()->uuid)
        @include('hero', ['title' => 'Техническая поддержка', 'breadcrumbs' => [], 'content' => 'boxed'])
    @else
        @include('hero', ['title' => '<a href="/admin/support"><i class="fa fa-arrow-left text-muted me-2"></i></a> Техническая поддержка', 'breadcrumbs' => [], 'content' => 'boxed'])
    @endif

    <div class="content content-full">
        @if (!request()->uuid)
            @livewire('support-tickets')
        @else
            @livewire('support-dialog', ['id' => request()->uuid])
        @endif
    </div>
@endsection
