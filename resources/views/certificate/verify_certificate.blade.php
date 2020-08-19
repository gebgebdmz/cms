@extends('layouts.header_and_footer')
@section('title', 'Certificate')
@section('content')



                
<div class="col-lg-12 text-center mt-5">
    <h1>Search your certificate here</h1>
    <h3>Enter your certification code or your name here</h3>
</div>

<div class="col-md-4 offset-md-4 mt-5 ">
    <div class="input-group mb-3">
        <form action="" class="site-block-top-search" method="POST">
            @csrf
            <div class="form-inline"> 
                <input type="text" class="form-control" name="s_sertif" placeholder="Search">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</div>


@endsection