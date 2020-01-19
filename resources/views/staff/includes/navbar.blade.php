<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light" style="background-color: darkred">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" style="color: white"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="color: white">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color: darkred">
                <a href="{{route('staff.logout')}}" class="dropdown-item"style="background-color: darkred; color: white">
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
