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
                $('#wwBalance').text(r + ' USDT')
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
            <div class="d-flex flex-column justify-content-end text-end">
                <div class="fs-3 fw-semibold mb-0 d-flex justify-content-end align-items-center" id="wwBalance">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="ms-2">USDT</div>
                </div>
                <p class="fs-sm fw-semibold text-dark-75 text-uppercase mb-0">
                    <i class="far fa-chart-bar opacity-75 me-1"></i> WestWallet
                </p>
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
                                {{ $users_count ?? 0 }}
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
                                {{ $subscribes_count ?? 0 }}
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
                                Продажи
                            </p>
                            <p class="fs-3 mb-0">
                                {{ $sells_sum ?? 0 }}
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
                                {{ $tickets_count ?? 0 }}
                            </p>
                        </div>
                        <div></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
