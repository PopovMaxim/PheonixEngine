<div class="block block-rounded block-mode-loading-refresh h-100">
    <div class="block-header block-header-default">
        <h3 class="block-title">Мои партнёры</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" wire:click="$emit('refresh_partners_list')">
                <i class="si si-refresh"></i>
            </button>
        </div>
    </div>
    <div class="block-content">
        <table class="table table-bordered table-striped table-vcenter fs-sm">
            <thead class="">
                <tr>
                    <th class="d-none d-sm-table-cell text-center" style="width: 32px;">
                        <i class="far fa-user"></i>
                    </th>
                    <th>Никнейм</th>
                    <th class="text-center" style="width: 15%;">Ранг</th>
                    <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Партнёры</th>
                    <th class="text-center" style="width: 20%;">Объём</th>
                    <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Активация</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($partners as $partner)
                    <tr>
                        <td class="d-none d-sm-table-cell text-center">
                            <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                        </td>
                        <td class="fw-normal">{{ $partner['nickname'] }}</td>
                        <td class="text-center">{{ $partner['current_rank'] }}</td>
                        <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                        <td class="text-center">0.00</td>
                        <td class="d-none d-md-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Сейчас у Вас нет ни одного партнёра...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $partners->links() }}
    </div>
</div>