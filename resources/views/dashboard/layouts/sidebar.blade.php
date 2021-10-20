<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ route('index') }}">
            <img src="{{ url($setting->avatar) }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ url($setting->avatar) }}" class="header-brand-img toggle-logo" alt="logo">
            <img src="{{ url($setting->avatar) }}" class="header-brand-img light-logo" alt="logo">
            <img src="{{ url($setting->avatar) }}" class="header-brand-img light-logo1" alt="logo">
        </a><!-- LOGO -->
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a>
        <!-- sidebar-toggle-->
    </div>
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{ $path . $user->avatar }}" alt="{{ $user->name }}" class="avatar-xl rounded-circle">
            </div>
            <div class="user-info">
                <h6 class=" mb-0 text-dark">{{ $user->name }}</h6>
                <span class="text-muted app-sidebar__user-name text-sm">{{ $user->email }}</span>
            </div>
        </div>
    </div>
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Home">
                <a href="{{ route('dashboard_admin.index') }}" target="_blank" class="nav-link text-center m-2">
                    <i class="fe fe-navigation"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Users">
                <a href="{{ route('dashboard_users.index') }}" class="nav-link text-center m-2">
                    <i class="fe fe-users"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Home Page">
                <a href="{{ route('index') }}" class="nav-link text-center m-2">
                    <i class="fa fa-server"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="LogOff">
                <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form2').submit();">
                    <i class="fe fe-power"></i>
                </a>
                <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <ul class="side-menu">
        <li>
            <h3>Dashboard</h3>
        </li>
        <li class="slide" data-step="1" data-intro="This is the first feature">
            <a class="side-menu__item" href="{{ route('dashboard_admin.index') }}"><i
                    class="side-menu__icon ti-home"></i><span class="side-menu__label">
                    Dashboard</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_topprojects.index') }}">
                <i class="side-menu__icon mdi mdi-projector-screen"></i>
                <span class="side-menu__label">Top Project</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_otherprojects.index') }}">
                <i class="side-menu__icon mdi mdi-archive "></i>
                <span class="side-menu__label">Projects</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_advertisementother.index') }}">
                <i class="mdi mdi-arrange-send-backward side-menu__icon"></i>
                <span class="side-menu__label">Advertisement</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_draws.index') }}">
                <i class="mdi mdi-arrow-all side-menu__icon"></i>
                <span class="side-menu__label">Draws</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_discount.index') }}">
                <i class="mdi mdi-buffer side-menu__icon"></i>
                <span class="side-menu__label">Discount</span>
            </a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ route('dashboard_users.index') }}">
                <i class="mdi mdi-account-multiple-plus side-menu__icon"></i>
                <span class="side-menu__label">Registered Users</span>
            </a>
        </li>

        @if (Auth::user()->role == '1')
        <li class="slide" data-step="1" data-intro="This is the first feature">
            <a class="side-menu__item" href="{{ route('dashboard_users.index', ['type' => '1']) }}"><i
                    class="side-menu__icon fa fa-user"></i><span class="side-menu__label">
                    Admins</span>
            </a>
        </li>
        @endif
        <li class="slide">
            <a class="side-menu__item" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form2').submit();">
                <i class="side-menu__icon ti-lock"></i><span class="side-menu__label">
                    Sign Out</span>
            </a>
            <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>