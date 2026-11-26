@extends('admin.master')

@section('title') Demand Analysis @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Custom Orders</h1>
                    <p>Demand of Custom Orders</p>
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
                    <form action="{{route('forecast.demand', 'forecast')}}" method="POST">
                        @csrf
                        <div class="input-group mb-3" style="width: 20%;">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Forecast</label>
                            </div>
                            <select class="form-select" id="inputGroupSelect01" name='forecast'>
                                <option selected value="0">Next Month</option>
                                <option selected value="1">2 Month</option>
                                <option value="3">Quarterly</option>
                                <option value="6">Semi-annually</option>
                                <option value="12">Annually</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <br>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Demand of Custom Order</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="barChart" style="height:345px; min-height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Tabular
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>Month</th>
                                        <th>Demand</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i = 0; $i < count($demand); $i++)
                                        <tr class="text-center">
                                            <td>{{$months[$i]}}</td>
                                            <td>{{$demand[$i]}}</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var ctx1 = document.getElementById('barChart').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Monthy Demands',
                    data: [
                        @foreach($demand as $d)
                        {{ $d }},
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
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Remove decimal points when the value is a whole number.
                            callback: function (value) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });

        });
    </script>


@endsection
