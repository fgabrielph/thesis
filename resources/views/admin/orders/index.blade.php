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
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"><span class="fas fa-bolt"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->order_number}}</td>
                                        <td class="text-center">{{$order->user->name}}</td>
                                        <td class="text-center"><h5>{!! $order->payment_status ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Unpaid</span>' !!}</h5></td>
                                        <td class="text-center">
                                            <h4>
                                                <?php
                                                if ($order->status == 'pending' || $order->status == 'Pending') {
                                                    echo "<span class='badge badge-warning'>Pending";
                                                } elseif ($order->status == 'Processing') {
                                                    echo "<span class='badge badge-info'>Processing";
                                                } elseif ($order->status == 'Completed') {
                                                    echo "<span class='badge badge-success'>Completed";
                                                } elseif ($order->status == 'Dispatched') {
                                                    echo "<span class='badge badge-light'>Dispatched";
                                                } elseif ($order->status == 'Accepted') {
                                                    echo "<span class='badge badge-success'>Accepted";
                                                } elseif ($order->status == 'Return') {
                                                    echo "<span class='badge badge-secondary'>Return";
                                                } elseif ($order->status == 'Initialised') {
                                                    echo "<span class='badge badge-primary'>Placed";
                                                } elseif ($order->status == 'Canceled') {
                                                    echo "<span class='badge badge-danger'>Canceled";
                                                } elseif ($order->status == 'WaitingForPayment') {
                                                    echo "<span class='badge badge-light'>Waiting for Payment";
                                                }
                                                echo "</span>";
                                                ?>
                                            </h4>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" data-toggle="modal" data-target="#view{{$order->id}}" class="btn btn-md btn-primary"><span class="fas fa-search"></span> View</button>
                                            <button type="button" data-toggle="dropdown" class="btn btn-md dropdown-toggle" style="color: white; background-color: orange">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-toggle="modal" data-target="#modify{{$order->id}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> Modify Status</a>
                                                @if(!(empty($order->image)))
                                                    <a href="#" data-toggle="modal" data-target="#receipt{{$order->id}}" class="dropdown-item"><span class="fas fa-search"></span> View Receipt</a>
                                                @endif
                                            </div>
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
                                                            <address><strong>{{ $order->user->name }}</strong><br>Email: {{ $order->user->email }}</address>
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

                                    <!-- Modal -->
                                    <div class="modal fade" id="modify{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('admin_orders.update', $order->id)}}" class="form-horizontal" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Order Status</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label class="col-md-4 control-label">Status: </label>
                                                                    <div class="col-md-12">
                                                                        <select class="form-control" name="status">
                                                                            <option name="{{$order->status}}">{{$order->status}}</option>
                                                                            <option value="Accepted">Accepted</option>
                                                                            <option value="Dispatched">Dispatched</option>
                                                                            <option value="Completed">Completed</option>
                                                                            <?php
                                                                            if($order->payment_status == 0) {
                                                                            ?>
                                                                                <option value="Canceled">Canceled</option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <option value="Return">Return</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <input class="btn btn-primary" type="submit" value="Save Changes">
                                                    </div>
                                                    <input name="_method" type="hidden" value="PUT">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
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
                                                            <img src="/storage/assets/images/medium_thumbnail/{{$order->image}}" width="100%" alt="this is image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
