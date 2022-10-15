<div wire:poll.keep-alive wire:poll.1500ms>
    <div class="row">
        @forelse ($tickets as $ticket)
        <div class="col-md-3 h-100">
            <a href="{{ route('admin.support', ['uuid' => $ticket['id']]) }}" class="block block-rounded @if ($ticket['status'] == 'new') border border-warning @endif">
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
        @empty
        @endforelse
    </div>
</div>
