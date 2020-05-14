@extends('site.master')

@section('title') {{$category_name->name}} @endsection

@section('others')

    <!--Carousel Wrapper-->
    <div id="carousel-example-1z" class="carousel slide carousel-fade pt-4" data-ride="carousel">

        <!--Indicators-->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
        </ol>
        <!--/.Indicators-->

        <!--Slides-->
        <div class="carousel-inner" role="listbox">

            <div class="carousel-item active">
                <div class="view" style="background-image: url('/assets/images/factory2.jpg'); background-repeat: no-repeat; background-size: cover;">
                </div>
            </div>

        </div>
        <!--/.Slides-->

        <!--Controls-->
        <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->

    </div>
    <!--/.Carousel Wrapper-->

@endsection

@section('content')

    <style>

        .sticky {
            position: fixed;
            width: 255px;
        }

        .scrollbar {
            overflow-y: scroll;
            height: 625px;
            background-color: gainsboro;
        }

        a:hover#customs {
            background-color: grey !important;
        }

        #style-3::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar-thumb
        {
            background-color: #000000;
        }

    </style>

    <div class="container">

        <!--Navbar-->
        <nav class="navbar navbar-expand-lg black lighten-3 mt-3 mb-3 white-text">

            <!-- Navbar brand -->
            <span class="navbar-brand">Not what you're looking for? <a class="btn purple-gradient waves-effect waves-light" href="{{route('site.inquire')}}" role="button">Ask for a Quotation</a></span>

            <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">

{{--                <form class="form-inline">--}}
{{--                    <div class="md-form my-0">--}}
{{--                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">--}}
{{--                    </div>--}}
{{--                </form>--}}
            </div>
            <!-- Collapsible content -->

        </nav>
        <!--/.Navbar-->

        <div class="row">
            <div class="col-md-3">
                <div class="card" id="myCategory">
                    <div class="card-header black white-text">
                        Categories
                    </div>
                    <div class="scrollbar" id="style-3">
                            <a class="nav-link" id="customs" style="color: black;" href="{{route('site.shop')}}">All </a>
                        @foreach($categories as $category)
                            <a class="nav-link" id="customs" style="color: black;" href="{{route('site.categories', $category)}}">{{$category->name}} </a>
                        @endforeach
                    </div>

                    <!-- ORANGE HOVER -->
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header mdb-color black white-text">
                        <h1><b>{{$category_name->name}}</b></h1>
                    </div>
                    <div class="card-body">

{{--                        <section class="text-center mb-4">--}}

{{--                            <!--Grid row-->--}}
{{--                            <div class="row wow fadeIn">--}}
{{--                            @foreach($items as $item)--}}
{{--                                <!--Grid column-->--}}

{{--                                    <div class="col-lg-3 col-md-6 mb-4">--}}

{{--                                        <!--Card-->--}}
{{--                                        <div class="card" style="width: 100%; height: 100%">--}}

{{--                                            <!--Card image-->--}}
{{--                                            <div class="view overlay">--}}
{{--                                                <img src="/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="">--}}
{{--                                                <a href="#" data-toggle="modal" data-target="#addtocart{{$item->id}}">--}}
{{--                                                    <div class="mask rgba-white-slight">Buy Now</div>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <!--Card image-->--}}

{{--                                            <!--Card content-->--}}
{{--                                            <div class="card-body text-center">--}}
{{--                                                <!--Category & Title-->--}}
{{--                                                <h5 class="grey-text">{{$item->categories->name}}</h5>--}}
{{--                                                <h5>--}}
{{--                                                    <strong>--}}
{{--                                                        <a href="{{route('site.product', $item->id)}}">{{$item->name}}</a>--}}
{{--                                                        --}}{{--                                        <span class="badge badge-pill danger-color">NEW</span>--}}
{{--                                                    </strong>--}}
{{--                                                </h5>--}}

{{--                                            </div>--}}
{{--                                            <!--Card content-->--}}

{{--                                        </div>--}}
{{--                                        <!--Card-->--}}

{{--                                    </div>--}}
{{--                                    <!--Grid column-->--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <!--Grid row-->--}}
{{--                        </section>--}}

                        <div class="row">
                            @foreach($items as $item)
                                <div class="col-md-3">
                                    <div class="card" style="margin-bottom: 7px">
                                        <div class="card-header" style="font-size: 17px">
                                            <a href="{{route('site.product', $item->id)}}">{{$item->name}}</a>
                                        </div>
                                        <div class="card-body">
                                            <img src="/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="" width="100%">
                                        </div>
                                        <div class="card-footer">
                                            <div class="float-right">
                                                <button data-toggle="modal" data-target="#addtocart{{$item->id}}" type="button" href="#" class="btn btn-md btn-success">Buy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--Section: Products v.3-->
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{$items->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <script>--}}
{{--        window.onscroll = function () {--}}
{{--            myFunction()--}}
{{--        };--}}

{{--        var header = document.getElementById("myCategory");--}}
{{--        var sticky = header.offsetTop;--}}

{{--        function myFunction() {--}}
{{--            if (window.pageYOffset > sticky) {--}}
{{--                header.classList.add("sticky");--}}
{{--            } else {--}}
{{--                header.classList.remove("sticky");--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}

@endsection

@section('footer')

    {{--    @foreach($items as $item)--}}
    {{--        {{$item->name}}--}}
    {{--    @endforeach--}}

    @include('site.includes.footer')

@endsection
