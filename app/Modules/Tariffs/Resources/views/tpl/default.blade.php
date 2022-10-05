<div class=" d-flex justify-content-center">
    <table class="w-50 table table-borderless table-hover table-vcenter text-center mb-0 border">
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
                            {{ $tariff['result_price'] }} {{ config('app.external-currency') }}
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