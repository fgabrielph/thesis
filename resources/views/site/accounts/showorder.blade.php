@extends ('site.layouts.storefront')

@section ('title') {{$order->order_number}} @endsection

@section ('content')
    <div class="sf-order-detail">
        <div class="card">
            <div class="card-header d-flex flex-column flex-sm-row justify-content-between gap-2">
                <h1 class="h4 mb-0">{{$order->order_number}}</h1>
                <span class="text-muted">{{$order->created_at->toFormattedDateString()}}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->suborder as $item)
                                <tr>
                                    <td>{{$item->item_id}}</td>
                                    <td>{{$item->item?->name}}</td>
                                    <td>{{$item->item?->brands?->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td><x-storefront.money :amount="$item->quantity * $item->price" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <strong>Total: <x-storefront.money :amount="$order->grand_total" /></strong>

                <div class="d-flex flex-wrap gap-2">
                    @if ($order->invoice_id)
                        <a href="{{route('invoice.show', $order->invoice_id)}}" class="btn btn-outline-secondary"
                            >View Invoice</a
                        >
                    @endif
                    @if ($order->payment_method === 'bank' && $order->status === 'Pending')
                        <a href="{{route('proof.add', $order->id)}}" class="btn btn-outline-secondary"
                            >{{ empty($order->image) ? 'Add' : 'Edit' }} proof of payment</a
                        >
                    @endif
                    <a href="{{route('orders.index')}}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
