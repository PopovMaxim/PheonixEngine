<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/180x180.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xsmooth.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/js/plugins/toast/jquery.toast.min.css') }}">

    @stack('css')
    @livewireStyles
</head>
<body>
    <div id="page-container" class="{{ config('theme.wrapper_class') }}">
        {{--@include('overlay')--}}

        @include('sidebar')
        @include('header')
        
        <main id="main-container">
            @if(request()->user()->hasRole('support'))
                @include('admin.navbar')
            @endif
            @if (request()->session()->has('previous_id'))
                <div class="alert alert-warning mb-0 text-center">
                    <div class="d-inline"><b>Внимание!</b> Сейчас Вы авторизованы в роли пользователя <b>{{ request()->user()->nickname }}</b>.</div>
                    <form class="d-inline" method="post" action="{{ route('admin.users.logout', ['id' => request()->session()->has('previous_id')]) }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0">Выйти</button>
                    </form>
                </div>
            @endif
            @yield('hero')
            @include('content')
        </main>

        @include('footer')
    </div>

    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/clipboardjs/clipboard.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var clipboard = new ClipboardJS('.copy');

        clipboard.on('success', function(e) {
            tooltip = new bootstrap.Tooltip($(e.trigger), {
                placement: 'bottom',
                title: 'Скопировано',
            })

            tooltip.show()

            setTimeout(() => {
                tooltip.dispose()
            }, 3000)

            e.clearSelection();
        });
    </script>
    <script>
        Swal.mixin({
            buttonsStyling: !1,
            target: "#page-container",
            customClass: {
                confirmButton: "btn btn-success m-1",
                cancelButton: "btn btn-danger m-1",
                input: "form-control"
            }
        });
    </script>
    @stack('js')
    @livewireScripts

    @if (session()->has('status'))
        @php
            $status = session('status');
        @endphp

        <script>
            $.toast({
                heading: '{!! $status['title'] !!}',
                text: "{!! $status['text'] !!}",
                icon: "{{ $status['type'] }}",
                loader: false,
                hideAfter: 7000,
                position: 'bottom-right'
            })
            //Swal.fire("{{ $status['title'] }}", "{{ $status['text'] }}", "{{ $status['type'] }}")
        </script>
    @endif

    @if (session()->has('toast_notify'))
        @php
            $toast = session('toast_notify');
        @endphp
        <script>
            $.toast({
                heading: 'Внимание!',
                text: "{{ $toast['text'] }}",
                icon: 'error',
                loader: false,
                hideAfter: 7000,
                position: 'bottom-right'
            })
        </script>
    @endif
</body>
</html>