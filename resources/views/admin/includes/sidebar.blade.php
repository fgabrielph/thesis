<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="../../../assets/images/LogoMJC.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">NEW MJC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../../assets/images/agent-1.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin_orders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('customorders.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Custom Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('deliveries.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Delivery Management</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Account Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('staffs.index')}}" class="nav-link">
                                <i class="fas fa-user-circle nav-icon"></i>
                                <p>Staffs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customers.index')}}" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link">
                                <i class="fas fa-square nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('brands.index')}}" class="nav-link">
                                <i class="fas fa-bolt nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('items.index')}}" class="nav-link">
                                <i class="fas fa-box-open nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Reports<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('report.items')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>List of Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.custom_orders')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>List of Custom Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.orders')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>List of Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.staffs')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>List of Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.admins')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>List of Admins</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Visualization</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logs.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Logs</p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
