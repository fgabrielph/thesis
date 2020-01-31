@extends('admin.master')

@section('title') Customers @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customers</h1>
                    <p>list of costumers</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-toggle="modal" data-target="#add" class="btn btn-primary float-right"><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Customer
                    </a>
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
                        <div class="card-header">
                            <h3 class="card-title">Manage Customer</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Email Status</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"><i class="fas fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="text-center">{{$customer->id}}</td>
                                        <td class="text-center">{{$customer->name}}</td>
                                        <td class="text-center">{{$customer->email}}</td>
                                        <td class="text-center">{!! !empty($customer->email_verified_at) ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-danger">Not Verified</span>'!!}</td>
                                        <td class="text-center">{!! $customer->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Deactivated</span>' !!}</td>
                                        <td class="text-center">
                                            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-toggle="modal" data-target="#view{{$customer->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                                <a href="{{route('customers.edit', $customer->id)}}" class="dropdown-item">{!! $customer->status ? '<span class="fas fa-times"></span>' : '<span class="fas fa-check"></span>' !!}  {{$customer->status ? 'Deactivate' : 'Activate'}}</a>
                                                <?php
                                                    if(count($customer->orders) == 0) {
                                                        ?>
                                                        <a href="#" data-toggle="modal" data-target="#delete{{$customer->id}}" class="dropdown-item"><span class="fas fa-trash"></span> Delete</a>
                                                 <?php
                                                    }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal View -->
                                    <div class="modal fade" id="view{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/storage/assets/images/large_thumbnail/{{$customer->avatar}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <strong><h2>{{$customer->name}}</h2></strong>
                                                            <h3 class="text-success">{{$customer->email}}</h3>
                                                            <p>STATUS: {{ $customer->status ? 'Active' : 'Deactivated' }}</p>
                                                            <h1>{!! !empty($customer->email_verified_at) ? '<span class="badge bg-success">VERIFIED</span>' : '<span class="badge bg-danger">NOT VERIFIED</span>'!!}</h1>
                                                            <h5></h5>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- End of Modal View -->

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="delete{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <legend class="header">Delete Account?</legend>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/storage/assets/images/large_thumbnail/{{$customer->avatar}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <strong><h2>{{$customer->name}}</h2></strong>
                                                            <h3 class="text-success">{{$customer->email}}</h3>
                                                            <h1>{!! !empty($customer->email_verified_at) ? '<span class="badge bg-success">VERIFIED</span>' : '<span class="badge bg-danger">NOT VERIFIED</span>'!!}</h1>
                                                            <h5></h5>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="col-md-2 btn btn-primary btn-rounded" data-dismiss="modal">Close</button>
                                                    {!!Form::open(['action' => ['Admin\CustomerController@destroy', $customer->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'col-md-2 btn btn-danger btn-rounded'])}}
                                                    {!!Form::close()!!}
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- End of Modal Delete -->

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
{{--                                {{$customers->links()}}--}}
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Add Item Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <!-- Form Name -->
                    <legend class="header">Add Customer</legend>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['class' => 'form-horizontal', 'action' => 'Admin\CustomerController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                    <div class="form-group">
                        {{Form::label('', 'Name', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::text('name', '', ['class' => 'form-control input-md',  'placeholder' => 'Name'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('', 'Email', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::text('email', '', ['class' => 'form-control input-md',  'placeholder' => 'Email'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('', 'Password', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::password('password', ['class' => 'form-control input-md',  'placeholder' => 'Password'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('', 'Confirm Password', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::password('confirm_pass', ['class' => 'form-control input-md',  'placeholder' => 'Confirm Password'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{Form::label('', 'Image', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::file('image')}}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="col-md-2 btn btn-danger" data-dismiss="modal">Cancel</button>
                    {{Form::submit('Submit', ['class' => 'col-md-2 btn btn-success'])}}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div> <!-- End Add Item Modal -->

@endsection
