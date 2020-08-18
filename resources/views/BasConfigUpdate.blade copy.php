@extends('layouts.master')

@section('title', 'Details')

@section('content')
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<div class="container">
            <div class="col-md-3">
                <ul class="breadcrumb">
                    <li><a href="/BasConfig">Display</a></li>
                    <li><a href="/BasConfig/Insert">Insert</a></li>

                </ul>
            </div>

            <div class="col-md-8">
            <form  action="/BasConfig/Update/{{$list->id}}" method="post" > 
               @method('patch')
                @csrf
                    <div class="form-group">
                        <label>ID:</label>
                        <input type="text" class="form-control" name="id" value="{{$list->id}}" disabled >
                    </div>
                    <div class="form-group">
                        <label>Key:</label>
                        <input type="text" class="form-control" name="key" value="{{$list->key}}"   >
                    </div>
                    <div class="form-group">
                        <label>Value:</label>
                        <input type="text" class="form-control" name="value"  value="{{$list->value}}"  >
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <input type="text" class="form-control" name="description" value="{{$list->description}}"   >
                    </div>
                  
                    <button type="submit" class="btn btn-default" > Update </button>
                </form>

            </div>
           
                  
        </div>    



@endsection