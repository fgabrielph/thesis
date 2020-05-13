@extends('admin.master')

@section('title') Custom Order {{$customorder->id}} @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Custom Order Number {{$customorder->id}}</h1>
                    <p>Placed by {{$customorder->user->name}}</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('admin.includes.messages')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order</h3>
                        </div>

                        <br>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <br>
                                            @if($customorder->quantity == null && $customorder->status == 0 && $customorder->completed == null)
                                                <h3>NO Quantity YET</h3>
                                            @elseif($customorder->quantity == null && $customorder->status != 2)
                                                <h3>In Progress</h3>
                                            @elseif($customorder->status == 2)
                                                <h3><b>This Order is Canceled</b></h3>
                                            @elseif(empty($customorder->completed))
                                                <h3>0 / {{$customorder->quantity}}, In Progress</h3>
                                            @else
                                                <input type="text" value="{{$customorder->completed}}" class="dial" data-thickness=.3><br>
                                                <h3>{{$customorder->completed}} out of {{$customorder->quantity}} Completed</h3>
                                            @endif
                                        </div>
                                    </div>

                                    @if($customorder->payment_status == 0 && $customorder->status != 2)
                                        <h3 class="text-center"><b>No Payment has been placed yet!</b></h3>
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h1>Order Number: {{$customorder->id}}</h1>
                                        </div>

                                        <!-- Start Row -->
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="card-body">
                                                    <h5><b>Placed By: </b>{{$customorder->user->name}}</h5><br>
                                                    <h5><b>Payment Status: </b>
                                                        @if($customorder->payment_status == 0 && $customorder->status == 2)
                                                            <span class='badge badge-danger'>Declined Order</span>
                                                        @elseif($customorder->payment_status == 0)
                                                            <span class='badge badge-danger'>Not yet Paid</span>
                                                        @elseif($customorder->payment_status == 2)
                                                            <h5><span class='badge badge-warning'>Waiting for Approval</span></h5>
                                                        @elseif($customorder->payment_status == 1)
                                                            <span class="badge badge-success">Paid</span>
                                                        @elseif($customorer->payment_status == 3)
                                                            <span class="badge-info">Partially Paid</span>
                                                        @endif
                                                    </h5><br>
                                                    <h5><b>Status: </b>
                                                        @if($customorder->status == 0)
                                                            <span class='badge badge-warning'>Pending</span>
                                                        @elseif($customorder->status == 1)
                                                            <span class='badge badge-success'>Accepted</span>
                                                        @elseif($customorder->status == 2)
                                                            <span class="badge badge-danger">Declined</span>
                                                        @elseif($customorder->status == 3)
                                                            <span class="badge badge-success">Completed</span>
                                                        @elseif($customorder->status == 5)
                                                            <span class="badge badge-success">Delivered</span>
                                                        @endif
                                                    </h5><br>
                                                    <h5><b>Contact Number: {{$customorder->user->mobile_number}}</b></h5><br>
                                                    <h5><b>Description: </b></h5>
                                                    <p style="font-size: 23px">{{$customorder->description}}</p>
                                                    <br>
                                                    <h5 class="card-footer">
                                                        <b>Total Price:
                                                            @if(empty($customorder->price))
                                                                N/A
                                                            @else
                                                                {{$customorder->price}}
                                                            @endif
                                                        </b>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <br>
                                                <div class="justify-content-center">
                                                    <a href="#" data-toggle="modal" data-target="#imageModal"><img src="/assets/images/{{$customorder->image}}" width="100%"></a>
                                                </div>
                                                <br><br>
                                                <h3><b>Created at: </b>{{$customorder->created_at->toFormattedDateString()}}</h3>
                                            </div>
                                        </div>
                                        <!-- End Row -->
                                        <br>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="/assets/images/{{$customorder->image}}" width="100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('customorders.index')}}" class="btn btn-lg btn-block btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script src="http://anthonyterrien.com/demo/knob/jquery.knob.min.js"></script>
    <script>
        $('.dial').knob({

            max: '{{$customorder->quantity}}',
            readOnly: true,
            fgColor : 'orange',
            inputColor: 'black',
            draw: function () {
                $(this.i).val(this.cv + ' / {{$customorder->quantity}}').css('font-size', '20pt'); //Puts a percent after values
            },
        });
    </script>

@endsection
