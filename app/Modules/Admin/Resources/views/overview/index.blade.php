@extends('admin::layouts.master')

@push('css')
@endpush

@push('js')
<script>
    setTimeout(function () {
        $.ajax({
            url: "{{ route('admin.balance.westwallet') }}",
            method: 'post',
            success: function (r) {
                $('.ww-balance').text(r + ' USDT')
            }
        })
        $.ajax({
            url: "{{ route('admin.users.balance') }}",
            method: 'post',
            success: function (r) {
                $('.users-balance').text(r + ' PX')
            }
        })
    }, 2000);

</script>
@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="my-3 d-lg-flex justify-content-between justify-sm-content-center align-items-center">
            <div class="py-4 py-md-0 text-center text-md-start">
                <h1 class="fs-2 mb-2">Обзор</h1>
                <h2 class="fs-lg fw-normal text-dark-75 mb-0">Панель администратора</h2>
            </div>
        </div>
    </div>
</div>

<div class="content content-full">
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Пользователи
                            </p>
                            <p class="fs-3 mb-0">
                                <span class="text-success" data-bs-toggle="tooltip" data-bs-title="Активные">{{ $users_actived ?? 0 }}</span> / 
                                <span class="text-danger" data-bs-toggle="tooltip" data-bs-title="Не активные">{{ $users_count - $users_actived ?? 0 }}</span> / 
                                <span class="text-muted" data-bs-toggle="tooltip" data-bs-title="Всего">{{ $users_count ?? 0 }}</span>
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Балансы пользователей
                            </p>
                            <p class="fs-3 mb-0 users-balance">
                                Загрузка...
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Баланс WestWallet
                            </p>
                            <p class="fs-3 mb-0 ww-balance">
                                Загрузка...
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Сумма заявок на выплату
                            </p>
                            <p class="fs-3 mb-0">
                                {{ $withdrawal_sum ?? 0 }} PX
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Сумма переводов
                            </p>
                            <p class="fs-3 mb-0">
                                {{ $transfer_sum ?? 0 }} PX
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Начислено бонусов
                            </p>
                            <p class="fs-3 mb-0">
                                {{ $bonus_sum ?? 0 }} PX
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Подписки
                            </p>
                            <p class="fs-3 mb-0">
                                <span class="text-success" data-bs-toggle="tooltip" data-bs-title="Активные">{{ $actived_subscribes ?? 0 }}</span> / 
                                <span class="text-danger" data-bs-toggle="tooltip" data-bs-title="Истёкшие">{{ $expired_subscribes ?? 0 }}</span> / 
                                <span class="text-muted" data-bs-toggle="tooltip" data-bs-title="За всё время">{{ $total_subscribes ?? 0 }}</span>
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Тикеты
                            </p>
                            <p class="fs-3 mb-0">
                                <span class="text-danger" data-bs-toggle="tooltip" data-bs-title="Новые">{{ $new_tickets ?? 0 }}</span> / 
                                <span class="text-warning" data-bs-toggle="tooltip" data-bs-title="Ожидают ответа поддержки">{{ $wait_support_tickets ?? 0 }}</span> / 
                                <span class="text-success" data-bs-toggle="tooltip" data-bs-title="Ожидают ответа от пользователя">{{ $wait_user_tickets ?? 0 }}</span> / 
                                <span class="text-muted" data-bs-toggle="tooltip" data-bs-title="Закрыто">{{ $closed_tickets ?? 0 }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="block block-rounded block-mode-loading-refresh h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Топ 5 продажников</h3>
                </div>
                <div class="block-content d-flex justify-content-between flex-column">
                    <table class="table table-bordered table-vcenter fs-sm">
                        <thead class="">
                            <tr>
                                <th class="d-none d-sm-table-cell text-center" style="width: 60px;"></th>
                                <th>Участник</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 25%;">Активировано партнёров</th>
                                <th class="d-none d-sm-table-cell text-center" style="width: 25%;">Заработано бонусов</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_5_sellers as $user)
                                <tr style="min-height: 60px;">
                                    <td class="d-none d-sm-table-cell text-center">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="fw-normal">
                                        <div class="d-flex flex-row align-items-center">
                                            <div class="me-2">
                                                <img class="img-avatar img-avatar48" src="https://pheonix.local/assets/media/avatars/avatar10.jpg" alt="">
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.users.read', ['id' => $user['id']]) }}" class="fw-semibold">{{ $user['nickname'] }}</a>
                                                <div class="text-muted fs-sm">
                                                    ФИО: {{ $user['full_name'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center">{{ $user['bonus_count'] }} чел.</td>
                                    <td class="d-none d-sm-table-cell text-center">{{ number_format($user['bonus_sum'] / 100, 2) }} PX</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
