@extends('site.master')

@section('title') Orders @endsection

@section('content')

    {{--    @foreach($orders as $order)--}}

    {{--            {{$order->id}}--}}
    {{--            <br>--}}
    {{--            {{$order->order_number}}--}}

    {{--    @endforeach--}}

    <div class="container">
        @include('site.includes.messages')
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
                        <th scope="col"><i class="fas fa-bolt"></i></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row"><h4>{{ $order->order_number }}</h4></th>
                            <td><h5>{{ $order->first_name }}</h5></td>
                            <td><h5>{{ $order->last_name }}</h5></td>
                            <td><h5>{{ number_format($order->grand_total, 2) }}</h5></td>
                            <td><h5>{{ $order->item_count }}</h5></td>
                            <td><h5>
                                <?php
                                if ($order->status == 'Pending') {
                                    echo "<span class='badge badge-warning'>Pending";
                                } elseif ($order->status == 'Processing') {
                                    echo "<span class='badge badge-info'>Processing";
                                } elseif ($order->status == 'Completed') {
                                    echo "<span class='badge badge-success'>Completed";
                                } elseif ($order->status == 'Accepeted') {
                                    echo "<span class='badge badge-success'>Accepted";
                                } elseif ($order->status == 'Return') {
                                    echo "<span class='badge badge-secondary'>Return";
                                } elseif ($order->status == 'Initialised') {
                                    echo "<span class='badge badge-primary'>Placed";
                                } else {
                                    echo "<span class='badge badge-danger'>Canceled";
                                }
                                echo "</span>";
                                ?>
                                </h5>
                            </td>
                            <td>
                                <button type="button" data-toggle="dropdown" class="btn btn-md btn-rounded btn-primary dropdown-toggle">Actions</button>
                                <div class="dropdown-menu">
                                    <a href="#" data-toggle="modal" data-target="#view{{$order->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                    <a href="{{route('orders.show', $order->id)}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> View Detailed</a>
                                </div>
                            </td>
                        </tr>
                        <div id="view{{$order->id}}" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">Order</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <h2 class="page-header"><i class="fa fa-globe"></i> {{ $order->order_number }}</h2>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-right">Date: {{ $order->created_at->toFormattedDateString() }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Placed By
                                                <address><strong>{{ $order->user->name }}</strong><br>Email: {{ $order->user->email }}</address>
                                            </div>
                                            <div class="col-4">Ship To
                                                <address><strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>{{ $order->address }}<br>{{ $order->city }}, {{ $order->country }} {{ $order->post_code }}<br>{{ $order->phone_number }}<br></address>
                                            </div>
                                            <div class="col-4">
                                                <b>Order ID:</b> {{ $order->id }}<br>
                                                <b>Amount:</b> P {{ number_format($order->grand_total, 2) }}<br>
                                                <b>Payment Method:</b> {{ $order->payment_method }}<br>
                                                <b>Payment Status:</b> {{ $order->payment_status == 1 ? 'Completed' : 'Not Completed' }}<br>
                                                <b>Order Status:</b> {{$order->status}}<br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!--Footer-->
    <footer class="page-footer text-center font-small mt-4 wow fadeIn fixed-bottom">

        <div class="orange">
            <!--Call to action-->
            <div class="pt-3">
                <a class="btn btn-outline-white" href="#" role="button">Inquire Now</a>
                <a class="btn btn-outline-white" href="#" role="button">Contacts</a>
            </div>
            <!--/.Call to action-->


            <!--Copyright-->
            <div class="footer-copyright py-3 black">
                © 2019 Copyright:
                <a href="#" target="_blank"> New MJC </a>
            </div>
            <!--/.Copyright-->

        </div>


    </footer>
    <!--/.Footer-->

@endsection
