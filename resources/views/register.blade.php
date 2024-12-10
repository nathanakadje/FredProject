
@extends('Layout.app')

@section('content')

{{-- <div class="limiter">
    <div class="container-login100" style="background-image: url('/FrontEnd/images/bg-01.jpg');">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action="/register/traitement" method="POST">
            @csrf
                <span class="login100-form-title p-b-34 p-t-27">
                    Register
                </span>
                <div class="wrap-input100 validate-input" data-validate = "Enter Name">
                    <input class="input100 @error('name') is-invalid @enderror" type="text" name="name" placeholder="Name">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    @error('name')
                    <div class="text-white">{{ $message }}</div>
                @enderror
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100 @error('email') is-invalid @enderror" type="text" name="email" placeholder="Email">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    @error('email')
                    <div class="text-white">{{ $message }}</div>
                @enderror
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    @error('password')
                    <div class="text-white">{{ $message }}</div>
                @enderror
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
                @if (session('status'))
                
                        <a href="#"  class="txt1 " >{{ session('status') }}</a>  
                
                 @endif

                <div class="text-center p-t-40">
                    <a class="txt1" href="/login">
                        Have an account
                    </a>
                </div>
            </form>         
        </div>
    </div>
</div>

<div id="dropDownSelect1"></div> --}}



<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action="/register/traitement" method="POST">
                @csrf
                <span class="login100-form-title p-b-43">
                    Login to continue
                </span>
                
            
                <div class="wrap-input100 validate-input" data-validate = "Valid name is required: ex@abc.xyz">
                    <input class="input100 @error('name') is-invalid @enderror" type="text" name="name" >
                    <span class="focus-input100"></span>
                    <span class="label-input100">Name</span>
                    @error('name')
                    <div class="text-white">{{ $message }}</div>
                @enderror
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="input100 @error('email') is-invalid @enderror" type="text" name="email">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Email</span>
                    @error('email')
                    <div class="text-white">{{ $message }}</div>
                @enderror
                </div>
                
                
                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100 @error('password') is-invalid @enderror" type="password" name="password">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                    @error('password')
                    <div class="text-white">{{ $message }}</div>
                @enderror
                </div>

                {{-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                    <div>
                        <a href="#" class="txt1">
                            Forgot Password?
                        </a>
                    </div>
                </div> --}}
        

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>


                <div class="text-center p-t-40">
                    <a class="txt1" href="/login">
                        Have an account
                    </a>
                </div>
            </form>

            <div class="login100-more" style="background-image: url('/FrontEnd2/Login_v18/images/bg-01.jpg');">
            </div>
        </div>
    </div>
</div>
@endsection