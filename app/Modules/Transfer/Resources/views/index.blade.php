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
                Перевод
            </h1>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title text-center">Мой номер счёта</h3>
                </div>
                <div class="block-content pb-4">
                    <div>
                        <p class="text-center">Для получения перевода от другого участника, сообщите ему свой номер счёта.</p>
                        <div class="d-flex justify-content-center">
                            <div class="bg-gray w-50 p-3 rounded text-center fw-bold">
                                {{ request()->user()->account_number }}
                            </div>
                        </div>
                        <div class="text-muted text-center"><small>Нажмите на код, чтобы скопировать</small></div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title text-center">Форма перевода</h3>
                </div>
                <div class="block-content">
                    @if(session()->has('request_status'))
                        @php
                            $session = session('request_status');
                        @endphp
                        <div class="alert alert-{{ $session['type'] }}">{{ $session['text'] }}</div>
                    @endif
                    <form action="{{ route('transfer.send') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label" for="account_number">Номер счёта получателя</label>
                            <input type="text" class="form-control form-control-alt @error('account_number') is-invalid @enderror" id="account_number" name="account_number" placeholder="PH-123-456">
                            @error('account_number')
                                <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="amount">Сумма</label>
                            <input type="text" class="form-control form-control-alt @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="100.00">
                            @error('amount')
                                <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Перевести</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
