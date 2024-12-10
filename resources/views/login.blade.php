@extends('Layout.app2')

@section('content')

<div class="limiter">
    <div class="container-login100" style="background-image: url('/FrontEnd/images/bg-01.jpg');">
        <div class="wrap-login100">
            @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
            <form class="login100-form validate-form" action="/login/traitement" method="POST">
            @csrf
                <span class="login100-form-title p-b-34 p-t-27">
                    Log in
                </span>

                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100" type="text" name="email" placeholder="Email" required>
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" name="password" placeholder="Password" required>
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="contact100-form-checkbox">
                    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                    <label class="label-checkbox100" for="ckb1">
                        Remember me
                    </label>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-40">
                    <a class="txt1" href="/register">
                        Create an account ?
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="dropDownSelect1"></div>
@endsection