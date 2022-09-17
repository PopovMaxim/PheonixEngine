@extends('admin::layouts.master')

@section('admin.page-actions')
<a class="btn btn-sm btn-alt-primary" href="javascript:void(0)">
    <i class="fa fa-plus"></i> Добавить
</a>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-maxlength'])
    </script>
@endpush

@section('content')
@include('admin.header')

<div class="content content-full p-0">
    <div class="row g-0 flex-md-grow-1">
        <div class="col-lg-5 col-xl-3 h100-scroll bg-body-dark">
            <div class="content">
                <div class="row d-lg-none push">
                    <div class="col">
                        <button type="button" class="btn btn-alt-primary w-100" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                            <i class="fa fa-envelope opacity-50 me-1"></i> Заявки
                        </button>
                    </div>
                </div>
                <div id="side-content" class="d-none d-lg-block push">
                    <div class="list-group fs-sm">
                        @forelse ($tickets as $ticket)
                            <a class="list-group-item list-group-item-action" href="{{ route('admin.support', ['id' => $ticket['id']]) }}">
                                <span class="badge rounded-pill bg-primary float-end ms-2">0</span>
                                <span class="float-end rounded-pill badge bg-{{ $ticket['status_attributes']['color'] }}">{{ $ticket['status_attributes']['text'] }}</span>
                                <p class="fs-6 fw-bold mb-0">
                                    {{ $ticket['subject']['title'] }}
                                </p>
                                <p class="text-muted mb-2">
                                    {{ $ticket['text'] }}
                                </p>
                                <p class="fs-sm text-muted mb-0">
                                    <strong>{{ $ticket['user']['nickname'] }}</strong>, {{ $ticket['created_at']->diffForHumans() }}
                                </p>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-xl-9 h100-scroll">
            <div class="content">
                @if (!request()->id)
                <div class="block block-rounded">
                    <div class="block-content text-center">
                        <p>Выберите заявку, которую хотите обработать...</p>
                    </div>
                </div>
                @else
                    @livewire('support-dialog', ['id' => request()->id])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
