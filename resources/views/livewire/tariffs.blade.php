<div>
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

    <div class="table-responsive">
        <table class="table table-borderless table-hover table-vcenter text-center mb-0 border">
            <thead>
                <tr class="table-dark text-uppercase fs-sm">
                    <th class="py-4" style="width: 180px;"></th>
                    <th class="py-4">Start</th>
                    <th class="py-4">Medium</th>
                    <th class="py-4 bg-primary">Business</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-body-light">
                    <td></td>
                    <td class="py-4">
                        <div class="h1 fw-bold mb-2">7,500 ₽</div>
                        <div class="h6 text-muted mb-0">на 1 год</div>
                    </td>
                    <td class="py-4">
                        <div class="h1 fw-bold mb-2">12,500 ₽</div>
                        <div class="h6 text-muted mb-0">на 2 года</div>
                    </td>
                    <td class="py-4">
                        <div class="h1 fw-bold text-primary mb-2">27,500 ₽</div>
                        <div class="h6 text-muted mb-0">на 5 лет</div>
                    </td>
                </tr>
                <tr>
                    <td class="fs-sm text-end">Срок</td>
                    <td>1 год</td>
                    <td>2 года</td>
                    <td>5 лет</td>
                </tr>
                <tr>
                    <td class="fs-sm text-end">Количество роботов</td>
                    <td>1 шт.</td>
                    <td>1 шт.</td>
                    <td>1 шт.</td>
                </tr>
                <tr>
                    <td class="fs-sm text-end">Линейный маркетинг</td>
                    <td>1 ур.</td>
                    <td>5 ур.</td>
                    <td>10 ур.</td>
                </tr>
                <tr>
                    <td class="fs-sm text-end">Бинарный маркетинг</td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                </tr>
                <tr>
                    <td class="fs-sm text-end">Тех. Поддержка</td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                    <td><i class="fas fa-circle-check text-success"></i></td>
                </tr>
                <tr class="bg-body-light">
                    <td></td>
                    <td>
                        <button type="button" class="btn rounded-0 btn-sm btn-hero btn-secondary px-4" wire:click="openModal(1)">Оформить</button>
                    </td>
                    <td>
                        <button type="button" class="btn rounded-0 btn-sm btn-hero btn-secondary px-4" wire:click="openModal(2)">Оформить</button>
                    </td>
                    <td>
                        <button type="button" class="btn rounded-0 btn-sm btn-hero btn-primary px-4" wire:click="openModal(3)">Оформить</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    @if ($this->modalVisible)
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="confirmModal">
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
                            <p>Вы уверены, что хотите оформить подписку на тариф <b>«{{ $this->tariffs[$this->selectedTariff]['title'] }}»</b>? Отменить это действие будет нельзя.</p>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-sm btn-primary" wire:click="submit" data-bs-dismiss="modal">Да, я уверен</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('js')
    <script>
        window.addEventListener('openModal', (e) => {
            var myModal = new bootstrap.Modal(document.getElementById('confirmModal'), {
                keyboard: false
            })
            myModal.show()
        });
    </script>
@endpush