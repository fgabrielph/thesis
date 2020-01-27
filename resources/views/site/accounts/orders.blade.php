@extends('site.master')

@section('title') Orders @endsection

@section('content')

    {{--    @foreach($orders as $order)--}}

    {{--            {{$order->id}}--}}
    {{--            <br>--}}
    {{--            {{$order->order_number}}--}}

    {{--    @endforeach--}}

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Orders</h1>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="black white-text">
                    <tr>
                        <th scope="col">Order No.</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Order Amount</th>
                        <th scope="col">Qty.</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->order_number }}</th>
                            <td>{{ $order->first_name }}</td>
                            <td>{{ $order->last_name }}</td>
                            <td>{{ round($order->grand_total, 2) }}</td>
                            <td>{{ $order->item_count }}</td>
                            <td><h5>
                                <?php
                                if ($order->status == 0) {
                                    echo "<span class='badge badge-warning'>Pending";
                                } elseif ($order->status == 1) {
                                    echo "<span class='badge badge-info'>Processing";
                                } elseif ($order->status == 2) {
                                    echo "<span class='badge badge-success'>Completed";
                                } else {
                                    echo "<span class='badge badge-danger'>Canceled";
                                }
                                echo "</span>";
                                ?>
                                </h5>
                            </td>
                            <td>
                                <button type="button" data-toggle="dropdown" class="btn btn-sm btn-rounded btn-primary dropdown-toggle">Actions</button>
                                <div class="dropdown-menu">
                                    <a href="#" data-toggle="modal" data-target="#view{{$order->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                    <a href="#" data-toggle="modal" data-target="#edit{{$order->id}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> Edit</a>
                                </div>
                            </td>
                        </tr>
                        <div id="view{{$order->id}}" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">Order</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <h2 class="page-header"><i class="fa fa-globe"></i> {{ $order->order_number }}</h2>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-right">Date: {{ $order->created_at->toFormattedDateString() }}</h5>
                                            </div>
                                        </div>
                                        <div class="row invoice-info">
                                            <div class="col-4">Placed By
                                                <address><strong>{{ $order->user->name }}</strong><br>Email: {{ $order->user->email }}</address>
                                            </div>
                                            <div class="col-4">Ship To
                                                <address><strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>{{ $order->address }}<br>{{ $order->city }}, {{ $order->country }} {{ $order->post_code }}<br>{{ $order->phone_number }}<br></address>
                                            </div>
                                            <div class="col-4">
                                                <b>Order ID:</b> {{ $order->order_number }}<br>
                                                <b>Amount:</b> P {{ round($order->grand_total, 2) }}<br>
                                                <b>Payment Method:</b> {{ $order->payment_method }}<br>
                                                <b>Payment Status:</b> {{ $order->payment_status == 1 ? 'Completed' : 'Not Completed' }}<br>
                                                <b>Order Status:</b>
                                                <?php
                                                if ($order->status == 0) {
                                                    echo "Pending";
                                                } elseif ($order->status == 1) {
                                                    echo "Processing";
                                                } elseif ($order->status == 2) {
                                                    echo "Completed";
                                                } else {
                                                    echo "Canceled";
                                                }
                                                ?>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-12 table-responsive">--}}
{{--                                                            <table class="table table-striped">--}}
{{--                                                                <thead>--}}
{{--                                                                <tr>--}}
{{--                                                                    <th>Qty</th>--}}
{{--                                                                    <th>Product</th>--}}
{{--                                                                    <th>SKU #</th>--}}
{{--                                                                    <th>Qty</th>--}}
{{--                                                                    <th>Subtotal</th>--}}
{{--                                                                </tr>--}}
{{--                                                                </thead>--}}
{{--                                                                <tbody>--}}
{{--                                                                @foreach($order->orderItems as $item)--}}
{{--                                                                    <tr>--}}
{{--                                                                        <td>{{ $item->id }}</td>--}}
{{--                                                                        <td>{{ $item->item->name }}</td>--}}
{{--                                                                        <td>{{ $item->item->brand }}</td>--}}
{{--                                                                        <td>{{ $item->item->stocks }}</td>--}}
{{--                                                                        <td>P {{ round($item->price_stocks, 2) }}</td>--}}
{{--                                                                    </tr>--}}
{{--                                                                @endforeach--}}
{{--                                                                </tbody>--}}
{{--                                                            </table>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                    @empty
                        <div class="col-sm-12">
                            <p class="alert alert-warning">No orders to display.</p>
                        </div>
                    @endforelse
                    </tbody>
                </table>

            </div>

        </div>

    </div>


@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
