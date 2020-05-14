<!--Footer-->
<footer class="page-footer text-center font-small mt-4">

    <div class="orange">
        <!--Call to action-->
        <div class="pt-3">
            <a class="btn purple-gradient waves-effect waves-light" href="{{route('site.inquire')}}" role="button">Get a Quote</a>
{{--            <a class="btn btn-outline-white" href="{{route('contact')}}" role="button">Contacts</a>--}}
        </div>
        <!--/.Call to action-->
    </div>


</footer>
<!--/.Footer-->

<!-- ========================= FOOTER ========================= -->
<footer class="section-footer bg-dark white">
    <br>
    <div class="container">
        <section class="footer-top padding-top">
            <div class="row">
                <aside class="col-sm-3 col-md-3 bg-dark white">
                    <h5 class="title" style="color: white">Customer Services</h5>
                    <ul class="list-unstyled">
                        <li> <a href="{{route('terms')}}">Terms and Conditions</a></li>
                        <li> <a href="{{route('policy')}}">Privacy Policy</a></li>
                    </ul>
                </aside>
                <aside class="col-sm-3  col-md-3 bg-dark white">
                    <h5 class="title" style="color: white">My Account</h5>
                    <ul class="list-unstyled">
                        @guest
                        <li> <a href="{{route('login')}}"> User Login </a></li>
                        <li> <a href="{{route('register')}}"> User register </a></li>
                        @else
                        <li><a href="{{route('account.index')}}">My Profile</a></li>
                        <li> <a href="{{route('custom_order.index')}}"> My Custom Orders </a></li>
                        <li> <a href="{{route('orders.index')}}"> My Orders </a></li>
                        @endguest
                    </ul>
                </aside>
                <aside class="col-sm-3  col-md-3 bg-dark white">
                    <h5 class="title" style="color: white">About</h5>
                    <ul class="list-unstyled">
                        <li> <a href="{{route('about')}}"> Our history </a></li>
                        <li> <a href="{{route('rr')}}"> About Returns </a></li>
                        <li> <a href="{{route('faqs')}}"> FAQs </a></li>
                    </ul>
                </aside>
                <aside class="col-sm-3 bg-dark">
                    <article class="white bg-dark" style="color: white;">
                        <h5 class="title" style="color: white">Contacts</h5>
                        <ul class="list-unstyled">
                            <li> <a href="{{route('contact')}}"> Location and Contact Numbers </a></li>
                        </ul>
                    </article>
                </aside>
            </div>
            <!-- row.// -->
            <br>
        </section>
        <section class="footer-bottom row border-top-white">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <p class="text-md-right text-white-50">
                    &copy 2019 Copyright
                    <br>
                    <a href="#" target="_blank"> New MJC </a>
                </p>
            </div>
        </section>
        <!-- //footer-top -->
    </div>
    <!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->
