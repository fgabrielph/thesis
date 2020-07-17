@extends('site.master')

@section('title') {{ $order->order_number }} @endsection

@section('content')

    <br><br><br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{ $order->order_number }} </h1>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-responsive-lg">
                    <thead class="black white-text">
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody>
                    @foreach($order->suborder as $item)
                        <tr>
                            <td>{{$item->order_id}}</td>
                            <td>{{$item->item_id}}</td>
                            <td>{{$item->item->name}}</td>
                            <td>{{$item->item->brands->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->quantity * $item->price}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <h1 class="float-md-right">Total: {{ number_format($order->grand_total, 2) }}</h1>
            </div>

        </div>

        <br>
        @if(!($order->invoice_id == null))
            <a href="{{route('invoice.show', $order->invoice_id)}}" class="btn btn-primary"><span class="fas fa-receipt"></span> View Invoice</a>
        @endif

        <a href="{{route('orders.index')}}" class="btn btn-primary"> Go Back</a>
    </div>

    <br><br><br><br>

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
