@extends('site.master')

@section('title') Shop @endsection

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
            height: auto;
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
{{--                        <input class="form-control mr-sm-2 white-text" type="text" placeholder="Search" aria-label="Search">--}}
{{--                    </div>--}}
{{--                </form>--}}
            </div>
            <!-- Collapsible content -->

        </nav>
        <!--/.Navbar-->


        <div class="row">
            <div class="col-md-3">
                <br>
                <div class="card" id="myCategory">
                    <div class="card-header black white-text">
                        Categories
                    </div>
                    <div class="scrollbar" id="style-3">
                        @foreach($categories as $category)
                            <a class="nav-link" id="customs" style="color: black;" href="{{route('site.categories', $category)}}">{{$category->name}} </a>
                        @endforeach
                    </div>

                    <!-- ORANGE HOVER -->
                </div>
            </div>

            <div class="col-md-9">
                <br>
                <div class="card">
                    <div class="card-header mdb-color black white-text">
                        <h1><b>ALL</b></h1>
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
{{--                                                <a href="#" data-toggle="modal" data-target="#addtocart{{$item->id}}">--}}
{{--                                                    <img src="/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="" width="100%">--}}
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
                        @foreach($items as $item)
                            <!-- Modal -->
                            <div class="modal fade" id="addtocart{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">

                                <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
                                <div class="modal-lg modal-dialog modal-dialog-centered" role="document">


                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">PRODUCT</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col d-flex justify-content-center">
                                                    <img src="/assets/images/large_thumbnail/{{$item->image}}" width="100%" height="100%" alt="this is image">
                                                </div>
                                                <div class="col">
                                                    <strong><h2>{{$item->name}}</h2></strong>
                                                    <h3 class="text-success">₱ {{number_format($item->price_stocks, 2)}}</h3>
                                                    <p>{{$item->description}}</p>
                                                    Remaining:<div class="text-info">{{$item->stocks}}</div><br>



                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            {!!Form::open(['action' => 'CartController@store', 'method' => 'POST'])!!}
                                            {{Form::hidden('id', $item->id)}}
                                            {{Form::hidden('name', $item->name)}}
                                            Quantity: {{Form::number('quantity', '', ['class' => 'form-control', 'placeholder' => '0', 'style' => 'width: 100px'])}}
                                            {{Form::hidden('price', $item->price_stocks)}}<br>
                                            {{Form::hidden('buynow', 1)}}
                                            <button class="btn btn-amber btn-lg my-0 p" type="submit">Buy Now</button>
                                            {!!Form::close()!!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                        @endforeach

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
{{--        window.onscroll = function() {myFunction()};--}}

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

    @include('site.includes.footer')

@endsection
