<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <a class="fw-semibold text-white tracking-wide" href="{{ route('dashboard') }}">
                <span class="smini-visible">
                    P<span class="opacity-75">h</span>
                </span>
                <span class="smini-hidden">
                    <img src="{{ asset('assets/media/logos/logo-short-white.png') }}" class="img-fluid" style="width: 200px;" />
                </span>
            </a>
            <div>
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
                <li class="nav-main-heading">Продукты</li>

                <li class="nav-main-item @if(request()->is('tariffs*')) open @endif" href="{{ route('tariffs') }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                      <i class="nav-main-link-icon fa fa-cubes"></i>
                      <span class="nav-main-link-name">Продукты</span>
                    </a>
                    <ul class="nav-main-submenu">
                        @foreach (\App\Modules\Tariffs\Entities\TariffLines::query()->orderBy('order', 'asc')->get() as $line)
                            <li class="nav-main-item">
                                <a class="nav-main-link @if(request()->is("tariffs/{$line['id']}")) active @endif" href="{{ route('tariffs', ['id' => $line['id']]) }}">
                                    <span class="nav-main-link-name">{{ $line['title'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('subscribes')) active @endif" href="{{ route('subscribes') }}">
                        <i class="nav-main-link-icon fa fa-star"></i>
                        <span class="nav-main-link-name">Подписки</span>
                    </a>
                </li>

                <li class="nav-main-heading">Финансы</li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('refill*')) active @endif" href="{{ route('refill') }}">
                        <i class="nav-main-link-icon fa fa-arrow-down"></i>
                        <span class="nav-main-link-name">Пополнение</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('withdraw')) active @endif" href="{{ route('withdraw') }}">
                        <i class="nav-main-link-icon fa fa-arrow-up"></i>
                        <span class="nav-main-link-name">Вывод</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('transfer')) active @endif" href="{{ route('transfer') }}">
                        <i class="nav-main-link-icon fa fa-exchange"></i>
                        <span class="nav-main-link-name">Перевод</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('transactions')) active @endif" href="{{ route('transactions') }}">
                        <i class="nav-main-link-icon fa fa-history"></i>
                        <span class="nav-main-link-name">История</span>
                    </a>
                </li>

                <li class="nav-main-heading">Партнёрская сеть</li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('network/partners')) active @endif" href="{{ route('network.partners') }}">
                        <i class="nav-main-link-icon fa fa-users"></i>
                        <span class="nav-main-link-name">Мои партнёры</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('network/line')) active @endif" href="{{ route('network.line') }}">
                        <i class="nav-main-link-icon fa fa-network-wired"></i>
                        <span class="nav-main-link-name">Линейный маркетинг</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('network/leader-pull')) active @endif" href="{{ route('network.leader-pull') }}">
                        <i class="nav-main-link-icon fa fa-crown"></i>
                        <span class="nav-main-link-name">Лидерский пулл</span>
                    </a>
                </li>
                <li class="nav-main-heading">Помощь</li>
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('support*')) active @endif" href="{{ route('support') }}">
                        <i class="nav-main-link-icon fa fa-headset"></i>
                        <span class="nav-main-link-name">Тех. Поддержка</span>
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
