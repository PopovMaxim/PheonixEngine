@extends('support::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="py-4 text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Техническая поддержка
                </h1>
                <a class="btn btn-hero btn-secondary" href="{{ route('support') }}">
                    <i class="fa fa-arrow-left me-1"></i> К списку запросов
                </a>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <div class="row">
            <div class="col-md-12">
                <div id="accordion" role="tablist" aria-multiselectable="false">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default" role="tab" id="accordion_h1">
                            <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q1" aria-expanded="true" aria-controls="accordion_q1">Детали</a>
                            <div class="block-options">
                                @if ($ticket['status'] != 'closed')
                                    <form method="POST" action="{{ route('support.close', ['uuid' => $ticket['id']]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Закрыть тикет</button>
                                    </form>
                                @else
                                    <span class="text-dark"><i class="fa fa-check"></i> Тикет закрыт</span>
                                @endif
                            </div>
                        </div>
                        <div id="accordion_q1" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-bs-parent="#accordion">
                            <div class="block-content">
                                <div>
                                    <strong>Номер</strong>
                                    <p>{{ $ticket['id'] }}</p>
                                </div>
                                <div>
                                    <strong>Статус</strong>
                                    <p class="text-{{ $ticket['status_attributes']['color'] }}">{{ $ticket['status_attributes']['text'] }}</p>
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
                            </div>
                        </div>
                    </div>
                </div>

                @livewire('support-dialog', ['ticket_id' => $ticket['id']])
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-maxlength'])
    </script>
@endpush