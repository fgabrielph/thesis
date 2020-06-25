@extends('admin.master')

@section('title') List of Deliveries  @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                    <p>list of custom orders</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{route('export', 'deliveries')}}" class="btn btn-primary float-right">
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
                            <h3 class="card-title">Deliveries</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Delivery ID</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Estimated Day of Arrival</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deliveries as $delivery)
                                    <tr>
                                        <td>{{$delivery->id}}</td>
                                        <td>{{$delivery->customer_name}}</td>
                                        <td>{{$delivery->order->address}}</td>
                                        <td>{{$delivery->status}}</td>
                                        <td>{{$delivery->created_at->format('m/d/Y')}}</td>
                                        @if(!empty($delivery->ETA))
                                            <td>{{$delivery->ETA}}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
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
