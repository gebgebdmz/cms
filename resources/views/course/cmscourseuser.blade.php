@extends('layouts.master')
@section('title','Course-User')
@section('content')
            <div class="container-fluid mt-5">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                          
                                <!-- <div class="alert alert-success col-4" role="alert">
                                    A simple success alert—check it out!
                                </div> -->
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Course_user
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Course</th>
                                                <th class="text-center">Login</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Academic_session</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cmsCU as $cms)
                                            <tr>
                                            <td class="text-center">{{ $cms->courseid }}</td>
                                            <td class="text-center">{{ $cms->loginid }}</td>
                                            <td class="text-center">{{ $cms->role }}</td>
                                            <td class="text-center">{{ $cms->academic_session }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        "processing": true,
                        "serverSide": true,

                        $(document).ready(function() {
                        $('#table').DataTable();
                    } );
                    </script>



@endsection