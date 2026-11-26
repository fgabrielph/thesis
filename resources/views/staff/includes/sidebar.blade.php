<!-- Sidebar -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('staff.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/LogoMJC.png') }}" alt="NEW MJC" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">NEW MJC</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <div class="sidebar-user-panel d-flex align-items-center gap-2 px-3 py-3 border-bottom border-secondary-subtle">
            @if (Auth::user()->image)
                <img src="{{ asset('assets/images/' . Auth::user()->image) }}" class="rounded-circle" width="35" height="35" alt="{{ Auth::user()->name }}">
            @else
                <span class="avatar-fallback">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            @endif
            <span class="text-white text-truncate">{{ Auth::user()->name }}</span>
        </div>

        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff_orders.index') }}" class="nav-link {{ request()->routeIs('staff_orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff_deliveries.index') }}" class="nav-link {{ request()->routeIs('staff_deliveries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Delivery Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff_customer.index') }}" class="nav-link {{ request()->routeIs('staff_customer.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Customer Management</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('staff_brands.*', 'staff_categories.*', 'staff_items.*', 'staff.lowitems') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory<i class="nav-arrow fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('staff_brands.index') }}" class="nav-link {{ request()->routeIs('staff_brands.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff_categories.index') }}" class="nav-link {{ request()->routeIs('staff_categories.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff_items.index') }}" class="nav-link {{ request()->routeIs('staff_items.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Items</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('walkin.index') }}" class="nav-link {{ request()->routeIs('walkin.*', 'staff.categories', 'staff_cart.*', 'staff_checkout.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-luggage-cart"></i>
                        <p>Walk-in</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- /.sidebar -->
