@props(['items', 'total'])

<div class="card sf-order-summary">
    <div class="card-header fw-semibold">Order summary</div>

    <ul class="list-group list-group-flush">
        @foreach ($items as $item)
            <li class="list-group-item d-flex justify-content-between gap-3">
                <div>
                    <div>{{$item->name}}</div>
                    <small class="text-muted">pcs. ×{{$item->qty}}</small>
                </div>
                <x-storefront.money :amount="$item->qty * $item->price" />
            </li>
        @endforeach

        <li class="list-group-item d-flex justify-content-between fw-semibold">
            <span>Total</span>
            <x-storefront.money :amount="$total" />
        </li>
    </ul>

    <div class="card-body">
        <x-storefront.delivery-notice />
    </div>
</div>
