@extends('admin.master')

@section('title') Item @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List of Item that are Critical</h1>
                    <p>list of custom orders</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{route('export', 'critical_level')}}" class="btn btn-primary float-right">
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
                            <h3 class="card-title">Items</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Product ID</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Stock Price</th>
                                    <th class="text-center">Category</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $item)
                                    <tr class="table-light">
                                        <td class="text-center">{{$item->id}}</td>
                                        <td class="text-center">{{$item->brands->name}}</td>
                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->stocks}}</td>
                                        <td class="text-center">{{number_format($item->price_stocks, 2)}}</td>
                                        <td class="text-center">{{$item->categories->name}}</td>
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
