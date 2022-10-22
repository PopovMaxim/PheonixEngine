<div class="bg-sidebar-dark p-3 push">
    <div class="d-lg-none">
        <button type="button" class="btn w-100 btn-dark d-flex justify-content-between align-items-center"
            data-toggle="class-toggle" data-target="#admin-menu" data-class="d-none">
                Меню администратора
                <i class="fa fa-bars"></i>
        </button>
    </div>

    <div id="admin-menu" class="d-none d-lg-block mt-2 mt-lg-0">
        <ul class="nav-main nav-main-horizontal nav-main-hover nav-main-horizontal-center nav-main-dark">
            @if(request()->user()->hasRole('super_admin'))
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.overview') }}">
                        <i class="nav-main-link-icon fa fa-dashboard"></i>
                        <span class="nav-main-link-name">Обзор</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="{{ route('admin.users') }}">
                        <i class="nav-main-link-icon fa fa-users"></i>
                        <span class="nav-main-link-name">Пользователи</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.users') }}">
                                <span class="nav-main-link-name">Все пользователи</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#">
                                <span class="nav-main-link-name">Заблокированные</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--<li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-boxes"></i>
                    <span class="nav-main-link-name">Продукты</span>
                    </a>
                    <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <span class="nav-main-link-name">Тарифы</span>
                        </a>
                        <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="javascript:void(0)">
                            <span class="nav-main-link-name">Линейки</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.tariffs') }}">
                            <span class="nav-main-link-name">Управление ценами</span>
                            </a>
                        </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <span class="nav-main-link-name">Дистрибутивы</span>
                        </a>
                        <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="javascript:void(0)">
                            <span class="nav-main-link-name">Версии</span>
                            </a>
                        </li>
                        </ul>
                    </li>
                    </ul>
                </li>--}}

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="{{ route('admin.transactions') }}">
                        <i class="nav-main-link-icon fa fa-coins"></i>
                        <span class="nav-main-link-name">Операции</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.transactions') }}">
                                <span class="nav-main-link-name">Все операции</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.transactions.refills') }}">
                                <span class="nav-main-link-name">Список пополнений</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.transactions.withdrawal') }}">
                                <span class="nav-main-link-name">Заявки на выплату</span>
                                <span class="nav-main-link-badge badge rounded-pill bg-primary">{{ \App\Modules\Withdraw\Entities\Withdraw::query()->where('type', 'withdrawal')->where('status', 'pending')->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('admin/subscribes*')) active @endif" href="{{ route('admin.subscribes') }}">
                        <i class="nav-main-link-icon fa fa-star"></i>
                        <span class="nav-main-link-name">Подписки</span>
                    </a>
                </li>
                
                {{--<li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-gift"></i>
                        <span class="nav-main-link-name">Бонусы</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#">
                                <span class="nav-main-link-name">Линейный бонус</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#">
                                <span class="nav-main-link-name">Быстрый бонус</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#">
                                <span class="nav-main-link-name">Лидерский пулл</span>
                            </a>
                        </li>
                    </ul>
                </li>--}}
            @endif

            @if(request()->user()->hasRole('super_admin') || request()->user()->hasRole('support') || request()->user()->can('support'))
                <li class="nav-main-item">
                    <a class="nav-main-link @if(request()->is('admin/support*')) active @endif" href="{{ route('admin.support') }}">
                        <i class="nav-main-link-icon fa fa-headset"></i>
                        <span class="nav-main-link-name">
                            Техническая поддержка
                            {{--<i class="fa fa-circle text-danger"></i>
                            <i class="fa fa-circle text-warning"></i>--}}
                        </span>
                    </a>
                </li>
            @endif

            @if(request()->user()->hasRole('super_admin') || request()->user()->can('show log-viewer'))
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="{{ route('admin.transactions') }}">
                        <i class="nav-main-link-icon fa fa-wrench"></i>
                        <span class="nav-main-link-name">Обслуживание</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ url('/admin/log-viewer/logs') }}">
                                <span class="nav-main-link-name">Логи</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
