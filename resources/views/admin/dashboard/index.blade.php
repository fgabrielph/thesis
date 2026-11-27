@extends ('admin.master')

@section ('title') Dashboard @endsection

@section ('content')
    <section class="content">
        <div class="container-fluid">
            <br />
            @include ('admin.includes.messages')
            @if ($lowitem != 0)
                <div class="alert alert-danger alert-dismissible">
                    <a
                        href="{{route('admin.lowitems')}}"
                        class="btn btn-primary float-end"
                        style="text-decoration: none"
                        >View Now</a
                    >
                    <h4>There {{ $lowitem == 1 ? 'is' : 'are' }} {{ $lowitem }} {{ Str::plural('item', $lowitem) }} low in stock</h4>
                </div>
            @endif
            <x-ui.page-header
                :title="'Welcome, '.Auth::user()->name"
                subtitle="Here is the current order and inventory overview."
            />

            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <x-ui.stat-card
                        label="New Orders"
                        :value="count($orders)"
                        :href="route('admin_orders.index')"
                        icon="shopping-bag"
                        tone="info"
                    />
                </div>
                <div class="col-md-3 col-6">
                    <x-ui.stat-card
                        label="User Registrations"
                        :value="count($users)"
                        :href="route('customers.index')"
                        icon="user-plus"
                        tone="warning"
                    />
                </div>
                <div class="col-md-3 col-6">
                    <x-ui.stat-card
                        label="On Delivery"
                        :value="count($pending_deliveries)"
                        :href="route('deliveries.index')"
                        icon="truck"
                        tone="danger"
                    />
                </div>
                <div class="col-md-3 col-6">
                    <x-ui.stat-card
                        label="Returns"
                        :value="count($returns)"
                        :href="route('admin_orders.index')"
                        icon="truck-loading"
                        tone="secondary"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header">Item Updates</div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Stocks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Number of Items as per Category</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                {{-- <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"><i class="fas fa-times"></i></button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="barChart" style="height: 345px; min-height: 230px"></canvas>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales of Order</h3>
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
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales of Custom Order</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chart" class="chart">
                                <canvas id="CustomlineChart" style="height: 345px; min-height: 230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('barChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($categories as $cat)
                        @json ($cat->name),
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Number of Items',
                            data: [
                                @foreach ($categories as $cat)
                                '{{ $cat->items_count }}',
                                @endforeach
                            ],
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { beginAtZero: true },
                    },
                },
            });

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

            var ctx2 = document.getElementById('CustomlineChart').getContext('2d');
            var myChart2 = new Chart(ctx2, {
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
                                @foreach ($cust_sales as $cust_sale)
                                {{ $cust_sale }},
                                @endforeach
                            ],
                            borderColor: 'blue',
                            backgroundColor: 'blue',
                            borderWidth: 1,
                            fill: false,
                        },
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
