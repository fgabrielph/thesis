@extends ('site.layouts.storefront')

@section ('title') Reset Password @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 480px">
        <div class="card">
            <div class="card-header fw-semibold">Reset password</div>

            <div class="card-body">
                <form method="POST" action="{{route('password.email')}}">
                    @csrf

                    <x-storefront.form-field name="email" label="Email" type="email" required autofocus />

                    <button type="submit" class="btn btn-primary w-100">Send password reset link</button>

                    <div class="text-center mt-3 small">
                        <a href="{{route('login')}}">Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
