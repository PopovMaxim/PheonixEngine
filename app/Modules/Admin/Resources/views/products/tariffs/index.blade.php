@extends('admin::layouts.master')

@section('admin.page-actions')
    <a class="btn btn-sm btn-alt-primary" href="{{ route('admin.products.tariffs.form') }}">
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
                <div class="block-options">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.line.form', ['id' => $line['id']]) }}" class="btn-block-option" data-bs-toggle="tooltip" title="Редактировать"><i class="fa fa-cog"></i></a>
                        <form method="post" action="{{ route('admin.products.line.delete', ['id' => $line['id']]) }}" onsubmit="return confirm('Вы уверены, что хотите удалить эту линейку тарифов?');">
                            @csrf
                            <button type="submit" class="btn-block-option" data-bs-toggle="tooltip" title="Удалить"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
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
                            @forelse ($tariffs->groupBy('tariff_line')[$line['id']] ?? [] as $value)
                                <tr>
                                    <td>{!! $value['status'] ? '<span class="text-success">Вкл</span>' : '<span class="text-danger">Выкл</span>' !!}</td>
                                    <td>{{ $line['title'] }}</td>
                                    <td>{{ $value['title'] }}</td>
                                    <td>{{ $value['price'] }}$</td>
                                    <td>
                                        @if (isset($value['sale']['variant']) && !is_null($value['sale']['variant']))
                                            {{ $value['sale']['sum'] }}@if ($value['sale']['variant'] == 'percentage')%@else$@endif
                                        @else
                                            Не установлено
                                        @endif
                                    </td>
                                    <td>{{ $value['translated_period'] }}</td>
                                    <td>0</td>
                                    <td>
                                        <div class="btn-group">
                                            {{--<a href="{{ route('admin.products.tariffs.stats', ['id' => $value['id']]) }}" class="btn btn-sm btn-alt-secondary me-2" data-bs-toggle="tooltip" title="Статистика"><i class="fa fa-chart-line"></i></a>--}}
                                            <a href="{{ route('admin.products.tariffs.form', ['id' => $value['id']]) }}" class="btn btn-sm btn-alt-secondary me-2" data-bs-toggle="tooltip" title="Редактировать"><i class="fa fa-cog"></i></a>
                                            <form method="post" action="{{ route('admin.products.tariffs.delete', ['id' => $value['id']]) }}" onsubmit="return confirm('Вы уверены, что хотите удалить этот тариф?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Удалить"><i class="fa fa-trash"></i></button>
                                            </form>
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
    
    <a class="block block-rounded" href="{{ route('admin.products.line.form') }}">
        <div class="block-content block-content-full d-flex align-items-center justify-content-center">
            <div class="text-center">
                <p class="fw-semibold mb-0 text-primary">
                    <i class="fa fa-plus"></i> Добавить новую линейку
                </p>
            </div>
        </div>
    </a>
</div>
@endsection
