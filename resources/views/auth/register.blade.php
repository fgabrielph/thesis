@extends ('site.layouts.storefront')

@section ('title') Register @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 560px">
        <div class="card">
            <div class="card-header fw-semibold">Register</div>

            <div class="card-body">
                <form method="POST" action="{{route('register')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <x-storefront.form-field name="first_name" label="First name" required autofocus />
                        </div>
                        <div class="col-md-6">
                            <x-storefront.form-field name="last_name" label="Last name" required />
                        </div>
                    </div>

                    <x-storefront.form-field name="email" label="Email" type="email" required />
                    <x-storefront.form-field name="password" label="Password" type="password" required />
                    <x-storefront.form-field
                        name="password_confirmation"
                        label="Confirm password"
                        type="password"
                        required
                    />

                    <button type="submit" class="btn btn-primary w-100">Register</button>

                    <div class="text-center mt-3 small">
                        <a href="{{route('login')}}">Already have an account?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
