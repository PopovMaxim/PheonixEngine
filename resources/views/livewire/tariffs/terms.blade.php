<div>
    @include('hero', ['title' => "<a href=\"/tariffs\"><i class=\"fa fa-arrow-left text-muted me-2\"></i></a> Лицензионное соглашение", 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <form method="POST" wire:submit.prevent="submit">
            @csrf
            <div class="block block-rounded">
                <div class="block-content">
                    <p>Редакция от 1 августа 2022 года</p>
                    <p>Лицензионное соглашение Общества с ограниченной ответственностью «Восхождение» (ИНН 2311250039), определяющее условия использования программного обеспечения (далее – ПО).</p>

                    <p>Обратите внимание! Перед началом использования ПО внимательно ознакомьтесь с условиями лицензионного соглашения.</p>

                    <p>При установке ПО нажатие вами кнопки с текстом согласия с условиями лицензионного соглашения и политики конфиденциальности означает, что вы безоговорочно соглашаетесь с условиями настоящего Лицензионного соглашения. В случае несогласия с условиями настоящего Лицензионного соглашения, вы вправе не приобретать лицензию на ПО.</p>
                    
                    <p>После приобретения ПО возврат денежных средств невозможен в связи с тем, что услуга в виде неисключительной лицензии на ПО считается предоставленной с момента
                        предоставления доступа в личный кабинет на Сайте и оплаты лицензии на ПО и появления возможности для скачивания файла соответствующего ПО.</p>
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