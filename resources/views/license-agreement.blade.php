@extends('layouts.auth')

@push('css')
    <style>
        body {
            background-image: url('assets/media/welcome/hero2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top;
        }
    </style>
@endpush

@section('content')
    <div class="bg-primary-dark-op">
        <div class="hero-static d-flex align-items-center justify-content-center">
            <div class="block block-rounded overflow-hidden" style="width: 800px; height: 900px;">
                <div class="text-center p-5">
                    <a class="fw-bold fs-1" href="{{ url('/') }}">
                        <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid w-50 mb-5" />
                    </a>
                    <p class="text-uppercase fw-bold fs-sm text-muted d-flex justify-content-center alig-items-center"><a href="{{ url('/') }}" class="me-2"><i class="fa fa-arrow-left"></i></a>Лицензионное соглашение</p>
                </div>
                <div class="block-content block-content-full" style="width: 800px; height: 600px;">
                    <iframe style="width: 100%; height: 100%;" src="https://docs.google.com/document/d/e/2PACX-1vTaSCwGaZyj1-Cq8GU412PSiZ-k42EglNEMzG8po6nx8709REzqdFjAkh_fIQ73wQ/pub?embedded=true"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection