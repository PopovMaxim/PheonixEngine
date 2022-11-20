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
            <div class="block block-rounded">
                <div class="block-content">
                    <h2 class="content-heading pt-0">Общие настройки</h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Общие настройки линейки
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="status">Статус</label>
                                <select class="form-select @error('details.status') is-invalid @enderror" id="status" name="details[status]">
                                    <option value="" selected="">Выберите статус</option>
                                    <option value="1" @if (isset($line) && $line['details']['status']) selected="" @endif>Включен</option>
                                    <option value="0" @if (isset($line) && !$line['details']['status']) selected="" @endif>Выключен</option>
                                </select>
                                @error('details.status')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="design">Шаблон</label>
                                <select class="form-select @error('details.design') is-invalid @enderror" id="design" name="details[design]">
                                    <option value="" selected="">Выберите шаблон</option>
                                    <option value="modern" @if (isset($line) && $line['details']['design'] == 'modern') selected="" @endif>Modern</option>
                                </select>
                                @error('details.design')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="key">Ключ</label>
                                <input type="text" class="form-control @error('details.key') is-invalid @enderror" id="key" name="details[key]" placeholder="Введите ключ линейки" value="{{ $line['details']['key'] ?? null }}">
                                @error('details.key')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="slug">Slug</label>
                                <input type="text" class="form-control @error('details.slug') is-invalid @enderror" id="slug" name="details[slug]" placeholder="Введите slug линейки" value="{{ $line['details']['slug'] ?? null }}">
                                @error('details.slug')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="title">Название</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Введите название линейки" value="{{ $line['title'] ?? null }}">
                                @error('title')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="description">Описание</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Введите описание линейки (не обязательно)">{{ $line['description'] ?? null }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="order">Сортировка</label>
                                <input type="text" class="form-control @error('order') is-invalid @enderror" id="order" name="order" placeholder="Укажите позицию линейки" value="{{ $line['order'] ?? null }}">
                                @error('order')
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