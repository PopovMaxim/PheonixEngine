@extends('admin::layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/repeater.js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sortable/jquery.sortable.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['js-flatpickr']);
        $(document).ready(function () {
            var repeater = $('.repeater').repeater({
                repeaters: [{
                    selector: '.inner-repeater'
                }]
            });

            var additionalList = @json($tariff['details']['additional'] ?? []);

            repeater.setList(additionalList);

            $('[data-repeater-list="additional"]').sortable();
        });
    </script>
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
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">

                    <li class="nav-item">
                        <button type="button" class="nav-link active" id="common-tab" data-bs-toggle="tab" data-bs-target="#common" role="tab" aria-controls="common" aria-selected="true">Общее</button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" id="text-tab" data-bs-toggle="tab" data-bs-target="#text" role="tab" aria-controls="text" aria-selected="true">Текст</button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing" role="tab" aria-controls="marketing" aria-selected="false">Маркетинг</button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale" role="tab" aria-controls="sale" aria-selected="false">Cкидки</button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" role="tab" aria-controls="design" aria-selected="false">Оформление</button>
                    </li>
                </ul>

                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade active show" id="common" role="tabpanel" aria-labelledby="common-tab">
                        <div class="row push">
                            <div class="col-lg-8 col-xl-5">
                                <div class="mb-4">
                                    <label class="form-label" for="status">Статус</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="" selected="">Выберите статус тарифа</option>
                                        <option value="1" @if (isset($tariff) && $tariff['status']) selected="" @endif>Включен</option>
                                        <option value="0" @if (isset($tariff) && !$tariff['status']) selected="" @endif>Выключен</option>
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
                                            <option value="{{ $line['id'] }}" @if (isset($tariff) && $tariff['tariff_line'] == $line['id']) selected="" @endif>{{ $line['title'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('tariff_line')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="title">Название</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Введите название тарифа" value="{{ $tariff['title'] ?? null }}">
                                    @error('title')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="key">Ключ</label>
                                    <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" placeholder="Введите ключ тарифа" value="{{ $tariff['key'] ?? null }}">
                                    @error('key')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="status">Период</label>
                                    <select class="form-select @error('period') is-invalid @enderror" id="period" name="period">
                                        <option value="" selected="">Выберите период</option>
                                        <option value="1 week" @if (isset($tariff) && $tariff['period'] == '1 week') selected="" @endif>1 неделя</option>
                                        <option value="2 weeks" @if (isset($tariff) && $tariff['period'] == '2 weeks') selected="" @endif>2 недели</option>
                                        <option value="3 weeks" @if (isset($tariff) && $tariff['period'] == '3 weeks') selected="" @endif>3 недели</option>
                                        <option value="1 month" @if (isset($tariff) && $tariff['period'] == '1 month') selected="" @endif>1 месяц</option>
                                        <option value="2 months" @if (isset($tariff) && $tariff['period'] == '2 months') selected="" @endif>2 месяца</option>
                                        <option value="3 months" @if (isset($tariff) && $tariff['period'] == '3 months') selected="" @endif>3 месяца</option>
                                        <option value="4 months" @if (isset($tariff) && $tariff['period'] == '4 months') selected="" @endif>4 месяца</option>
                                        <option value="5 months" @if (isset($tariff) && $tariff['period'] == '5 months') selected="" @endif>5 месяцев</option>
                                        <option value="6 months" @if (isset($tariff) && $tariff['period'] == '6 months') selected="" @endif>6 месяцев</option>
                                        <option value="7 months" @if (isset($tariff) && $tariff['period'] == '7 months') selected="" @endif>7 месяцев</option>
                                        <option value="8 months" @if (isset($tariff) && $tariff['period'] == '8 months') selected="" @endif>8 месяцев</option>
                                        <option value="9 months" @if (isset($tariff) && $tariff['period'] == '9 months') selected="" @endif>9 месяцев</option>
                                        <option value="10 months" @if (isset($tariff) && $tariff['period'] == '10 months') selected="" @endif>10 месяцев</option>
                                        <option value="11 months" @if (isset($tariff) && $tariff['period'] == '1 months') selected="" @endif>11 месяцев</option>
                                        <option value="1 year" @if (isset($tariff) && $tariff['period'] == '1 year') selected="" @endif>1 год</option>
                                        <option value="2 years" @if (isset($tariff) && $tariff['period'] == '2 years') selected="" @endif>2 года</option>
                                        <option value="3 years" @if (isset($tariff) && $tariff['period'] == '3 years') selected="" @endif>3 года</option>
                                        <option value="4 years" @if (isset($tariff) && $tariff['period'] == '4 years') selected="" @endif>4 года</option>
                                        <option value="5 years" @if (isset($tariff) && $tariff['period'] == '5 years') selected="" @endif>5 лет</option>
                                    </select>
                                    @error('period')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="details_license_limit">Количество лицензий</label>
                                    <select class="form-select @error('details.license_limit') is-invalid @enderror" id="details_license_limit" name="details[license_limit]">
                                        <option value="1" @if (isset($tariff['details']['license_limit']) && $tariff['details']['license_limit'] == 1) selected="" @endif>1</option>
                                    </select>
                                    @error('details.license_limit')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="price">Цена</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Введите цену тарифа" value="{{ $tariff['price'] ?? null }}">
                                    @error('price')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label" for="products">Продукты</label>
                                    <select class="form-select" id="products" name="details[products][]" size="5" multiple="">
                                        <option value="">Выберите одно или несколько значений</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product['key'] }}" @if (in_array($product['key'], $tariff['details']['products'] ?? [])) selected="" @endif>{{ $product['key'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="description">Описание</label>
                                    <textarea class="form-control" id="description" name="description @error('description') is-invalid @enderror" rows="4" placeholder="Введите описание тарифа (не обязательно)">{{ $tariff['description'] ?? null }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="priority">Приоритет</label>
                                    <input type="text" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" placeholder="Укажите приоритет тарифа" value="{{ $tariff['priority'] ?? null }}">
                                    @error('priority')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="text-tab">
                        <div class="row push">
                            <div class="col-lg-8 col-xl-5">
                                <div class="repeater">
                                    <div data-repeater-list="additional">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="mb-4">
                                                        <input class="form-control" type="text" name="title" placeholder="Название"/>
                                                    </div>
                                                    <div class="mb-0">
                                                        <textarea class="form-control" type="text" name="value" placeholder="Значение"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-0">
                                                        <input class="btn btn-danger" data-repeater-delete type="button" value="Удалить" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-3" />
                                        </div>
                                    </div>
                                    <input class="btn btn-outline-secondary mb-3" data-repeater-create type="button" value="Добавить" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="sale" role="tabpanel" aria-labelledby="sale-tab">
                        <div class="row push">
                            <div class="col-lg-8 col-xl-5">
                                <div class="mb-4">
                                    <label class="form-label" for="sale_variant">Тип скидки</label>
                                    <select class="form-select @error('sale.variant') is-invalid @enderror" id="sale_variant" name="sale[variant]">
                                        <option value="" selected="">Нет</option>
                                        <option value="fixed" @if (isset($tariff['sale']['variant']) && $tariff['sale']['variant'] == 'fixed') selected="" @endif>Фиксированная скидка</option>
                                        <option value="percentage" @if (isset($tariff['sale']['variant']) && $tariff['sale']['variant'] == 'percentage') selected="" @endif>Процент</option>
                                    </select>
                                    @error('sale.variant')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="sale_sum">Величина скидки</label>
                                    <input type="text" class="form-control @error('sale.sum') is-invalid @enderror" id="sale_sum" name="sale[sum]" placeholder="Целое или дробное число" value="{{ $tariff['sale']['sum'] ?? null }}">
                                    @error('sale.sum')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="sale_start_at">Дата старта</label>
                                    <input type="text" class="js-flatpickr form-control @error('sale.start_at') is-invalid @enderror" id="sale_start_at" name="sale[start_at]" placeholder="Выберите дату начала действия скидки" data-enable-time="true" data-time_24hr="true" value="{{ $tariff['sale']['start_at'] ?? null }}">
                                    @error('sale.start_at')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="sale_end_at">Дата окончания</label>
                                    <input type="text" class="js-flatpickr form-control @error('sale.end_at') is-invalid @enderror" id="sale_end_at" name="sale[end_at]" placeholder="Выберите дату окончания действия скидки" data-enable-time="true" data-time_24hr="true" value="{{ $tariff['sale']['end_at'] ?? null }}">
                                    @error('sale.end_at')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="marketing" role="tabpanel" aria-labelledby="marketing-tab">
                        <div class="row push">
                            <div class="col-lg-8 col-xl-5">
                                <div class="mb-4">
                                    <label class="form-label" for="details_marketing_limit">Уровни линейного маркетинга</label>
                                    <select class="form-select @error('details.marketing_limit') is-invalid @enderror" id="details_marketing_limit" name="details[marketing_limit]">
                                        <option value="" selected="">Выберите количество уровней</option>
                                        <option value="1" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 1) selected="" @endif>1</option>
                                        <option value="2" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 2) selected="" @endif>2</option>
                                        <option value="3" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 3) selected="" @endif>3</option>
                                        <option value="4" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 4) selected="" @endif>4</option>
                                        <option value="5" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 5) selected="" @endif>5</option>
                                        <option value="6" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 6) selected="" @endif>6</option>
                                        <option value="7" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 7) selected="" @endif>7</option>
                                        <option value="8" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 8) selected="" @endif>8</option>
                                        <option value="9" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 9) selected="" @endif>9</option>
                                        <option value="10" @if (isset($tariff['details']['marketing_limit']) && $tariff['details']['marketing_limit'] == 10) selected="" @endif>10</option>
                                    </select>
                                    @error('details.marketing_limit')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="ribbon_form">Быстрый бонус</label>
                                    <select class="form-select @error('ribbon.form') is-invalid @enderror" id="ribbon_form" name="details[quick_bonus]">
                                        <option value="1" @if (isset($tariff['details']['quick_bonus']) && $tariff['details']['quick_bonus']) selected="" @endif>Есть</option>
                                        <option value="0" @if (isset($tariff['details']['quick_bonus']) && !$tariff['details']['quick_bonus']) selected="" @endif>Нет</option>
                                    </select>
                                    @error('details.quick_bonus')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="details_leader_bonus">Лидерский пул</label>
                                    <select class="form-select @error('details.leader_bonus') is-invalid @enderror" id="details_leader_bonus" name="details[leader_bonus]">
                                        <option value="1" @if (isset($tariff['details']['leader_bonus']) && $tariff['details']['leader_bonus']) selected="" @endif>Есть</option>
                                        <option value="0" @if (isset($tariff['details']['leader_bonus']) && !$tariff['details']['leader_bonus']) selected="" @endif>Нет</option>
                                    </select>
                                    @error('details.leader_bonus')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                        <div class="row push">
                            <div class="col-lg-8 col-xl-5">
                                <div class="mb-4">
                                    <label class="form-label" for="color">Цвет фона и кнопок</label>
                                    <select class="form-select @error('color') is-invalid @enderror" id="color" name="color">
                                        <option value="dark" @if (isset($tariff['color']) && $tariff['color'] == 'dark') selected="" @endif>Dark</option>
                                        <option value="primary" @if (isset($tariff['color']) && $tariff['color'] == 'primary') selected="" @endif>Primary</option>
                                        <option value="warning" @if (isset($tariff['color']) && $tariff['color'] == 'warning') selected="" @endif>Warning</option>
                                        <option value="info" @if (isset($tariff['color']) && $tariff['color'] == 'info') selected="" @endif>Info</option>
                                        <option value="danger" @if (isset($tariff['color']) && $tariff['color'] == 'danger') selected="" @endif>Danger</option>
                                        <option value="success" @if (isset($tariff['color']) && $tariff['color'] == 'success') selected="" @endif>Success</option>
                                        <option value="muted" @if (isset($tariff['color']) && $tariff['color'] == 'muted') selected="" @endif>Muted</option>
                                    </select>
                                    @error('color')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="ribbon_color">Цвет ленты</label>
                                    <select class="form-select @error('ribbon.color') is-invalid @enderror" id="ribbon_color" name="ribbon[color]">
                                        <option value="" selected="">Выберите цвет ленты</option>
                                        <option value="primary" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'primary') selected="" @endif>Primary</option>
                                        <option value="warning" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'warning') selected="" @endif>Warning</option>
                                        <option value="info" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'info') selected="" @endif>Info</option>
                                        <option value="danger" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'danger') selected="" @endif>Danger</option>
                                        <option value="success" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'success') selected="" @endif>Success</option>
                                        <option value="muted" @if (isset($tariff['ribbon']['color']) && $tariff['ribbon']['color'] == 'muted') selected="" @endif>Muted</option>
                                    </select>
                                    @error('ribbon.color')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="ribbon_text">Текст ленты</label>
                                    <input type="text" class="form-control @error('ribbon.text') is-invalid @enderror" id="ribbon_text" name="ribbon[text]" placeholder="Выберите дату начала действия скидки" value="{{ $tariff['ribbon']['text'] ?? null }}">
                                    @error('ribbon.text')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="ribbon_form">Форма ленты</label>
                                    <select class="form-select @error('ribbon.form') is-invalid @enderror" id="ribbon_form" name="ribbon[form]">
                                        <option value="" selected="">Выберите форму ленты</option>
                                        <option value="bookmark" @if (isset($tariff['ribbon']['form']) && $tariff['ribbon']['form'] == 'bookmark') selected="" @endif>Bookmark</option>
                                        <option value="modern" @if (isset($tariff['ribbon']['form']) && $tariff['ribbon']['form'] == 'modern') selected="" @endif>Modern</option>
                                        <option value="glass" @if (isset($tariff['ribbon']['form']) && $tariff['ribbon']['form'] == 'glass') selected="" @endif>Glass</option>
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
        </div>
    </form>
@endsection