@extends('admin::layouts.master')

@section('admin.page-actions')
<a class="btn btn-sm btn-alt-primary" href="javascript:void(0)">
    <i class="fa fa-plus"></i> Добавить
</a>
@endsection

@section('content')
@include('admin.header')

<div class="content content-full">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Список пользователей</h3>
            <div class="block-options">
                <a href="#" style="cursor: pointer;"><i class="fa fa-filter"></i></a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-vcenter">
                    <thead>
                        <tr>
                            <th class="fs-sm text-muted">Пользователь</th>
                            <th style="width: 10%;" class="fs-sm text-muted text-center">Статус</th>
                            <th style="width: 15%;" class="fs-sm text-muted">Тип</th>
                            <th style="width: 15%;" class="fs-sm text-muted">Сумма</th>
                            <th style="width: 10%;" class="text-center fs-sm text-muted">Дата</th>
                            <th class="text-center" style="width: 100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="me-2">
                                            <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                        </div>
                                        <div>
                                            <a href="#" class="fw-semibold">{{ $transaction['user']['nickname'] }}</a>
                                            <div class="text-muted fs-sm">
                                                ФИО: {{ $transaction['user']['full_name'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fs-sm text-muted text-center">{!! $transaction['html_status'] !!}</td>
                                <td class="fs-sm text-muted">{{ $transaction['translated_type'] }}</td>
                                <td class="fs-sm text-muted">{{ $transaction['formatted_amount'] }}</td>
                                <td class="text-muted fs-sm text-center">{{ $transaction['created_at']->format('d.m.Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Edit">
                                            <i class="fa fa-ellipsis"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                {{ $transactions->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
