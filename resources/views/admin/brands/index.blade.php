@extends('admin.master')

@section('title') Brands @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Brands</h1>
                    <p>list of brands</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-toggle="modal" data-target="#add" class="btn btn-primary float-right"><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Brand
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
                            <h3 class="card-title">Manage Brands</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center"><i class="fas fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $brand)
                                    <tr>
                                        <td class="text-center">{{$brand->id}}</td>
                                        <td class="text-center">{{$brand->name}}</td>
                                        <td class="text-center"><img src="/assets/images/large_thumbnail/{{$brand->image}}" style="width: 40px; height: 40px" alt="this is image"></td>
                                        <td class="text-center"><button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-toggle="modal" data-target="#view{{$brand->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                                <a href="#" data-toggle="modal" data-target="#edit{{$brand->id}}" class="dropdown-item"><span class="fas fa-pen"></span> Edit</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal View -->
                                    <div class="modal fade" id="view{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/large_thumbnail/{{$brand->image}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <br><br><br>
                                                            <strong><h1>{{$brand->name}}</h1></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- End of Modal View -->

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <!-- Form Name -->
                                                    <legend class="header">Update Brand</legend>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col">
                                                        {!! Form::open(['class' => 'form-horizontal', 'action' => ['Admin\BrandController@update', $brand->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                                        <!-- Text input-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Name', ['class' => 'col-md-4 control-label'])}}
                                                                <div class="col-md-12">
                                                                    {{Form::text('name', $brand->name, ['class' => 'form-control input-md',  'placeholder' => 'Name'])}}
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                {{Form::label('', 'Image', ['class' => 'col-md-4 control-label'])}}
                                                                <div class="col-md-12">
                                                                    {{Form::file('image')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="col-md-2 btn btn-danger btn-rounded" data-dismiss="modal">Close</button>
                                                    {{Form::hidden('_method', 'PUT')}}
                                                    {{Form::submit('Save Changes', ['class' => 'col-md-2 btn btn-info', 'style' => 'color: white;'])}}
                                                </div>

                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div> <!-- End of Modal Edit -->

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

    <!-- Add Brand Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <!-- Form Name -->
                    <legend class="header">Add Brand</legend>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['class' => 'form-horizontal', 'action' => 'Admin\BrandController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                    <div class="form-group">
                        {{Form::label('', 'Name', ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-12">
                            {{Form::text('name', '', ['class' => 'form-control input-md',  'placeholder' => 'Name'])}}
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
    </div> <!-- End Brand Modal -->

@endsection
