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
<!-- 
@extends('frontend.master_login')
@section('title','Register')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
            @if (session('status'))
                        <div class="alert alert-success col-12 text-center" id="alert-message">
                            {{ session('status') }}
                        </div>
                        @endif

                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                <div class="card-body">
                    <form method="post" action="{{route('register')}}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="username">Username</label>
                            <input class="form-control py-4 @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Enter username" value="{{ old('username') }}" required autocomplete="username" autofocus />
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        <div class="form-group">
                            <label class="small mb-1" for="name">Name</label>
                            <input class="form-control py-4 @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Enter name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Enter email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputAddress">Address</label>
                            <input class="form-control py-4 @error('address') is-invalid @enderror" id="address" name="address" type="text" placeholder="Enter address" value="{{ old('address') }}" required autocomplete="address" autofocus />
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputPhone">Phone</label>
                            <input class="form-control py-4 @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" placeholder="Enter phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus />
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Password</label>
                                    <input class="form-control py-4  @error('password') is-invalid @enderror" id="password" type="password" placeholder="Enter password" name="password" required autocomplete="new-password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                    <input class="form-control py-4 " id="password" type="password" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4 mb-0"><button type="submit" class="btn btn-primary btn-block">Create Account</button></div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{ route('login')}}">Have an account? Go to login</a></div>
                    <br>
                    <div class="text-muted justify-content-between small">Copyright &copy; Your Website 2020</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
