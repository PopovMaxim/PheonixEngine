@extends('education::layouts.master')

@push('js')
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <script>
        var player = videojs('my-video');

        player.on('ended', function () {
            $.ajax({
                url: '{{ route("education.video-completed", ["id" => $id, "number" => $number]) }}',
                method: 'post',
                success: function (r) {
                    var confirmResult = confirm('Перейти к следующему уроку?');

                    if (confirmResult) {
                        return location.href = '{{ route("education.read", ["id" => $id, "number" => $next]) }}';
                    }
                }
            });
        })
    </script>
@endpush

@push('css')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet" />
@endpush

@section('content')
    @include('hero', ['title' => $video['title'], 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="alert alert-primary">Доступ к следующему видео будет открыт автоматически после того как Вы досмотрите до конца это видео.</div>
        <video
            id="my-video"
            class="video-js vjs-theme-fantasy vjs-16-9"
            controls
            preload="auto"
            poster='{{ asset("assets/media/covers/insider/{$number}.jpg") }}'
            data-setup="{}"
        >
            <source src="{{ route('education.video', ['id' => $id, 'number' => $number]) }}" type="video/mp4" />
            <p class="vjs-no-js">Для просмотра этого видео включите JavaScript и рассмотрите возможность обновления веб-браузера до
                <a href="https://videojs.com/html5-video-support/" target="_blank">поддерживающего HTML5 видео.</a>
            </p>
        </video>

        <div class="d-flex justify-content-between align-items-center mt-3">
            @if ($disabled_prev) <a class="btn btn-secondary disabled">Предыдущий урок</a> @else <a href="{{ route('education.read', ['id' => $id, 'number' => $prev]) }}" class="btn btn-secondary">Предыдущий урок</a> @endif
            @if ($disabled_next) <a class="btn btn-secondary disabled">Следующий урок</a> @else <a href="{{ route('education.read', ['id' => $id, 'number' => $next]) }}" class="btn btn-secondary">Следующий урок</a> @endif
        </div>
    </div>
@endsection
