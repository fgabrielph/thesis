@extends('admin.master')

@section('title') List of Custom Orders @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Custom Orders</h1>
                    <p>list of custom orders</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{route('export', 'custom_orders')}}" class="btn btn-primary float-right">
                        Export
                    </a>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Custom Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Order ID</th>
                                    <th class="text-center">Ordered by</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Date Ordered</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($custom_orders as $order)
                                    <tr class="table-light">
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->user->name}}</td>
                                        <td class="text-center">{{$order->quantity}}</td>
                                        <td class="text-center">{{$order->price}}</td>
                                        <td class="text-center">{{$order->created_at->toFormattedDateString()}}</td>
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
