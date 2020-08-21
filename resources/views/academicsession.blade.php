@extends('layouts.master')
@section('title','Academic Session')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
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

            <!-- button view modal -->
            <div class="float-left">
            <div class="form-group mx-sm-3 mb-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            +Add Session
            </button>
            </div>
            </div>
            <!-- end modal -->

            <!-- page view modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('academicsession.create') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="username">Session</label>
                                <input type="text" class="form-control" name="session" required>
                            </div>
                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</i></button>
                            <button type="submit" class="btn btn-primary">Ok</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal -->

            <!-- table menu -->
            <table id="session" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Session</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <!-- end table -->

            <!-- edit modal -->
            @foreach ($academicsession as $a)
            <div class="modal fade" id="modal_edit_{{$a->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Session</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                        <form id="academic_session_form_{{$a->id}}" action="{{ url('academicsession/update', [$a->id]) }}" method="POST">
                        @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" form="academic_session_form_{{$a->id}}" />

                            <div class="form-group">
                                <label for="username">Session</label>
                                <input type="text" class="form-control" name="session" value="{{$a->session}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" form="academic_session_form_{{$a->id}}" class="btn btn-primary">Ok</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- end edit -->
            @foreach ($academicsession as $a)
            <div class="modal fade" id="modal_delete_{{$a->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        are you sure want to delete?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="{{ url('academicsession/destroy', [$a->id]) }}" class="btn btn-primary">Ok</a>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    var row = 0;

    $(document).ready(function() {
        $('#academicsession thead tr').clone(true).appendTo('#academicsession thead');
        $('#academicsession thead tr:eq(1) th').each(function(i) {
            if (row < 2) {
                var title= $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '"/>');
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

        var table = $('#academicsession').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata.getacadsess') }}",
            "lengthMenu": [
                [100, -1],
                [100, "All"]
            ],
            "columns" : [{
                "data": "session"
                },
                {
                    sortable: false,
                    "render": function(data, type, full, meta) {
                        return '<div class="btn-group" role="group"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit_' + full.id + '">Edit <i class="ni ni-single-02"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_' + full.id + '">Delete <i class="ni ni-fat-delete"></i></button></div>';
                    }
                },
            ],
        });

        $('.selectpicker').selectpicker({
            style: 'btn-default',
        });
    });
</script>
@endsection
