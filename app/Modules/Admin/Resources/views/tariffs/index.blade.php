@extends('admin::layouts.master')

@section('admin.page-actions')
<a class="btn btn-sm btn-alt-primary" href="{{ route('admin.tariffs.create') }}">
    <i class="fa fa-plus"></i> Добавить
</a>
@endsection

@section('content')

@include('admin.header')

<div class="content content-full">
    @foreach ($tariff_lines as $line)
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Линейка {{ $line['title'] }}</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-vcenter text-center">
                        <thead>
                            <tr>
                                <th style="width: 10%;" class="fs-sm text-muted text-center">Статус</th>
                                <th style="width: 15%;" class="fs-sm text-muted">Линейка</th>
                                <th style="width: 15%;" class="fs-sm text-muted">Название</th>
                                <th style="width: 15%;" class="fs-sm text-muted">Цена</th>
                                <th style="width: 15%;" class="fs-sm text-muted">Скидка</th>
                                <th style="width: 15%;" class="fs-sm text-muted">Срок</th>
                                <th style="width: 10%;" class="fs-sm text-muted">Продано</th>
                                <th class="text-center" style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tariffs->groupBy('tariff_line')[$line['id']] as $value)
                                <tr>
                                    <td>{{ $value['status'] }}</td>
                                    <td>{{ $line['title'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['price'] }}$</td>
                                    <td>
                                        @if ($value['sale'])
                                            {{ $value['sale']['sum'] }}@if ($value['sale']['variant'] == 'percentage')%@else$@endif
                                        @else
                                            Нет
                                        @endif
                                    </td>
                                    <td>{{ $value['translated_period'] }}</td>
                                    <td>0</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                                data-bs-toggle="tooltip" title="" data-bs-original-title="Edit">
                                                <i class="fa fa-ellipsis"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="8" class="text-center">В этой линейке нет тарифов...</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
