@extends('admin.master')

@section('title') Custom Order @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Custom Orders</h1>
                    <p>list of custom orders</p>
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
                            <h3 class="card-title">Manage Custom Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="defTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Order ID</th>
                                    <th class="text-center">Placed by</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center"><span class="fas fa-bolt"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($custom_orders as $cust_order)
                                    <tr class="text-center">
                                        <td>{{$cust_order->id}}</td>
                                        <td>{{$cust_order->user->name}}</td>
                                        <td>@if($cust_order->payment_status == 0)
                                            <h5><span class='badge badge-danger'>Not yet paid</span></h5>
                                            @elseif($cust_order->payment_status == 1)
                                                <h5><span class='badge badge-success'>Paid</span></h5>
                                            @elseif($cust_order->payment_status == 2)
                                                <h5><span class='badge badge-warning'>Waiting for Approval</span></h5>
                                            @endif
                                        </td>
                                        <td>@if($cust_order->status == 0)
                                                <h5><span class='badge badge-warning'>Pending</span></h5>
                                            @elseif($cust_order->status == 1)
                                                <h5><span class='badge badge-success'>Accepted</span></h5>
                                            @elseif($cust_order->status == 2)
                                                <h5><span class='badge badge-danger'>Declined</span></h5>
                                            @endif
                                        </td>
                                        <td>
                                            @if(empty($cust_order->quantity))
                                                <h5>Not Available</h5>
                                            @else
                                                <h5>{{$cust_order->quantity}}</h5>
                                            @endif
                                        </td>
                                        <td>
                                            @if(empty($cust_order->price))
                                                <h5>Not Available</h5>
                                            @else
                                                <h5>{{$cust_order->price}}</h5>
                                            @endif
                                        </td>
                                        <td><a href="{{route('customorders.show', $cust_order->id)}}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                            @if($cust_order->status == 0)
                                                <a href="{{route('customorders.accept', $cust_order->id)}}" class="btn btn-success">Accept</a>
                                                <a href="{{route('customorders.decline', $cust_order->id)}}" class="btn btn-danger">Decline</a>
                                            @elseif($cust_order->status == 1)
                                                <a href="{{route('customorders.edit', $cust_order->id)}}" class="btn text-white" style="background-color: orange;">Modify</a>
                                                @if($cust_order->payment_status == 2)
                                                    @if($cust_order->payment_method != 'cod')
                                                        <a href="#" data-toggle="modal" data-target="#receipt{{$cust_order->id}}" class="btn text-white" style="background-color: red;"><span class="fas fa-receipt"></span> View Bank Receipt</a>
                                                    @else
                                                        <a href="#" data-toggle="modal" data-target="#accept{{$cust_order->id}}" class="btn text-white" style="background-color: red;"><span class="fas fa-receipt"></span> View Info</a>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>

                                    @if($cust_order->payment_method == 'bank')
                                    <!-- Modal -->
                                    <div class="modal fade" id="receipt{{$cust_order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                            <img src="/assets/images/{{$cust_order->proof_image}}" width="100%" alt="this is image">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <form action="{{route('customorders.accept', $cust_order->id)}}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <input name="acceptor" type="hidden" value="1">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="submit" class="btn btn-success" value="Accept">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($cust_order->payment_method == 'cod')
                                    <!-- Modal -->
                                    <div class="modal fade" id="accept{{$cust_order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                                            <div class="modal-content" style="overflow-y: auto">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Mode of Payment: Cash on Delivery</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/{{$cust_order->image}}" width="100%" alt="this is image">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <form action="{{route('customorders.accept', $cust_order->id)}}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <input name="acceptor" type="hidden" value="1">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="submit" class="btn btn-success" value="Accept">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
