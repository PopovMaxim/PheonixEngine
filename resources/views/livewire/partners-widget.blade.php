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
        <table class="table table-bordered table-striped table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 64px;">
                        <i class="far fa-user"></i>
                    </th>
                    <th>Никнейм</th>
                    <th class="text-center">Ранг</th>
                    <th class="text-center">Партнёры</th>
                    <th class="text-center">Объём</th>
                    <th class="d-none d-sm-table-cell text-center">Активация</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td class="text-center">
                            <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                        </td>
                        <td class="fw-semibold">{{ $partner['nickname'] }}</td>
                        <td class="d-none d-sm-table-cell text-center">Нет</td>
                        <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }}</td>
                        <td class="d-none d-sm-table-cell text-center">0.00</td>
                        <td class="d-none d-md-table-cell text-center">{!! $partner['activated_at']?->format('d-m-Y') ?? '<span class="badge bg-danger">Не активирован</span>' !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $partners->links() }}
    </div>
</div>