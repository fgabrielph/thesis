@extends ('site.layouts.storefront')

@section ('title') Shop @endsection

@section ('content')
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 bg-dark text-white rounded p-3 mb-4"
    >
        <span class="fs-5">Not what you're looking for?</span>
        <a class="btn btn-primary" href="{{route('site.inquire')}}" role="button">Ask for a Quotation</a>
    </div>

    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="card">
                <div class="card-header fw-semibold">Categories</div>
                <div class="list-group list-group-flush">
                    @foreach ($categories as $category)
                        <a
                            class="list-group-item list-group-item-action"
                            href="{{route('site.categories', $category)}}"
                            >{{$category->name}}</a
                        >
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="col-lg-9">
            <h1 class="h4 mb-3">All Items</h1>

            <div class="row g-4">
                @forelse ($items as $item)
                    <div class="col-sm-6 col-lg-3">
                        <x-storefront.product-card :item="$item" />
                    </div>
                @empty
                    <p class="text-muted">No items found.</p>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">{{$items->links()}}</div>
        </div>
    </div>

    @foreach ($items as $item)
        <x-storefront.cart-modal :item="$item" />
    @endforeach
@endsection
