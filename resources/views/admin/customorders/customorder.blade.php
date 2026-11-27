@extends ('admin.master')

@section ('title') Custom Order{{$customorder->id}} @endsection

@section ('content')
    <x-ui.page-header
        :title="'Custom Order Number '.$customorder->id"
        :subtitle="'Placed by '.$customorder->user->first_name.' '.$customorder->user->last_name"
    />

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include ('admin.includes.messages')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order</h3>
                        </div>

                        <br />

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <br />
                                            @if ($customorder->quantity == null && $customorder->status == 0 && $customorder->completed == null)
                                                <h3>NO Quantity YET</h3>
                                            @elseif ($customorder->quantity == null && $customorder->status != 2)
                                                <h3>In Progress</h3>
                                            @elseif ($customorder->status == 2)
                                                <h3><b>This Order is Canceled</b></h3>
                                            @elseif (empty($customorder->completed))
                                                <h3>0 / {{$customorder->quantity}}, In Progress</h3>
                                            @else
                                                <div
                                                    class="progress mb-3"
                                                    role="progressbar"
                                                    aria-valuenow="{{$customorder->completed}}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="{{$customorder->quantity}}"
                                                >
                                                    <div
                                                        class="progress-bar bg-warning"
                                                        style="width: {{$customorder->quantity ? round(($customorder->completed / $customorder->quantity) * 100) : 0}}%"
                                                    ></div>
                                                </div>
                                                <h3>
                                                    {{$customorder->completed}} out of {{$customorder->quantity}} Completed
                                                </h3>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($customorder->payment_status == 0 && $customorder->status != 2)
                                        <h3 class="text-center"><b>No Payment has been placed yet!</b></h3>
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h1>Order Number: {{$customorder->id}}</h1>
                                        </div>

                                        <!-- Start Row -->
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="card-body">
                                                    <h5>
                                                        <b>Placed By: </b
                                                        >{{$customorder->user->first_name . ' ' . $customorder->user->last_name}}
                                                    </h5>
                                                    <br />
                                                    <h5>
                                                        <b>Payment Status: </b>
                                                        @if ($customorder->payment_status == 0 && $customorder->status == 2)
                                                            <span class="badge text-bg-danger">Declined Order</span>
                                                        @elseif ($customorder->payment_status == 0)
                                                            <span class="badge text-bg-danger">Not yet Paid</span>
                                                        @elseif ($customorder->payment_status == 2)
                                                            <h5>
                                                                <span class="badge text-bg-warning"
                                                                    >Waiting for Approval</span
                                                                >
                                                            </h5>
                                                        @elseif ($customorder->payment_status == 1)
                                                            <span class="badge text-bg-success">Paid</span>
                                                        @elseif ($customorer->payment_status == 3)
                                                            <span class="text-bg-info">Partially Paid</span>
                                                        @endif
                                                    </h5>
                                                    <br />
                                                    <h5>
                                                        <b>Status: </b>
                                                        @if ($customorder->status == 0)
                                                            <span class="badge text-bg-warning">Pending</span>
                                                        @elseif ($customorder->status == 1)
                                                            <span class="badge text-bg-success">Accepted</span>
                                                        @elseif ($customorder->status == 2)
                                                            <span class="badge text-bg-danger">Declined</span>
                                                        @elseif ($customorder->status == 3)
                                                            <span class="badge text-bg-success">Completed</span>
                                                        @elseif ($customorder->status == 5)
                                                            <span class="badge text-bg-success">Delivered</span>
                                                        @endif
                                                    </h5>
                                                    <br />
                                                    <h5>
                                                        <b>Contact Number: {{$customorder->user->mobile_number}}</b>
                                                    </h5>
                                                    <br />
                                                    <h5><b>Description: </b></h5>
                                                    <p style="font-size: 23px">{{$customorder->description}}</p>
                                                    <br />
                                                    <h5 class="card-footer">
                                                        <b
                                                            >Total Price:
                                                            @if (empty($customorder->price))
                                                                N/A
                                                            @else
                                                                <x-ui.money :amount="$customorder->price" />
                                                            @endif
                                                        </b>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <br />
                                                <div class="justify-content-center">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                        ><img src="/assets/images/{{$customorder->image}}" width="100%"
                                                    /></a>
                                                </div>
                                                <br /><br />
                                                <h3>
                                                    <b>Created at: </b
                                                    >{{$customorder->created_at->toFormattedDateString()}}
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- End Row -->
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div
                                class="modal fade"
                                id="imageModal"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="exampleModalCenterTitle"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="/assets/images/{{$customorder->image}}" width="100%" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('customorders.index')}}" class="btn btn-lg w-100 btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>

@endsection
