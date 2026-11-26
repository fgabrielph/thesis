<nav class="navbar navbar-expand-lg navbar-dark sf-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="/assets/images/LogoMJC.png" alt="New MJC" class="sf-brand" />
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#storefrontNav"
            aria-controls="storefrontNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="storefrontNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{route('home')}}"
                        >Home</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('site.shop', 'site.categories', 'site.product') ? 'active' : '' }}"
                        href="{{route('site.shop')}}"
                        >Shop</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{route('about')}}"
                        >About</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{route('contact')}}"
                        >Contact Us</a
                    >
                </li>
            </ul>

            <ul class="navbar-nav align-items-lg-center">
                <li class="nav-item">
                    <a
                        href="{{route('cart.index')}}"
                        class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                    >
                        @if (Cart::content()->count() > 0)
                            <span class="badge bg-danger me-1">{{Cart::content()->count()}}</span>
                        @endif
                        <i class="fas fa-shopping-cart"></i>
                        <span class="d-none d-sm-inline">Cart</span>
                    </a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a
                            href="{{route('orders.index')}}"
                            class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                        >
                            <i class="fas fa-cube"></i>
                            <span class="d-none d-sm-inline">Orders</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="storefrontAccountMenu"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="fas fa-user-circle"></i>
                            {{Auth::user()->name}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="storefrontAccountMenu">
                            <li><a class="dropdown-item" href="{{route('account.index')}}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{route('custom_order.index')}}">Custom Orders</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
