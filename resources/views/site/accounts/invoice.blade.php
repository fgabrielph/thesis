@extends ('site.layouts.storefront')

@section ('title') Invoice @endsection

@section ('content')
    <div class="sf-invoice">
        <div class="card">
            <div class="card-header d-flex flex-column flex-sm-row justify-content-between gap-2">
                <h1 class="h4 mb-0">Invoice {{$invoice->payment_id}}</h1>
                <span class="text-muted">{{$invoice->created_at->toFormattedDateString()}}</span>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="small text-muted">Email</div>
                        <div>{{$invoice->customer_email}}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-muted">Country Code</div>
                        <div>{{$invoice->country_code}}</div>
                        <div class="small text-muted mt-2">Currency</div>
                        <div>{{$invoice->currency}}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-muted">Customer ID</div>
                        <div>{{$invoice->customer_id}}</div>
                        <div class="small text-muted mt-2">Amount</div>
                        <div><x-storefront.money :amount="$invoice->price" /></div>
                        <div class="small text-muted mt-2">Payment Status</div>
                        <div>{{$invoice->payment_status}}</div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{route('orders.index')}}" class="btn btn-primary">Go Back</a>
            </div>
        </div>
    </div>
@endsection
