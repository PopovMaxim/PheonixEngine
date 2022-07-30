@extends('network::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-3">
                Линейный маркетинг
            </h1>
        </div>
    </div>
</div>
<div class="content content-full">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row text-center">
                <div class="col-md-4 py-3">
                    <div class="fs-1 fw-light text-primary mb-1">
                        {{ $level_1['count'] }} чел.
                    </div>
                    <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Уровень 1</a>
                </div>
                <div class="col-md-4 py-3">
                    <div class="fs-1 fw-light text-primary mb-1">
                        {{ $level_2['count'] }} чел.
                    </div>
                    <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Уровень 2</a>
                </div>
                <div class="col-md-4 py-3">
                    <div class="fs-1 fw-light text-primary mb-1">
                        {{ $level_3['count'] }} чел.
                    </div>
                    <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Уровень 3</a>
                </div>
            </div>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Уровень 1</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 64px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="text-center" style="width: 20%;">Спонсор</th>
                        <th class="text-center" style="width: 5%;">Партнёры</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата регистрации</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата активации</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($level_1['list'] as $partner)
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                            </td>
                            <td class="fw-semibold">{{ $partner['nickname'] ?? $partner['obfuscated_email'] }}</td>
                            <td class="fw-semibold text-center">Я</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['created_at']->format('d-m-Y') }}</td>
                            <td class="d-none d-md-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $level_1['list']->links() }}
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Уровень 2</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 64px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="text-center" style="width: 20%;">Спонсор</th>
                        <th class="text-center" style="width: 5%;">Партнёры</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата регистрации</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата активации</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($level_2['list'] as $partner)
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                            </td>
                            <td class="fw-semibold">{{ $partner['nickname'] ?? $partner['obfuscated_email'] }}</td>
                            <td class="fw-semibold text-center">{{ $partner['sponsor']['nickname'] ?? $partner['sponsor']['obfuscated_email'] }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['created_at']->format('d-m-Y') }}</td>
                            <td class="d-none d-md-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $level_2['list']->links() }}
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Уровень 3</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 64px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="text-center" style="width: 20%;">Спонсор</th>
                        <th class="text-center" style="width: 5%;">Партнёры</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата регистрации</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 20%;">Дата активации</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($level_3['list'] as $partner)
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                            </td>
                            <td class="fw-semibold">{{ $partner['nickname'] ?? $partner['obfuscated_email'] }}</td>
                            <td class="fw-semibold text-center">{{ $partner['sponsor']['nickname'] ?? $partner['sponsor']['obfuscated_email'] }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['created_at']->format('d-m-Y') }}</td>
                            <td class="d-none d-md-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $level_3['list']->links() }}
        </div>
    </div>
</div>
@endsection
