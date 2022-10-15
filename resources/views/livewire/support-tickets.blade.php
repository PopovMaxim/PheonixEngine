<div>
    @if (\App\Models\SupportTickets::query()->where('status', '<>', 'closed')->count())
        @foreach ($statuses as $key => $status)
            @if ($key == 'closed') @continue @endif
            @if (\App\Models\SupportTickets::query()->where('status', $key)->count())
                <h2 class="content-heading">{{ $status }}</h2>
            @endif
            <div class="row">
                @foreach (\App\Models\SupportTickets::query()->where('status', $key)->get() as $ticket)
                    <div class="col-md-3 h-100">
                        <a href="{{ route('admin.support', ['uuid' => $ticket['id']]) }}" class="block block-rounded @if ($ticket['status'] == 'wait_support') border border-2 border-warning @endif @if ($ticket['status'] == 'wait_user') border border-2 border-success @endif @if ($ticket['status'] == 'new') border border-2 border-danger @endif">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">{{ $ticket['subject']['title'] }}</h3>
                            </div>
                            <div class="block-content">
                                <p>{{ \Illuminate\Support\Str::limit($ticket['text'], 100, $end = '...') }}</p>
                            </div>
                            <div class="block-content block-content-full block-content-sm border-top border-bottom light fs-sm">
                                <div class="d-flex flex-row">
                                    <div class="me-2">
                                        <img class="img-avatar img-avatar48" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                    </div>
                                    <div>
                                        {{ $ticket['user']['nickname'] }}
                                        <div class="text-muted fs-sm">
                                            ФИО: {{ $ticket['user']['full_name'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                                {{ $ticket['created_at'] }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="alert alert-success">На данный момент нет ни одной заявки в техническую поддержку.</div>
    @endif
</div>
