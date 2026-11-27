@extends ('site.layouts.storefront')

@section ('title') Custom Order {{$custom_order->id}} @endsection

@section ('content')
    <div class="sf-custom-order">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if ($custom_order->quantity == null && $custom_order->status == 0 && $custom_order->completed == null)
                            <h2 class="h5 mb-0">No quantity yet</h2>
                        @elseif ($custom_order->quantity == null && $custom_order->status != 2)
                            <h2 class="h5 mb-0">In progress</h2>
                        @elseif ($custom_order->status == 2)
                            <h2 class="h5 mb-0 text-danger">This order is canceled</h2>
                        @elseif (empty($custom_order->completed))
                            <h2 class="h5 mb-0">0 / {{$custom_order->quantity}}, in progress</h2>
                        @else
                            <h2 class="h5 mb-0">{{$custom_order->completed}} out of {{$custom_order->quantity}} completed</h2>
                        @endif
                    </div>
                </div>

                @if ($custom_order->status == 1)
                    <div class="card mt-4">
                        <div class="card-body">
                            @if ($custom_order->price != null)
                                @if (!(empty($custom_order->payment_method)))
                                    @if (!(empty($custom_order->proof_image)) && $custom_order->payment_status == 2)
                                        <form
                                            action="{{route('custom_order.payment', $custom_order->id)}}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >
                                            @csrf
                                            @method ('PUT')

                                            <img
                                                src="/assets/images/{{$custom_order->proof_image}}"
                                                class="img-fluid rounded mb-3"
                                                alt="Proof of payment"
                                            />

                                            <label for="custom-proof" class="form-label">Upload new proof</label>
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="custom-proof"
                                                name="image"
                                                data-preview="#custom-proof-image"
                                            />
                                            <img id="custom-proof-image" src="" class="img-fluid rounded mt-3 d-none" alt="" />

                                            <button class="btn btn-primary w-100 mt-3" type="submit">Proceed</button>
                                        </form>
                                    @elseif ($custom_order->payment_method == 'cod')
                                        <p class="text-center mb-0">Your payment method is waiting for approval.</p>
                                    @endif
                                @endif
                            @else
                                <p class="text-center mb-0"><strong>No price has been placed yet.</strong></p>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($custom_order->status == 1 && $custom_order->price != null && empty($custom_order->payment_method))
                    <div class="card mt-4">
                        <div class="card-body">
                            <form
                                action="{{route('custom_order.payment', $custom_order->id)}}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf
                                @method ('PUT')

                                <fieldset class="mb-3">
                                    <legend class="form-label fs-6">Payment method</legend>

                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="payment_method"
                                            id="credit"
                                            value="cod"
                                            required
                                        />
                                        <label class="form-check-label" for="credit">Cash on Delivery</label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="payment_method"
                                            id="bank"
                                            value="bank"
                                            required
                                        />
                                        <label class="form-check-label" for="bank">Bank Transfer</label>
                                    </div>
                                </fieldset>

                                <div id="bankt" hidden>
                                    @if (empty($custom_order->proof_image))
                                        <img
                                            id="custom-proof-image"
                                            src="/assets/images/error-img.png"
                                            class="img-fluid rounded mb-3"
                                            alt="Proof preview"
                                        />
                                    @else
                                        <img
                                            id="custom-proof-image"
                                            src="/assets/images/{{$custom_order->proof_image}}"
                                            class="img-fluid rounded mb-3"
                                            alt="Proof of payment"
                                        />
                                    @endif

                                    <label for="custom-proof" class="form-label">Upload proof</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="custom-proof"
                                        name="image"
                                        data-preview="#custom-proof-image"
                                    />
                                </div>

                                <button class="btn btn-primary w-100 mt-3" type="submit">Proceed</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h4 mb-0">Order number: {{$custom_order->id}}</h1>
                    </div>

                    <div class="card-body">
                        <p><strong>Placed by:</strong> {{$custom_order->user->name}}</p>

                        <p>
                            <strong>Payment status:</strong>
                            @if ($custom_order->payment_status == 0 && $custom_order->status == 2)
                                <span class="badge bg-danger">Declined Order</span>
                            @elseif ($custom_order->payment_status == 0)
                                <span class="badge bg-danger">Not yet Paid</span>
                            @elseif ($custom_order->payment_status == 2)
                                <span class="badge bg-warning text-dark">Pending for Approval</span>
                            @else
                                <span class="badge bg-success">Paid</span>
                            @endif
                        </p>

                        <p>
                            <strong>Status:</strong>
                            @if ($custom_order->status == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($custom_order->status == 1)
                                <span class="badge bg-success">Accepted</span>
                            @elseif ($custom_order->status == 2)
                                <span class="badge bg-danger">Declined</span>
                            @elseif ($custom_order->status == 3)
                                <span class="badge bg-success">Completed</span>
                            @elseif ($custom_order->status == 4)
                                <span class="badge bg-warning text-dark">On Delivery</span>
                            @elseif ($custom_order->status == 5)
                                <span class="badge bg-dark">Delivered</span>
                            @elseif ($custom_order->status == 6)
                                <span class="badge bg-light text-dark">Return</span>
                            @endif
                        </p>

                        <p><strong>Contact number:</strong> {{$custom_order->user->mobile_number}}</p>

                        <p class="mb-1"><strong>Description:</strong></p>
                        <p>{{$custom_order->description}}</p>

                        <p class="mb-0">
                            <strong>Total price:</strong>
                            @if (empty($custom_order->price))
                                N/A
                            @else
                                <x-storefront.money :amount="$custom_order->price" />
                            @endif
                        </p>
                    </div>

                    <div class="card-footer d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <span class="text-muted">Created at {{$custom_order->created_at->toFormattedDateString()}}</span>
                        <a href="{{route('custom_order.index')}}" class="btn btn-primary">Go Back</a>
                    </div>
                </div>

                @if ($custom_order->image)
                    <div class="card mt-4">
                        <div class="card-header fw-semibold">Reference image</div>
                        <div class="card-body text-center">
                            <a href="#imageModal" data-bs-toggle="modal">
                                <img src="/assets/images/{{$custom_order->image}}" class="img-fluid rounded" alt="Custom order reference" />
                            </a>
                        </div>
                    </div>

                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5" id="imageModalLabel">Reference image</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="/assets/images/{{$custom_order->image}}" class="img-fluid" alt="Custom order reference" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
