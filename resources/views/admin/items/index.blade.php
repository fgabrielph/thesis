@extends('admin.master')

@section('title') Item @endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Items</h1>
                    <p>list of items</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-toggle="modal" data-target="#add" class="btn btn-primary float-right"><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Item
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
                            <h3 class="card-title">Manage Items</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-hover table-responsive">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Product ID</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Stock Price</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center"><i class="fas fa-bolt"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $item)
                                    <tr class="table-light">
                                        <td class="text-center">{{$item->id}}</td>
                                        <td class="text-center"><img src="/storage/assets/images/large_thumbnail/{{$item->image}}" style="width: 50px; height: 30px" alt="this is image"></td>
                                        <td class="text-center">{{$item->brands->name}}</td>
                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->stocks}}</td>
                                        <td class="text-center">{{number_format($item->price_stocks, 2)}}</td>
                                        <td class="text-center">{{$item->categories->name}}</td>
                                        <td class="text-center"><p style="width: 600px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$item->description}}</p></td>
                                        <td class="text-center">
                                            <button type="button" data-toggle="dropdown" class="btn btn-rounded btn-secondary dropdown-toggle">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-toggle="modal" data-target="#view{{$item->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                                <a href="#" data-toggle="modal" data-target="#edit{{$item->id}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal View -->
                                    <div class="modal fade" id="view{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/storage/assets/images/large_thumbnail/{{$item->image}}" width="100%" alt="this is image">
                                                        </div>
                                                        <div class="col">
                                                            <strong><h1>{{$item->name}}</h1></strong>
                                                            <h2>{{$item->brand_id}}</h2>
                                                            <h3 class="text-success">{{number_format($item->price_stocks, 2)}}</h3>
                                                            <p>{{$item->description}}</p>
                                                            <h5>Stock Remaining: {{$item->stocks}}</h5>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- End of Modal View -->


                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <!-- Form Name -->
                                                    <legend class="header">Update Item</legend>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/storage/assets/images/large_thumbnail/{{$item->image}}" style="height: 300px; width: 400px; margin-top: 250px" alt="this is image">
                                                        </div>

                                                        <div class="col">
                                                        {!! Form::open(['class' => 'form-horizontal', 'action' => ['Admin\ItemController@update', $item->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                         <!-- Text input-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Name', ['class' => 'col-md-4 control-label'])}}
                                                                <div class="col-md-12">
                                                                    {{Form::text('name', $item->name, ['class' => 'form-control input-md',  'placeholder' => 'Name'])}}
                                                                </div>
                                                            </div>
                                                             <!-- Text input-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Brand', ['class' => 'col-md-4 control-label', 'for' => 'input-select'])}}
                                                                <div class="col-md-12">
                                                                    <select class="form-control" name="brand">
                                                                        <option value="{{ $item->brand_id }}">{{ $item->brands->name }}</option>
                                                                        <option disabled>-----------------</option>
                                                                        @foreach($brands as $brand)
                                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Prepended text-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Stock Price', ['class' => 'col-md-12 control-label'])}}
                                                                <div class="col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">PhP</span> {{Form::number('price_stocks', $item->price_stocks, ['class' => 'form-control', 'placeholder' => '0.00', 'step' => '0.1'])}}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Text input-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Stocks (Increase or Decrease)', ['class' => 'col-md control-label'])}}
                                                                <div class="col-md-12">
                                                                    {{Form::number('stocks', $item->stocks, ['class' => 'form-control input-md', 'placeholder' => '0'])}}
                                                                </div>
                                                            </div>

                                                            <!-- Text input-->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Category', ['class' => 'col-md-4 control-label', 'for' => 'input-select'])}}
                                                                <div class="col-md-12">
                                                                    <select class="form-control" name="category">
                                                                        <option value="{{ $item->category_id }}">{{ $item->categories->name }}</option>
                                                                        <option disabled>-----------------</option>
                                                                        @foreach($categories as $category)
                                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Textarea -->
                                                            <div class="form-group">
                                                                {{Form::label('', 'Description', ['class' => 'col-md-4 control-label'])}}
                                                                <div class="col-md-12">
                                                                    {{Form::textarea('description', $item->description, ['style' => 'resize: none;' ,'class' => 'form-control',  'placeholder' => 'Description'])}}
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
                                                    {{Form::submit('Save Changes', ['class' => 'col-md-2 btn btn-success'])}}
                                                </div>

                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div> <!-- End of Modal Edit -->


                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{$items->links()}}
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Add Item Modal -->
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <!-- Form Name -->
                                <legend class="header">Add Item</legend>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                {!! Form::open(['class' => 'form-horizontal', 'action' => 'Admin\ItemController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    {{Form::label('', 'Name', ['class' => 'col-md-4 control-label'])}}
                                    <div class="col-md-12">
                                        {{Form::text('name', '', ['class' => 'form-control input-md',  'placeholder' => 'Name'])}}
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    {{Form::label('', 'Brand', ['class' => 'col-md-4 control-label', 'for' => 'input-select'])}}
                                    <div class="col-md-12">
                                        <select class="form-control" name="brand">
                                            <option name="default">-- Select Brand --</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Prepended text-->
                                <div class="form-group">
                                    {{Form::label('', 'Stock Price', ['class' => 'col-md-12 control-label'])}}
                                    <div class="col-md-12">
                                        <div class="input-group-prepend"><span class="input-group-text">PhP</span> {{Form::number('price_stocks', 'null', ['class' => 'form-control', 'placeholder' => '0.00', 'step' => '0.1'])}} </div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    {{Form::label('', 'Stocks', ['class' => 'col-md-4 control-label'])}}
                                    <div class="col-md-12">
                                        {{Form::number('stocks', '', ['class' => 'form-control input-md', 'placeholder' => '0'])}}
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    {{Form::label('', 'Category', ['class' => 'col-md-4 control-label', 'for' => 'input-select'])}}
                                    <div class="col-md-12">
                                        <select class="form-control" name="category">
                                            <option name="default">-- Select Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    {{Form::label('', 'Description', ['class' => 'col-md-4 control-label'])}}
                                    <div class="col-md-12">
                                        {{Form::textarea('description', '', ['style' => 'resize: none;' ,'class' => 'form-control',  'placeholder' => 'Description'])}}
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
                                <button type="button" class="col-md-2 btn btn-danger btn-rounded" data-dismiss="modal">Cancel</button>
                                {{Form::submit('Submit', ['class' => 'col-md-2 btn btn-success btn-rounded'])}}
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div> <!-- End Add Item Modal -->
            </div>
        </div>
    </div>

@endsection
