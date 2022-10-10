@extends('robots::layouts.master')

@section('content')
<div>
    @include('hero', ['title' => "<a href=\"{$back}\"><i class=\"fa fa-arrow-left text-muted me-2\"></i></a> Внимание", 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <form method="POST">
            @csrf
            <input type="hidden" name="account_number" value="{{ request()->input('account_number') }}" />
            <input type="hidden" name="accept" value="{{ request()->input('accept') }}" />
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <i class="fa fa-warning fa-6x text-warning mb-3"></i>
                    <p>Номер счёта <b>«{{ request()->input('account_number') }}»</b> уже активирован. <br/> Вы уверены, что хотите зарегистрировать ещё одну лицензию на этот номер счёта?</p>
                </div>
                {{--<div class="block-content block-content-full block-content-sm border-bottom d-flex justify-content-center">
                    <div class="form-check w-50">
                        <input class="form-check-input @error('accept') is-invalid @enderror" type="checkbox" name="accepted" id="accept" value="1">
                        <label class="form-check-label" for="example-checkbox-default1">Да, я уверен что хочу зарегистрировать ещё одну лицензию на номер счёта <b>{{ request()->input('account_number') }}</b>.</label>
                    </div>
                </div>--}}
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" value="1" name="confirm" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-check opacity-50 me-1"></i> Да, я уверен
                    </button>
                    <a href="{{$back}}" class="btn btn-sm btn-alt-secondary">
                        <i class="fa fa-times opacity-50 me-1"></i> Отмена
                    </a>
                </div>
            </div>
        </form>
    </div>
<div>
@endsection
