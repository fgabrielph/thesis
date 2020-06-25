@extends('admin.master')

@section('title') Order Content @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Order Contents</h1>
                    <p>list of items in order {{$order->id}}</p>
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
                            <h3 class="card-title">Order Content of {{$order->id}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-responsive-lg">
                                <thead class="black white-text">
                                <th>Order ID</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                </thead>
                                <tbody>
                                @foreach($order->suborder as $item)
                                    <tr>
                                        <td>{{$item->order_id}}</td>
                                        <td>{{$item->item_id}}</td>
                                        <td>{{$item->item->name}}</td>
                                        <td>{{$item->item->brands->name}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->quantity * $item->price}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <h1 class="float-md-right">Total: {{ number_format($order->grand_total, 2) }}</h1>
                        </div>

                    </div>

                    <br>
                    <a href="{{route('admin_orders.index')}}" class="btn btn-primary"> Go Back</a>
                </div>
            </div>
        </div>
    </div>


@endsection
