@extends('robots::layouts.master')

@section('content')
<div class="bg-transparent">
    <div class="content content-full content-top">
        <div class="text-center">
            <h1 class="fw-bold text-dark mb-4">
                Управление подпиской
            </h1>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            @if (is_null($subscribe->productKey))
                <form method="POST">
                    @csrf
                    <div class="block block-rounded">
                        <div class="block-content">
                            <div class="row justify-content-center py-sm-3 py-md-5">
                                <div class="col-sm-10 col-md-8">
                                    <div class="mb-4">
                                        <label class="form-label" for="account-number">Номер счёта</label>
                                        <input type="text" class="form-control form-control-alt @error('account_number') is-invalid @enderror" id="account-number" name="account_number" value="{{ old('account_number') }}" placeholder="Введите номер счёта">
                                        @error('account_number')
                                            <div class="invalid-feedback animated fadeIn">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('accept') is-invalid @enderror" type="checkbox" value="1" id="accept" name="accept">
                                            <label class="form-check-label" for="accept">Я уверен(а) что хочу активировать данный номер счёта.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                            <button type="submit" class="btn btn-sm btn-alt-primary">
                                <i class="fa fa-check opacity-50 me-1"></i> Получить ключ продукта
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="row items-push">
                    <div class="col-md-4">
                        <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                              <div>
                                <p class="fs-lg fw-semibold mb-0">
                                    @if ($account_number)
                                        Активирован
                                    @else
                                        Не активирован
                                    @endif
                                </p>
                                <p class="text-muted mb-0">
                                    Текущий статус
                                </p>
                              </div>
                              <div class="ms-3 item">
                                <i class="fa fa-2x fa-key text-muted"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                              <div>
                                <p class="fs-lg fw-semibold mb-0">
                                    {{ now()->parse($subscribe['details']['expired_at'])->format('d.m.Y в H:i:s') }}
                                </p>
                                <p class="text-muted mb-0">
                                    Дата истечения
                                </p>
                              </div>
                              <div class="ms-3 item">
                                <i class="fa fa-2x fa-calendar text-muted"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block block-rounded h-100 mb-0" href="javascript:void(0)">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                              <div>
                                <p class="fs-lg fw-semibold mb-0">
                                    {{ $subscribe->productKey['account_number'] }}
                                </p>
                                <p class="text-muted mb-0">
                                    Номер счёта
                                </p>
                              </div>
                              <div class="ms-3 item">
                                <i class="fa fa-2x fa-star text-muted"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="block block-rounded block-themed">
                            <div class="block-header">
                                <h3 class="block-title text-center">Ключ активации продукта</h3>
                            </div>
                            <div class="block-content pt-0">
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    <div class="col-sm-10 col-md-8">
                                        <div class="d-flex justify-content-center">
                                            <div class="bg-gray p-3 rounded text-center fw-bold">
                                                {{ $subscribe->productKey['activation_key'] }}
                                            </div>
                                        </div>
                                        <div class="text-muted text-center"><small>Нажмите на код, чтобы скопировать</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
