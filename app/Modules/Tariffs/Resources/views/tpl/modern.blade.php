<div class="content content-boxed">
    <div class="row d-flex justify-content-center">
        @foreach ($tariffs->sortBy('priority') as $tariff)
            <div class="col-md-6 col-xl-4">
                <div class="block block-rounded block-themed block-fx-shadow" href="javascript:void(0)">
                    <div class="block-header text-center @if ($tariff['color']) bg-{{ $tariff['color'] }} @else bg-dark @endif @if ($tariff['ribbon']) ribbon @endif @if (isset($tariff['ribbon']['form'])) ribbon-{{ $tariff['ribbon']['form'] }} @endif @if (isset($tariff['ribbon']['color'])) ribbon-{{ $tariff['ribbon']['color'] }} @endif">
                        <h3 class="block-title">
                            {{ $tariff['title'] }}
                            @if (isset($tariff['ribbon']['text']))
                                <div class="ribbon-box" style="margin: 8px 0; padding: 0px 15px; top: 0; bottom: 0;">
                                    {{ $tariff['ribbon']['text'] }}
                                </div>
                            @endif
                        </h3>
                    </div>
                    <div class="block-content border-bottom bg-body-light py-3">
                        <div class="py-2 text-center">
                            <p class="h1 fw-bold mb-2 @if ($tariff['color']) text-{{ $tariff['color'] }} @endif">{{ $tariff['result_price'] }} {{ config('app.external-currency') }}</p>
                            @if (isset($tariff['sale']['variant']))
                                <div class="h6 text-muted mb-0">
                                    скидка
                                    @if ($tariff['sale']['variant'] == 'percentage') {{ $tariff['sale']['sum'] }}% @elseif ($tariff['sale']['variant'] == 'numeric') {{ $tariff['sale']['sum'] }} {{ config('app.external-currency') }} @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="block-content p-0">
                        <div>
                            <div class="border-bottom py-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted fs-sm">Срок подписки</div>
                                    <div>
                                        {{ $tariff['translated_period'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom py-3 px-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted fs-sm">Количество лицензий</div>
                                    <div>
                                        <strong>{{ $tariff['details']['license_limit'] ?? 0 }}</strong> шт.
                                    </div>
                                </div>
                            </div>
                            @if (isset($tariff['details']['license_limit']))
                                <div class="border-bottom py-3 px-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted fs-sm">Линейный маркетинг</div>
                                        <div>
                                            <strong>{{ $tariff['details']['license_limit'] ?? 0 }}</strong> ур.
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($tariff['details']['leader_bonus']))
                                <div class="border-bottom py-3 px-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted fs-sm">Лидерский бонус</div>
                                        <div>
                                            @if ($tariff['details']['leader_bonus']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($tariff['details']['quick_bonus']))
                                <div class="border-bottom py-3 px-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted fs-sm">Быстрый бонус</div>
                                        <div>
                                            @if ($tariff['details']['quick_bonus']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($tariff['details']['support']))
                                <div class="border-bottom py-3 px-3 px-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted fs-sm">Тех. Поддержка</div>
                                        <div>
                                            @if ($tariff['details']['support']) <i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-body-light">
                        @if (isset($tariff['details']['sell_start_from']) && now()->parse($tariff['details']['sell_start_from'])->timestamp < now()->timestamp)
                            <span class="btn btn-hero btn-primary px-4 w-100" wire:click="openTerms({{ $tariff['id'] }})">Оформить</span>
                        @else
                            <span class="btn btn-hero btn-primary px-4 w-100 disabled">Старт через
                                @if (now()->parse('2022-10-15 12:15:00')->timestamp > now()->timestamp)
                                    {{ now()->diffInHours(now()->parse('2022-10-15 12:15:00')) }} часов</span>
                                @else
                                    {{ now()->diffInMinutes(now()->parse('2022-10-15 12:15:00')) }} мин.</span>
                                @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>