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
                            <table id="orderTable" class="table table-hover">
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
                                                if ($order->status == 'pending') {
                                                    echo "<span class='badge badge-warning'>Pending";
                                                } elseif ($order->status == 'processing') {
                                                    echo "<span class='badge badge-info'>Processing";
                                                } elseif ($order->status == 'completed') {
                                                    echo "<span class='badge badge-success'>Completed";
                                                } elseif ($order->status == 'return') {
                                                    echo "<span class='badge badge-secondary'>Return";
                                                } elseif ($order->status == 'initialised') {
                                                    echo "<span class='badge badge-primary'>Placed";
                                                } else {
                                                    echo "<span class='badge badge-danger'>Canceled";
                                                }
                                                echo "</span>";
                                                ?>
                                            </h4>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" data-toggle="modal" data-target="#view{{$order->id}}" class="btn btn-md btn-primary"><span class="fas fa-search"></span> View</button>
                                            <button type="button" data-toggle="dropdown" class="btn btn-md btn-primary">Actions</button>
                                            <div class="dropdown-menu">

                                                <a href="#" data-toggle="modal" data-target="#modify{{$order->id}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> Modify Status</a>
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
