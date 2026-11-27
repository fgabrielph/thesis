@extends ('site.layouts.storefront')

@section ('title') Orders @endsection

@section ('content')
    <div class="sf-orders">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <h1 class="h3 mb-0">Orders</h1>
            <a href="{{route('custom_order.index')}}" class="btn btn-outline-secondary">Custom Orders</a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Order No.</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Qty.</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>{{$order->first_name}} {{$order->last_name}}</td>
                                    <td><x-storefront.money :amount="$order->grand_total" /></td>
                                    <td>{{$order->item_count}}</td>
                                    <td>
                                        @if ($order->status == 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($order->status == 'Canceled')
                                            <span class="badge bg-danger">Declined</span>
                                        @elseif ($order->status == 'Confirmed')
                                            <span class="badge text-dark" style="background-color: greenyellow"
                                                >Confirmed</span
                                            >
                                        @elseif ($order->status == 'Return')
                                            <span class="badge bg-secondary">Returned</span>
                                        @elseif ($order->status == 'On Delivery')
                                            <span class="badge bg-secondary">On Delivery</span>
                                        @elseif ($order->status == 'Completed')
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-primary dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{route('orders.show', $order->id)}}" class="dropdown-item"
                                                        >View details</a
                                                    >
                                                </li>
                                                @if ($order->status == 'Pending' && $order->payment_method == 'bank')
                                                    <li>
                                                        <a href="{{route('proof.add', $order->id)}}" class="dropdown-item"
                                                            >{{ empty($order->image) ? 'Add' : 'Edit' }} proof of payment</a
                                                        >
                                                    </li>
                                                @endif
                                                @if ($order->payment_status == 0 && $order->payment_method == 'cod' && $order->status != 'Canceled')
                                                    <li><hr class="dropdown-divider" /></li>
                                                    <li>
                                                        <form
                                                            action="{{route('orders.update', $order->id)}}"
                                                            method="POST"
                                                            onsubmit="return confirm('Cancel this order?')"
                                                        >
                                                            @csrf
                                                            @method ('PUT')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                >Cancel order</button
                                                            >
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
