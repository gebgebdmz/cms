@extends('layouts.master')

@section('title', 'Details')

@section('content')
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<div class="container">
            <div class="col-md-3">
                <ul class="breadcrumb">
                    <li><a href="/BasRole">Display</a></li>
                    <li><a href="/BasRole/Insert">Insert</a></li>

                </ul>
            </div>

            <div class="col-md-8">
            <form  action="/BasRole/Update/{{$list->id}}" method="post" > 
               @method('patch')
                @csrf
                    <div class="form-group">
                        <label>ID:</label>
                        <input type="text" class="form-control" name="id" value="{{$list->id}}" disabled >
                    </div>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name" value="{{$list->name}}"   >
                    </div>
                    <div class="form-group">
                        <label>Remark:</label>
                        <input type="text" class="form-control" name="remark"  value="{{$list->remark}}"  >
                    </div>
                   
                  
                    <button type="submit" class="btn btn-default" > Update </button>
                </form>

            </div>
           
                  
        </div>    



@endsection