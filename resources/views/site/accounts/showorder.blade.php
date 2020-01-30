@extends('site.master')

@section('title') {{ $order->order_number }} @endsection

@section('content')

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
                            <td>{{$item->quantity * $item->item->price_stocks}}</td>
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
        <a href="{{route('invoice.show', $order->invoice_id)}}" class="btn btn-primary"><span class="fas fa-receipt"></span> View Invoice</a>
        <a href="{{route('orders.index')}}" class="btn btn-primary"> Go Back</a>
    </div>

    <br>

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
