@extends('layouts.master')

@section('title', 'Details')

@section('content')
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<div class="container">
            <div class="col-md-2">
                <ul class="breadcrumb">
                    <li><a href="/BasRole">Display</a></li>
                    <li><a href="/BasRole/Insert">Insert</a></li>

                </ul>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label>ID:</label>
                    <input type="text" class="form-control" name="id" value="{{$list->id}}" disabled >
                </div>
          
             
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" name="key" value="{{$list->name}}" disabled  >
                </div>
                <div class="form-group">
                    <label>remark:</label>
                    <input type="text" class="form-control" name="value"  value="{{$list->remark}}" disabled  >
                </div>
              
            </div>
           
                  
        </div>    



@endsection