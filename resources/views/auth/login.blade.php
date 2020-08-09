@extends('frontend.home')
@section('title', 'login')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">
                    
                <form action="{{route('login')}}" method="POST">
                    @csrf
                        <div class="form-group  validate-input m-b-23" data-validate = "Username is required">
                            <label class="small mb-1" for="username">Username</label>
                            <input class="form-control py-4 @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Enter username" value="{{ old('username') }}" required autocomplete="username" autofocus />
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="password">Password</label>
                            <input class="form-control py-4  @error('password') is-invalid @enderror" id="password" type="password" placeholder="Enter password" name="password" required autocomplete="current-password" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                                <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                            </div>
                        </div> 
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                            <a class="small btn btn-link"  href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                            <button type="submit" class="btn btn-primary" href="index.html">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{route('register')}}">Need an account? Sign up!</a></div>
                    <br>
                    <div class="text-muted justify-content-between small">Copyright &copy; Your Website 2020</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
