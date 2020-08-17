@extends('frontend.master_login')
@section('title','Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6  ">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                    <div class="card-body">
                        <form method="post" action="{{route('login')}}">
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
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control py-4  @error('password') is-invalid @enderror" id="password" type="password" placeholder="Enter password" name="password" required autocomplete="new-password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>       
                            
                       <button type="submit" class="btn btn-primary btn-block">Login</button>

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
</div>
@endsection

