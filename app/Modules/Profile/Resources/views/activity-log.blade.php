@extends('profile::layouts.master')

@push('css')
@endpush

@push('js')
@endpush

@section('content')
    <div class="bg-transparent">
        <div class="content content-full">
            <div class="pt-5 py-4 text-center">
                <h1 class="fw-bold my-2 text-dark">История активности</h1>
            </div>
        </div>
    </div>

    <div class="content content-full content-boxed">
        <div class="block block-rounded mb-0">
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-vcenter fs-sm">
                        <thead>
                            <tr>
                                <th>Действие</th>
                                <th>IP</th>
                                <th>User Agent</th>
                                <th class="text-center">Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr style="min-height: 60px;">
                                    <td>{{ $log['translate_action'] }}</td>
                                    <td>{{ $log['session_details']['ip'] }}</td>
                                    <td>{{ $log['session_details']['user_agent'] }}</td>
                                    <td class="text-center">
                                        <span class="fs-sm text-muted">{{ $log['updated_at']->format('d.m.y в H:i:s') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">История активности не найдена...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
