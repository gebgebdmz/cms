@extends('layouts.master')
@section('title','Course')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Course</li>
    </ol>
</div>
<div class="container">
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


    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <!-- Modal -->


                <div class="modal fade" id="ModalInsertData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="course/create" method="POST">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label class="control-label">FullName:</label>
                                        <input type="text" class="form-control" name="course_fullname" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">ShortName:</label>
                                        <input type="text" class="form-control" name="course_shortname" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Id Number:</label>
                                        <input type="text" class="form-control" name="course_idnumber" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Category:</label>
                                        <input type="text" class="form-control" name="course_category" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Duration:</label>
                                        <input type="text" class="form-control" name="course_duration" required>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="ni ni-fat-remove"></i></button>
                                <button type="submit" class="btn btn-primary">Add Data<i class="ni ni-check-bold"></i></button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary mb-2 float-left" data-toggle="modal" data-target="#ModalInsertData">Insert Data</button>

                <table class="table table-striped" id="app">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Course Fullname</th>
                            <th scope="col">Course Shortname</th>
                            <th scope="col">Course Id Number</th>
                            <th scope="col">Course Category</th>
                            <th scope="col">Course Duration</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dynamic-row">

                    </tbody>
                </table>
                @foreach ($app as $p)
                <div class="modal fade" id="modal_edit_{{$p->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="app_form_{{$p->id}}" action="{{ url('course/update', [$p->id]) }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="app_form_{{$p->id}}" />

                                    <div class="form-group">
                                        <label class="control-label">FullName:</label>
                                        <input type="text" class="form-control" name="course_fullname" value="{{$p->course_fullname}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">ShortName:</label>
                                        <input type="text" class="form-control" name="course_shortname" value="{{$p->course_shortname}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Id Number:</label>
                                        <input type="text" class="form-control" name="course_idnumber" value="{{$p->course_idnumber}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Category:</label>
                                        <input type="text" class="form-control" name="course_category" value="{{$p->course_category}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Duration:</label>
                                        <input type="text" class="form-control" name="course_duration" value="{{$p->course_duration}}" required>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel <i class="ni ni-fat-remove"></i></button>
                                <button type="submit" form="app_form_{{$p->id}}" class="btn btn-primary">Update <i class="ni ni-check-bold"></i></button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- @foreach ($app as $p)
                <div class="modal fade" id="modal_hapus_{{$p->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Data akan dihapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Data yang dihapus tidak dapat dikembalikan!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="ni ni-fat-remove"></i></button>
                                <a href="{{ url('roleapp/delete', [$p->id]) }}" class="btn btn-danger"><i class="ni ni-check-bold"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

    <link rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
  
    <script>
        //load search, individual or not
        var row = 0;

        $(document).ready(function() {


            $('#app thead tr').clone(true).appendTo('#app thead');
            $('#app thead tr:eq(1) th').each(function(i) {
                if (row < 7) {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                } else {
                    $(this).html('');
                }
                row++;
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            //load datatable processing, using serverside yajra, with pagination option, also action button as well

            var table = $('#app').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('ajaxdata.getcourse') }}",
                "lengthMenu": [
                    [20, 50, 100, 500, 1000, -1],
                    [20, 50, 100, 500, 1000, "All"]
                ],
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "course_fullname"
                    },
                    {
                        "data": "course_shortname"
                    },
                    {
                        "data": "course_idnumber"
                    },
                    {
                        "data": "course_category"
                    },
                    {
                        "data": "course_duration"
                    },
                    {
                        sortable: false,
                        "render": function(data, type, full, meta) {
                            return '<div class="btn-group" role="group"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit_' + full.id + '">Edit <i class="ni ni-single-02"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_hapus_' + full.id + '">Delete <i class="ni ni-fat-delete"></i></button></div>';
                        }
                    },
                ],
            });

        });
    </script>


@endsection