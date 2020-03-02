@extends('site.master')

@section('title') Custom Order @endsection

@section('content')

    <div class="container">
        @include('site.includes.messages')
        <div class="card">
            <div class="card-header">
                <h1>Custom Orders</h1>
            </div>
            <div class="card-body">
                <table class="table text-center table-responsive table-bordered">
                    <thead class="black white-text">
                    <tr>
                        <th scope="col">Custom Order No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Created At</th>
                        <th scope="col"><i class="fas fa-bolt"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($custom_orders as $order)
                        <tr>
                            <td><h5>{{$order->id}}</h5></td>
                            <td><h6>{{$order->name}}</h6></td>
                            <td><h6>{{$order->description}}</h6></td>
                            <td><img src="/assets/images/{{$order->image}}" width="40%"></td>
                            <td><h5>@if($order->status == 0)
                                        <span class='badge badge-info'>Processing</span>
                                    @elseif($order->status == 1)
                                        <span class='badge badge-info'>Accepted</span>
                                    @elseif($order->status == 2)
                                        <span class='badge badge-danger'>Declined</span>
                                    @endif
                                </h5>
                            </td>
                            <td>
                                <h5>@if($order->payment_status == 0 && $order->status == 2)
                                        <span class='badge badge-danger'>Declined Order</span>
                                    @elseif($order->payment_status == 0)
                                        <span class='badge badge-danger'>Not yet Paid</span>
                                    @elseif($order->payment_status == 2)
                                        <span class='badge badge-warning'>Pending for Approval</span>
                                    @elseif($order->payment_status == 1)
                                        <span class='badge badge-info'>Paid</span>
                                    @endif
                                </h5>
                            </td>
                            <td><h5>{{$order->created_at->toFormattedDateString()}}</h5></td>
                            <td><a href="{{route('custom_order.show', $order->id)}}" class="btn btn-lg btn-primary"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
