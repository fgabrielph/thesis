@extends('site.master')

@section('title') {{$item->name}} @endsection

@section('content')

    <!--Main layout-->
    <main class="mt-5 pt-4">


        <div class="container dark-grey-text mt-5">

        @include('site.includes.messages')

            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-md-6 mb-4 d-flex justify-content-center">

                    <img src="/storage/assets/images/large_thumbnail/{{$item->image}}" class="img-fluid" alt="">

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!--Content-->
                    <div class="p-4">

                        <p class="lead font-weight-bold">{{$item->name}}</p>

                        <p class="lead">
                            <span>₱ {{number_format($item->price_stocks, 2)}}</span>
                        </p>

                        <p class="lead font-weight-bold">Description</p>

                        <p>{{$item->description}}</p>

                        <p class="font-weight-normal">Stocks: {{$item->stocks}}</p>

                        {!!Form::open(['action' => 'CartController@store', 'method' => 'POST'])!!}
                        {{Form::hidden('id', $item->id)}}
                        {{Form::hidden('name', $item->name)}}
                        Quantity: {{Form::number('quantity', '', ['class' => 'form-control', 'placeholder' => '0', 'style' => 'width: 100px'])}}
                        {{Form::hidden('price', $item->price_stocks)}}<br>
                        <button class="btn btn-primary btn-md my-0 p" type="submit">Add to cart
                            <i class="fas fa-shopping-cart ml-1"></i>
                        </button>
                        {!!Form::close()!!}
                    </div>
                    <!--Content-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

            <hr>

            <a href="{{route('site.shop')}}" class="btn btn-lg" style="background-color: orange; color: white">Go Back</a>

            <!--Grid row-->
            <div class="row wow fadeIn">




            </div>
            <!--Grid row-->
            <hr>

        </div>
    </main>
    <!--Main layout-->

@endsection

@section('footer')
    @include('site.includes.footer')
@endsection
