@extends ('site.layouts.storefront')

@section ('title') Login @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 480px">
        <div class="card">
            <div class="card-header fw-semibold">Login</div>

            <div class="card-body">
                <form method="POST" action="{{route('login')}}">
                    @csrf

                    <x-storefront.form-field name="email" label="Email" type="email" required autofocus />
                    <x-storefront.form-field name="password" label="Password" type="password" required />

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>

                    <div class="d-flex justify-content-between mt-3 small">
                        <a href="{{route('password.request')}}">Forgot your password?</a>
                        <a href="{{route('register')}}">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
