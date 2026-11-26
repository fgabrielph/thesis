@extends('admin.master')

@section('title') Staffs @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Staffs</h1>
                    <p>list of staffs</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-end"><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Staff
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
                            <h3 class="card-title">Manage Staff</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"><i class="fas fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staffs as $staff)
                                    <tr>
                                        <td class="text-center">{{$staff->id}}</td>
                                        <td class="text-center">{{$staff->name}}</td>
                                        <td class="text-center">{{$staff->email}}</td>
                                        <td class="text-center">{!! $staff->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Deactivated</span>' !!}</td>
                                        <td class="text-center">
                                            <button type="button" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#view{{$staff->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                                <a href="{{route('staffs.edit', $staff->id)}}" class="dropdown-item">{!! $staff->status ? '<span class="fas fa-times"></span>' : '<span class="fas fa-check"></span>' !!}  {{$staff->status ? 'Deactivate' : 'Activate'}}</a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$staff->id}}" class="dropdown-item"><span class="fas fa-trash"></span> Delete</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal View -->
                                    <div class="modal fade" id="view{{$staff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/large_thumbnail/{{$staff->image}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <strong><h2>{{$staff->name}}</h2></strong>
                                                            <h3 class="text-success">{{$staff->email}}</h3>
                                                            <p>STATUS: {!! $staff->status ? 'Active' : 'Deactivated'!!}</p>
                                                            <h5></h5>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- End of Modal View -->

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="delete{{$staff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <legend class="header">Delete Account?</legend>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/large_thumbnail/{{$staff->image}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <strong><h2>{{$staff->name}}</h2></strong>
                                                            <h3 class="text-success">{{$staff->email}}</h3>
                                                            <p>THIS IS JOSEPH</p>
                                                            <h5></h5>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="col-md-2 btn btn-primary btn-rounded" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ action('Admin\StaffController@destroy', $staff->id) }}" method="POST">@csrf
                                                    @method('DELETE')
                                                    <button class="col-md-2 btn btn-danger btn-rounded" type="submit">Delete</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- End of Modal Delete -->

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
                    <legend class="header">Add Staff</legend>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ action('Admin\StaffController@store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-12">
                            <input class="form-control input-md" placeholder="Name" type="text" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Email</label>
                        <div class="col-md-12">
                            <input class="form-control input-md" placeholder="Email" type="text" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-12">
                            <input class="form-control input-md" placeholder="Password" type="password" name="password">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-12">
                            <input class="form-control input-md" placeholder="Confirm Password" type="password" name="confirm_pass">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Image</label>
                        <div class="col-md-12">
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="col-md-2 btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button class="col-md-2 btn btn-success" type="submit">Submit</button>
                </div>

                </form>
            </div>
        </div>
    </div> <!-- End Add Item Modal -->

@endsection
