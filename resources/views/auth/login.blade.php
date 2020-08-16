@extends('frontend.master_login')
@section('title','Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6  ">
            <div class="card">

                <div class="card-body">
                    <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <br>
                        <span class="login100-form-title p-b-26 ">

                            <center> Login </center>

                        </span>
                        <br>
                        <span class="login100-form-title p-b-48">
                        </span>

                        <label for="username">Username</label>
                        <div class="wrap-input100 validate-input">
                            <input class="input100 @error('username') is-invalid @enderror" value="{{ old('username') }}" required autocomplete="username" autofocus type="text" name="username">
                            <span class="focus-input100" data-placeholder="username"></span>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <label for="password">Password</label>  
                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                            </span>
                            <input class="input100  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" type="password">
                            <span class="focus-input100" data-placeholder="Password"></span>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Login
                                </button>
                            </div>
                        </div>

                        <div class="text-center p-t-100">
                            <span class="txt1">
                                Don’t have an account?
                            </span>
                            <a class="txt2" href="{{ route('register') }}">
                                Register
                            </a>
                            <br>
                            <a class=" txt1 btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection