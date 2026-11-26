@props(['item'])

<div class="card h-100 shadow-sm">
    <a href="{{route('site.product', $item->id)}}" class="sf-product-image card-img-top">
        <img src="/assets/images/large_thumbnail/{{$item->image}}" alt="{{$item->name}}" />
    </a>

    <div class="card-body d-flex flex-column">
        <a class="h6 text-decoration-none mb-0" href="{{route('site.product', $item->id)}}">{{$item->name}}</a>

        <div class="mt-auto pt-2">
            <x-storefront.money :amount="$item->price_stocks" />
            <div class="small text-muted">Stocks: {{$item->stocks}}</div>
        </div>
    </div>

    <div class="card-footer bg-white border-0 pt-0">
        <button
            type="button"
            class="btn btn-primary w-100"
            data-bs-toggle="modal"
            data-bs-target="#addtocart{{$item->id}}"
        >
            Buy
        </button>
    </div>
</div>
