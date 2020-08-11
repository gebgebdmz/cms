@extends('layouts.master')
    @section('title', 'menu')
    @section('content')
 <div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="float-right">
            @if ($message = Session::get('sukses'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button> 
					<strong>{{ $message }}</strong>
				</div>
				@endif
                
                    <!-- end search  -->
            </div>
            <!-- button modal  -->
            <div class="float-left">
            <div class="form-group mx-sm-3 mb-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            +Add Menu
            </button>
            </div>
            </div>
            <!-- end button  -->
           
          
            <!-- view modal  -->
                             
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Menu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                   
                        <div class="modal-body">
                            <form action="{{ route('create') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="username">App Name</label>
                                    <input type="text" class="form-control" name="app_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="Type">Parent Menu ID</label>
                                    <input type="text" class="form-control" name="parent_menu_id" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Role ID</label>
                                    <input type="text" class="form-control" name="role_id" required>
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
            <!-- end modal  -->
            <!-- table menu  -->
                        <table id="table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Name App</th>
                                    <th class="text-center">Parent menu</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
            <!-- end table   -->

            <!-- Edit modal  -->
            @foreach ($menu as $m)
            <div class="modal fade" id="modal_edit_{{$m->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit menu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="menu_form_{{$m->id}}" action="{{ url('menu/update', [$m->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" form="menu_form_{{$m->id}}" />

                            <div class="form-group">
                                <label for="username">App Name</label>
                                <input type="text" class="form-control" name="app_name" value="{{$m->app_name}}">
                            </div>
                            <div class="form-group">
                                <label for="Type">Parent Menu ID</label>
                                <input type="text" class="form-control" name="parent_menu_id" value="{{$m->parent_menu_id}}">
                            </div>

                            <div class="form-group">
                                <label for="name">Role ID</label>
                                <input type="text" class="form-control" name="role_id" value="{{$m->role_id}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" form="menu_form_{{$m->id}}" class="btn btn-primary">Ok</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- end edit  -->
            @foreach ($menu as $m)
            <div class="modal fade" id="modal_hapus_{{$m->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        do you want to delete?    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="{{ url('menu/destroy', [$m->id]) }}" class="btn btn-primary">Ok</a>
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
            var table = $('#table').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata.datajax') }}",
            "lengthMenu" : [[20, 50, 100, 500, 1000, -1],[20, 50, 100, 500, 1000, "All"]],
            "columns":[
                { "data": "app_name" },
                { "data": "parent_menu_id" },
                { "data": "name" },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        return '<div class="text-center"><button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal_edit_'+full.id+'">Edit</button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_hapus_'+full.id+'">Delete</button></div>';
                        
                    }
                    
                },

            ],
            });
       $('#table thead tr').clone(true).appendTo( '#table thead' );
    $('#table thead tr:eq(1) th').each( function (i) {
        if (row < 3 ) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        } else {
            $(this).html('');
        }
        row++;
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );



     


    
} );
    </script>

<!-- end live search  -->
@endsection
