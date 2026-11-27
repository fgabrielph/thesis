@extends ('site.layouts.storefront')

@section ('title') Set New Password @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 480px">
        <div class="card">
            <div class="card-header fw-semibold">Set a new password</div>

            <div class="card-body">
                <form method="POST" action="{{route('password.update')}}">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}" />

                    <x-storefront.form-field name="email" label="Email" type="email" required />
                    <x-storefront.form-field name="password" label="New password" type="password" required />
                    <x-storefront.form-field
                        name="password_confirmation"
                        label="Confirm password"
                        type="password"
                        required
                    />

                    <button type="submit" class="btn btn-primary w-100">Reset password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
