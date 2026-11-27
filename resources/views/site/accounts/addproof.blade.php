@extends ('site.layouts.storefront')

@section ('title') Add Proof of Payment @endsection

@section ('content')
    <div class="sf-proof mx-auto" style="max-width: 720px">
        <div class="card">
            <div class="card-header fw-semibold">Upload Proof of Payment</div>

            <form action="{{route('proof.upload', $order->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method ('PUT')

                <div class="card-body">
                    @if ($order->image == null)
                        <img
                            id="img"
                            src="/assets/images/error-img.png"
                            class="img-fluid rounded mx-auto d-block mb-3"
                            alt="No proof uploaded"
                        />
                    @else
                        <img
                            id="img"
                            src="/assets/images/medium_thumbnail/{{$order->image}}"
                            class="img-fluid rounded mx-auto d-block mb-3"
                            alt="Current proof of payment"
                        />
                    @endif

                    <label for="imgInp" class="form-label">Upload image</label>
                    <input
                        name="image"
                        type="file"
                        class="form-control"
                        id="imgInp"
                        data-preview="#img"
                        accept="image/*"
                    />
                </div>

                <div class="card-footer d-flex flex-column flex-sm-row justify-content-between gap-2">
                    <a href="{{route('orders.index')}}" class="btn btn-outline-secondary">Go Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
