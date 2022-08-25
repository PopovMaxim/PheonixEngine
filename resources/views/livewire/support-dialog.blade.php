<div class="block block-rounded">
    <div class="block-content block-content-full text-break overflow-y-auto" style="height: 500px;">
        @forelse ($ticket->messages()->orderBy('id', 'desc')->get() as $message)
        <div class="@if (request()->user()->id == $message['user_id']) ms-4 text-end @else me-4 @endif">
            <div
                class="fs-sm text-muted animated fadeIn my-2 @if (request()->user()->id == $message['user_id']) text-end @endif">
                {{ $message['created_at']->format('d.m.Y в H:i:s') }}</div>
        </div>

        <div class="@if (request()->user()->id == $message['user_id']) ms-4 text-end @else me-4 @endif">
            <div
                class="fs-sm d-inline-block fw-medium animated fadeIn bg-body-light border-3 px-3 py-2 mb-2 shadow-sm mw-100 @if (request()->user()->id == $message['user_id']) border-end border-primary rounded-start text-start @else border-start border-dark rounded-end @endif">
                {{ $message['message'] }}
            </div>
        </div>
        @empty
        <div class="alert alert-info">Здесь пока нет ни одного сообщения...</div>
        @endforelse
    </div>

    @if ($ticket['status'] != 'closed')
        <div class="block-content p-2 bg-body-dark">
            <form class="w-100" wire:submit.prevent="submit">
                <div class="input-group dropup">
                    {{--<button type="button" class="btn btn-link d-sm-none" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa fa-plus"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="fa fa-file-alt fa-fw me-1"></i> Загрузить файл
                        </a>
                    </div>
                    <button type="button" class="btn btn-link d-none d-sm-inline-block">
                        <i class="fa fa-file-alt"></i>
                    </button>--}}
                    <input type="text" class="js-chat-input form-control form-control-alt border-0 bg-transparent" wire:model.defer="message" maxlength="255" data-threshold="200" placeholder="Введите сообщение..." data-separator=" из ">
                    <button type="submit" class="btn btn-link">
                        <i class="fab fa-telegram-plane opacity-50"></i>
                        <span class="d-none d-sm-inline ms-1 fw-semibold">Отправить</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
