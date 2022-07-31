<div class="block block-rounded" id="partner-register-state-block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Сторона регистрации партнёра</h3>
    </div>
    <div class="block-content block-content-full">
        <form wire:submit.prevent="submit">
            <div class="row">
                <div class="col-12">
                    <div class="form-check form-block mb-2">
                        <input type="radio" class="form-check-input" id="partner-register-side-sponsor" name="side" value="" wire:model="side" wire:change="submit">
                        <label class="form-check-label" for="partner-register-side-sponsor">
                            <span class="d-block fw-normal p-1">
                                <span class="d-block fw-semibold mb-1">Спонсорская нога</span>
                                <span class="d-block fs-sm fw-medium text-muted">Партнёр будет зарегистрирован в спонсорскую ногу</span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check form-block mb-2">
                        <input type="radio" class="form-check-input" id="partner-register-side-left" name="side" value="left" wire:model="side" wire:change="submit">
                        <label class="form-check-label" for="partner-register-side-left">
                            <span class="d-block fw-normal p-1">
                                <span class="d-block fw-semibold mb-1">Левая нога</span>
                                <span class="d-block fs-sm fw-medium text-muted">Партнёр будет зарегистрирован в левую ногу</span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check form-block mb-0">
                        <input type="radio" class="form-check-input" id="partner-register-side-right" name="side" value="right" wire:model="side" wire:change="submit">
                        <label class="form-check-label" for="partner-register-side-right">
                            <span class="d-block fw-normal p-1">
                                <span class="d-block fw-semibold mb-1">Правая нога</span>
                                <span class="d-block fs-sm fw-medium text-muted">Партнёр будет зарегистрирован в правую ногу</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        window.addEventListener('loading', (e) => {
            Dashmix.block('state_loading', '#partner-register-state-block')
        });

        window.addEventListener('updated', (e) => {
            setTimeout(() => {
                Dashmix.block('state_normal', '#partner-register-state-block');
            }, 300)
        });
    </script>
</div>