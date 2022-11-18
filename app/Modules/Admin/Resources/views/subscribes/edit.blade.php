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
    <form method="post">
        @csrf
        <div class="content content-boxed">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block">
                    <li class="nav-item">
                        <a class="nav-link @if(is_null($tab)) active @endif" href="{{ route('admin.subscribes.edit', ['uuid' => $subscribe['id']]) }}">Общая информация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'key') active @endif" href="{{ route('admin.subscribes.edit', ['uuid' => $subscribe['id'], 'tab' => 'key']) }}">Ключ и номер счёта</a>
                    </li>
                </ul>

                <div class="block-content p-0">
                    @if (is_null($tab))
                        <div class="p-3">
                            <div class="mb-4">
                                <label class="form-label">Пользователь</label>
                                <a target="_blank" href="{{ route('admin.users.read', ['id' => $subscribe['user']['id']]) }}">
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
                        
                        <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                            <button type="submit" class="btn btn-alt-primary mb-0">
                                <i class="fa fa-check-circle opacity-50 me-1"></i> Сохранить
                            </button>
                        </div>
                    @endif

                    @if ($tab == 'key')
                        @if ($subscribe['key'])
                            <div class="p-3">
                                <div class="mb-4">
                                    <label class="form-label" for="already_activated">Статус</label>
                                    <select class="form-select" id="already_activated" name="already_activated">
                                        <option selected="" value="">Выберите статус...</option>
                                        <option value="1" @if ($subscribe['key']['already_activated']) selected="" @endif>Активирован</option>
                                        <option value="0" @if (!$subscribe['key']['already_activated']) selected="" @endif>Не активирован</option>
                                    </select>
                                    @error('already_activated')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Ключ активации</label>
                                    <input type="text" class="form-control" value="{{ $subscribe['key']['activation_key'] }}" readonly>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Номер счёта</label>
                                    <input type="text" class="form-control" id="account-number" name="account_number" value="{{ $subscribe['key']['account_number'] }}" placeholder="Введите номер счёта" />
                                </div>

                                @if ($subscribe['key']['account'])
                                    {{--<div class="mb-4">
                                        <label class="form-label">Брокер</label>
                                        <input type="text" class="form-control" id="account-company" name="account_company" value="{{ $subscribe['key']['account']['account_company'] }}" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Имя аккаунта</label>
                                        <input type="text" class="form-control" id="account-name" name="account_name" value="{{ $subscribe['key']['account']['account_name'] }}" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Продукт</label>
                                        <input type="text" class="form-control" id="ea-name" name="ea_name" value="{{ $subscribe['key']['account']['ea_name'] }}" readonly />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Версия продукта</label>
                                        <input type="text" class="form-control" id="ea-version" name="ea_version" value="{{ $subscribe['key']['account']['ea_version'] }}" readonly />
                                    </div>--}}
                                @endif
                            </div>
                                
                            <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                                <button type="submit" class="btn btn-alt-primary mb-0">
                                    <i class="fa fa-check-circle opacity-50 me-1"></i> Сохранить
                                </button>
                            </div>
                        @else
                            <div class="p-3">
                                <div class="mb-4">
                                    <label class="form-label">Номер счёта</label>
                                    <input type="text" class="form-control" name="account_number" value="" placeholder="Введите номер счёта" />
                                </div>
                            </div>
                                
                            <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                                <button type="submit" class="btn btn-alt-primary mb-0">
                                    <i class="fa fa-check-circle opacity-50 me-1"></i> Получить ключ продукта
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection
