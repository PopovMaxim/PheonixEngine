@extends('transfer::layouts.master')

@push('js')
@endpush

@section('content')
    @include('hero', ['title' => $title, 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <div class="block block-transparent">
                    <div class="block-content p-0">
                        <div class="border-bottom py-3">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <div>ID операции</div>
                                    <small><b>{{ $tx['id'] }}</b></small>
                                </div>
                                <div class="d-flex flex-column">
                                    <a class="copy" data-clipboard-text="{{ $tx['id'] }}"><i class="fa fa-copy" style="font-size: 20px;"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Статус</b> {!! $tx['html_status'] !!}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Операция</b> {!! $tx['translated_type'] !!}
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <b>Сумма</b> <div>{!! $tx['formatted_amount'] !!}</div>
                        </div>

                        @if ($tx['type'] == 'line_bonus')
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Уровень</b> {{ $tx['details']['level'] }}
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>От кого</b> {{ \App\Models\User::find($tx['details']['user_id'])?->nickname }}
                            </div>
                        @endif

                        @if ($tx['type'] == 'subscribe')
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Линейка</b> <div>{!! \App\Modules\Tariffs\Entities\Tariff::query()->where('id', $tx['details']['tariff'])->first()?->line['title'] ?? 'Неизвестно' !!}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Тариф</b> <div>{!! \App\Modules\Tariffs\Entities\Tariff::query()->where('id', $tx['details']['tariff'])->first()?->title ?? 'Неизвестно' !!}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Истекает</b> <div>{!! now()->parse($tx['details']['expired_at'])->format('d.m.Y в H:i:s') !!}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <b>Ссылка</b> <a target="_blank" href="{{ route('subscribes.read', ['uuid' => $tx['id']]) }}">Перейти к подписке</a>
                            </div>
                        @endif

                        @if ($tx['type'] == 'transfer')
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                @if ($tx['details']['sender'] != $tx['user_id'])
                                    <b>Отправитель</b>
                                    <div>{{ $tx['sender']['nickname'] }}</div>
                                @else
                                    <b>Получатель</b>
                                    <div>{{ $tx['receiver']['nickname'] }}</div>
                                @endif
                            </div>
                        @endif

                        @if ($tx['type'] == 'withdrawal')
                            @if (isset($tx['details']['gateway']['blockchain_confirmations']))
                                <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                    <b>Подтверждения</b> {{ $tx['details']['gateway']['blockchain_confirmations'] ?? 0 }} / {{ $gateway->data['min_confirmations'] }}</span>
                                </div>
                            @endif

                            <div class="border-bottom py-3">
                                <div>
                                    <div>
                                        <div>Адрес</div>
                                        <small><b>{{ $tx['details']['gateway']['address'] }}</b></small>
                                    </div>
                                </div>
                            </div>

                            @if (isset($tx['details']['gateway']['blockchain_hash']))
                                <div class="border-bottom py-3">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <div>Hash</div>
                                            <small><b>{{ $tx['details']['gateway']['blockchain_hash'] }}</b></small>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (in_array($tx['status'], ['pending']))
                                <div class="border-top py-3">
                                    <form onsubmit="return confirm('Вы уверены, что хотите отменить заявку на вывод?');" method="post" action="{{ route('withdraw.cancel') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Отменить заявку</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            @if (isset($faq) && count($faq))
                <div class="col-md-5">
                    <h4>Часто задаваемые вопросы</h4>
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach ($faq as $category)
                            @foreach ($category['items'] as $item)
                                <div class="block block-transparent mb-0">
                                    <div class="block-header ps-0 pt-0" role="tab" id="header_{{ $item['id'] }}">
                                        <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#text_{{ $item['id'] }}" aria-expanded="true" aria-controls="text_{{ $item['id'] }}">{{ $item['question'] }}</a>
                                    </div>
                                    <div id="text_{{ $item['id'] }}" class="collapse" role="tabpanel" aria-labelledby="header_{{ $item['id'] }}" data-bs-parent="#accordion" style="">
                                        <div class="block-content ps-0 pt-0 fs-sm">
                                            <p>{!! $item['answer'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection