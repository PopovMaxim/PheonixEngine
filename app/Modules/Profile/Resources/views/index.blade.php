@extends('profile::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full">
            <div class="pt-5 py-4 text-center">
                <h1 class="fw-bold my-2 text-dark">Редактирование профиля</h1>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        @livewire('update-profile')
    </div>
@endsection
