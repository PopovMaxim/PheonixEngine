<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title')</title>

    <meta name="robots" content="noindex, nofollow">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xsmooth.min.css') }}">

    <style>
        .bg-image {
            background-image: url('{{ asset("assets/media/welcome/hero2.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top;
        }
    </style>
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <div class="bg-image">
                <div class="row g-0 justify-content-end bg-primary-dark-op">
                    <div class="hero-static col-md-8 d-flex flex-column bg-body-extra-light">
                        <div class="flex-grow-0 p-5">
                            <a class="fw-bold fs-1" href="{{ route('login') }}">
                                <img src="{{ asset('assets/media/logos/logo-short.png') }}" style="width: 300px;" />
                            </a>
                        </div>

                        <div class="flex-grow-1 d-flex align-items-center p-5 bg-body-light">
                            <div class="w-100">
                                <p class="text-danger fs-4 fw-bold text-uppercase mb-2">
                                    Статус @yield('code')
                                </p>
                                <h1 class="fw-bold mb-2 mb-5">
                                    @yield('message')
                                </h1>
                                @if ($exception->getStatusCode() != '503')
                                    <a class="btn btn-lg btn-alt-danger" href="{{ url('/') }}">
                                        <i class="fa fa-arrow-left opacity-50 me-1"></i> Вернуться на главную
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{--<ul class="list-inline flex-gow-1 p-5 fs-sm fw-medium mb-0">
                            <li class="list-inline-item">
                                <a class="text-muted" href="javascript:void(0)">
                                    Dashboard
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="javascript:void(0)">
                                    Support
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="javascript:void(0)">
                                    Contact
                                </a>
                            </li>
                        </ul>--}}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
</body>

</html>
