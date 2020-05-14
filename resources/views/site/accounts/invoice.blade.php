@extends('site.master')

@section('title') Invoice @endsection

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="col-6">
                    <h3 class="page-header"><i class="fa fa-globe"></i> {{ $invoice->payment_id}}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-12">
                        <h5 class="text-right">Date: {{ $invoice->created_at->toFormattedDateString() }}</h5>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-4">
                        <h6><address>Email: <strong> {{ $invoice->customer_email }} </strong></address></h6>
                    </div>
                    <div class="col-4">
                        <address>Country Code: {{ $invoice->country_code }}<br>Paid in currency: <strong>{{ $invoice->currency }}</strong></address>
                    </div>
                    <div class="col-4">
                        <b>Customer ID:</b> {{ $invoice->customer_id }}<br>
                        <b>Amount:</b> P {{ number_format($invoice->price, 2) }}<br>
                        <b>Payment Status:</b> {{ $invoice->payment_status }}<br>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <a href="{{route('orders.index')}}" class="btn btn-primary"> Go Back</a>
    </div>

    <br><br><br><br><br><br><br>
@endsection

@section('footer')

    @include('site.includes.footer')

@endsection
