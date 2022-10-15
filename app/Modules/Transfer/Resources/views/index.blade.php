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
    <div class="row items-push">
        <div class="col-md-6">
            <div class="block block-rounded h-100">
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
                            <input type="text" class="form-control form-control-alt @error('account_number') is-invalid @enderror" value="{{ old('account_number') }}" id="account_number" name="account_number" placeholder="PX-123-456">
                            @error('account_number')
                                <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="amount">Сумма</label>
                            <input type="text" class="form-control form-control-alt @error('amount') is-invalid @enderror" value="{{ old('amount') }}" id="amount" name="amount" placeholder="100.00">
                            @error('amount')
                                <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="amount">Код подтверждения</label>
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="text" class="form-control form-control-alt @error('confirm_code') is-invalid @enderror me-lg-4" name="confirm_code" placeholder="Код из почтового сообщения">
                                <button type="submit" name="send_confirm_code" class="btn btn-outline-primary">Выслать&nbsp;код</button>
                            </div>
                            @error('confirm_code')
                                <div class="text-danger fs-sm mt-1 animated fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Перевести</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded h-100">
                <div class="block-content py-5">
                    <div>
                        <h3 class="h3 text-center">Мой номер счёта</h3>
                        <p class="text-center">Для получения перевода от другого участника, сообщите ему свой номер счёта.</p>
                        <div class="d-flex justify-content-center">
                            <a class="bg-gray w-50 p-3 rounded text-center fw-bold copy" data-clipboard-text="{{ request()->user()->account_number }}" style="cursor: pointer;">
                                {{ request()->user()->account_number }}
                            </a>
                        </div>
                        <div class="text-muted text-center"><small>Нажмите чтобы скопировать</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-heading pt-0">История переводов</div>

    <div class="block block-rounded h-100 mb-0">
        <div class="block-content d-flex justify-content-between flex-column">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-vcenter fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20%;">Статус</th>
                            <th class="text-center" style="width: 20%;">Отправитель</th>
                            <th class="text-center" style="width: 20%;">Получатель</th>
                            <th class="text-center" style="width: 20%;">Сумма</th>
                            <th class="text-center" style="width: 20%;">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transfers as $transaction)
                            <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href = '{{ route('transfer.read', ['uuid' => $transaction['id']]) }}'">
                                <td class="text-center">{!! $transaction['html_status'] !!}</td>
                                <td class="text-center">
                                    @if ($transaction['details']['sender'] == $transaction['user_id'])
                                        Я
                                    @else
                                        <div>{{ $transaction['sender']['nickname'] }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($transaction['details']['sender'] != $transaction['user_id'])
                                        Я
                                    @else
                                        <div>{{ $transaction['receiver']['nickname'] }}</div>
                                    @endif
                                </td>
                                <td class="text-center" style="width: 20%;">
                                    {{ $transaction['formatted_amount'] }}
                                </td>
                                <td class="text-center">
                                    <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Ни одного перевода не найдено...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $transfers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
