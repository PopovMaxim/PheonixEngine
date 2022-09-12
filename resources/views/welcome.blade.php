@section('nav-items')
<li class="nav-main-item">
    <a class="nav-main-link" href="{{ url('/') }}">
        <i class="nav-main-link-icon fa fa-home"></i>
        <span class="nav-main-link-name text-light">ГЛАВНАЯ</span>
    </a>
</li>
<li class="nav-main-item">
    <a class="nav-main-link" href="#about-company">
        <i class="nav-main-link-icon fa fa-users"></i>
        <span class="nav-main-link-name text-light">О КОМПАНИИ</span>
    </a>
</li>
<li class="nav-main-item">
    <a class="nav-main-link" href="#about-product">
        <i class="nav-main-link-icon fas fa-star"></i>
        <span class="nav-main-link-name text-light">О ПРОДУКТЕ</span>
    </a>
</li>
<li class="nav-main-item">
    <a class="nav-main-link" href="#tariffs">
        <i class="nav-main-link-icon fab fa-paypal"></i>
        <span class="nav-main-link-name text-light">ТАРИФЫ</span>
    </a>
</li>
<li class="nav-main-item">
    <a class="nav-main-link" href="#page-footer">
        <i class="nav-main-link-icon fa fa-envelope"></i>
        <span class="nav-main-link-name text-light">КОНТАКТЫ</span>
    </a>
</li>
<li class="nav-main-item">
    <a class="nav-main-link active" href="{{ route('login') }}">
        <i class="nav-main-link-icon fa fa-user"></i>
        <span class="nav-main-link-name">ЛИЧНЫЙ КАБИНЕТ</span>
    </a>
</li>
@endsection

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Pheonix.Tech - уникальные алгоритмы для продуктивной торговли</title>

    <meta name="description" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta name="robots" content="noindex, nofollow">

    <meta property="og:title" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta property="og:site_name" content="Pheonix.Tech">
    <meta property="og:description" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">

    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xsmooth.min.css') }}">
    <style>
        .bg-hero {
            background-image: url('assets/media/welcome/hero2.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: top;
        }

        @media screen and (max-width: 1100px) {
            .bg-hero {
                background-image: url('assets/media/welcome/hero2.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: top;
            }
        }

    </style>
</head>

<body>
    <div id="page-container"
        class="sidebar-dark side-scroll page-header-static page-header-dark page-header-glass main-content-boxed">

        <nav id="sidebar" aria-label="Main Navigation">
            <div class="bg-header-dark">
                <div class="content-header bg-white-5 py-5">
                    <a class="fw-semibold text-white tracking-wide" href="{{ url('/') }}">
                        <span class="smini-visible">
                            P<span class="opacity-75">H</span>
                        </span>
                        <span class="smini-hidden">
                            <img src="{{ asset('assets/media/logos/logo-short-white.png') }}" class="img-fluid"
                                style="width: 200px" />
                        </span>
                    </a>
                    <div>
                        <button type="button" class="btn btn-alt-secondary d-lg-none ms-1" data-toggle="layout"
                            data-action="sidebar_close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="js-sidebar-scroll">
                <div class="content-side">
                    <ul class="nav-main text-light">
                        @yield('nav-items')
                    </ul>
                </div>
            </div>
        </nav>

        <header id="page-header" class="py-3">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <a class="fs-lg fw-semibold text-dark" href="{{ url('/') }}">
                        <img src="{{ asset('assets/media/logos/logo-short-white.png') }}" class="img-fluid"
                            style="width: 200px" />
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="d-none d-lg-block">
                        <ul class="nav-main nav-main-horizontal nav-main-hover">
                            @yield('nav-items')
                        </ul>
                    </div>
                    <button type="button" class="btn btn-alt-secondary d-lg-none ms-1" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
            </div>

            <div id="page-header-loader" class="overlay-header bg-primary-darker">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                    </div>
                </div>
            </div>
        </header>

        <main id="main-container">
            <!-- Hero -->
            <div class="bg-image bg-hero" id="index">
                <div class="hero bg-primary-dark-op">
                    <div class="hero-inner">
                        <div class="content content-full">
                            <div class="row">
                                <div class="col-lg-5 text-center text-lg-start d-lg-flex align-items-lg-center">
                                    <div>
                                        <h1 class="display-6 fw-bold text-light mb-3">
                                            Сложное в простом
                                        </h1>
                                        <h2 class="fw-normal fs-4 text-light mb-5">
                                            Создаём эффективные инновационные технологии, повышая качество жизни
                                            общества,
                                            реализуя и продвигая современные IT-решение
                                        </h2>
                                        <div>
                                            <a class="btn btn-primary px-3 py-2 m-1" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-link opacity-50 me-1"></i> Узнать подробнее
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 offset-lg-1 d-none d-lg-block">
                                    <img src="{{ asset('assets/media/logos/logo-icon-colorfull.png') }}"
                                        class="img-fluid" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-meta">
                        <div>
                            <span class="d-inline-block animated bounce infinite">
                                <i class="si si-arrow-down text-muted fa-2x"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- END Hero -->

                <!-- Section 2 -->
                <div class="bg-body-extra-light" id="about-company">
                    <div class="content content-full">
                        <div class="py-5 push">
                            <h2 class="mb-2 text-center">
                                О компании
                            </h2>
                            <h4 class="text-muted mb-0 text-center">
                                Компания ФТ занимается разработкой программного обеспечения для
                                торговых<br />терминалов,
                                реализуя сложные идеи в IT-решения, доступные каждому
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- END Section 2 -->

                <!-- Section 2 -->
                <div class="bg-body-light" id="about-product">
                    <div class="content content-full">
                        <div class="py-5 push">
                            <h2 class="mb-2 text-center">
                                О продукте
                            </h2>
                            <h4 class="text-muted mb-0 text-center">
                                Наши Уникальные Торговые алгоритмы позволяют <br /> упростить процесс работы с торговыми
                                терминами
                            </h4>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <div class="me-5">
                                <div class="d-flex flex-row align-items-center mb-5">
                                    <i class="fa fa-3x fa-tachometer-alt text-primary"></i>
                                    <div class="ms-3">
                                        <h3 class="mb-0">Скорость</h3>
                                        <p class="mb-0">Высокая скорость обработки сигналов и совершения сделок на их основе</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center mb-5">
                                    <i class="fa fa-3x fa-layer-group text-primary"></i>
                                    <div class="ms-3">
                                        <h3 class="mb-0">Удобный интерфейс</h3>
                                        <p class="mb-0">Мы продумали всё до мелочей, чтобы у Вас остался только положительный пользовательский опыт</p>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ asset('assets/media/welcome/macbook.png') }}" class="img-fluid w-75" />
                        </div>
                    </div>
                </div>

                <div class="bg-body-extra-light" id="about-product">
                    <div class="content content-full">
                        <div class="py-5 push">
                            <h2 class="mb-2 text-center">
                                Преимущества
                            </h2>
                            <h4 class="text-muted mb-0 text-center">
                                Нам важно чтобы Вы были довольны
                            </h4>

                            <div class="row py-3 text-center mt-5">
                                <div class="col-sm-6 col-md-4 mb-5">
                                    <div class="my-3">
                                        <i class="fa fa-3x fa-star text-xsmooth"></i>
                                    </div>
                                    <h4 class="h5 mb-2">
                                        Уникальные алгоритмы
                                    </h4>
                                    <p class="mb-0 text-muted">
                                        Наши уникальные алгоритмы торговли качественно выделяются среди других подобных
                                        решений
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-4 mb-5">
                                    <div class="my-3">
                                        <i class="fa fa-3x fa-coins text-xsmooth"></i>
                                    </div>
                                    <h4 class="h5 mb-2">
                                        Доступные условия
                                    </h4>
                                    <p class="mb-0 text-muted">
                                        Условия нашей подписки подойдут всем, вне зависимости то того кто вы -
                                        профессионал или новичок.
                                    </p>
                                </div>
                                <div class="col-sm-6 col-md-4 mb-5">
                                    <div class="my-3">
                                        <i class="fa fa-3x fa-network-wired text-xsmooth"></i>
                                    </div>
                                    <h4 class="h5 mb-2">
                                        Бонусная система
                                    </h4>
                                    <p class="mb-0 text-muted">
                                        Всем клиентам доступная бонусная система вознаграждений за использование наших
                                        продуктов
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Section 2 -->

                <!-- Section 5 -->
                <div class="bg-body-light" id="tariffs">
                    <div class="content content-full">
                        <div class="py-5 push">
                            <h2 class="mb-2 text-center">
                                Тарифы
                            </h2>
                            <h3 class="text-muted mb-0 text-center">
                                Наши тарифы подойдут всем
                            </h3>
                        </div>
                        <div class="text-center mb-5">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-vcenter text-center mb-0 border">
                                    <thead>
                                        <tr class="table-dark text-uppercase fs-sm">
                                            <th class="py-4" style="width: 180px;"></th>
                                            <th class="py-4">Старт</th>
                                            <th class="py-4">Стандарт</th>
                                            <th class="py-4 bg-primary">Бизнес</th>
                                            <th class="py-4 bg-primary">Профессионал</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-body-light">
                                            <td></td>
                                            <td class="py-4">
                                                <div class="h1 fw-bold mb-0">7,500 ₽</div>
                                            </td>
                                            <td class="py-4">
                                                <div class="h1 fw-bold mb-0">12,500 ₽</div>
                                            </td>
                                            <td class="py-4">
                                                <div class="h1 fw-bold text-primary mb-0">27,500 ₽</div>
                                            </td>
                                            <td class="py-4">
                                                <div class="h1 fw-bold text-primary mb-0">27,500 ₽</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">Срок</td>
                                            <td>1 год</td>
                                            <td>2 года</td>
                                            <td>5 лет</td>
                                            <td>1 год</td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">Количество роботов</td>
                                            <td>1 шт.</td>
                                            <td>1 шт.</td>
                                            <td>1 шт.</td>
                                            <td>1 шт.</td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">Windows</td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">Android</td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">macOS</td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-sm text-end">Тех. Поддержка</td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                            <td><i class="fas fa-circle-check text-success"></i></td>
                                        </tr>
                                        <tr class="bg-body-light">
                                            <td></td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-0 btn-sm btn-hero btn-secondary px-4"
                                                    wire:click="openModal(1)">Подробнее</button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-0 btn-sm btn-hero btn-secondary px-4"
                                                    wire:click="openModal(2)">Подробнее</button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-0 btn-sm btn-hero btn-primary px-4"
                                                    wire:click="openModal(3)">Подробнее</button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-0 btn-sm btn-hero btn-primary px-4"
                                                    wire:click="openModal(3)">Подробнее</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Section 5 -->

                <!-- Section 6 -->
                <div class="bg-body-extra-light" id="tariffs">
                    <div class="content content-full">
                        <div class="py-5 push">
                            <h2 class="mb-0 text-center">
                                Уже используете наши продукты?
                            </h2>
                        </div>
                        <div class="row py-3 text-center">
                            <div class="col-sm-6 col-md-4 mb-5">
                                <div class="my-3">
                                    <i class="fa fa-3x fa-repeat text-xsmooth"></i>
                                </div>
                                <h4 class="h5 mb-2">
                                    Продление лицензии
                                </h4>
                                <p class="mb-0 text-muted">
                                    Уже есть активная лицензия, но заканчивается срок? Продлите её в несколько кликов в
                                    своём личном кабинете.
                                </p>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-5">
                                <div class="my-3">
                                    <i class="fa fa-3x fa-key text-xsmooth"></i>
                                </div>
                                <h4 class="h5 mb-2">
                                    Личный кабинет
                                </h4>
                                <p class="mb-0 text-muted">
                                    Управляйте своими лицензиями и оформляйте другие услуги в своём личном кабинете.
                                </p>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-5">
                                <div class="my-3">
                                    <i class="fa fa-3x fa-headset text-xsmooth"></i>
                                </div>
                                <h4 class="h5 mb-2">
                                    Техническая поддержка
                                </h4>
                                <p class="mb-0 text-muted">
                                    Есть вопросы? Наша бесплатная техническая поддержка ответит на любые вопросы по
                                    нашим
                                    продуктам.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Section 6 -->

        </main>

        <footer id="page-footer" class="footer-static bg-body-light">
            <div class="content py-4">
                <div class="row items-push fs-sm border-bottom pt-4 justify-content-center">
                    <div class="col-md-4">
                        <h3 class="fw-semibold">Правовые документы</h3>
                        <ul class="list list-simple-mini">
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Согласие на обработку
                                    персональных данных
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Договор оферта
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Политика
                                    конфиденциальности
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Реквизиты компании
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3 class="fw-semibold">Контакты</h3>
                        <div class="fs-sm push">
                            г. Краснодар, ул. Феоникса 20, п.910<br>
                            <abbr title="Phone">WhatsApp:</abbr> +7 (123) 456-7890
                        </div>
                    </div>
                </div>
                <!-- END Footer Navigation -->

                <!-- Footer Copyright -->
                <div class="fs-sm pt-4 text-center">
                    <a class="fw-semibold" href="#" target="_blank">Pheonix.Tech</a> &copy; <span
                        data-toggle="year-copy"></span> Все права защищены.
                </div>
                <!-- END Footer Copyright -->
            </div>
        </footer>
    </div>
    <script src="assets/js/dashmix.app.min.js"></script>
</body>

</html>
