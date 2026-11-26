<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }} | Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite ('resources/js/app.js')
</head>

<body
    class="login-page"
    style="background-image: url('{{ asset('assets/images/Background.png') }}'); background-size: cover; background-position: center;"
>
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('assets/images/Dz5gMSnB2dt7wZHjluX6nGrgj.png') }}" width="90%" alt="NEW MJC" />
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Admin Login</p>

                <form action="{{ route('admin.login.post') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required autofocus />
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required />
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
