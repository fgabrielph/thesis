@extends('admin.master')

@section('title') Dashboard @endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <br>
            <div class="card">
                <div class="card-header">
                    <h1>WELCOME {{ Auth::user()->name }}</h1>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{count($orders)}}</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('admin_orders.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{count($users)}}</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('customers.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{count($pending_deliveries)}}</h3>
                            <p>Pending Deliveries</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header">
                            Item Updates
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Stocks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->stocks}}</td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('items.index')}}" class="btn btn-primary">Check Inventory</a>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </section>

@endsection
