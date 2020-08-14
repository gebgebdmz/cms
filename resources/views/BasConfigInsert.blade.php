@extends('layouts.master')

@section('title', 'Details')

@section('content')
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<div class="container">
            <div class="col-md-2">
                <ul class="breadcrumb">
                    <li><a href="/BasConfig">Display</a></li>
                    <li><a href="/BasConfig/Insert">Insert</a></li>

                </ul>
            </div>
            <div class="col-md-8">
                <form  action="/BasConfig/Insert" method="post" > 
                @csrf

                    <div class="form-group">
                        <label>Key:</label>
                        <input type="text" class="form-control" name="key"  >
                    </div>
                    <div class="form-group">
                        <label>Value:</label>
                        <input type="text" class="form-control" name="value"   >
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <input type="text" class="form-control" name="description"  >
                    </div>
                   
                  
                    <button type="submit" class="btn btn-default" > Insert </button>
                </form>

            </div>
</div>



@endsection