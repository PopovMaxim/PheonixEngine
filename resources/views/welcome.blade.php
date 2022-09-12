<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Pheonix.Tech - уникальные алгоритмы для продуктивной торговли</title>

    <meta name="description" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta property="og:site_name" content="Pheonix.Tech">
    <meta property="og:description" content="Pheonix.Tech - уникальные алгоритмы для продуктивной торговли">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <!-- END Stylesheets -->
  </head>
  <body>
    <div id="page-container" class="sidebar-dark side-scroll page-header-fixed page-header-glass main-content-boxed">
      <nav id="sidebar" aria-label="Main Navigation">
        <!-- Side Header -->
        <div class="bg-header-dark">
          <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="{{ url('/') }}">
              <span class="smini-visible">
                D<span class="opacity-75">x</span>
              </span>
              <span class="smini-hidden">
                <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid" />
              </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
              <!-- Toggle Sidebar Style -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
              <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');">
                <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
              </button>
              <!-- END Toggle Sidebar Style -->

              <!-- Close Sidebar, Visible only on mobile screens -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                <i class="fa fa-times-circle"></i>
              </button>
              <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
          </div>
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
          <!-- Side Navigation -->
          <div class="content-side">
            <ul class="nav-main">
              <li class="nav-main-item">
                <a class="nav-main-link" href="{{ url('/') }}">
                  <i class="nav-main-link-icon fa fa-home"></i>
                  <span class="nav-main-link-name">Главная</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="#specs">
                  <i class="nav-main-link-icon fa fa-rocket"></i>
                  <span class="nav-main-link-name">Рекомендации к ПК</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="#tariffs">
                  <i class="nav-main-link-icon fab fa-paypal"></i>
                  <span class="nav-main-link-name">Тарифы</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="#page-footer">
                  <i class="nav-main-link-icon fa fa-envelope"></i>
                  <span class="nav-main-link-name">Контакты</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link active" href="{{ route('login') }}">
                  <i class="nav-main-link-icon fa fa-user"></i>
                  <span class="nav-main-link-name">Личный кабинет</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
      </nav>
      <!-- END Sidebar -->

      <!-- Header -->
      <header id="page-header">
        <!-- Header Content -->
        <div class="content-header mt-3">
          <!-- Left Section -->
          <div class="d-flex align-items-center">
            <!-- Logo -->
            <a class="fs-lg fw-semibold text-dark" href="{{ url('/') }}">
                <img src="{{ asset('assets/media/logos/logo-short.png') }}" class="img-fluid" style="width: 200px" />
            </a>
            <!-- END Logo -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div class="d-flex align-items-center">
            <!-- Menu -->
            <div class="d-none d-lg-block">
              <ul class="nav-main nav-main-horizontal nav-main-hover">
                <li class="nav-main-item">
                  <a class="nav-main-link" href="{{ url('/') }}">
                    <i class="nav-main-link-icon fa fa-home"></i>
                    <span class="nav-main-link-name">Главная</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="#specs">
                    <i class="nav-main-link-icon fa fa-rocket"></i>
                    <span class="nav-main-link-name">Рекомендации к ПК</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="#tariffs">
                    <i class="nav-main-link-icon fab fa-paypal"></i>
                    <span class="nav-main-link-name">Тарифы</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="#page-footer">
                    <i class="nav-main-link-icon fa fa-envelope"></i>
                    <span class="nav-main-link-name">Контакты</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link active" href="{{ route('login') }}">
                    <i class="nav-main-link-icon fa fa-user"></i>
                    <span class="nav-main-link-name">Личный кабинет</span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- END Menu -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-alt-secondary d-lg-none ms-1" data-toggle="layout" data-action="sidebar_toggle">
              <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->
          </div>
          <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Loader -->
        <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-primary-darker">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
            </div>
          </div>
        </div>
        <!-- END Header Loader -->
      </header>
      <!-- END Header -->

      <!-- Main Container -->
      <main id="main-container">
        <!-- Hero -->
        <div class="hero hero-lg bg-body-extra-light overflow-hidden" id="index">
          <div class="hero-inner">
            <div class="content content-full">
              <div class="row">
                <div class="col-lg-5 text-center text-lg-start d-lg-flex align-items-lg-center">
                  <div>
                    <h1 class="h2 fw-bold mb-3">
                        Уникальное ПО для работы на торговых терминалах
                    </h1>
                    <p class="fs-4 text-muted mb-5">
                        Наши уникальные торговые алгоритмы позволяют упростить и автоматизировать процесс работы с торговыми терминами. 
                    </p>
                    <div>
                      <a class="btn btn-primary px-3 py-2 m-1" href="javascript:void(0)">
                        <i class="fa fa-fw fa-link opacity-50 me-1"></i> Узнать подробнее
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 offset-lg-1 d-none d-lg-block">
                    <img src="{{ asset('assets/media/logos/logo-icon-colorfull.png') }}" class="img-fluid" />
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
        <div class="bg-body-light" id="specs">
          <div class="content content-full">
            <div class="py-5 push">
              <h2 class="mb-2 text-center">
                Рекомендуемые требования к ПК
              </h2>
              <h3 class="text-muted mb-0 text-center">
                Проверьте, подходит ли Ваш ПК
              </h3>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col-md-5">
                Процессор: 1 GHz или выше <br/>
                OS: Windows 7 и выше <br/>
                RAM: 512 MB <br/>
                Хранилище: Свободное место на жестком диске 50 МБ <br/>
                Экран: Разрешение экрана 800x600
              </div>
            </div>
            </div>
          </div>
        </div>
        <!-- END Section 2 -->

        <!-- Section 3 -->
        <div class="bg-body-extra-light" id="tariffs">
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
                                <th class="py-4">Start</th>
                                <th class="py-4">Medium</th>
                                <th class="py-4 bg-primary">Business</th>
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
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">Срок</td>
                                <td>1 год</td>
                                <td>2 года</td>
                                <td>5 лет</td>
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">Количество роботов</td>
                                <td>1 шт.</td>
                                <td>1 шт.</td>
                                <td>1 шт.</td>
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">Windows</td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">Android</td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">macOS</td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td class="fs-sm text-end">Тех. Поддержка</td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                                <td><i class="fas fa-circle-check text-success"></i></td>
                            </tr>
                            <tr class="bg-body-light">
                                <td></td>
                                <td>
                                    <button type="button" class="btn rounded-0 btn-sm btn-hero btn-secondary px-4" wire:click="openModal(1)">Подробнее</button>
                                </td>
                                <td>
                                    <button type="button" class="btn rounded-0 btn-sm btn-hero btn-secondary px-4" wire:click="openModal(2)">Подробнее</button>
                                </td>
                                <td>
                                    <button type="button" class="btn rounded-0 btn-sm btn-hero btn-primary px-4" wire:click="openModal(3)">Подробнее</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <!-- END Section 3 -->
      </main>
      <!-- END Main Container -->


      <!-- Footer -->

      <footer id="page-footer" class="footer-static bg-body-light">
        <div class="content py-4">
          <!-- Footer Navigation -->
          <div class="row items-push fs-sm border-bottom pt-4 justify-content-center">
            <div class="col-md-4">
              <h3 class="fw-semibold">Правовые документы</h3>
              <ul class="list list-simple-mini">
                <li>
                  <a class="fw-semibold" href="javascript:void(0)">
                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Согласие на обработку персональных данных
                  </a>
                </li>
                <li>
                  <a class="fw-semibold" href="javascript:void(0)">
                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Договор оферта
                  </a>
                </li>
                <li>
                  <a class="fw-semibold" href="javascript:void(0)">
                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Политика конфиденциальности 
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
              <a class="fw-semibold" href="#" target="_blank">Pheonix.Tech</a> &copy; <span data-toggle="year-copy"></span> Все права защищены.
          </div>
          <!-- END Footer Copyright -->
        </div>
      </footer>
      <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="assets/js/dashmix.app.min.js"></script>
  </body>
</html>
