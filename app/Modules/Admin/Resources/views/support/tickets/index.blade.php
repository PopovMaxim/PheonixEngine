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
        <div class="row">
            @forelse ($tickets as $ticket)
                <div class="col-md-3 h-100">
                    <a href="{{ route('admin.support', ['uuid' => $ticket['id']]) }}" class="block block-rounded block-themed">
                        <div class="block-header @if ($ticket['status'] == 'new') bg-warning @endif">
                            <h3 class="block-title">{{ $ticket['subject']['title'] }}</h3>
                        </div>
                        <div class="block-content">
                            <p>{{ \Illuminate\Support\Str::limit($ticket['text'], 150, $end = '...') }}</p>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                            <div class="d-flex justify-content-start">
                                <div class="me-2">
                                    <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.read', ['id' => $ticket['user']['id']]) }}" class="fw-semibold">{{ $ticket['user']['nickname'] }}</a>
                                    <div class="text-muted fs-sm">
                                        ФИО: {{ $ticket['user']['full_name'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                            {{ $ticket['created_at'] }}
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
        @else
            @livewire('support-dialog', ['id' => request()->uuid])
        @endif
    </div>
@endsection
