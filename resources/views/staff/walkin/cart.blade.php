@extends('staff.master')

@section('title') Cart @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Contents</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container wow fadeIn">
            <!-- Heading -->
            <h2 class="my-5 h2 text-center">Cart</h2>
        @include('site.includes.messages')

        @if(Cart::content()->count() > 0)

            <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-8">

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
                                                {{redirect()->route('walkin.index')->with('error', 'Exceeded!')}}
                                            @endif
                                            <td>
                                                <form action="{{route('staff_cart.update', $item->rowId)}}" method="post" role="form">
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
                                                <form action="{{ route('staff_cart.remove', $item->rowId) }}" method="POST">
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
                            <a href="{{ route('staff_cart.clear') }}" class="btn btn-danger btn-block mb-4">Clear Cart</a>
                        </h4>

                        <h3 class="d-flex justify-content-between">
                            <span><b>Total: </b></span>
                            <strong>₱{{Cart::total()}}</strong>
                        </h3>

                        <hr>
                        <a href="{{route('staff_checkout.index')}}" class="btn btn-success btn-lg btn-block">Proceed To Checkout</a>

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

            @else
                <center>
                    <h3>No items in Cart!</h3>
                    <a href="{{route('walkin.index')}}" class="btn btn-primary btn-rounded">Add Items to Cart</a>
                </center>
            @endif
        </div>
    </div>

@endsection
