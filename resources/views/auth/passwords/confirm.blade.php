@extends ('site.layouts.storefront')

@section ('title') Confirm Password @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 480px">
        <div class="card">
            <div class="card-header fw-semibold">Confirm your password</div>

            <div class="card-body">
                <p>Please confirm your password before continuing.</p>

                <form method="POST" action="{{route('password.confirm')}}">
                    @csrf

                    <x-storefront.form-field name="password" label="Password" type="password" required autofocus />

                    <button type="submit" class="btn btn-primary w-100">Confirm password</button>

                    <div class="text-center mt-3 small">
                        <a href="{{route('password.request')}}">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
