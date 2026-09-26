<nav class="navbar admin-navbar navbar-expand bg-white">
    <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true"
            aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports"
                aria-label="Search">
        </form>

        <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme"
                title="Switch color theme">
                <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
                <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="Notifications">
                    <span class="notification-dot"></span>
                    <i class="bi bi-bell" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end notification-menu">
                    <div class="dropdown-header fw-bold text-body">Notifications</div>
                    <a class="dropdown-item" href="#">
                        <span class="notification-title">New user registered</span>
                        <span class="notification-time">4 minutes ago</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <span class="notification-title">Revenue target reached</span>
                        <span class="notification-time">32 minutes ago</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <span class="notification-title">Security review completed</span>
                        <span class="notification-time">1 hour ago</span>
                    </a>
                </div>
            </div>

            <div class="dropdown">
                <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="{{ Auth::user()->name ?? 'Admin' }}">
                    <span class="profile-name d-none d-sm-inline">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-1"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-1"></i> Account settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent">
                                <i class="bi bi-box-arrow-right me-1"></i> Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
