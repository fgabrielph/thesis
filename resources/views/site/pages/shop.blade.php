@extends('site.master')

@section('title') Shop @endsection

@section('content')

        <!--Navbar-->
            <ul style="padding-left: 50%;">
                {{$categories->links()}}
            </ul>
        <nav class="navbar navbar-expand-lg navbar-dark mdb-color black mt-3 mb-5">

            <!-- Navbar brand -->
            <span class="navbar-brand">Categories:</span>

            <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">

                <!-- Links -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">All
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('site.categories', $category->id)}}" >{{$category->name}} &nbsp; |</a>
                        </li>
                    @endforeach
                </ul>
                <!-- Links -->

                <form class="form-inline">
                    <div class="md-form my-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    </div>
                </form>
            </div>
            <!-- Collapsible content -->

        </nav>
        <!--/.Navbar-->

    <div class="container card">
        <br>
        <section class="text-center mb-4">

            <!--Grid row-->
            <div class="row wow fadeIn">
            @foreach($items as $item)
                <!--Grid column-->

                    <div class="col-lg-3 col-md-6 mb-4">

                        <!--Card-->
                        <div class="card">

                            <!--Card image-->
                            <div class="view overlay">
                                <img src="/storage/assets/images/large_thumbnail/{{$item->image}}" class="card-img-top" alt="">
                                <a href="#" data-toggle="modal" data-target="#addtocart{{$item->id}}">
                                    <div class="mask rgba-white-slight">Buy Now</div>
                                </a>
                            </div>
                            <!--Card image-->

                            <!--Card content-->
                            <div class="card-body text-center">
                                <!--Category & Title-->
                                <h5 class="grey-text">{{$item->categories->name}}</h5>
                                <h5>
                                    <strong>
                                        <a href="{{route('site.product', $item->id)}}">{{$item->name}}</a>
                                        {{--                                        <span class="badge badge-pill danger-color">NEW</span>--}}
                                    </strong>
                                </h5>

                            </div>
                            <!--Card content-->

                        </div>
                        <!--Card-->

                    </div>
                    <!--Grid column-->
                @endforeach
            </div>
            <!--Grid row-->
        </section>
        <!--Section: Products v.3-->
    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
