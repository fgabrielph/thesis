@extends ('site.layouts.storefront')

@section ('title') Checkout @endsection

@section ('content')
    <h1 class="h3 text-center mb-4">Checkout</h1>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <form action="{{route('checkout.store')}}" method="POST" class="card-body">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <x-storefront.form-field
                                name="firstName"
                                label="First name"
                                :value="Auth::user()->first_name"
                                required
                            />
                        </div>
                        <div class="col-md-6">
                            <x-storefront.form-field
                                name="lastName"
                                label="Last name"
                                :value="Auth::user()->last_name"
                                required
                            />
                        </div>
                    </div>

                    <x-storefront.form-field
                        name="email"
                        label="Email"
                        type="email"
                        :value="Auth::user()->email"
                        disabled
                    />

                    <x-storefront.form-field name="address" label="Address" :value="Auth::user()->address" required />

                    <div class="row">
                        <div class="col-md-4">
                            <x-storefront.form-field name="city" label="City" :value="old('city')" required />
                        </div>
                        <div class="col-md-4">
                            <x-storefront.form-field name="zip" label="Zip Code" :value="old('zip')" required />
                        </div>
                        <div class="col-md-4">
                            <x-storefront.form-field
                                name="mobile_num"
                                label="Mobile Number"
                                :value="Auth::user()->mobile_number"
                                required
                            />
                        </div>
                    </div>

                    <x-storefront.form-field name="notes" label="Notes" />

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="checker" />
                        <label class="form-check-label" for="checker">Deliver to a different person</label>
                    </div>

                    <div id="receiver" hidden>
                        <x-storefront.form-field name="deliver_to" label="Deliver to" />
                    </div>

                    <div id="receiver_address" hidden>
                        <x-storefront.form-field name="deliver_to_address" label="Address of the receiver" />
                    </div>

                    <fieldset class="mb-4">
                        <legend class="form-label fs-6">Payment method</legend>

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                id="credit"
                                value="cod"
                                required
                            />
                            <label class="form-check-label" for="credit">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                id="bank"
                                value="bank"
                                required
                            />
                            <label class="form-check-label" for="bank">Bank Transfer</label>
                        </div>
                    </fieldset>

                    <button class="btn btn-primary btn-lg w-100" type="submit">Place order</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <x-storefront.order-summary :items="Cart::content()" :total="Cart::total()" />
        </div>
    </div>
@endsection
