@extends('transfer::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/maskMoney/jquery.maskMoney.min.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('#amount').maskMoney();
        })
    </script>
@endpush

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    Заявка на вывод
                </h1>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                @if (!$withdraw_request)
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title text-center">Форма заявки</h3>
                        </div>
                        <div class="block-content">
                            @if(session()->has('request_status'))
                                @php
                                    $session = session('request_status');
                                @endphp
                                <div class="alert alert-{{ $session['type'] }}">{{ $session['text'] }}</div>
                            @endif
                            <form action="{{ route('withdraw.request') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label" for="amount">Сумма</label>
                                    <input type="text" class="form-control form-control-alt @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="100.00">
                                    @error('amount')
                                        <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Отправить заявку</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="block block-rounded block-fx-pop">
                        <div class="block-content block-content-full">
                            <div class="d-md-flex justify-content-md-between align-items-md-center">
                                <div class="p-1 p-md-3">
                                    <div class="d-md-flex justify-content-md-between align-items-md-center">
                                        <div class="me-4">
                                            <i class="fa fa-clock fa-3x text-warning"></i>
                                        </div>
                                        <div>
                                            <h3 class="h4 fw-bold mb-1">{{ $withdraw_request['formatted_amount'] }}</h3>
                                            <p class="fs-sm text-muted mb-0">
                                                {{ $withdraw_request['created_at'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 p-md-3">
                                    <form method="post" action="{{ route('withdraw.cancel') }}">
                                        @csrf
                                        <button class="btn btn-sm btn-alt-danger rounded-pill px-3 me-1 my-1">
                                            <i class="fa fa-times opacity-50 me-1"></i> Отменить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
