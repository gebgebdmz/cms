@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body">
                    <form class="login100-form validate-form " method="POST" action="{{ route('register') }}">
                        @csrf
                        <br>
                        <span class="login100-form-title p-b-26 ">

                            <center> Register </center>

                        </span>
                        <br>
                        <span class="login100-form-title p-b-48">
                            <!-- <i class="zmdi zmdi-font"></i> -->
                        </span>

                        @if (session('status'))
                        <div class="alert alert-success col-12 text-center" id="alert-message">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="wrap-input100 validate-input">
                            <input class="input100 @error('username') is-invalid @enderror" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            <span class="focus-input100" data-placeholder="username"></span>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100 @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <span class="focus-input100" data-placeholder="name"></span>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                            </span>
                            <input class="input100 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span class="focus-input100" data-placeholder="email"></span>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                            </span>
                            <input class="input100  @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                            <span class="focus-input100" data-placeholder="phone"></span>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                            </span>
                            <input class="input100  @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                            <span class="focus-input100" data-placeholder="address"></span>

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                            </span>
                            <input class="input100  @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                            <span class="focus-input100" data-placeholder="password"></span>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input">
                            </span>
                            <input class="input100" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"">
                                <span class=" focus-input100" data-placeholder="confirm password"></span>
                        </div>

                        <div class="container-login100-form-btn ">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Register
                                </button>

                            </div>
                        </div>

                        <div class="text-center p-t-15">
                            <span class="txt1">
                                already have an account?
                            </span>

                            <a class="txt2" href="{{ route('login') }}">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection