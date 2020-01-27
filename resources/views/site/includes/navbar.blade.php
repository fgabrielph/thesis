<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark black scrolling-navbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="../assets/images/LogoMJC.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8; width: 80px; height: 40px">
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="{{route('home')}}">Home
{{--                        <span class="sr-only">(current)</span>--}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="{{route('site.shop')}}">Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="#">Contact Us</a>
                </li>
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a href="{{route('cart.index')}}" class="nav-link waves-effect" style="color: orange">
                        @if(Cart::content()->count() > 0)
                            <span class="badge red z-depth-1 mr-1"> {{Cart::content()->count()}} </span>
                        @endif
                        <i class="fas fa-shopping-cart"></i>
                        <span class="clearfix d-none d-sm-inline-block"> Cart </span>
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
                            <a class="dropdown-item" href="{{route('account.index')}}">{{ Auth::user()->name }}</a>
                            <a class="dropdown-item" href="{{route('orders.index')}}">Orders</a>
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
