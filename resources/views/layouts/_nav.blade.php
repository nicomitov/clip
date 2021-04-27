<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">

    <div class="navbar-brand d-flex justify-content-between align-items-center col-md-3 col-xl-2 mr-0" style="background-color: rgba(0, 0, 0, 0.25);">

        {{-- logo --}}
        <a class="logo" href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        {{-- Collapse --}}
        <button class="navbar-toggler pull-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    {{-- Links --}}
    <div class="collapse navbar-collapse px-3" id="navbarSupportedContent">

        {{-- Left --}}
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ isActiveRoute('home') }}">
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ isActiveRoute('logs.*') }}" href="{{ route('logs.index') }}">
                    Logs
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/help">
                    Help
                </a>
            </li>

            <span class="d-md-none">
                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute('clients.index') }}" href="{{ route('clients.index') }}">
                        Clients
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute('subscriptions.index') }}" href="{{ route('subscriptions.index') }}">
                        Subscriptions
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute('topics.index') }}" href="{{ route('topics.index') }}">
                        Topics
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute('users.index') }}" href="{{ route('users.index') }}">
                        Users
                    </a>
                </li>
            </span>
        </ul>

        {{-- Right --}}
        <ul class="navbar-nav nav-flex-icons">
            @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">
                    {{-- <i class="fas fa-sign-in-alt"></i> --}}
                    Login
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link">
                    {{-- <i class="fas fa-user-plus mr-2"></i> --}}
                    Register
                </a>
            </li>
            @else

            {{-- logged in user --}}
            <li class="nav-item dropdown nav_dd">
                <a href="" class="nav-link dropdown-toggle" id="userDropdown" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    @if (auth()->user()->hasNotifications())
                        <i class="fas fa-bell text-orange"></i>
                    @else
                        <i class="far fa-user"></i>
                    @endif
                    {{ auth()->user()->name }}
                </a>
                <div class="profile_dropdown dropdown-menu dropdown-menu-lg-right dropdown-primary" aria-labelledby="userDropdown">

                    <div class="px-4 py-2 d-flex align-items-start">
                        <span class="p-2 mr-3 rounded border">
                            <i class="far fa-user avatar"></i>
                        </span>

                        <div class="align-self-start">
                            <strong>{{ auth()->user()->name }}</strong>

                            <p class="small text-muted mb-0">
                                [{{ implode_nm(auth()->user()->roles, 'name') }}]
                            </p>
                            <p class="small text-muted mb-2">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('users.edit', auth()->user()) }}" class="dropdown-item">
                        <i class="fas fa-cog mr-1"></i>
                        Profile
                    </a>
                    <a href="{{ route('notifications.index') }}" class="dropdown-item">
                        <i class="fas fa-bell mr-1"></i>
                        Notifications
                        @if (auth()->user()->hasNotifications())
                            <span class="badge badge-pill badge-orange">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-divider"></div>

                    @can('create', 'App/Page')
                    <a href="{{ route('pages.create') }}" class="dropdown-item">
                        <i class="fas fa-plus mr-1"></i> Create a New Page
                    </a>
                    @endcan

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off mr-1"></i> Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </a>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</div>
</nav>
