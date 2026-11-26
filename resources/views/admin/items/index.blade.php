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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-end"><span class="fas fa-plus" aria-hidden="true"></span>
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
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="defTable" class="table table-hover">
                                <thead class="table-dark">
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
                                        <td class="text-center"><img src="/assets/images/large_thumbnail/{{$item->image}}" style="width: 50px; height: 30px" alt="this is image"></td>
                                        <td class="text-center">{{$item->brands->name}}</td>
                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->stocks}}</td>
                                        <td class="text-center">{{number_format($item->price_stocks, 2)}}</td>
                                        <td class="text-center">{{$item->categories->name}}</td>
                                        <td class="text-center"><p style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$item->description}}</p></td>
                                        <td class="text-center">
                                            <button type="button" data-bs-toggle="dropdown" class="btn btn-rounded btn-secondary dropdown-toggle">Actions</button>
                                            <div class="dropdown-menu">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#view{{$item->id}}" class="dropdown-item"><span class="fas fa-search"></span> View</a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}" class="dropdown-item"><span class="fas fa-pencil-alt"></span> Edit</a>
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
                                                            <img src="/assets/images/large_thumbnail/{{$item->image}}" width="100%" alt="this is image">
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

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="/assets/images/large_thumbnail/{{$item->image}}" style="height: 300px; width: 400px; margin-top: 250px" alt="this is image">
                                                        </div>

                                                        <div class="col">
                                                        <form action="{{ action('Admin\ItemController@update', $item->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf
                                                         <!-- Text input-->
                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label">Name</label>
                                                                <div class="col-md-12">
                                                                    <input class="form-control input-md" placeholder="Name" type="text" name="name" value="{{ old('name', $item->name) }}">
                                                                </div>
                                                            </div>
                                                             <!-- Text input-->
                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label" for="input-select">Brand</label>
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
                                                            <div class="mb-3">
                                                                <label class="col-md-12 control-label">Stock Price</label>
                                                                <div class="col-md-12">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">PhP</span> <input class="form-control" placeholder="0.00" step="0.1" type="number" name="price_stocks" value="{{ old('price_stocks', $item->price_stocks) }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Text input-->
                                                            <div class="mb-3">
                                                                <label class="col-md control-label">Stocks (Increase or Decrease)</label>
                                                                <div class="col-md-12">
                                                                    <input class="form-control input-md" placeholder="0" type="number" name="stocks" value="{{ old('stocks', $item->stocks) }}">
                                                                </div>
                                                            </div>

                                                            <!-- Text input-->
                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label" for="input-select">Category</label>
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
                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label">Description</label>
                                                                <div class="col-md-12">
                                                                    <textarea style="resize: none;" class="form-control" placeholder="Description" name="description">{{ old('description', $item->description) }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="col-md-4 control-label">Image</label>
                                                                    <div class="col-md-12">
                                                                        <input type="file" name="image">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="col-md-2 btn btn-danger btn-rounded" data-bs-dismiss="modal">Close</button>
                                                    @method('PUT')
                                                    <button class="col-md-2 btn btn-success" type="submit">Save Changes</button>
                                                </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- End of Modal Edit -->


                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                            </ul>
                        </div> -->
                    </div>
                </div>

                <!-- Add Item Modal -->
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <!-- Form Name -->
                                <legend class="header">Add Item</legend>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ action('Admin\ItemController@store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf

                                <div class="mb-3">
                                    <label class="col-md-4 control-label">Name</label>
                                    <div class="col-md-12">
                                        <input class="form-control input-md" placeholder="Name" type="text" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="mb-3">
                                    <label class="col-md-4 control-label" for="input-select">Brand</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="brand">
                                            <option name="default" disabled selected>-- Select Brand --</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Prepended text-->
                                <div class="mb-3">
                                    <label class="col-md-12 control-label">Stock Price</label>
                                    <div class="col-md-12">
                                        <div class="input-group-prepend"><span class="input-group-text">PhP</span> <input class="form-control" placeholder="0.00" step="0.1" type="number" name="price_stocks" value="{{ old('price_stocks') }}"> </div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="mb-3">
                                    <label class="col-md-4 control-label">Stocks</label>
                                    <div class="col-md-12">
                                        <input class="form-control input-md" placeholder="0" type="number" name="stocks" value="{{ old('stocks') }}">
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="mb-3">
                                    <label class="col-md-4 control-label" for="input-select">Category</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="category">
                                            <option name="default" disabled selected>-- Select Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="mb-3">
                                    <label class="col-md-4 control-label">Description</label>
                                    <div class="col-md-12">
                                        <textarea style="resize: none;" class="form-control" placeholder="Description" name="description">{{ old('description') }}</textarea>
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
                                <button type="button" class="col-md-2 btn btn-danger btn-rounded" data-bs-dismiss="modal">Cancel</button>
                                <button class="col-md-2 btn btn-success btn-rounded" type="submit">Submit</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div> <!-- End Add Item Modal -->
            </div>
        </div>
    </div>

@endsection
