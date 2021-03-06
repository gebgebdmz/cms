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



            <form action="/myprofile/update_email" method="POST" class="mt-3">
                {{ csrf_field() }}
                 

                <div class="form-group"> 
                    <label for="email">Old Email:</label>
                    <div class="form-inline"> 
                        <input type="email" class="form-control" name="email" value="{{$profile_data -> email}}" disabled>
                    </div>
                </div>

                    <div class="form-group">
                        <label for="email">New Email:</label>
                        <input type="email" class="form-control" name="email" value=" " >
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
