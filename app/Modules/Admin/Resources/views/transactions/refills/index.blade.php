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
            <h3 class="block-title">Список пополнений</h3>
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
                            <th class="text-center" style="width: 10%;">Статус</th>
                            <th class="text-center" style="width: 15%;">Способ оплаты</th>
                            <th style="width: 15%;">Валюта</th>
                            <th class="text-center" style="width: 5%;">Сумма</th>
                            <th class="text-center" style="width: 10%;">Дата</th>
                            <th class="text-center" style="width: 100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href = '{{ route('admin.transactions.refills.read', ['uuid' => $transaction['id']]) }}'">
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
                                <td class="text-center">{!! $transaction['html_status'] !!}</td>
                                <td class="text-center">{{ $transaction['type'] }}</td>
                                <td><div class="d-flex flex-row align-items-center"><img src="{{ asset($transaction['gateway']->data['icon']) }}" class="me-2" style="width: 30px; height: 30px;" /> <span class="d-none d-sm-block">{{ $transaction['gateway']->data['title'] }}</span></div></td>
                                <td class="text-center" style="width: 20%;">
                                    @if ($transaction['status'] == 'canceled')
                                        0 {{ $transaction['gateway']->data['abbr'] }}
                                    @else
                                        <span class="">
                                            @if (isset($transaction['details']['gateway']['amount']))
                                                {{ $transaction['details']['gateway']['amount'] }} {{ $transaction['gateway']->data['abbr'] }}
                                            @else
                                                <i class="fa fa-circle-notch fa-spin text-primary"></i>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.transactions.refills.edit', ['uuid' => $transaction['id']]) }}" class="btn btn-sm btn-alt-secondary me-2"
                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Редактировать">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
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
