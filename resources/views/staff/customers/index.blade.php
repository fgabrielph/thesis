@extends ('staff.master')

@section ('title') Customers @endsection

@section ('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customers</h1>
                    <p>list of costumers</p>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-end"
                        ><span class="fas fa-plus" aria-hidden="true"></span>
                        Add Customer
                    </a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include ('staff.includes.messages')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Customer</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="margin: 1%">
                            <table id="defTable" class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Email Verified</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"><i class="fas fa-bolt"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        @if ($customer->id != 0)
                                            <tr>
                                                <td class="text-center">{{$customer->id}}</td>
                                                <td class="text-center">
                                                    {{$customer->first_name . ' ' . $customer->last_name}}
                                                </td>
                                                <td class="text-center">{{$customer->email}}</td>
                                                <td class="text-center">
                                                    {!! !empty($customer->email_verified_at) ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-danger">Not Verified</span>'!!}
                                                </td>
                                                <td class="text-center">
                                                    {!! $customer->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Deactivated</span>' !!}
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        class="btn btn-primary dropdown-toggle"
                                                    >
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a
                                                            href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#view{{$customer->id}}"
                                                            class="dropdown-item"
                                                            ><span class="fas fa-search"></span> View</a
                                                        >
                                                        <a
                                                            href="{{route('staff_customer.edit', $customer->id)}}"
                                                            class="dropdown-item"
                                                            >{!! $customer->status ? '<span class="fas fa-times"></span>' : '<span class="fas fa-check"></span>' !!} {{$customer->status ? 'Deactivate' : 'Activate'}}</a
                                                        >
                                                        @if (count($customer->orders) == 0)
                                                            <a
                                                                href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{$customer->id}}"
                                                                class="dropdown-item"
                                                                ><span class="fas fa-trash"></span> Delete</a
                                                            >
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal View -->
                                            <div
                                                class="modal fade"
                                                id="view{{$customer->id}}"
                                                tabindex="-1"
                                                role="dialog"
                                                aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true"
                                            >
                                                <div
                                                    class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document"
                                                >
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-center">
                                                                    <img
                                                                        src="/assets/images/large_thumbnail/{{$customer->avatar}}"
                                                                        width="100%"
                                                                        alt="this is image"
                                                                    />
                                                                </div>
                                                                <div class="col">
                                                                    <strong
                                                                        ><h2>
                                                                            {{$customer->first_name . ' ' . $customer->last_name}}
                                                                        </h2></strong
                                                                    >
                                                                    <h3 class="text-success">{{$customer->email}}</h3>
                                                                    <p>STATUS: {{ $customer->status ? 'Active' : 'Deactivated' }}</p>
                                                                    <h5></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Modal View -->

                                            <!-- Modal Delete -->
                                            <div
                                                class="modal fade"
                                                id="delete{{$customer->id}}"
                                                tabindex="-1"
                                                role="dialog"
                                                aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true"
                                            >
                                                <div
                                                    class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document"
                                                >
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <legend class="header">Delete Account?</legend>

                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"
                                                            ></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col d-flex justify-content-center">
                                                                    <img
                                                                        src="/assets/images/large_thumbnail/{{$customer->avatar}}"
                                                                        width="100%"
                                                                        alt="this is image"
                                                                    />
                                                                </div>
                                                                <div class="col">
                                                                    <strong
                                                                        ><h2>
                                                                            {{$customer->first_name . ' ' . $customer->last_name}}
                                                                        </h2></strong
                                                                    >
                                                                    <h3 class="text-success">{{$customer->email}}</h3>
                                                                    <h1>
                                                                        {!! !empty($customer->email_verified_at) ? '<span class="badge bg-success">VERIFIED</span>' : '<span class="badge bg-danger">NOT VERIFIED</span>'!!}
                                                                    </h1>
                                                                    <h5></h5>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button
                                                                type="button"
                                                                class="col-md-2 btn btn-primary btn-rounded"
                                                                data-bs-dismiss="modal"
                                                            >
                                                                Close
                                                            </button>
                                                            <form
                                                                action="{{ action('Staff\CustomerController@destroy', $customer->id) }}"
                                                                method="POST"
                                                            >
                                                                @csrf
                                                                @method ('DELETE')
                                                                <button
                                                                    class="col-md-2 btn btn-danger btn-rounded"
                                                                    type="submit"
                                                                >
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Modal Delete -->
                                        @endif
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
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Add Item Modal -->
    <div
        class="modal fade"
        id="add"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Form Name -->
                    <legend class="header">Add Customer</legend>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form
                        id="add-form"
                        action="{{ action('Staff\CustomerController@store') }}"
                        method="POST"
                        class="form-horizontal"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-12">
                                <input
                                    class="form-control input-md"
                                    placeholder="First Name"
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-12">
                                <input
                                    class="form-control input-md"
                                    placeholder="Last Name"
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Email</label>
                            <div class="col-md-12">
                                <input
                                    class="form-control input-md"
                                    placeholder="Email"
                                    type="text"
                                    name="email"
                                    value="{{ old('email') }}"
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-12">
                                <input
                                    class="form-control input-md"
                                    placeholder="Password"
                                    type="password"
                                    name="password"
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-12">
                                <input
                                    class="form-control input-md"
                                    placeholder="Confirm Password"
                                    type="password"
                                    name="confirm_pass"
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-md-4 control-label">Image</label>
                            <div class="col-md-12">
                                <input type="file" name="image" />
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
    </div>
    <!-- End Add Item Modal -->

@endsection
