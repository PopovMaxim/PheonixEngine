@extends('admin::layouts.master')

@section('content')
@include('admin.header')

<div class="content content-full">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Список заявок на выплату</h3>
            <div class="block-options">
                <a href="#" style="cursor: pointer;"><i class="fa fa-filter"></i></a>
            </div>
        </div>
        <div class="block-content">
            <form method="post">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="text">Заголовок</label>
                    <input class="form-control form-control-alt" id="subject" name="subject" placeholder="Заголовок рассылки..." />
                </div>
                <div class="mb-4">
                    <label class="form-label" for="text">Текст</label>
                    <textarea class="form-control form-control-alt" id="text" name="text" rows="7" placeholder="Текст рассылки..."></textarea>
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
