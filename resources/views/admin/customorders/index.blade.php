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
                                            @endif
                                        </td>
                                        <td>@if($cust_order->status == 0)
                                                <h5><span class='badge badge-warning'>Pending</span></h5>
                                            @elseif($cust_order->status == 1)
                                                <h5><span class='badge badge-success'>Accepted</span></h5>
                                            @endif
                                        </td>
                                        <td><a href="#" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                            @if($cust_order->status == 0)
                                                <a href="#" class="btn btn-success">Accept</a>
                                                <a href="{{route('customorders.edit', $cust_order->id)}}" class="btn btn-danger">Decline</a>
                                            @elseif($cust_order->status == 1)
                                                <a href="#" class="btn text-white" style="background-color: orange;">Modify</a>
                                            @endif
                                        </td>
                                    </tr>
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
