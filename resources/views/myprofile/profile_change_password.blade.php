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



            <form action="/myprofile/update_password" method="POST" class="mt-3">
                {{ csrf_field() }}

                
                    <div class="form-group">
                      <label for="password">Old password:</label>
                      <input type="password" class="form-control" data-toggle="password" name="old_password" >
                    </div>

                    <div class="form-group">
                        <label for="password">New password:</label>
                        <input type="password" class="form-control" data-toggle="password" name="new_password" >
                      </div>

                      <div class="form-group">
                        <label for="password">Confirm New password:</label>
                        <input type="password" class="form-control" data-toggle="password" name="confirm_new_password" >
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
