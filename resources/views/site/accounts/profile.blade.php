@extends('site.master')

@section('title') {{Auth::user()->name}} @endsection

@section('content')

    <div class="container">
        @include('site.includes.messages')
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Profile Picture
                    </div>
                        <img src="/assets/images/large_thumbnail/{{Auth::user()->avatar}}" width="100%">
                </div>
                <br>
                <h1><a href="{{route('custom_order.index')}}" class="btn btn-lg btn-block blue-gradient">Custom Orders</a></h1>
            </div>

            <div class="col-md-8">
                <div class="card" style="height: 480px">
                    <div class="card-header">
                        {{Auth::user()->name}}'s Dashboard
                    </div>
                    <div class="card-body">
                        <form action="{{route('account.name')}}" method="POST">
                            @csrf
                            <label><strong>Name: </strong></label>
                            <input class="form-control input-md" type="text" name="name" value="{{Auth::user()->name}}"><br>
                            <label><strong>Email: </strong></label>
                            <input class="form-control input-md" type="text" name="email" value="{{Auth::user()->email}}"><br>
                            <button class="btn btn-sm btn-amber" type="submit">Update</button>
                            <br>
                            <div class="row">
                                <div class="col-4">
                                    <label><strong>Address: </strong></label>
                                    <p>{{Auth::user()->address}}</p>
                                </div>
                                <div class="col-4">
                                    <label><strong>Mobile: </strong></label>
                                    <p>{{Auth::user()->mobile_number}}</p>
                                </div>
                                <div class="col-4">
                                    <label><strong>Birthday: </strong></label>
                                    <p>{{Auth::user()->birthday}}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Account Navigation
                    </div>
                    <a href="#" data-toggle="modal" data-target="#profilepicture" class="btn btn-block btn-black">Update Profile Picture</a><br>
                    <a href="#" data-toggle="modal" data-target="#address" class="btn btn-block btn-black">Change Address</a><br>
                    <a href="#" data-toggle="modal" data-target="#birthday" class="btn btn-block btn-black">Change Birthday</a><br>
                    <a href="#" data-toggle="modal" data-target="#password" class="btn btn-block btn-black">Change Password</a><br>
                    <a href="#" data-toggle="modal" data-target="#mobile_number" class="btn btn-block btn-black">Change Mobile Number</a><br>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="profilepicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content" style="overflow-y: auto">
                        <form action="{{route('account.picture', Auth::user()->id)}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Upload Profile Picture</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <img src="/assets/images/large_thumbnail/{{Auth::user()->avatar}}" width="100%" alt="this is image">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="" class="col-md-6 control-label">Upload Image</label>
                                        <div class="col">
                                            <input name="image" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="hidden" name="_method" type="hidden" value="PUT">
                                <input class="btn btn-primary" type="submit" value="Save Changes">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{route('account.address')}}" class="form-horizontal" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Updated Address</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Address: </label>
                                            <div class="col-md-12">
                                                <input name="address" type="text" class="form-control input-md" value="{{Auth::user()->address}}">
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

            <!-- Modal -->
            <div class="modal fade" id="birthday" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{route('account.birthday')}}" class="form-horizontal" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Update Birthday</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Birthday: </label>
                                            <div class="col-md-12">
                                                <input name="birthday" type="text" class="form-control input-md" value="{{Auth::user()->birthday}}">
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

            <!-- Modal -->
            <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{route('account.password')}}" class="form-horizontal" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Update Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Old Password: </label>
                                            <div class="col-md-12">
                                                <input name="password" type="password" class="form-control input-md">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">New Password: </label>
                                            <div class="col-md-12">
                                                <input name="newpass" type="password" class="form-control input-md">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Confirm Password: </label>
                                            <div class="col-md-12">
                                                <input name="confirmpass" type="password" class="form-control input-md">
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

            <!-- Modal -->
            <div class="modal fade" id="mobile_number" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{route('account.mobile')}}" class="form-horizontal" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Update Mobile Number</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Mobile Number: </label>
                                            <div class="col-md-12">
                                                <input name="mobile_num" type="text" class="form-control input-md" value="{{Auth::user()->mobile_number}}">
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


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Transaction History
                    </div>
                        <table class="table table-striped">
                            <thead class="black white-text">
                                <th>Order</th>
                                <th>Payment</th>
                                <th>Created At</th>
                                <th class="text-center"><span class="fas fa-bolt"></span></th>
                            </thead>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td><h5>{!! $order->payment_status ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-danger">Not Completed</span>' !!}</h5></td>
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>
                                    <td class="text-center">
                                        <a href="{{route('orders.show', $order->id)}}" class="btn btn-md btn-primary"><span class="fas fa-pencil-alt"></span>&nbsp;View Invoice</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                </div>
                <br>
                {{$orders->links()}}
            </div>
        </div>
    </div>

@endsection

@section('footer')

    @include('site.includes.footer')

{{--    <!--Footer-->--}}
{{--    <footer class="page-footer text-center font-small mt-4 wow fadeIn fixed-bottom">--}}

{{--        <div class="orange">--}}
{{--            <!--Call to action-->--}}
{{--            <div class="pt-3">--}}
{{--                <a class="btn btn-outline-white" href="#" role="button">Inquire Now</a>--}}
{{--                <a class="btn btn-outline-white" href="#" role="button">Contacts</a>--}}
{{--            </div>--}}
{{--            <!--/.Call to action-->--}}


{{--            <!--Copyright-->--}}
{{--            <div class="footer-copyright py-3 black">--}}
{{--                © 2019 Copyright:--}}
{{--                <a href="#" target="_blank"> New MJC </a>--}}
{{--            </div>--}}
{{--            <!--/.Copyright-->--}}

{{--        </div>--}}


{{--    </footer>--}}
{{--    <!--/.Footer-->--}}

@endsection
