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
                <form  action="/BasRole/Insert" method="post" > 
                @csrf

                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name"  >
                    </div>
                    <div class="form-group">
                        <label>Remark:</label>
                        <input type="text" class="form-control" name="remark"   >
                    </div>
                  
                    <button type="submit" class="btn btn-default" > Insert </button>
                </form>

            </div>
</div>



@endsection