@extends('staff.master')

@section('title') Checkout @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Overview</h1>
                    <p>Contents</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container wow fadeIn">

            <!-- Heading -->
            <h2 class="my-5 h2 text-center">Checkout form</h2>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-8 mb-4">
                @include('site.includes.messages')
                <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <form action="{{route('staff_checkout.invoice')}}" class="card-body"  method="POST" role="form" enctype="multipart/form-data">
                        @csrf

                        <!--Grid row-->
                            <div class="row">

                                <!--Grid column-->
                                <div class="col-md-6 mb-2">

                                    <!--firstName-->
                                    <div class="md-form ">
                                        <input value="{{ old('firstName') }}" name="firstName" type="text" id="firstName" class="form-control">
                                        <label for="firstName" class="">First name</label>
                                    </div>

                                </div>
                                <!--Grid column-->

                                <!--Grid column-->
                                <div class="col-md-6 mb-2">

                                    <!--lastName-->
                                    <div class="md-form">
                                        <input value="{{ old('lastName') }}" name="lastName" type="text" id="lastName" class="form-control">
                                        <label for="lastName" class="">Last name</label>
                                    </div>

                                </div>
                                <!--Grid column-->

                            </div>
                            <!--Grid row-->


                            <hr class="mb-4">

                            <!--Grid row-->
                            <div class="row">

                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="state">Mobile Number</label>
                                    <input value="{{ old('mobile_num') }}" name="mobile_num" type="text" id="address-2" class="form-control">
                                </div>


                            </div>
                            <!--Grid row-->

                            <hr class="mb-4">

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Proceed</button>

                        </form>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-4 mb-4">

                    <!-- Heading -->
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-danger badge-pill">{{count(Cart::content())}}</span>
                    </h4>

                    <!-- Cart -->
                    <ul class="list-group mb-3 z-depth-1">
                        @foreach(Cart::content() as $item)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">{{$item->name}}</h6>
                                    <small class="text-muted">pcs. x{{$item->qty}}</small>
                                </div>
                                <span class="text-muted">₱ {{number_format($item->qty * $item->model->price_stocks, 2)}}</span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (PHP)</span>
                            <strong>₱ {{Cart::Total()}}</strong>
                        </li>
                    </ul>
                    <!-- Cart -->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        </div>
    </div>

@endsection
