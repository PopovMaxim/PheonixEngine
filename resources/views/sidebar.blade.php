<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <a class="fw-semibold text-white tracking-wide" href="/">
                <span class="smini-visible">
                    N<span class="opacity-75">v</span>
                </span>
                <span class="smini-hidden">
                    {{ env('APP_NAME') }}
                </span>
            </a>
            <div>
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('dashboard')) active @endif"
                        href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon fa fa-dashboard"></i>
                        <span class="nav-main-link-name">Панель управления</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('tariffs')) active @endif" href="{{ url('tariffs') }}">
                        <i class="nav-main-link-icon fa fa-cubes"></i>
                        <span class="nav-main-link-name">Тарифы</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('robots')) active @endif" href="{{ url('robots') }}">
                        <i class="nav-main-link-icon fa fa-robot"></i>
                        <span class="nav-main-link-name">Роботы</span>
                        <span class="nav-main-link-badge badge bg-secondary">Скоро</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('wallet')) active @endif" {{--href="{{ url('wallet') }}"--}}>
                        <i class="nav-main-link-icon fa fa-wallet"></i>
                        <span class="nav-main-link-name">Кошелёк</span>
                        <span class="nav-main-link-badge badge bg-secondary">Скоро</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('transactions')) active @endif" href="{{ route('transactions') }}">
                        <i class="nav-main-link-icon fa fa-coins"></i>
                        <span class="nav-main-link-name">Транзакции</span>
                    </a>
                </li>

                <li class="nav-main-item @if(request()->is('network*')) open @endif">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-network-wired"></i>
                        <span class="nav-main-link-name">Партнёрская сеть</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link @if(request()->is('network/partners')) active @endif" href="{{ route('network.partners') }}">
                                <span class="nav-main-link-name">Мои партнёры</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @if(request()->is('network/line')) active @endif" href="{{ route('network.line') }}">
                                <span class="nav-main-link-name">Линейный маркетинг</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @if(request()->is('network/tree')) active @endif" href="{{ route('network.tree') }}">
                                <span class="nav-main-link-name">Бинарное дерево</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @if(request()->is('network/promo')) active @endif" {{--href="{{ route('network.promo') }}"--}}>
                                <span class="nav-main-link-name">Рекламные материалы</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('support')) active @endif" {{--href="{{ url('support') }}"--}}>
                        <i class="nav-main-link-icon fa fa-headset"></i>
                        <span class="nav-main-link-name">Поддержка</span>
                        <span class="nav-main-link-badge badge bg-secondary">Скоро</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('faq')) active @endif" {{--href="{{ url('faq') }}"--}}>
                        <i class="nav-main-link-icon fa fa-circle-question"></i>
                        <span class="nav-main-link-name">FAQ</span>
                        <span class="nav-main-link-badge badge bg-secondary">Скоро</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
