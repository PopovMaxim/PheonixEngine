<div>
    @include('hero', ['title' => "<a href=\"/tariffs\"><i class=\"fa fa-arrow-left text-muted me-2\"></i></a> Лицензионное соглашение", 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <form method="POST" wire:submit.prevent="submit">
            @csrf
            <div class="block block-rounded">
                <div class="block-content">
                    <iframe width="100%" height="800px" src="https://docs.google.com/document/d/e/2PACX-1vTaSCwGaZyj1-Cq8GU412PSiZ-k42EglNEMzG8po6nx8709REzqdFjAkh_fIQ73wQ/pub?embedded=true"></iframe>
                </div>
                <div class="block-content block-content-full block-content-sm border-bottom d-flex justify-content-center">
                    <div class="form-check w-50">
                        <input class="form-check-input @error('accept') is-invalid @enderror" type="checkbox" name="accepted" id="accept" value="1" wire:model="accept">
                        <label class="form-check-label" for="accept">Я соглашаюсь со всем перечисленным выше и хочу оформить подписку на тариф <b>«{{ $tariff['title'] }}»</b> из линейки <b>«{{ $tariff['line']['title'] }}»</b>.</label>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-check opacity-50 me-1"></i> Оформить
                    </button>
                </div>
            </div>
        </form>
    </div>
<div>