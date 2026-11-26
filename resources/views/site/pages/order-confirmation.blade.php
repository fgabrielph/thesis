@extends ('site.master')

@section ('title') Order placed @endsection

@section ('content')
    <br /><br /><br />
    <div class="container">
        <div class="card text-center">
            <div class="card-body py-5">
                <h2 class="mb-3">Order placed</h2>
                <p class="lead">Thank you. We received your order.</p>

                <p class="mb-1">
                    Order number:
                    <strong>{{$order->order_number}}</strong>
                </p>
                <p class="mb-1">
                    Total:
                    <strong>₱ {{number_format($order->grand_total, 2)}}</strong>
                </p>
                <p class="text-muted">
                    Payment method:
                    {{$order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer'}}
                </p>
            </div>

            <div class="card-footer">
                <a href="{{route('orders.show', $order)}}" class="btn btn-primary">View order</a>
                <a href="{{route('site.shop')}}" class="btn btn-outline-primary">Continue shopping</a>
            </div>
        </div>

        <div class="mt-4">
            @include ('site.includes.delivery-notice')
        </div>
    </div>
@endsection

@section ('footer')
    @include ('site.includes.footer')
@endsection
