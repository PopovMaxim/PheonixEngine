<div>
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="text-center">
                <h1 class="fw-bold text-dark mb-4">
                    {{ $tariff_line['title'] }}
                </h1>
            </div>
        </div>
    </div>
    
    @if (isset($tariff_line['details']['design']))
        @include("tariffs::tpl.{$tariff_line['details']['design']}")
    @else
        @include('tariffs::tpl.default')
    @endif

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
