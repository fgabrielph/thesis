<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="#" target="_blank">
            <strong class="red-text">NEW MJC</strong>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link waves-effect" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="#">About NEW MJC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="#">Contact Us</a>
                </li>
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link waves-effect">
                        <span class="badge red z-depth-1 mr-1"> 1 </span>
                        <i class="fas fa-shopping-cart"></i>
                        <span class="clearfix d-none d-sm-inline-block"> Cart </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://www.facebook.com/mdbootstrap" class="nav-link waves-effect" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link waves-effect">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('register')}}" class="nav-link waves-effect">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i></a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                            <a class="dropdown-item" href="#">Orders</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

        </div>

    </div>
</nav>
<!-- Navbar -->
