@extends('staff.master')

@section('title') Categories @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categories</h1>
                    <p>list of categories</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-end"><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Category
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
                    @include('staff.includes.messages')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Categories</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="orderTable" class="table table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center"><i class="fas fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="text-center">{{$category->id}}</td>
                                        <td class="text-center">{{$category->name}}</td>
                                        <td class="text-center"><a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{$category->id}}"><span class="fas fa-pen" style="color: grey"></span></a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <!-- Form Name -->
                                                    <legend class="header">Update Category Name</legend>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col">
                                                        <form id="edit-form-{{ $category->id }}" action="{{ action('Staff\CategoryController@update', $category->id) }}" method="POST" class="form-horizontal">@csrf
@method('PUT')

                                                        <!-- Text input-->
                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label">Name</label>
                                                                <div class="col-md-12">
                                                                    <input class="form-control input-md" placeholder="Name" type="text" name="name" value="{{ old('name', $category->name) }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="col-md-2 btn btn-danger btn-rounded" data-bs-dismiss="modal">Close</button>
                                                                                                        <button class="col-md-2 btn btn-info" style="color: white;" form="edit-form-{{ $category->id }}" type="submit">Save Changes</button>
                                                </div>

                                                </form>
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <!-- Form Name -->
                    <legend class="header">Add Category</legend>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="add-form" action="{{ action('Staff\CategoryController@store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf

                    <div class="mb-3">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-12">
                            <input class="form-control input-md" placeholder="Name" type="text" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="col-md-2 btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button class="col-md-2 btn btn-success" form="add-form" type="submit">Submit</button>
                </div>

                </form>
            </div>
        </div>
    </div> <!-- End Add Item Modal -->

@endsection
