@extends ('site.layouts.storefront')

@section ('title') My Account @endsection

@section ('content')
    <div class="sf-profile">
        <h1 class="h3 mb-4">My Account</h1>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header fw-semibold">Profile Picture</div>
                    <img
                        src="{{ Auth::user()->avatar ? '/assets/images/large_thumbnail/'.Auth::user()->avatar : '/assets/images/noavatar.jpg' }}"
                        class="card-img-bottom"
                        alt="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"
                    />
                </div>

                <div class="mt-3">
                    <x-storefront.account-nav />
                </div>

                <div class="card mt-3">
                    <div class="card-header fw-semibold">Account Settings</div>
                    <div class="list-group list-group-flush">
                        <a
                            href="#"
                            class="list-group-item list-group-item-action"
                            data-bs-toggle="modal"
                            data-bs-target="#profilepicture"
                            >Update Profile Picture</a
                        >
                        <a
                            href="#"
                            class="list-group-item list-group-item-action"
                            data-bs-toggle="modal"
                            data-bs-target="#address"
                            >Change Address</a
                        >
                        <a
                            href="#"
                            class="list-group-item list-group-item-action"
                            data-bs-toggle="modal"
                            data-bs-target="#birthday"
                            >Change Birthday</a
                        >
                        <a
                            href="#"
                            class="list-group-item list-group-item-action"
                            data-bs-toggle="modal"
                            data-bs-target="#password"
                            >Change Password</a
                        >
                        <a
                            href="#"
                            class="list-group-item list-group-item-action"
                            data-bs-toggle="modal"
                            data-bs-target="#mobile_number"
                            >Change Mobile Number</a
                        >
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header fw-semibold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}'s Dashboard</div>
                    <div class="card-body">
                        <form action="{{route('account.name')}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <x-storefront.form-field
                                        name="first_name"
                                        label="First name"
                                        :value="Auth::user()->first_name"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <x-storefront.form-field
                                        name="last_name"
                                        label="Last name"
                                        :value="Auth::user()->last_name"
                                    />
                                </div>
                            </div>

                            <x-storefront.form-field
                                name="email"
                                label="Email"
                                type="email"
                                :value="Auth::user()->email"
                            />

                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="small text-muted">Address</div>
                                <div>{{Auth::user()->address}}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted">Mobile</div>
                                <div>{{Auth::user()->mobile_number}}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="small text-muted">Birthday</div>
                                <div>{{Auth::user()->birthday}}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header fw-semibold">Transaction History</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order</th>
                                        <th>Payment</th>
                                        <th>Created At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{$order->order_number}}</td>
                                            <td>
                                                @if ($order->payment_status)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-danger">Not Completed</span>
                                                @endif
                                            </td>
                                            <td>{{$order->created_at->toFormattedDateString()}}</td>
                                            <td class="text-center">
                                                <a href="{{route('orders.show', $order->id)}}" class="btn btn-sm btn-primary"
                                                    >View Invoice</a
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-center">{{$orders->links()}}</div>
            </div>
        </div>

        <div class="modal fade" id="profilepicture" tabindex="-1" aria-labelledby="profilepictureLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form
                        action="{{route('account.picture', Auth::user()->id)}}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method ('PUT')

                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="profilepictureLabel">Upload Profile Picture</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img
                                src="{{ Auth::user()->avatar ? '/assets/images/large_thumbnail/'.Auth::user()->avatar : '/assets/images/noavatar.jpg' }}"
                                class="img-fluid rounded mb-3"
                                alt="Current profile picture"
                            />
                            <label for="profile_image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="profile_image" name="image" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="address" tabindex="-1" aria-labelledby="addressLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('account.address')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="addressLabel">Updated Address</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-storefront.form-field
                                name="address"
                                label="Address"
                                :value="Auth::user()->address"
                            />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="birthday" tabindex="-1" aria-labelledby="birthdayLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('account.birthday')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="birthdayLabel">Update Birthday</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-storefront.form-field
                                name="birthday"
                                label="Birthday"
                                :value="Auth::user()->birthday"
                            />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="password" tabindex="-1" aria-labelledby="passwordLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('account.password')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="passwordLabel">Update Password</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-storefront.form-field name="password" label="Old Password" type="password" />
                            <x-storefront.form-field name="newpass" label="New Password" type="password" />
                            <x-storefront.form-field name="confirmpass" label="Confirm Password" type="password" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mobile_number" tabindex="-1" aria-labelledby="mobileLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('account.mobile')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="mobileLabel">Update Mobile Number</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-storefront.form-field
                                name="mobile_num"
                                label="Mobile Number"
                                :value="Auth::user()->mobile_number"
                            />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
