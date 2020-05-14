@extends('site.master')

@section('title') Contact Us @endsection

@section('content')
    <br>
    <br>
    <div class="container">
        <br>
        <h3 class="text-center">Visit and Contact Us</h3>
        <div class="row mt-3">
            <div class="col-md-9">
                <img src="{{asset('/assets/images/location.JPG')}}" alt="">
            </div>
            <div class="col-md-3">
                <h4><i class="fas fa-search-location"></i> Located</h4>
                <p class="text-muted text-justify" style="font-size: 20px;">1101 D. Gomez Street, Barrio Obrero, Tondo, City of Manila, Metro Manila</p>
                <h4><i class="fas fa-phone"></i> Contact Us</h4>
                <p class="text-muted text-justify" style="font-size: 20px;"><i class="fas fa-dot-circle"></i> 364 8556</p>
                <p class="text-muted text-justify" style="font-size: 20px;"><i class="fas fa-dot-circle"></i> 361 9775</p>
                <p class="text-muted text-justify" style="font-size: 20px;"><i class="fas fa-dot-circle"></i> 359 5705</p>
            </div>
        </div>
    </div>







@endsection

@section('footer')

    @include('site.includes.footer')

@endsection



