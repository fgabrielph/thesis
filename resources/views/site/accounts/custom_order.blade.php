@extends ('site.layouts.storefront')

@section ('title') Custom Orders @endsection

@section ('content')
    <div class="sf-custom-orders">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <h1 class="h3 mb-0">Custom Orders</h1>
            <a href="{{route('site.inquire')}}" class="btn btn-primary">Request a Quote</a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($custom_orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->name}}</td>
                                    <td class="text-truncate" style="max-width: 240px">{{$order->description}}</td>
                                    <td>
                                        @if ($order->status == 0)
                                            <span class="badge bg-info text-dark">Processing</span>
                                        @elseif ($order->status == 1)
                                            <span class="badge bg-info text-dark">Accepted</span>
                                        @elseif ($order->status == 2)
                                            <span class="badge bg-danger">Declined</span>
                                        @elseif ($order->status == 3)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif ($order->status == 4)
                                            <span class="badge bg-warning text-dark">On Delivery</span>
                                        @elseif ($order->status == 5)
                                            <span class="badge bg-dark">Delivered</span>
                                        @elseif ($order->status == 6)
                                            <span class="badge bg-light text-dark">Return</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->payment_status == 0 && $order->status == 2)
                                            <span class="badge bg-danger">Declined Order</span>
                                        @elseif ($order->payment_status == 0)
                                            <span class="badge bg-danger">Not yet Paid</span>
                                        @elseif ($order->payment_status == 2)
                                            <span class="badge bg-warning text-dark">Pending for Approval</span>
                                        @elseif ($order->payment_status == 1)
                                            <span class="badge bg-info text-dark">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>
                                    <td class="text-center">
                                        <a href="{{route('custom_order.show', $order->id)}}" class="btn btn-sm btn-primary"
                                            >View</a
                                        >
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No custom orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
