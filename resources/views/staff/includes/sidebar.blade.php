<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: darkred;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link" style="color: white">
        <img src="../assets/images/LogoMJC.png" alt="NEW MJC Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">NEW MJC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/images/agent-1.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" style="color: white">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('staff.dashboard')}}" class="nav-link" style="color: white">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: white">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('staff_customer.index')}}" class="nav-link" style="color: white">
                        <i class="fas fa-user nav-icon"></i>
                        <p>Customer Management</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" style="color: white">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: white">
                                <i class="fas fa-square nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: white">
                                <i class="fas fa-box-open nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: white">
                                <i class="fas fa-bolt nav-icon"></i>
                                <p>Attributes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" style="color: white">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Delivery Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: white">
                                <i class="fas fa-times nav-icon"></i>
                                <p>NULL</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
