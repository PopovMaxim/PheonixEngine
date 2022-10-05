<div class="block block-rounded block-mode-loading-refresh h-100">
    <div class="block-header block-header-default">
        <h3 class="block-title">Мои партнёры</h3>
    </div>
    <div class="block-content d-flex justify-content-between flex-column" style="min-height: 370px;">
        <div>
            <table class="table table-bordered table-striped table-vcenter fs-sm">
                <thead class="">
                    <tr>
                        <th class="d-none d-sm-table-cell text-center" style="width: 32px;">
                            <i class="far fa-user"></i>
                        </th>
                        <th>Никнейм</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 25%;">Количество партнёров</th>
                        {{--<th class="text-center" style="width: 20%;">Объём</th>--}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $partner)
                        <tr style="min-height: 60px;">
                            <td class="d-none d-sm-table-cell text-center">
                                <img class="img-avatar img-avatar32" src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                            </td>
                            <td class="fw-normal">{{ $partner['nickname'] }}</td>
                            <td class="d-none d-sm-table-cell text-center">{{ $partner['partners']->count() }} чел.</td>
                            {{--<td class="text-center">{{ $partner['total_value'] }}</td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Сейчас у Вас нет ни одного партнёра...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $partners->links() }}
        </div>
    </div>
</div>