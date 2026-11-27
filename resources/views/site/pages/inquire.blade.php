@extends ('site.layouts.storefront')

@section ('title') Inquire Form @endsection

@section ('content')
    <div>
        <div class="card">
            <div class="card-header bg-dark text-white">
                <div>
                    <h1 class="h4 mb-0"><i class="fa fa-globe"></i> Inquire for Custom Order</h1>
                </div>
            </div>
            <div class="card-body">
                <form
                    action="{{route('inquiry')}}"
                    class="border border-light p-5"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    {{csrf_field()}}
                    <label for="textInput">Name</label>
                    <input
                        type="text"
                        id="defaultContactFormName"
                        class="form-control mb-4"
                        name="name"
                        placeholder="Name"
                    />

                    <label for="address" class="textInput">Address</label>
                    <input
                        value="{{ old('address') }}"
                        name="address"
                        type="text"
                        id="address"
                        class="form-control"
                        placeholder=""
                    />

                    <br />

                    <!--Grid row-->
                    <div class="row">
                        <!--Grid column-->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="state">City</label>
                            <input
                                value="{{ old('city') }}"
                                name="city"
                                type="text"
                                id="address-2"
                                class="form-control"
                            />
                        </div>
                        <!--Grid column-->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="state">Zip Code</label>
                            <input
                                value="{{ old('zip_code') }}"
                                name="zip_code"
                                type="text"
                                id="address-2"
                                class="form-control"
                            />
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="state">Contact Number</label>
                            <input
                                value="{{ old('contactnum') }}"
                                name="contactnum"
                                type="text"
                                id="address-2"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <!--Grid row-->

                    <!--address-->
                    <br />
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <img
                                id="img"
                                src="{{url('../assets/images/noimage.jpg')}}"
                                class="img-fluid rounded mx-auto d-block"
                            />
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <br />
                    <div class="mb-4">
                        <label for="fileInput" class="form-label">Upload</label>
                        <input
                            type="file"
                            class="form-control"
                            id="fileInput"
                            name="image"
                            data-preview="#img"
                        />
                    </div>
                    <label for="textInput"
                        >Description <b><i style="color: red">*Please include the Quantity of your order.</i></b></label
                    >
                    <textarea
                        class="form-control rounded-0"
                        id="exampleFormControlTextarea2"
                        rows="3"
                        name="description"
                        placeholder="Description"
                    ></textarea>

                    <br />

                    <input name="_method" type="hidden" value="PUT" />
                    <button class="btn btn-primary w-100" type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>

@endsection

