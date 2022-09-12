<div class="bg-sidebar-dark p-3 push">
    <div class="d-lg-none">
        <button type="button" class="btn w-100 btn-dark d-flex justify-content-between align-items-center"
            data-toggle="class-toggle" data-target="#horizontal-navigation-click-centered-dark" data-class="d-none">
                Меню администратора
                <i class="fa fa-bars"></i>
        </button>
    </div>

    <div id="horizontal-navigation-click-centered-dark" class="d-none d-lg-block mt-2 mt-lg-0">
        <ul class="nav-main nav-main-horizontal nav-main-horizontal-center nav-main-dark">
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.users') }}">
                    <i class="nav-main-link-icon fa fa-users"></i>
                    <span class="nav-main-link-name">Пользователи</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.transactions') }}">
                    <i class="nav-main-link-icon fa fa-coins"></i>
                    <span class="nav-main-link-name">Операции</span>
                </a>
            </li>
        </ul>
    </div>
</div>
