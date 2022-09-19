<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
    <meta name="robots" content="noindex, nofollow">

    <meta property="og:title" content="{{ env('APP_NAME') }}">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:description" content="{{ env('APP_DESCRIPTION') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xsmooth.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/js/plugins/toast/jquery.toast.min.css') }}">

    @stack('css')
    @livewireStyles
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toast/jquery.toast.min.js') }}"></script>

    @stack('js')
    @livewireScripts
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
