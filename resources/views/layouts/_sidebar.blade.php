<nav class="col-md-3 col-xl-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">

        {{-- clients --}}
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ isActiveRoute('clients.*') }}" href="{{ route('clients.index') }}">
                    <i class="far fa-user-circle fa-lg"></i> CLIENTS
                </a>
            </li>

            <ul>
                <li class="nav-item">
                    <a href="{{ route('clients.by_subscription', 'dn') }}" class="nav-link {{ isActiveUrl(route('clients.by_subscription', 'dn')) }}">
                        <i class="far fa-circle"></i> Daily News
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clients.by_subscription', 'clip') }}" class="nav-link {{ isActiveUrl(route('clients.by_subscription', 'clip')) }}">
                        <i class="far fa-circle"></i> Pressclipping
                    </a>
                </li>
                <li class="nav-item py-1"></li>
                <li class="nav-item">
                    <a href="{{ route('clients.status', 'active') }}" class="nav-link {{ isActiveUrl(route('clients.status', 'active')) }}">
                        <i class="far fa-circle"></i> Active
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clients.status', 'inactive') }}" class="nav-link {{ isActiveUrl(route('clients.status', 'inactive')) }}">
                        <i class="far fa-circle"></i> Inactive
                    </a>
                </li>
                @can('create', 'App\Client')
                <li class="nav-item py-1"></li>
                <li class="nav-item">
                    <a href="{{ route('clients.create') }}" class="nav-link {{ isActiveRoute('clients.create') }}">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </li>
                @endcan
            </ul>
        </ul>
        <hr>

        {{-- subscriptions --}}
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ isActiveRoute('subscriptions.*') }}" href="{{ route('subscriptions.index') }}">
                    <i class="far fa-check-circle fa-lg"></i> SUBSCRIPTIONS
                </a>
            </li>

            <ul>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.by_type', 'dn') }}" class="nav-link {{ isActiveUrl(route('subscriptions.by_type', 'dn')) }}">
                        <i class="far fa-circle"></i> Daily News
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.by_type', 'clip') }}" class="nav-link {{ isActiveUrl(route('subscriptions.by_type', 'clip')) }}">
                        <i class="far fa-circle"></i> Pressclipping
                    </a>
                </li>
                <li class="nav-item py-1"></li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.status', 'active') }}" class="nav-link {{ isActiveUrl(route('subscriptions.status', 'active')) }}">
                        <i class="far fa-circle"></i> Active
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.status', 'inactive') }}" class="nav-link {{ isActiveUrl(route('subscriptions.status', 'inactive')) }}">
                        <i class="far fa-circle"></i> Inactive
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.status', 'expiring') }}" class="nav-link {{ isActiveUrl(route('subscriptions.status', 'expiring')) }}">
                        <i class="far fa-circle"></i> Expiring
                    </a>
                </li>
                @can('create', 'App\Subscription')
                <li class="nav-item py-1"></li>
                <li class="nav-item">
                    <a href="{{ route('subscriptions.create') }}" class="nav-link {{ isActiveRoute('subscriptions.create') }}">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </li>
                @endcan
            </ul>
        </ul>
        <hr>

        {{-- topics --}}
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ isActiveRoute('topics.index') }}" href="{{ route('topics.index') }}">
                    <i class="far fa-file-alt fa-lg"></i> TOPICS PRESSCLIPPING
                </a>
            </li>

            <ul>
                <li class="nav-item">
                    <a href="{{ route('topics.status', 'active') }}" class="nav-link {{ isActiveUrl(route('topics.status', 'active')) }}">
                        <i class="far fa-circle"></i> Active
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('topics.status', 'inactive') }}" class="nav-link {{ isActiveUrl(route('topics.status', 'inactive')) }}">
                        <i class="far fa-circle"></i> Inactive
                    </a>
                </li>

                @can('create', 'App\Topic')
                <li class="nav-item py-1"></li>
                <li class="nav-item">
                    <a href="{{ route('topics.create') }}" class="nav-link {{ isActiveRoute('topics.create') }}">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </li>
                @endcan
            </ul>
        </ul>
        <hr>

        {{-- users --}}
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ isActiveRoute('users.index') }}" href="{{ route('users.index') }}">
                    <i class="far fa-user fa-lg"></i> USERS
                </a>
            </li>

            <ul>
                @can('create', 'App\User')
                <li class="nav-item">
                    <a href="{{ route('users.create') }}" class="nav-link {{ isActiveRoute('users.create') }}">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </li>
                @endcan
            </ul>
        </ul>

        {{-- subscriptions --}}
        {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Subscriptions</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fas fa-home"></i> All
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fas fa-home"></i> Daily News
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fas fa-home"></i> Pressclipping
                </a>
            </li>
        </ul> --}}

    </div>

    <div class="sidebar_bottom">
        <a href="/release-notes">v. {{ env('APP_VERSION') }} / {{ env('APP_DATE') }}</a>
    </div>
</nav>
