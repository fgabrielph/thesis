@extends ('site.layouts.storefront')

@section ('title') Order placed @endsection

@section ('content')
    <div class="sf-confirmation mx-auto" style="max-width: 720px">
        <div class="card text-center">
            <div class="card-body py-5">
                <h1 class="h3 mb-3">Order placed</h1>
                <p class="lead">Thank you. We received your order.</p>

                <p class="mb-1">
                    Order number:
                    <strong>{{$order->order_number}}</strong>
                </p>
                <p class="mb-1">
                    Total:
                    <x-storefront.money :amount="$order->grand_total" />
                </p>
                <p class="text-muted">
                    Payment method:
                    {{$order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer'}}
                </p>
            </div>

            <div class="card-footer d-flex flex-column flex-sm-row justify-content-center gap-2">
                <a href="{{route('orders.show', $order)}}" class="btn btn-primary">View order</a>
                <a href="{{route('site.shop')}}" class="btn btn-outline-secondary">Continue shopping</a>
            </div>
        </div>

        <div class="mt-4">
            <x-storefront.delivery-notice />
        </div>
    </div>
@endsection
