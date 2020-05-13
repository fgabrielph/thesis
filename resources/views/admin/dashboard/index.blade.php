@extends('admin.master')

@section('title') Dashboard @endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <br>
            @include('admin.includes.messages')
            @if($lowitem != 0)
            <div class="alert alert-danger alert-dismissible">
                <a href="{{route('admin.lowitems')}}" class="btn btn-primary float-right" style="text-decoration: none">View Now</a>
                <h4>There are {{$lowitem}} item(s) low in stock</h4>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h1>WELCOME {{ Auth::user()->name }}</h1>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3 col-6">
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
                <div class="col-md-3 col-6">
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

{{--                <div class="col-md-3 col-6">--}}
{{--                    <!-- small box -->--}}
{{--                    <div class="small-box bg-warning">--}}
{{--                        <div class="inner">--}}
{{--                            <h3>{{$lowitem}}</h3>--}}

{{--                            <p>Inventory Alert</p>--}}
{{--                        </div>--}}
{{--                        <div class="icon">--}}
{{--                            <i class="fas fa-boxes"></i>--}}
{{--                        </div>--}}
{{--                        <a href="{{route('customers.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- ./col -->
                <div class="col-md-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{count($pending_deliveries)}}</h3>
                            <p>On Delivery</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="{{route('deliveries.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-md-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{count($returns)}}</h3>
                            <p>Returns</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <a href="{{route('deliveries.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

                <div class="col-lg-8 col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Number of Items as per Category</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="barChart" style="height:345px; min-height:230px"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- BAR CHART -->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Sales of Order</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="lineChart" style="height:345px; min-height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Sales of Custom Order</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="CustomlineChart" style="height:345px; min-height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script>

        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [
                    @foreach($categories as $cat)
                         '{{ $cat->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Number of Items',
                    data: [
                        @foreach($categories as $cat)
                            '{{ $cat->items_count }}',
                        @endforeach
                    ],
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    borderWidth         : 1,
                }]
            },
            options: {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx1 = document.getElementById('lineChart').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Monthy Sales',
                    data: [
                        @foreach($sales as $sale)
                            {{ $sale }},
                        @endforeach
                    ],
                    borderColor         : 'blue',
                    backgroundColor         : 'blue',
                    borderWidth         : 1,
                    fill               : false
                },
                {{--    {--}}
                {{--    label: 'Forecasted Sale',--}}
                {{--    data: [--}}
                {{--        @foreach($sales as $sale)--}}
                {{--        {{ $sale }},--}}
                {{--        @endforeach--}}

                {{--        @foreach($forecasted as $forecast)--}}
                {{--        {{ $forecast }},--}}
                {{--        @endforeach--}}
                {{--    ],--}}
                {{--    borderColor        : 'red',--}}
                {{--    backgroundColor         : 'red',--}}
                {{--    borderWidth        : 1,--}}
                {{--    fill               : false--}}
                {{--}--}}
                ]
            },
            options: {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById('CustomlineChart').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Monthy Sales',
                    data: [
                        @foreach($cust_sales as $cust_sale)
                        {{ $cust_sale }},
                        @endforeach
                    ],
                    borderColor         : 'blue',
                    backgroundColor         : 'blue',
                    borderWidth         : 1,
                    fill               : false
                }
                {{--, {--}}
                {{--    label: 'Forecasted Sale',--}}
                {{--    data: [--}}
                {{--        @foreach($cust_sales as $cust_sale)--}}
                {{--        {{ $cust_sale }},--}}
                {{--        @endforeach--}}

                {{--        @foreach($cust_forecasted as $cust_forecast)--}}
                {{--        {{ $cust_forecast }},--}}
                {{--        @endforeach--}}
                {{--    ],--}}
                {{--    borderColor        : 'red',--}}
                {{--    backgroundColor         : 'red',--}}
                {{--    borderWidth        : 1,--}}
                {{--    fill               : false--}}
                {{--}--}}
                ]
            },
            options: {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

@endsection

