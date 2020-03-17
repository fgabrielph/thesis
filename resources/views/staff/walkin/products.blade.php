@extends('staff.master')

@section('title') Walk - in @endsection

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
            background-color: white;
        }

        a:hover#customs {
            background-color: gainsboro !important;
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

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Products</h1>
                    <p>Walk-in customer products</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{route('staff_cart.index')}}" class="btn btn-primary float-right"><span class="fas fa-shopping-cart" aria-hidden="true"></span>
                        Cart
                        @if(Cart::content()->count() > 0)
                            <span class="badge bg-danger"> {{Cart::content()->count()}} </span>
                        @endif
                    </a>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-danger" id="myCategory">
                        <div class="card-header black white-text">
                            Categories
                        </div>
                        <div class="scrollbar" id="style-3">
                            @foreach($categories as $category)
                                <a class="nav-link" id="customs" style="color: black;" href="{{route('staff.categories', $category)}}">{{$category->name}} </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    @include('staff.includes.messages')
                    <div class="card card-danger">
                        <div class="card-header">
                            Shop
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($items as $item)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                {{$item->name}}
                                            </div>
                                            <div class="card-body">
                                                <img src="/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="" width="100%">
                                            </div>
                                            <div class="card-footer">
                                                <div class="">Qty: {{$item->stocks}}</div>Price: {{$item->price_stocks}}
                                                <div class="float-right">
                                                    <button data-toggle="modal" data-target="#addtocart{{$item->id}}" type="button" href="#" class="btn btn-md btn-success">Buy</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @foreach($items as $item)
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
                                            {!!Form::open(['action' => 'Staff\CartController@store', 'method' => 'POST'])!!}
                                            {{Form::hidden('id', $item->id)}}
                                            {{Form::hidden('name', $item->name)}}
                                            Quantity: {{Form::number('quantity', '', ['class' => 'form-control', 'placeholder' => '0', 'style' => 'width: 100px'])}}
                                            {{Form::hidden('price', $item->price_stocks)}}<br>
{{--                                                {{Form::hidden('buynow', 1)}}--}}
                                            <button class="btn btn-outline-success btn-lg my-0 p" type="submit">Buy Now</button>
                                            {!!Form::close()!!}

                                        </div>
                                    </div>
                                </div>
                            </div>
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
