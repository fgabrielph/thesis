@extends('admin.master')

@section('title') Delivery @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Delivery</h1>
                    <p>list of deliveries</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('admin.includes.messages')
                    <div class="card">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">On Delivery</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Returns</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Completed</a>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="margin: 1%">
                                    <table id="orderTable" class="table table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Number</th>
                                            <th>Ship to</th>
                                            <th>City</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Estimated Day of Arrival</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveries as $delivery)
                                            @if($delivery->status == 'On Delivery' && $delivery->order->status != 'Canceled')
                                            <tr>
                                                <td>{{$delivery->id}}</td>
                                                <td>{{$delivery->order->order_number}}</td>
                                                <td>{{$delivery->customer_name}}</td>
                                                <td>{{$delivery->order->city}}</td>
                                                <td>{{$delivery->order->address}}</td>
                                                <td><h4><span class="badge bg-secondary">{{$delivery->status}}</span></h4></td>
                                                <td>{{$delivery->created_at->toFormattedDateString()}}</td>
                                                <td>{{date('M d, Y', strtotime($delivery->ETA))}}</td>
                                                <td>
                                                    <a href="{{route('deliveries.status', ['status' => 'Completed', 'id' => $delivery->id])}}" class="btn btn-lg btn-success">Complete</a>
                                                </td>

                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="margin: 1%">
                                    <table id="atkTable" class="table table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Number</th>
                                            <th>Ship to</th>
                                            <th>City</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Estimated Day of Arrival</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveries as $delivery)
                                            @if($delivery->status == 'Return' && $delivery->order->status != 'Canceled')
                                                <tr>
                                                    <td>{{$delivery->id}}</td>
                                                    <td>{{$delivery->order->order_number}}</td>
                                                    <td>{{$delivery->customer_name}}</td>
                                                    <td>{{$delivery->order->city}}</td>
                                                    <td>{{$delivery->order->address}}</td>
                                                    <td><h4><span class="badge bg-secondary">{{$delivery->status}}</span></h4></td>
                                                    <td>{{$delivery->created_at->toFormattedDateString()}}</td>
                                                    <td>{{date('M d, Y', strtotime($delivery->ETA))}}</td>
                                                    <td>
{{--                                                        <a href="{{route('deliveries.status', ['status' => 'On Delivery', 'id' => $delivery->id])}}" class="btn btn-lg btn-primary"><span class="fas fa-truck"></span> Deliver</a>--}}
                                                        <a href="#" data-toggle="modal" data-target="#deliver{{$delivery->id}}" class="btn btn-md btn-success"><span class="fas fa-truck"></span> Deliver</a>
                                                    </td>

                                                </tr>
                                            @endif

                                            @if($delivery->status == 'Return' && $delivery->order->status != 'Canceled')
                                                <!-- Modal -->
                                                <div class="modal fade" id="deliver{{$delivery->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <form action="{{route('deliveries.edit_eda', $delivery->id)}}" class="form-horizontal" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Estimated Day of Arrival</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label class="col-md-5 control-label">Date: <b><i style="color: red">*Max is 7 days.</i></b></label>
                                                                                <div class="col-md-11">
                                                                                    <input name="date" id="datepicker{{$delivery->id}}" type="text" class="form-control input-md" value="{{date('M d, Y', strtotime($delivery->ETA))}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    <input class="btn btn-primary" type="submit" value="Save Changes">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" style="margin: 1%">
                                    <table id="defTable" class="table table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Number</th>
                                            <th>Ship to</th>
                                            <th>City</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Date Completed</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveries as $delivery)
                                            @if($delivery->status == 'Completed' && $delivery->order->status != 'Canceled')
                                                <tr>
                                                    <td>{{$delivery->id}}</td>
                                                    <td>{{$delivery->order->order_number}}</td>
                                                    <td>{{$delivery->customer_name}}</td>
                                                    <td>{{$delivery->order->city}}</td>
                                                    <td>{{$delivery->order->address}}</td>
                                                    <td><h4><span class="badge bg-success">{{$delivery->status}}</span></h4></td>
                                                    <td>{{$delivery->created_at->toFormattedDateString()}}</td>
                                                    @if(empty($delivery->updated_at))
                                                        <td>TEST</td>
                                                    @else
                                                        <td>{{$delivery->updated_at->format('M d Y -- h:iA')}}</td>
                                                    @endif
                                                    <td><a href="{{route('deliveries.status', ['status' => 'Return', 'id' => $delivery->id])}}" class="btn btn-lg btn-primary">Return?</a></td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            @foreach($deliveries as $delivery)
            $( "#datepicker{{$delivery->id}}" ).datepicker();
            @endforeach
        } );
    </script>

@endsection
