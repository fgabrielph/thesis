<!-- Sidebar -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/LogoMJC.png') }}" alt="NEW MJC" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">NEW MJC</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <div class="sidebar-user-panel d-flex align-items-center gap-2 px-3 py-3 border-bottom border-secondary-subtle">
            <span class="avatar-fallback">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            <span class="text-white text-truncate">{{ Auth::user()->name }}</span>
        </div>

        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin_orders.index') }}" class="nav-link {{ request()->routeIs('admin_orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customorders.index') }}" class="nav-link {{ request()->routeIs('customorders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Custom Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('deliveries.index') }}" class="nav-link {{ request()->routeIs('deliveries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Delivery Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('custom_deliveries.index') }}" class="nav-link {{ request()->routeIs('custom_deliveries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck-pickup"></i>
                        <p>Custom Deliveries</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('staffs.*', 'customers.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Account Management<i class="nav-arrow fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('staffs.index') }}" class="nav-link {{ request()->routeIs('staffs.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Staffs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('categories.*', 'brands.*', 'items.*', 'admin.lowitems') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory<i class="nav-arrow fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brands.index') }}" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Items</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('report.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Reports<i class="nav-arrow fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.items') }}" class="nav-link {{ request()->routeIs('report.items') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.custom_orders') }}" class="nav-link {{ request()->routeIs('report.custom_orders') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Custom Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.orders') }}" class="nav-link {{ request()->routeIs('report.orders') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.staffs') }}" class="nav-link {{ request()->routeIs('report.staffs') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.admins') }}" class="nav-link {{ request()->routeIs('report.admins') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Admins</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.deliveries') }}" class="nav-link {{ request()->routeIs('report.deliveries') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>List of Deliveries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.critical_level') }}" class="nav-link {{ request()->routeIs('report.critical_level') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-exclamation-triangle"></i>
                                <p>List of Critical Level Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.monthly_sales') }}" class="nav-link {{ request()->routeIs('report.monthly_sales') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Monthly Sales Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('analysis.*', 'forecast.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Visualization<i class="nav-arrow fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('analysis.orders') }}" class="nav-link {{ request()->routeIs('analysis.orders', 'forecast.orders') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Order Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('analysis.demand') }}" class="nav-link {{ request()->routeIs('analysis.demand', 'forecast.demand') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Demand Custom Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logs.index') }}" class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Logs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- /.sidebar -->
