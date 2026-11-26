@extends ('site.layouts.storefront')

@section ('title') Cart @endsection

@section ('content')
    <h1 class="h3 text-center mb-4">Cart</h1>

    @if (Cart::content()->count() > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card sf-cart-card">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col"><span class="visually-hidden">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img
                                                    src="/assets/images/large_thumbnail/{{$item->model->image}}"
                                                    alt="{{$item->model->name}}"
                                                    class="sf-cart-thumb rounded"
                                                />
                                                <span>{{$item->model->name}}</span>
                                            </div>
                                        </td>
                                        <td><x-storefront.money :amount="$item->price" /></td>
                                        <td>
                                            <form
                                                action="{{route('cart.update', $item->rowId)}}"
                                                method="POST"
                                                class="d-flex align-items-center gap-2"
                                            >
                                                @csrf
                                                @method ('PUT')
                                                <input type="hidden" name="proID" value="{{$item->id}}" />
                                                <input
                                                    type="number"
                                                    name="qty"
                                                    value="{{$item->qty}}"
                                                    min="1"
                                                    class="form-control form-control-sm"
                                                    style="width: 90px"
                                                    aria-label="Quantity for {{$item->model->name}}"
                                                />
                                                <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                    >Update</button
                                                >
                                            </form>
                                        </td>
                                        <td>
                                            <x-storefront.money :amount="$item->qty * $item->price" />
                                        </td>
                                        <td>
                                            <form action="{{route('cart.remove', $item->rowId)}}" method="POST">
                                                @csrf
                                                @method ('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <x-storefront.order-summary :items="Cart::content()" :total="Cart::total()" />

                <div class="d-grid gap-2 mt-3">
                    <a href="{{route('checkout.index')}}" class="btn btn-primary btn-lg">Proceed to checkout</a>
                    <a href="{{route('cart.clear')}}" class="btn btn-outline-danger">Clear cart</a>
                </div>

                <div class="d-flex justify-content-center gap-4 mt-3">
                    <img src="/assets/images/COD.png" alt="Cash on delivery" class="img-fluid" style="max-height: 48px" />
                    <img src="/assets/images/pay-bank.png" alt="Bank transfer" class="img-fluid" style="max-height: 48px" />
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h2 class="h4">Oh no!</h2>
            <img src="/assets/images/emptycart.png" alt="Empty cart" class="img-fluid my-4" style="max-width: 320px" />
            <div>
                <a href="{{route('site.shop')}}" class="btn btn-primary">Continue shopping</a>
            </div>
        </div>
    @endif
@endsection
