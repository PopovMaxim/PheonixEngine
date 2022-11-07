<div class="block block-rounded block-mode-loading-refresh h-100 mb-0">
    @if ($header)
        <div class="block-header block-header-default">
            <h3 class="block-title">История начислений</h3>
        </div>
    @endif
    <div class="block-content d-flex justify-content-between flex-column" @if ($min_height) style="min-height: {{ $min_height }}px; @endif">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-vcenter fs-sm">
                <thead>
                    <tr>
                        <th style="width: 25%;">Начисление</th>
                        <th class="text-center" style="width: 20%;">Статус</th>
                        <th class="text-center" style="width: 20%;">Сумма</th>
                        <th class="text-center" style="width: 20%;">Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr style="min-height: 60px; cursor: pointer;" onclick="return location.href='{{ route('transactions.read', ['uuid' => $transaction['id']]) }}'">
                            <td>{{ $transaction['translated_type'] }}</td>
                            <td class="text-center">{!! $transaction['html_status'] !!}</td>
                            <td class="text-center text-{{ $transaction['direction'] == 'inner' ? 'success' : 'danger' }} fw-bold" style="width: 20%;">{{ $transaction['formatted_amount'] }}</td>
                            <td class="text-center">
                                <span class="fs-sm text-muted">{{ $transaction['updated_at']->format('d.m.y в H:i:s') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">На данный момент история начислений пуста...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    </div>
</div>