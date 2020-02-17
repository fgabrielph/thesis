@extends('site.master')

@section('title') {{$custom_order->id}} @endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        THE GRAPH <br>
                        @if($custom_order->quantity == null)
                            NO QTY YET
                        @else
                            {{$custom_order->quantity}}
                        @endif
                    </div>
                </div>
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
                                    @if($custom_order->payment_status == 0)
                                        <span class='badge badge-danger'>Not yet Paid</span>
                                    @else
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </h5><br>
                                <h5><b>Order Placed At: </b>{{$custom_order->created_at->toFormattedDateString()}}</h5><br>
                                <h5><b>Status: </b>
                                    @if($custom_order->status == 0)
                                        <span class='badge badge-warning'>Pending</span>
                                    @elseif($custom_order->status == 1)
                                        <span class='badge badge-success'>Accepted</span>
                                    @elseif($custom_order->status == 2)
                                        <span class="badge badge-success">Completed</span>
                                    @endif
                                </h5><br>
                                <h5><b>Description: </b></h5>
                                <p style="font-size: 23px">{{$custom_order->description}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="justify-content-center">
                                <a href="#" data-toggle="modal" data-target="#imageModal"><img src="/storage/assets/images/{{$custom_order->image}}" width="100%"></a>
                            </div>
                            <br><br>
                            <h3><b>ETA: </b></h3>{{$custom_order->updated_at->toFormattedDateString()}}
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <br>
                <a href="{{route('custom_order.index')}}" class="btn btn-lg btn-block blue-gradient">Go Back</a>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="/storage/assets/images/{{$custom_order->image}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')

{{--    @include('site.includes.footer')--}}

    <!--Footer-->
    <footer class="page-footer text-center font-small mt-4 wow fadeIn fixed-bottom">

        <div class="orange">
            <!--Call to action-->
            <div class="pt-3">
                <a class="btn btn-outline-white" href="#" role="button">Inquire Now</a>
                <a class="btn btn-outline-white" href="#" role="button">Contacts</a>
            </div>
            <!--/.Call to action-->

            <!--Copyright-->
            <div class="footer-copyright py-3 black">
                © 2019 Copyright:
                <a href="#" target="_blank"> New MJC </a>
            </div>
            <!--/.Copyright-->

        </div>


    </footer>
    <!--/.Footer-->

@endsection
