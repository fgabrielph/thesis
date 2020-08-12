@extends('site.master')

@section('title') Checkout @endsection

@section('content')

    <br><br><br>
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
                    <form action="{{route('paypal.checkout')}}" class="card-body"  method="POST" role="form" enctype="multipart/form-data">
                    @csrf

                        <!--Grid row-->
                        <div class="row">

                            <!--Grid column-->
                            <div class="col-md-6 mb-2">

                                <!--firstName-->
                                <div class="md-form ">
                                    <input value="{{ Auth::user()->first_name }}" name="firstName" type="text" id="firstName" class="form-control">
                                    <label for="firstName" class="">First name</label>
                                </div>

                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-6 mb-2">

                                <!--lastName-->
                                <div class="md-form">
                                    <input value="{{ Auth::user()->last_name }}" name="lastName" type="text" id="lastName" class="form-control">
                                    <label for="lastName" class="">Last name</label>
                                </div>

                            </div>
                            <!--Grid column-->

                        </div>
                        <!--Grid row-->

                        <!--email-->
                        <div class="md-form mb-5">
                            <input type="text" id="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled>
                            <label for="email" class="">Email </label>
                        </div>

                        <!--address-->
                        <div class="md-form mb-5">
                            <input value="{{ Auth::user()->address }}" name="address" type="text" id="address" class="form-control" placeholder="">
                            <label for="address" class="">Address</label>
                        </div>


                        <!--Grid row-->
                        <div class="row">

                            <!--Grid column-->
                            <div class="col-lg-4 col-md-6 mb-4">

                                <label for="state">City</label>
                                <input value="{{ old('city') }}" name="city" type="text" id="address-2" class="form-control">

                            </div>
                            <!--Grid column-->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <label for="state">Zip Code</label>
                                <input value="{{ old('zip') }}" name="zip" type="text" id="address-2" class="form-control">
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <label for="state">Mobile Number</label>
                                <input value="{{ Auth::user()->mobile_number }}" name="mobile_num" type="text" id="address-2" class="form-control">
                            </div>



                        </div>
                        <!--Grid row-->

                        <!--address-->
                        <div class="md-form mb-5">
                            <input name="notes" type="text" id="address" class="form-control" placeholder="Enter Notes">
                            <label for="address" class="">Notes</label>
                        </div>



                        <input class="mb-3" type="checkbox" value="" id="checker"> Receiver
                        <!--deliver to-->
                        <div id="receiver" class="md-form mb-5" style="display: none">
                            <input name="deliver_to" type="text" id="deliver_to" class="form-control" placeholder="Enter Receiver's Full Name">
                            <label for="deliver_to" class="">Deliver to</label>
                        </div>

                        <!--deliver to address-->
                        <div id="receiver_address" class="md-form mb-5" style="display: none">
                            <input name="deliver_to_address" type="text" id="deliver_to_address" class="form-control" placeholder="Enter Receiver's Address">
                            <label for="deliver_to_address" class="">Address of the Receiver</label>
                        </div>



                        <div class="d-block my-3">
                            <fieldset id="radio_group">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" value="cod" required>
                                    <label class="custom-control-label" for="credit">Cash on Delivery</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="bank" name="paymentMethod" type="radio" class="custom-control-input" value="bank" required>
                                    <label class="custom-control-label" for="bank">Bank Transfer</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" value="paypal" required>
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </fieldset>




                        </div>
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

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection

@section('js')

    <script>

        $('#checker').change(function(){
            if ($(this).prop('checked')) {
                $('#receiver').show();
                $('#receiver_address').show();

                $('#deliver_to').prop('required', true);
                $('#deliver_to_address').prop('required', true);

            }else {
                $('#receiver').hide();
                $('#receiver_address').hide();

                $('#deliver_to').removeAttr('required');
                $('#deliver_to_address').removeAttr('required');

                $('#deliver_to').val("");
                $('#deliver_to_address').val("");
            }
        })

    </script>

@endsection

