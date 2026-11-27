@extends ('site.layouts.storefront')

@section ('title') Verify Email @endsection

@section ('content')
    <div class="sf-auth mx-auto" style="max-width: 560px">
        <div class="card">
            <div class="card-header fw-semibold">Verify your email address</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p>
                    Before proceeding, please check your email for a verification link. If you did not receive the email,
                </p>

                <form method="POST" action="{{route('verification.resend')}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Request another link</button>
                </form>
            </div>
        </div>
    </div>
@endsection
