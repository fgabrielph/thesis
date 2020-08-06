@extends('admin.master')

@section('title') Sales Report Monthy @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Sales</h1>
                    <p>Monthly Sales Reports</p>
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
                    <br>
                    <div class="card card-primary">

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
                    <!-- /.card -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Tabular
                            </div>
                            <div class="float-right">
                                <a href="{{route('export', 'sales')}}" class="btn btn-primary float-right">
                                    Export Table
                                </a>
                            </div><!-- /.col -->
                            <br>
                            <div class="card-body">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>Month</th>
                                        <th>Actual Sales</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i = 0; $i < count($sales); $i++)
                                        <tr class="text-center">
                                            <td><strong>{{$months[$i]}}</strong></td>
                                            <td><strong>PHP</strong> <i>{{number_format($sales[$i], 2)}}</i></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script>

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
    </script>


@endsection
