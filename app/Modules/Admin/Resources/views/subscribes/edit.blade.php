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
@include('hero', ['title' => '<a href="/admin/subscribes"><i class="fa fa-arrow-left text-muted me-2"></i></a> Редактирование подписки', 'breadcrumbs' => []])
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
                                <a href="{{ route('admin.users.read', ['id' => $subscribe['user']['id']]) }}">
                                    <div class="d-flex flex-row my-3">
                                        <div class="me-2">
                                            <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                        </div>
                                        <div>
                                            {{ $subscribe['user']['nickname'] }}
                                            <div class="text-muted fs-sm">
                                                ФИО: {{ $subscribe['user']['full_name'] }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Идентификатор</label>
                                <input type="text" class="form-control" value="{{ $subscribe['id'] }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Статус</label>
                                <select class="form-select" id="status" name="status">
                                    <option selected="" value="">Выберите статус...</option>
                                    <option value="new" @if ($subscribe['status'] == 'new') selected="" @endif>Новая</option>
                                    <option value="pending" @if ($subscribe['status'] == 'pending') selected="" @endif>В обработке</option>
                                    <option value="completed" @if ($subscribe['status'] == 'completed') selected="" @endif>Исполнено</option>
                                    <option value="canceled" @if ($subscribe['status'] == 'canceled') selected="" @endif>Отменено</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="amount">Сумма</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Введите сумму пополнения..." value="{{ number_format($subscribe['amount'] / 100, 2) }}">
                                @error('amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="patronymic">Дата создания</label>
                                <input type="text" class="form-control @error('created_at') is-invalid @enderror" id="created_at" name="created_at" placeholder="Дата создания операции..." value="{{ $subscribe['created_at'] }}" readonly>
                                @error('created_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="patronymic">Дата изменения</label>
                                <input type="text" class="form-control @error('updated_at') is-invalid @enderror" id="updated_at" name="updated_at" placeholder="Дата изменения операции..." value="{{ $subscribe['updated_at'] }}" readonly>
                                @error('updated_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-globe text-muted me-1"></i> Детали подписки
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="details[tariff]">Тариф</label>
                                <select class="form-select" id="details[tariff]" name="details[tariff]">
                                    @foreach (\App\Modules\Tariffs\Entities\Tariff::all() as $tariff)
                                        <option value="{{ $tariff['id'] }}" @if($tariff['id'] == $subscribe['details']['tariff']) selected="" @endif>[{{ $tariff['line']['title'] }}] {{ $tariff['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('details.tariff')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[expired_at]">Дата истечения</label>
                                <input type="text" class="form-control @error('details.expired_at') is-invalid @enderror" id="details[expired_at]" name="details[expired_at]" placeholder="Дата истечения..." value="{{ $subscribe['details']['expired_at'] ?? null }}">
                                @error('details.expired_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-key text-muted me-1"></i> Ключ
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="details[tariff]">Тариф</label>
                                <select class="form-select" id="details[tariff]" name="details[tariff]">
                                    @foreach (\App\Modules\Tariffs\Entities\Tariff::all() as $tariff)
                                        <option value="{{ $tariff['id'] }}" @if($tariff['id'] == $subscribe['details']['tariff']) selected="" @endif>[{{ $tariff['line']['title'] }}] {{ $tariff['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('details.tariff')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="details[expired_at]">Дата истечения</label>
                                <input type="text" class="form-control @error('details.expired_at') is-invalid @enderror" id="details[expired_at]" name="details[expired_at]" placeholder="Дата истечения..." value="{{ $subscribe['details']['expired_at'] ?? null }}">
                                @error('details.expired_at')
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
