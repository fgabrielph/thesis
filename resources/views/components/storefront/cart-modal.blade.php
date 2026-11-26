@props(['item'])

<div
    class="modal fade"
    id="addtocart{{$item->id}}"
    tabindex="-1"
    aria-labelledby="addtocartLabel{{$item->id}}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{action('CartController@store')}}" method="POST">
                @csrf

                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="addtocartLabel{{$item->id}}">{{$item->name}}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="sf-product-image">
                                <img src="/assets/images/large_thumbnail/{{$item->image}}" alt="{{$item->name}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-storefront.money :amount="$item->price_stocks" />
                            <p class="mt-3 mb-2">{{$item->description}}</p>
                            <p class="text-muted mb-3">Stocks: {{$item->stocks}}</p>

                            <label for="quantity-{{$item->id}}" class="form-label">Quantity</label>
                            <input
                                type="number"
                                class="form-control"
                                id="quantity-{{$item->id}}"
                                name="quantity"
                                min="1"
                                value="{{old('quantity', 1)}}"
                            />
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{$item->id}}" />
                    <input type="hidden" name="name" value="{{$item->name}}" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Buy Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
