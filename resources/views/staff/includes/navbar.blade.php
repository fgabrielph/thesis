<!-- Header -->
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-label="Account menu" title="Account">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <span class="dropdown-item-text text-muted">{{ Auth::user()->name }}</span>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('staff.logout') }}" class="dropdown-item">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- /.header -->
