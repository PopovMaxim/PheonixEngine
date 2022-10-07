@extends('robots::layouts.master')

@section('content')
<div>
    @include('hero', ['title' => "<a href=\"{$back}\"><i class=\"fa fa-arrow-left text-muted me-2\"></i></a> Соглашение об использовании", 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <form method="POST">
            @csrf
            <input type="hidden" name="account_number" value="{{ request()->input('account_number') }}" />
            <input type="hidden" name="accept" value="{{ request()->input('accept') }}" />
            <div class="block block-rounded">
                <div class="block-content">
                    <p>
                        Тут будет соглашение об использовании, но сейчас его нету.
                    </p>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" name="accepted" value="1" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-check opacity-50 me-1"></i> Я согласен со всем перечисленным выше
                    </button>
                </div>
            </div>
        </form>
    </div>
<div>
@endsection
