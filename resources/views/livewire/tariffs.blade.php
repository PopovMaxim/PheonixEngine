<div>
    <div class="text-center mb-5">
        <div>
            <div class="bg-transparent">
                <div class="content content-full content-top">
                    <div class="text-center">
                        <h1 class="fw-bold text-dark mb-5">
                            {{ $tariff_line['title'] }}
                        </h1>
                    </div>
                </div>
            </div>
            
        @if (session('status'))
            @php
                $status = session('status');
                $type = $status['type'];
                $message = $status['message'];
            @endphp
            <div class="alert alert-{{ $type }} alert-dismissible" role="alert">
                <h3 class="alert-heading fs-4 my-2">Внимание!</h3>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
                <p class="mb-0">{!! $message !!}</p>
            </div>
        @endif
        
            <table class="table table-borderless table-hover table-vcenter text-center mb-0 border">
                <thead>
                    <tr class="table-dark text-uppercase fs-sm">
                        <th class="py-4" style="width: 180px;"></th>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <th class="@if ($tariff['color']) bg-{{ $tariff['color'] }} @endif @if ($tariff['ribbon']) ribbon @endif  @if (isset($tariff['ribbon']['form'])) ribbon-{{ $tariff['ribbon']['form'] }} @endif @if (isset($tariff['ribbon']['color'])) ribbon-{{ $tariff['ribbon']['color'] }} @endif">
                                <div>
                                    {{ $tariff['title'] }}
                                    @if (isset($tariff['ribbon']['text']))
                                        <div class="ribbon-box" style="margin: 8px 0; padding: 0px 15px; top: 0; bottom: 0;">
                                            {{ $tariff['ribbon']['text'] }}
                                        </div>
                                    @endif
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-body-light">
                        <td></td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td class="py-4">
                                <div class="h1 fw-bold mb-0 @if ($tariff['color']) text-{{ $tariff['color'] }} @endif">
                                    $ {{ $tariff['result_price'] }}
                                </div>
                                @if (isset($tariff['sale']['variant']))
                                    <div class="h6 text-muted mb-0">
                                        скидка
                                        @if ($tariff['sale']['variant'] == 'percentage') {{ $tariff['sale']['sum'] }}% @elseif ($tariff['sale']['variant'] == 'numeric') {{ $tariff['sale']['sum'] }} {{ config('app.external-currency') }} @endif
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Срок</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>{{ $tariff['translated_period'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Количество лицензий</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>{{ $tariff['details']['license_limit'] ?? 0 }} шт.</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Линейный маркетинг</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>{{ $tariff['details']['marketing_limit'] ?? 0 }} ур.</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Лидерский бонус</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>@if ($tariff['details']['leader_bonus']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Быстрый бонус</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>@if ($tariff['details']['quick_bonus']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fs-sm text-end">Тех. Поддержка</td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>@if ($tariff['details']['support']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                        @endforeach
                    </tr>
                    <tr class="bg-body-light">
                        <td></td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>
                                <div>
                                    <button type="button" class="btn rounded-0 btn-sm btn-hero @if ($tariff['color']) btn-{{ $tariff['color'] }} @else btn-secondary @endif px-4" wire:click="selectTariff({{ $tariff['id'] }})">Оформить</button>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr class="bg-body-light">
                        <td></td>
                        @foreach ($tariffs->sortBy('priority') as $tariff)
                            <td>
                                <button type="button" class="btn rounded-0 btn-sm btn-link px-4" wire:click="openDescription({{ $tariff['id'] }})">Подробнее</button>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if ($this->tariff)
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="selectTariff">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Оформление подписки</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                        </div>
                        <div class="block-content">
                            <p>Вы уверены, что согласны с <a href="#">лицензионным соглашением</a> и хотите оформить подписку на тариф <b>«{{ $this->tariff['title'] }}»</b> из линейки <b>«{{ $this->tariff['line']['title'] }}»</b>? Отменить это действие будет нельзя.</p>
                            
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-sm btn-primary" wire:click="submit" data-bs-dismiss="modal" wire:click="submit">Да, я уверен</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="openDescription">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Описание тарифа</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                        </div>
                        <div class="block-content">
                            <p>{{ $this->tariff['description'] }}</p>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('js')
    <script>
        window.addEventListener('selectTariff', (e) => {
            var modal = new bootstrap.Modal(document.getElementById('selectTariff'), {
                keyboard: false
            })
            modal.show()
        });
        window.addEventListener('openDescription', (e) => {
            var modal = new bootstrap.Modal(document.getElementById('openDescription'), {
                keyboard: false
            })
            modal.show()
        });
    </script>
@endpush

@push('css')
@endpush
