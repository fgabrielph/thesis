@extends('site.master')

@section('title') Cart @endsection

@section('content')

    <br><br>
    <div class="container wow fadeIn">
        <!-- Heading -->
        <h2 class="my-5 h2 text-center">Cart</h2>
    @include('site.includes.messages')

    @if(Cart::content()->count() > 0)

        <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-8 mb-4">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                            <!--Table-->
                            <table class="table table-hover table-fixed table-responsive">

                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th><p></p></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Cart::content() as $item)
                                    <tr>
                                        <td>{{$item->model->id}}</td>
                                        <td><img src="/assets/images/large_thumbnail/{{$item->model->image}}" alt="pic" width="100px"></td>
                                        <td>{{$item->model->name}}</td>
                                        @if($item->qty > $item->model->stocks)
                                            {{redirect()->route('site.shop')->with('error', 'Exceeded!')}}
                                        @endif
                                        <td>
                                            <form action="{{route('cart.update', $item->rowId)}}" method="post" role="form">
                                                {{method_field('PUT')}}
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="hidden" name="proID" value="{{$item->id}}" />
                                                <input type="number" size="2" value="{{$item->qty}}" name="qty" style="width: 90px">
                                                <input type="submit" class="btn btn-sm btn-primary" value="Update" style="margin: 5px">
                                            </form>

                                        </td>
                                        <td>₱{{number_format($item->model->price_stocks, 2)}}</td>
                                        <td>₱{{number_format($item->qty * $item->model->price_stocks, 2)}}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <!--Table body-->

                            </table>
                            <!--Table-->

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->


                <!--Grid column-->
                <div class="col-md-4 mb-4">

                    <!-- Heading -->
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('cart.clear') }}" class="btn btn-danger btn-block mb-4">Clear Cart</a>
                    </h4>

                    <h3 class="d-flex justify-content-between">
                        <span><b>Total: </b></span>
                        <strong>₱{{Cart::total()}}</strong>
                    </h3>

                    <hr>
                    <a href="{{route('checkout.index')}}" class="btn btn-success btn-lg btn-block">Proceed To Checkout</a>

                    <figure class="itemside">
                        <div class="row">
                            <div class="col-md-4">
                                <aside class="aside"><img src="/assets/images/COD.png"></aside>
                            </div>
                            <div class="col-md-4">
                                <aside class="aside"><img src="/assets/images/paypal.png"></aside>
                            </div>
                            <div class="col-md-4">
                                <aside class="aside"><img src="/assets/images/pay-bank.png"></aside>
                            </div>
                        </div>

                    </figure>

                    <p style="color: red; font-size: 20px;"><i><strong>* Free delivery within metro manila. For Shipping outside Metro Manila please contact 364-8556 or email  <a href="mailto:mjctrdgmfg@gmail.com">mjctrdgmfg@gmail.com</a></strong></i></p>

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        @else

        <center>
            <h3>Oh no!</h3>
            <img src="/assets/images/emptycart.png" alt="Empty" style="width:50%;"><br>
            <a href="{{route('site.shop')}}" class="btn btn-primary btn-rounded">Continue Shopping</a>
        </center>
        @endif


    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
