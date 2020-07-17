@extends('site.master')

@section('title') {{$custom_order->id}} @endsection

@section('content')

    <script src="http://anthonyterrien.com/demo/knob/jquery.knob.min.js"></script>

    <br><br><br>
    <div class="container">
        @include('site.includes.messages')
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <br>
                        @if($custom_order->quantity == null && $custom_order->status == 0 && $custom_order->completed == null)
                            <h3>NO Quantity YET</h3>
                        @elseif($custom_order->quantity == null && $custom_order->status != 2)
                            <h3>In Progress</h3>
                        @elseif($custom_order->status == 2)
                            <h3><b>This Order is Canceled</b></h3>
                        @elseif(empty($custom_order->completed))
                            <h3>0 / {{$custom_order->quantity}}, In Progress</h3>
                        @else
                            <input type="text" value="{{$custom_order->completed}}" class="dial" data-thickness=.3><br>
                            <h3>{{$custom_order->completed}} out of {{$custom_order->quantity}} Completed</h3>
                        @endif
                    </div>
                </div>
                <br>

                @if($custom_order->status == 1)

                    @if($custom_order->price != null)

                        @if(!(empty($custom_order->payment_method)))

                        <!-- Checks if the Proof Image is Validated by Admin -->
                            @if(!(empty($custom_order->proof_image)) && $custom_order->payment_status == 2)
                                <form action="{{route('custom_order.payment', $custom_order->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <img id="img" src="/assets/images/{{$custom_order->proof_image}}" class="img-fluid rounded mx-auto d-block"/>

                                    <br>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="imgInp" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>


                                    <br>
                                    <input type="hidden" value="editproof">
                                    <input name="_method" type="hidden" value="PUT">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Proceed</button>
                                </form>
                            @elseif($custom_order->payment_method == 'cod')

                                <h3 class="text-center">Your Payment method is waiting for approval!</h3>
{{--                            @else--}}
{{--                                <form action="{{route('custom_order.payment', $custom_order->id)}}" method="POST" enctype="multipart/form-data">--}}
{{--                                    @csrf--}}
{{--                                    <label for="textInput"><strong>Payment Method:</strong></label>--}}
{{--                                    <div class="d-block my-3">--}}
{{--                                        <fieldset id="radio_group">--}}
{{--                                            <div class="custom-control custom-radio">--}}
{{--                                                <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="cod" onclick="no_form()" required>--}}
{{--                                                <label class="custom-control-label" for="credit">Cash on Delivery</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-radio">--}}
{{--                                                <input id="bank" name="payment_method" type="radio" class="custom-control-input" value="bank" onclick="with_form(1)" required>--}}
{{--                                                <label class="custom-control-label" for="bank">Bank Transfer</label>--}}
{{--                                            </div>--}}
{{--                                        </fieldset>--}}
{{--                                    </div>--}}

{{--                                    <br>--}}

{{--                                    <div id="bankt" style="display: none;">--}}
{{--                                        @if($custom_order->proof_image == null)--}}
{{--                                            <img id="img" src="{{url('../assets/images/error-img.png')}}" class="img-fluid rounded mx-auto d-block"/>--}}
{{--                                        @else--}}
{{--                                            <img id="img" src="/assets/images/{{$custom_order->proof_image}}" class="img-fluid rounded mx-auto d-block"/>--}}
{{--                                        @endif--}}

{{--                                        <br>--}}

{{--                                        <div class="input-group">--}}
{{--                                            <div class="input-group-prepend">--}}
{{--                                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-file">--}}
{{--                                                <input name="image" type="file" class="custom-file-input" id="imgInp" aria-describedby="inputGroupFileAddon01">--}}
{{--                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <br>--}}

{{--                                    <input name="_method" type="hidden" value="PUT">--}}
{{--                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Proceed</button>--}}
{{--                                </form>--}}
                            @endif
                        @else
                                <form action="{{route('custom_order.payment', $custom_order->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="textInput"><strong>Payment Method:</strong></label>
                                    <div class="d-block my-3">
                                        <fieldset id="radio_group">
                                            <div class="custom-control custom-radio">
                                                <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="cod" onclick="no_form()" required>
                                                <label class="custom-control-label" for="credit">Cash on Delivery</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input id="bank" name="payment_method" type="radio" class="custom-control-input" value="bank" onclick="with_form(1)" required>
                                                <label class="custom-control-label" for="bank">Bank Transfer</label>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <br>

                                    <div id="bankt" style="display: none;">
                                        @if($custom_order->proof_image == null)
                                            <img id="img" src="{{url('../assets/images/error-img.png')}}" class="img-fluid rounded mx-auto d-block"/>
                                        @else
                                            <img id="img" src="/assets/images/{{$custom_order->proof_image}}" class="img-fluid rounded mx-auto d-block"/>
                                        @endif

                                        <br>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input name="image" type="file" class="custom-file-input" id="imgInp" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <input name="_method" type="hidden" value="PUT">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Proceed</button>
                                </form>
                        @endif
                    @else

                        <h3 class="text-center"><b>No Price has been placed yet!</b></h3>
                    @endif
                @endif
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Order Number: {{$custom_order->id}}</h1>
                    </div>

                    <!-- Start Row -->
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5><b>Placed By: </b>{{$custom_order->user->name}}</h5><br>
                                <h5><b>Payment Status: </b>
                                    @if($custom_order->payment_status == 0 && $custom_order->status == 2)
                                        <span class='badge badge-danger'>Declined Order</span>
                                    @elseif($custom_order->payment_status == 0)
                                        <span class='badge badge-danger'>Not yet Paid</span>
                                    @elseif($custom_order->payment_status == 2)
                                        <span class='badge badge-warning'>Pending for Approval</span>
                                    @else
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </h5><br>
                                <h5><b>Status: </b>
                                    @if($custom_order->status == 0)
                                        <span class='badge badge-warning'>Pending</span>
                                    @elseif($custom_order->status == 1)
                                        <span class='badge badge-success'>Accepted</span>
                                    @elseif($custom_order->status == 2)
                                        <span class="badge badge-danger">Declined</span>
                                    @elseif($custom_order->status == 3)
                                        <span class='badge badge-success'>Completed</span>
                                    @elseif($custom_order->status == 4)
                                        <span class='badge badge-warning'>On Delivery</span>
                                    @elseif($custom_order->status == 5)
                                        <span class='badge badge-dark'>Delivered</span>
                                    @elseif($custom_order->status == 6)
                                        <span class='badge badge-light'>Return</span>
                                    @endif
                                </h5><br>
                                <h5><b>Contact Number: {{$custom_order->user->mobile_number}}</b></h5><br>
                                <h5><b>Description: </b></h5>
                                <p style="font-size: 23px">{{$custom_order->description}}</p>
                                <br>
                                <h5 class="card-footer">
                                    <b>Total Price:
                                        @if(empty($custom_order->price))
                                            N/A
                                        @else
                                            PHP {{number_format($custom_order->price, 2)}}
                                        @endif
                                    </b>
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="justify-content-center">
                                <a href="#" data-toggle="modal" data-target="#imageModal"><img src="/assets/images/{{$custom_order->image}}" width="100%"></a>
                            </div>
                            <br><br>
                            <h3><b>Created at: </b>{{$custom_order->created_at->toFormattedDateString()}}</h3>
                        </div>
                    </div>
                    <!-- End Row -->
                    <br>
                </div>
                <br>
                <a href="{{route('custom_order.index')}}" class="btn btn-lg btn-block blue-gradient">Go Back</a>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="/assets/images/{{$custom_order->image}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

    {{--    <!--Footer-->--}}
    {{--    <footer class="page-footer text-center font-small mt-4 wow fadeIn fixed-bottom">--}}

    {{--        <div class="orange">--}}
    {{--            <!--Call to action-->--}}
    {{--            <div class="pt-3">--}}
    {{--                <a class="btn btn-outline-white" href="#" role="button">Inquire Now</a>--}}
    {{--                <a class="btn btn-outline-white" href="#" role="button">Contacts</a>--}}
    {{--            </div>--}}
    {{--            <!--/.Call to action-->--}}

    {{--            <!--Copyright-->--}}
    {{--            <div class="footer-copyright py-3 black">--}}
    {{--                © 2019 Copyright:--}}
    {{--                <a href="#" target="_blank"> New MJC </a>--}}
    {{--            </div>--}}
    {{--            <!--/.Copyright-->--}}

    {{--        </div>--}}


    {{--    </footer>--}}
    {{--    <!--/.Footer-->--}}

@endsection

@section('js')

    <script src="http://anthonyterrien.com/demo/knob/jquery.knob.min.js"></script>
    <script>
        $('.dial').knob({

            max: '{{$custom_order->quantity}}',
            readOnly: true,
            fgColor: 'orange',
            inputColor: 'black',
            draw: function () {
                $(this.i).val(this.cv + ' / {{$custom_order->quantity}}').css('font-size', '20pt'); //Puts a percent after values
            },
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('img').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });

        function no_form() {
            $('#bankt').hide();
        }

        function with_form() {
            $('#bankt').show();
        }
    </script>

@endsection
