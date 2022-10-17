@extends('admin::layouts.master')

@section('content')
@include('admin.header')

<div class="content content-full">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Список заявок на выплату</h3>
            <div class="block-options">
                <a href="#" style="cursor: pointer;"><i class="fa fa-filter"></i></a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20%;">Пользователь</th>
                            <th class="text-left" style="width: 20%;">Валюта</th>
                            <th class="text-center" style="width: 20%;">Сумма</th>
                            <th class="text-center" style="width: 20%;">Адрес</th>
                            <th class="text-center" style="width: 20%;">Дата</th>
                            <th class="text-center" style="width: 100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href = '{{ route('withdraw.read', ['uuid' => $transaction['id']]) }}'">
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
                                <td><div class="d-flex flex-row align-items-center"><img src="{{ asset($transaction['gateway']->data['icon']) }}" class="me-2" style="width: 30px; height: 30px;" /> <span class="d-none d-sm-block">{{ $transaction['gateway']->data['title'] }}</span></div></td>
                                <td class="text-center" style="width: 20%;">
                                    {{ $transaction['formatted_amount'] }}
                                </td>
                                <td class="text-center" style="width: 20%;">
                                    {{ $transaction['obfuscated_address'] }}
                                </td>
                                <td class="text-center">
                                    <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.transactions.withdrawal.send', ['uuid' => $transaction['id']]) }}" class="btn btn-sm btn-alt-secondary"
                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Выплатить">
                                            <i class="fa fa-hand-holding-usd"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Ни одного вывода не найдено...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $transactions->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
