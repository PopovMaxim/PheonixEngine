@extends('admin::layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script>Dashmix.helpersOnLoad(['js-flatpickr'])</script>
@endpush

@section('admin.page-actions')
<button class="btn btn-sm btn-alt-primary" type="submit">
    <i class="fa fa-plus"></i> Сохранить
</button>
@endsection

@section('content')
    <form method="post">
        @csrf
        @include('admin.header')
        <div class="content">
            <!-- Elements -->
            <div class="block block-rounded">
                <div class="block-content">
                    <!-- Basic Elements -->
                    <h2 class="content-heading pt-0">Общие настройки</h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Общие настройки тарифа
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="status">Статус</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="" selected="">Выберите статус тарифа</option>
                                    <option value="1">Включен</option>
                                    <option value="0">Выключен</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tariff_line">Линейка тарифов</label>
                                <select class="form-select @error('tariff_line') is-invalid @enderror" id="tariff_line" name="tariff_line">
                                    <option value="" selected="">Выберите линейку тарифов</option>
                                    @foreach ($tariff_lines as $line)
                                        <option value="{{ $line['id'] }}">{{ $line['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('tariff_line')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="title">Название</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Введите название тарифа">
                                @error('title')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="key">Ключ</label>
                                <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" placeholder="Введите ключ тарифа">
                                @error('key')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="status">Период</label>
                                <select class="form-select @error('period') is-invalid @enderror" id="period" name="period">
                                    <option value="" selected="">Выберите период</option>
                                    <option value="1 week">1 неделя</option>
                                    <option value="2 weeks">2 недели</option>
                                    <option value="3 weeks">3 недели</option>
                                    <option value="1 month">1 месяц</option>
                                    <option value="2 months">2 месяца</option>
                                    <option value="3 months">3 месяца</option>
                                    <option value="4 months">4 месяца</option>
                                    <option value="5 months">5 месяцев</option>
                                    <option value="6 months">6 месяцев</option>
                                    <option value="7 months">7 месяцев</option>
                                    <option value="8 months">8 месяцев</option>
                                    <option value="9 months">9 месяцев</option>
                                    <option value="10 months">10 месяцев</option>
                                    <option value="11 months">11 месяцев</option>
                                    <option value="1 year">1 год</option>
                                    <option value="2 years">2 года</option>
                                    <option value="3 years">3 года</option>
                                    <option value="4 years">4 года</option>
                                    <option value="5 years">5 лет</option>
                                </select>
                                @error('period')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="price">Цена</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Введите цену тарифа">
                                @error('price')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Описание</label>
                                <textarea class="form-control" id="description" name="description @error('description') is-invalid @enderror" rows="4" placeholder="Введите описание тарифа (не обязательно)"></textarea>
                                @error('description')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="priority">Приоритет</label>
                                <input type="text" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" placeholder="Укажите приоритет тарифа">
                                @error('priority')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="content-heading pt-0">Управление скидками</h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Управление скидками на тарифы
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="sale_variant">Скидка</label>
                                <select class="form-select @error('sale.variant') is-invalid @enderror" id="sale_variant" name="sale[variant]">
                                    <option value="" selected="">Нет</option>
                                    <option value="fixed">Фиксированная скидка</option>
                                    <option value="percentage">Процент</option>
                                </select>
                                @error('sale.variant')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="sale_sum">Величина скидки</label>
                                <input type="text" class="form-control @error('sale.sum') is-invalid @enderror" id="sale_sum" name="sale[sum]" placeholder="Целое или дробное число">
                                @error('sale.sum')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="sale_start_at">Дата старта</label>
                                <input type="text" class="js-flatpickr form-control @error('sale.start_at') is-invalid @enderror" id="sale_start_at" name="sale[start_at]" placeholder="Выберите дату начала действия скидки" data-enable-time="true" data-time_24hr="true">
                                @error('sale.start_at')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="sale_end_at">Дата окончания</label>
                                <input type="text" class="js-flatpickr form-control @error('sale.end_at') is-invalid @enderror" id="sale_end_at" name="sale[end_at]" placeholder="Выберите дату окончания действия скидки" data-enable-time="true" data-time_24hr="true">
                                @error('sale.end_at')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h2 class="content-heading pt-0">Оформление</h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Настройки цвета и дополнительных элементов
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="color">Цвет фона и кнопок</label>
                                <select class="form-select @error('color') is-invalid @enderror" id="color" name="color">
                                    <option value="" selected="">Выберите цвет фона и кнопок</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="info">Info</option>
                                    <option value="danger">Danger</option>
                                    <option value="success">Success</option>
                                    <option value="muted">Muted</option>
                                </select>
                                @error('color')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="ribbon_color">Цвет ленты</label>
                                <select class="form-select @error('ribbon.color') is-invalid @enderror" id="ribbon_color" name="ribbon[color]">
                                    <option value="" selected="">Выберите цвет ленты</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="info">Info</option>
                                    <option value="danger">Danger</option>
                                    <option value="success">Success</option>
                                    <option value="muted">Muted</option>
                                </select>
                                @error('ribbon.color')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="ribbon_text">Текст ленты</label>
                                <input type="text" class="form-control @error('ribbon.text') is-invalid @enderror" id="ribbon_text" name="ribbon[text]" placeholder="Выберите дату начала действия скидки">
                                @error('ribbon.text')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="ribbon_form">Форма ленты</label>
                                <select class="form-select @error('ribbon.form') is-invalid @enderror" id="ribbon_form" name="ribbon[form]">
                                    <option value="" selected="">Выберите форму ленты</option>
                                    <option value="bookmark">Bookmark</option>
                                    <option value="modern">Modern</option>
                                    <option value="glass">Glass</option>
                                </select>
                                @error('ribbon.form')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection