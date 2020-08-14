@extends('layouts.master')
@section('title','Profile')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">


                @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ implode(', ', $errors->all(':message')) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



            <form action="/myprofile" method="POST" class="mt-3">
                {{ csrf_field() }}
                    <div class="form-group">
                      <label for="username">username:</label>
                      <input type="text" class="form-control" name="username"  value="{{$profile_data -> username}}">
                    </div>
                    <div class="form-group">
                      <label for="password">password:</label>
                      <a href="{{ url('myprofile/edit_password') }}" class="btn btn-warning btn-sm">Edit Password</a>
                    </div>

                    <div class="form-group">
                        <label for="name">name:</label>
                        <input type="text" class="form-control" name="name" value="{{$profile_data -> name}}">
                      </div>

                    <div class="form-group"> 
                        <label for="email">e-mail:</label>
                        <div class="form-inline"> 
                            <input type="email" class="form-control" name="email" value="{{$profile_data -> email}}" disabled>
                            <a href="{{ url('myprofile/edit_email') }}" class="btn btn-warning ">Edit Email</a>
                        </div>
                    </div>

                      

                      <div class="form-group">
                        <label for="phone">phone:</label>
                        <input type="text" class="form-control" name="phone" value="{{$profile_data -> phone}}">
                      </div>

                      <div class="form-group">
                        <label for="address">address:</label>
                        <input type="address" class="form-control" name="address" value="{{$profile_data -> address}}">
                      </div>

                       <div class="row">
                           <div class="col-md-4">
                            </div>
                            <div class="col-md-6">

                                <button type="submit" class="btn btn-primary">Update</button>

                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>

                </form>


            </div>
            <div class="col-md-3">
            </div>
        </div>

    </div>
@endsection
