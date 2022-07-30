<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">Цитаты успешных трейдеров</h3>
        <div class="block-options">
            <button type="button" wire:click="$emit('refresh')" class="btn-block-option" data-toggle="block-option" data-action="state_toggle">
                <i class="si si-refresh"></i>
            </button>
        </div>
    </div>
    <div class="block-content">
        <figure>
            <p>{{ $quote['text'] }}</p>
            <figcaption class="blockquote-footer">{{ $quote['author'] }}</figcaption>
        </figure>
    </div>
</div>