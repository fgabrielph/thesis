<footer class="sf-footer mt-5">
    <div class="sf-footer-cta py-3">
        <div class="container text-center">
            <a class="btn btn-dark" href="{{route('site.inquire')}}">Get a Quote</a>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3">
                <h5 class="h6 text-white">Customer Services</h5>
                <ul class="list-unstyled">
                    <li><a href="{{route('terms')}}">Terms and Conditions</a></li>
                    <li><a href="{{route('policy')}}">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h5 class="h6 text-white">My Account</h5>
                <ul class="list-unstyled">
                    @guest
                        <li><a href="{{route('login')}}">User Login</a></li>
                        <li><a href="{{route('register')}}">User Register</a></li>
                    @else
                        <li><a href="{{route('account.index')}}">My Profile</a></li>
                        <li><a href="{{route('custom_order.index')}}">My Custom Orders</a></li>
                        <li><a href="{{route('orders.index')}}">My Orders</a></li>
                    @endguest
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h5 class="h6 text-white">About</h5>
                <ul class="list-unstyled">
                    <li><a href="{{route('about')}}">Our History</a></li>
                    <li><a href="{{route('rr')}}">About Returns</a></li>
                    <li><a href="{{route('faqs')}}">FAQs</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h5 class="h6 text-white">Contacts</h5>
                <ul class="list-unstyled">
                    <li><a href="{{route('contact')}}">Location and Contact Numbers</a></li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary mt-4 pt-3 text-md-end small">
            &copy; 2020-{{date('Y')}} Copyright
            <a href="{{route('home')}}">New MJC</a>
        </div>
    </div>
</footer>
