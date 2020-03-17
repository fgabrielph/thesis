@extends('admin.master')

@section('title') Orders @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                    <p>list of orders</p>
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
                            <h3 class="card-title">Manage Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="defTable" class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-center">Order Number</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Payment Method</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"><span class="fas fa-bolt"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @if($order->status != 'On Delivery')
                                    <tr>
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->order_number}}</td>
                                        <td class="text-center">
                                            @if($order->user->name == 'N/A')
                                                {{$order->first_name . ' ' . $order->last_name}}
                                            @else
                                                {{$order->user->name}}
                                            @endif
                                        </td>
                                        <td>
                                            <h5>
                                                @if($order->payment_method == 'paypal')
                                                    Paypal
                                                @elseif($order->payment_method == 'cod')
                                                    Cash on Delivery
                                                @elseif($order->payment_method == 'bank')
                                                    Bank Transfer
                                                @elseif($order->payment_method == 'cash')
                                                    Cash
                                                @endif
                                            </h5>

                                        </td>
                                        <td class="text-center"><h5>{!! $order->payment_status ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Unpaid</span>' !!}</h5></td>
                                        <td class="text-center">
                                            <h4>
                                                @if($order->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($order->status == 'Canceled')
                                                    <span class="badge bg-danger">Declined</span>
                                                @elseif($order->status == 'Confirmed')
                                                    <span class="badge" style="background-color: greenyellow">Confirmed</span>
                                                @elseif($order->status == 'Return')
                                                    <span class="badge bg-secondary">Returned</span>
                                                @elseif($order->status == 'Completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @endif
                                            </h4>
                                        </td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#view{{$order->id}}" class="btn btn-md btn-primary"><span class="fas fa-search"></span> View</button>
                                            @if($order->payment_method == 'cod' && $order->status != 'Confirmed' && $order->status != 'Completed' && $order->status != 'Return' && $order->status != 'Canceled')
                                            <a href="{{route('admin_orders.status', ['status' => 'Confirmed', 'id' => $order->id])}}" class="btn btn-md btn-primary"><span class="fas fa-check-circle"></span> Confirm</a>
                                            @endif
                                            @if(!(empty($order->image)))
                                                <a href="#" data-toggle="modal" data-target="#receipt{{$order->id}}" class="btn text-white" style="background-color: grey;"><span class="fas fa-receipt"></span> View Receipt</a>
                                            @endif
                                            @if($order->status == 'Confirmed')
{{--                                                <a href="{{route('admin_orders.status', ['status' => 'On Delivery', 'id' => $order->id])}}" class="btn btn-md btn-success"><span class="fas fa-truck"></span> Deliver</a>--}}
                                                <a href="#" data-toggle="modal" data-target="#deliver{{$order->id}}" class="btn btn-md btn-success"><span class="fas fa-truck"></span> Deliver</a>
                                            @endif
                                        </td>
                                    </tr>

                                    <div id="view{{$order->id}}" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title h4" id="myLargeModalLabel">Order</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h2 class="page-header"><i class="fa fa-globe"></i> {{ $order->order_number }}</h2>
                                                        </div>
                                                        <div class="col-6">
                                                            <h5 class="text-right">Date: {{ $order->created_at->toFormattedDateString() }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">Placed By
                                                            <address>
                                                                <strong>
                                                                    @if($order->user->name == 'N/A')
                                                                        {{$order->first_name . ' ' . $order->last_name}}
                                                                    @else
                                                                        {{$order->user->name}}
                                                                    @endif
                                                                </strong>
                                                                <br>Email:
                                                                @if($order->user->email == 'N/A@walkin.com')
                                                                    N/A
                                                                @else
                                                                    {{ $order->user->email }}
                                                                @endif
                                                            </address>
                                                        </div>
                                                        <div class="col-4">Ship To
                                                            <address><strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>{{ $order->address }}<br>{{ $order->city }}, {{ $order->country }} {{ $order->post_code }}<br>{{ $order->phone_number }}<br></address>
                                                        </div>
                                                        <div class="col-4">
                                                            <b>Order ID:</b> {{ $order->id }}<br>
                                                            <b>Amount:</b> P {{ number_format($order->grand_total, 2) }}<br>
                                                            <b>Payment Method:</b> {{ $order->payment_method }}<br>
                                                            <b>Payment Status:</b> {{ $order->payment_status == 1 ? 'Completed' : 'Not Completed' }}<br>
                                                            <b>Order Status:</b> {{$order->status}}<br>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="receipt{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                                            <div class="modal-content" style="overflow-y: auto">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Uploaded Receipt</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/medium_thumbnail/{{$order->image}}" width="100%" alt="this is image">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    @if($order->status != 'Confirmed' && $order->status != 'Completed' && $order->status != 'Return')
                                                    <a href="{{route('admin_orders.status', ['status' => 'Accept', 'id' => $order->id])}}" class="btn btn-lg btn-success">Accept</a>
                                                    <a href="{{route('admin_orders.status', ['status' => 'Decline', 'id' => $order->id])}}" class="btn btn-lg btn-danger">Decline</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($order->status == 'Confirmed')
                                    <!-- Modal -->
                                    <div class="modal fade" id="deliver{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('deliveries.eda', $order->id)}}" class="form-horizontal" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Estimated Day of Arrival</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label">Date: </label>
                                                                    <div class="col-md-12">
                                                                        <input name="date" id="datepicker{{$order->id}}" type="text" class="form-control input-md" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <input class="btn btn-primary" type="submit" value="Save Changes">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            @foreach($orders as $order)
            $( "#datepicker{{$order->id}}" ).datepicker();
            @endforeach
        } );
    </script>

@endsection
