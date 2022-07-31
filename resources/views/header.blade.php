<header id="page-header">
    <div class="content-header">
        <div class="space-x-1">
            <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="space-x-1">
            <div class="d-inline-block">
                <div class="btn btn-alt-secondary">
                    <i class="fa fa-fw fa-coins fs-sm"></i>
                    <span class="fs-sm">{{ request()->user()->formatted_balance }}</span>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-alt-secondary" id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    @if (request()->user()->unreadNotifications()->count())
                    <span
                        class="badge bg-warning rounded-pill">{{ request()->user()->unreadNotifications()->count() }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                        Уведомления
                    </div>
                    <ul class="nav-items my-2">
                        @forelse (request()->user()->unreadNotifications()->limit(5)->orderBy('created_at',
                        'desc')->get() as $notification)
                        <li>
                            <a class="d-flex text-dark py-2">
                                <div class="flex-shrink-0 mx-3">
                                    <i
                                        class="{{ \App\Modules\Notifications\Entities\Notification::getIcon($notification['data']['type']) }} fa-fw"></i>
                                </div>
                                <div class="flex-grow-1 fs-sm pe-2">
                                    <div class="fw-normal">{!! $notification['data']['text'] !!}</div>
                                    <div class="text-muted">{{ $notification['created_at'] }}</div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>
                            <div class="fs-sm text-center">
                                <div class="fw-normal">Нет непрочитанных уведомлений</div>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                    <div class="p-2 border-top">
                        <a class="btn btn-alt-primary w-100 text-center" href="{{ route('notifications') }}">
                            <i class="fa fa-fw fa-eye opacity-50 me-1"></i> Показать всё
                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-fw fa-user-circle"></i>
                    <i class="fa fa-fw fa-angle-down d-none opacity-50 d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                    <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                        <img class="img-avatar img-avatar48 img-avatar-thumb"
                            src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                        {{--<div class="pt-2">
                            <a class="text-white fw-semibold" href="be_pages_generic_profile.html">Henry Harrison</a>
                        </div>--}}
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="{{ route('profile.settings') }}">
                            <i class="far fa-fw fa-building me-1"></i> Настройки
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Выход
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
