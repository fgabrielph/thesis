@extends('site.master')

@section('title') Shop @endsection

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
                        <h1><b>ALL</b></h1>
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
                                                <a href="#" data-toggle="modal" data-target="#addtocart{{$item->id}}">
                                                    <img src="/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="" width="100%">
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

    <script>
        window.onscroll = function() {myFunction()};

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

    @include('site.includes.footer')

@endsection
