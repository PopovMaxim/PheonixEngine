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
            <div class="row">
                <div class="col-md-8">
                    @livewire('support-dialog', ['ticket_id' => request()->uuid])
                </div>
                <div class="col-md-4">
                    <div class="block-content">
                        <div>
                            <strong>Номер заявки</strong>
                            <p>{{ $ticket['id'] }}</p>
                        </div>
                        <div>
                            <strong>Пользователь</strong>
                            <div class="d-flex flex-row my-3">
                                <div class="me-2">
                                    <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                </div>
                                <div>
                                    {{ $ticket['user']['nickname'] }}
                                    <div class="text-muted fs-sm">
                                        ФИО: {{ $ticket['user']['full_name'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <strong>Категория</strong>
                            <p>{{ $ticket['subject']['title'] }}</p>
                        </div>
                        <div>
                            <strong>Дата создания</strong>
                            <p>{{ $ticket['created_at']->format('d.m.Y в H:i:s') }}</p>
                        </div>
                        @if ($ticket['status'] == 'closed')
                            <div>
                                <strong>Дата закрытия</strong>
                                <p>{{ $ticket['updated_at']->format('d.m.Y в H:i:s') }}</p>
                            </div>
                        @endif
                        <div>
                            <strong>Вопрос</strong>
                            <p>{{ $ticket['text'] }}</p>
                        </div>
                        @if ($ticket['status'] != 'closed')
                            <div>
                                <form method="POST" action="{{ route('admin.support.close', ['uuid' => $ticket['id']]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Закрыть тикет</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
