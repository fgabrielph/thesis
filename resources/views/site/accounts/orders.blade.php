@extends('site.master')

@section('title') Orders @endsection

@section('content')

    <div class="container">
        @include('site.includes.messages')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-md-6 text-right">
                        <h1><a href="{{route('custom_order.index')}}" class="btn btn-lg blue-gradient">Custom Orders</a></h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="defTable" class="table">
                    <thead class="black white-text">
                    <tr class="text-center">
                        <th scope="col">Order No.</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Order Amount</th>
                        <th scope="col">Qty.</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
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
                                    @if($order->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status == 'Canceled')
                                        <span class="badge bg-danger">Declined</span>
                                    @elseif($order->status == 'Confirmed')
                                        <span class="badge" style="background-color: greenyellow">Confirmed</span>
                                    @elseif($order->status == 'Return')
                                        <span class="badge bg-secondary">Returned</span>
                                    @elseif($order->status == 'On Delivery')
                                        <span class="badge bg-secondary">On Delivery</span>
                                    @elseif($order->status == 'Completed')
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </h5>
                            </td>
                            <td><h5>{{$order->created_at->toFormattedDateString()}}</h5></td>
                            <td>
                                <button type="button" data-toggle="dropdown" class="btn btn-md btn-rounded btn-primary dropdown-toggle">Actions</button>
                                <div class="dropdown-menu">
                                    <a href="#" data-toggle="modal" data-target="#view{{$order->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                    <a href="{{route('orders.show', $order->id)}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> View Detailed</a>
                                    @if($order->payment_status == 0 && $order->payment_method == 'cod' && $order->status != 'Canceled')
                                        <a href="#" data-toggle="modal" data-target="#cancel{{$order->id}}" class="dropdown-item"><span class="fas fa-times"></span> Cancel</a>
                                    @endif
                                    @if($order->status == 'Pending' && $order->payment_method == 'bank')
                                        @if(!(empty($order->image)) && $order->payment_status == 0)
                                            <a href="{{route('proof.add', $order->id)}}" class="dropdown-item"><span class="fas fa-pen"></span> Edit Proof of Payment</a>
                                        @else
                                            <a href="{{route('proof.add', $order->id)}}" class="dropdown-item"><span class="fas fa-plus"></span> Add Proof of Payment</a>
                                        @endif
                                    @endif
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
                                                <b>Order Status:</b>
                                                <?php
                                                    if($order->status == 'WaitingForPayment') {
                                                        echo 'Waiting for Payment';
                                                    } else {
                                                        echo $order->status;
                                                    }
                                                ?>
                                                <br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="cancel{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                             aria-hidden="true">

                            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
                            <div class="modal-dialog modal-dialog-centered" role="document">


                                <div class="modal-content">
                                    <form action="{{route('orders.update', $order->id)}}" class="form-horizontal" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLongTitle">Are you sure you want to Cancel?</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-lg btn-success">Yes</button>
                                        </div>
                                        <input type="hidden" name="_method" type="hidden" value="PUT">
                                    </form>
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
        <br>
{{--        <div class="d-flex justify-content-center">--}}
{{--            {{$orders->links()}}--}}
{{--        </div>--}}

    </div>




@endsection

@section('footer')

{{--    <!--Footer-->--}}
{{--    <footer class="page-footer text-center font-small mt-4 wow fadeIn fixed-bottom">--}}

{{--        <div class="orange">--}}
{{--            <!--Call to action-->--}}
{{--            <div class="pt-3">--}}
{{--                <a class="btn purple-gradient waves-effect waves-light" href="{{route('site.inquire')}}" role="button">Inquire Now</a>--}}
{{--                <a class="btn btn-outline-white" href="{{route('contact')}}" role="button">Contacts</a>--}}
{{--            </div>--}}
{{--            <!--/.Call to action-->--}}


{{--            <!--Copyright-->--}}
{{--            <div class="footer-copyright py-3 black">--}}
{{--                © 2019 Copyright:--}}
{{--                <a href="#" target="_blank"> New MJC </a>--}}
{{--            </div>--}}
{{--            <!--/.Copyright-->--}}

{{--        </div>--}}


{{--    </footer>--}}
{{--    <!--/.Footer-->--}}

@include('site.includes.footer')

@endsection
