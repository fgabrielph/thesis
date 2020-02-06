@extends('site.master')

@section('title') {{$category_name->name}} @endsection

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
        <div class="row">
            <div class="col-md-3">
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
                <div class="card">
                    <div class="card-header mdb-color black white-text">
                        <h1><b>{{$category_name->name}}</b></h1>
                    </div>
                    <div class="card-body">

                        <section class="text-center mb-4">

                            <!--Grid row-->
                            <div class="row wow fadeIn">
                            @foreach($items as $item)
                                <!--Grid column-->

                                    <div class="col-lg-3 col-md-6 mb-4">

                                        <!--Card-->
                                        <div class="card" style="width: 100%; height: 100%">

                                            <!--Card image-->
                                            <div class="view overlay">
                                                <img src="/storage/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="">
                                                <a href="#" data-toggle="modal" data-target="#addtocart{{$item->id}}">
                                                    <div class="mask rgba-white-slight">Buy Now</div>
                                                </a>
                                            </div>
                                            <!--Card image-->

                                            <!--Card content-->
                                            <div class="card-body text-center">
                                                <!--Category & Title-->
                                                <h5 class="grey-text">{{$item->categories->name}}</h5>
                                                <h5>
                                                    <strong>
                                                        <a href="{{route('site.product', $item->id)}}">{{$item->name}}</a>
                                                        {{--                                        <span class="badge badge-pill danger-color">NEW</span>--}}
                                                    </strong>
                                                </h5>

                                            </div>
                                            <!--Card content-->

                                        </div>
                                        <!--Card-->

                                    </div>
                                    <!--Grid column-->
                                @endforeach
                            </div>
                            <!--Grid row-->
                        </section>
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

    <script>
        window.onscroll = function () {
            myFunction()
        };

        var header = document.getElementById("myCategory");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>

@endsection

@section('footer')

    {{--    @foreach($items as $item)--}}
    {{--        {{$item->name}}--}}
    {{--    @endforeach--}}

    @include('site.includes.footer')

@endsection
