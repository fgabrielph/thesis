@extends ('admin.master')

@section ('title') Forecasted Analysis @endsection

@section ('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Forecast</h1>
                    <p>Order Sales Forecasted</p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{route('analysis.orders')}}" class="btn btn-primary w-100">Go Back</a>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-12">
                    @include ('admin.includes.messages')
                    {{--                    <form action="{{route('forecast.orders', 'forecast')}}" method="POST">--}}
                    {{--                        @csrf--}}
                    {{--                        <div class="input-group mb-3" style="width: 20%;">--}}
                    {{--                            <div class="input-group-prepend">--}}
                    {{--                                <label class="input-group-text" for="inputGroupSelect01">Forecast</label>--}}
                    {{--                            </div>--}}
                    {{--                            <select class="form-select" id="inputGroupSelect01" name='forecast'>--}}
                    {{--                                <option selected value="1">Monthly</option>--}}
                    {{--                                <option value="3">Quarterly</option>--}}
                    {{--                                <option value="6">Semi-annually</option>--}}
                    {{--                                <option value="12">Annually</option>--}}
                    {{--                            </select>--}}
                    {{--                        </div>--}}
                    {{--                        <button type="submit" class="btn btn-primary">Submit</button>--}}
                    {{--                    </form>--}}

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Forecast Sales of Order (Simple Moving Average)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="lineChart" style="height: 345px; min-height: 230px"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx1 = document.getElementById('lineChart').getContext('2d');
            var myChart1 = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: [
                        'January',
                        'Febuary',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ],
                    datasets: [
                        {
                            label: 'Monthy Sales',
                            data: [
                                @foreach ($sales as $sale)
                                {{ $sale }},
                                @endforeach
                            ],
                            borderColor: 'blue',
                            backgroundColor: 'blue',
                            borderWidth: 1,
                            fill: false,
                        },
                        {
                            label: 'Forecasted Sale',
                            data: [
                                @foreach ($sales as $sale)
                                {{ $sale }},
                                @endforeach

                                @foreach ($forecasted as $forecast)
                                {{ $forecast }},
                                @endforeach
                            ],
                            borderColor: 'red',
                            backgroundColor: 'red',
                            borderWidth: 1,
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true },
                    },
                },
            });
        });
    </script>

@endsection
