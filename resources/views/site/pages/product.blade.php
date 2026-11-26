@extends ('site.layouts.storefront')

@section ('title') {{$item->name}} @endsection

@section ('content')
    <div class="row g-5 align-items-start">
        <div class="col-md-6">
            <div class="sf-product-detail-image">
                <img src="/assets/images/large_thumbnail/{{$item->image}}" alt="{{$item->name}}" />
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="h3 mb-2">{{$item->name}}</h1>
            <x-storefront.money :amount="$item->price_stocks" />

            <p class="mt-4">{{$item->description}}</p>
            <p class="text-muted">Stocks: {{$item->stocks}}</p>

            <form action="{{action('CartController@store')}}" method="POST" class="row g-3 align-items-end mt-2">
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}" />
                <input type="hidden" name="name" value="{{$item->name}}" />

                <div class="col-auto">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input
                        type="number"
                        class="form-control"
                        id="quantity"
                        name="quantity"
                        min="1"
                        value="{{old('quantity', 1)}}"
                        style="width: 110px"
                    />
                </div>

                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">
                        Add to cart
                        <i class="fas fa-shopping-cart ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-5" />

    <a href="{{route('site.shop')}}" class="btn btn-outline-secondary">Go Back</a>
@endsection
