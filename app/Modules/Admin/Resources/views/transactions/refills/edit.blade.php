@extends('admin::layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            function initSelector() {
                $('.js-select2').select2({
                    theme: 'bootstrap-5'
                });
            }

            initSelector();
        });
    </script>
        
    <script src="{{ asset('assets/js/plugins/maskMoney/jquery.maskMoney.min.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#amount').maskMoney();
        })
    </script>
@endpush

@section('admin.page-actions')
<a class="btn btn-sm btn-alt-primary" href="javascript:void(0)">
    <i class="fa fa-user-plus"></i> Добавить
</a>
@endsection

@section('content')
@include('hero', ['title' => '<a href="/admin/transactions/refills"><i class="fa fa-arrow-left text-muted me-2"></i></a> Редактирование пополнения', 'breadcrumbs' => []])
    <div class="content content-boxed">
        <form method="POST" autocomplete="off">
            @csrf
            <div class="block block-rounded">
                <div class="block-content">
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-user-circle text-muted me-1"></i> Общая информация
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label">Пользователь</label>
                                <a href="{{ route('admin.users.read', ['id' => $tx['user']['id']]) }}">
                                    <div class="d-flex flex-row my-3">
                                        <div class="me-2">
                                            <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                        </div>
                                        <div>
                                            {{ $tx['user']['nickname'] }}
                                            <div class="text-muted fs-sm">
                                                ФИО: {{ $tx['user']['full_name'] }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Идентификатор</label>
                                <input type="text" class="form-control" value="{{ $tx['id'] }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Статус</label>
                                <select class="form-select" id="status" name="status">
                                    <option selected="" value="">Выберите статус...</option>
                                    <option value="new" @if ($tx['status'] == 'new') selected="" @endif>Новая</option>
                                    <option value="pending" @if ($tx['status'] == 'pending') selected="" @endif>В обработке</option>
                                    <option value="completed" @if ($tx['status'] == 'completed') selected="" @endif>Исполнено</option>
                                    <option value="canceled" @if ($tx['status'] == 'canceled') selected="" @endif>Отменено</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="amount">Сумма</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Введите сумму пополнения..." value="{{ number_format($tx['amount'] / 100, 2) }}">
                                @error('amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="patronymic">Дата создания</label>
                                <input type="text" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" placeholder="Дата создания операции..." value="{{ $tx['created_at'] }}" readonly>
                                @error('created_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="patronymic">Дата изменения</label>
                                <input type="text" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at" placeholder="Дата изменения операции..." value="{{ $tx['updated_at'] }}" readonly>
                                @error('updated_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-globe text-muted me-1"></i> Шлюз
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][type]">Тип</label>
                                <select class="form-select" id="details[gateway][type]" name="details[gateway][type]">
                                    <option value="crypto">Криптовалюты</option>
                                </select>
                                @error('details[gateway][type]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][currency]">Валюта</label>
                                <select class="form-select" id="details[gateway][currency]" name="details[gateway][currency]" readonly>
                                    <option value="{{ $gateway->data['key'] }}">{{ $gateway->data['title'] }}</option>
                                </select>
                                @error('details[gateway][currency]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][amount]">Сумма</label>
                                <input type="text" class="form-control @error('details[gateway][amount]') is-invalid @enderror" id="details[gateway][amount]" name="details[gateway][amount]" placeholder="Введите сумму пополнения..." value="{{ $tx['details']['gateway']['amount'] ?? 0 }}">
                                @error('details[gateway][amount]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][address]">Адрес</label>
                                <input type="text" class="form-control @error('details[gateway][address]') is-invalid @enderror" id="details[gateway][address]" name="details[gateway][address]" placeholder="Адрес пополнения..." value="{{ $tx['details']['gateway']['address'] ?? null }}" readonly>
                                @error('details[gateway][address]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][blockchain_hash]">Hash</label>
                                <input type="text" class="form-control @error('details[gateway][blockchain_hash]') is-invalid @enderror" id="details[gateway][blockchain_hash]" name="details[gateway][blockchain_hash]" placeholder="Hash транзакции..." value="{{ $tx['details']['gateway']['blockchain_hash'] ?? null }}">
                                @error('details[gateway][blockchain_hash]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[gateway][rate]">Курс</label>
                                <input type="text" class="form-control @error('details[gateway][rate]') is-invalid @enderror" id="details[gateway][rate]" name="details[gateway][rate]" placeholder="Курс" value="{{ $tx['details']['gateway']['rate'] ?? null }}">
                                @error('details[gateway][rate]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Submit -->
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="row p-3">
                        <div class="col-lg-8 col-xl-5 offset-lg-4">
                            <button type="submit" class="btn btn-alt-primary mb-0">
                                <i class="fa fa-check-circle opacity-50 me-1"></i> Подтвердить
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END Submit -->
            </div>
    
        </form>
    </div>
@endsection
