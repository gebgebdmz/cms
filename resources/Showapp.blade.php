

<div class="container mt-5">
    <div class="row">
    @if (session('status'))
                <div class="alert alert-success col-12 text-center" id="alert-message">
                    {{ session('status') }}
                </div>
            @endif 
            @if (session('failure'))
            
            <div class="col-6">
                <div class="alert alert-danger col-12 text-center" id="alert-message">
                    {{ session('failure') }}
                </div>
                </div>
            @endif
        <div class="col-12">
            <!-- Modal -->
            <div class="float-left">
                    <div class="form-group mx-sm-3 mb-2">
                    <form class="form-inline">
                       
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="ni ni-fat-add"></i>
                        </button>
                    </div>
                    </form>
            </div>
            
            
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Tambah App</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="app/create" method="POST">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="username">Name App</label>
                                    <input type="text" class="form-control" name="app_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="Type">Type App</label>
                                    <input type="text" class="form-control" name="app_type" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <input type="text" class="form-control" name="description" required>
                                </div>

                                <div class="form-group">
                                    <label for="text">Nama Menu</label>
                                    <input type="text" class="form-control" name="menu_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">URL Menu</label>
                                    <input type="text" class="form-control" name="menu_url" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ni ni-fat-remove"></i></button>
                            <button type="submit" class="btn btn-primary"><i class="ni ni-check-bold"></i></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table table-striped" id="app">
                <thead>
                    <tr>
                        <th scope="col">Nama App</th>
                        <th scope="col">Type App</th>
                        <th scope="col">Description</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">URL Menu</th>
                        <th scope="col"></th>
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
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit App</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="app_form_{{$p->id}}" action="{{ url('update', [$p->id]) }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" form="app_form_{{$p->id}}" />

                                <div class="form-group">
                                    <label for="username">Name App</label>
                                    <input type="text" class="form-control" name="app_name" value="{{$p->app_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="Type">Type App</label>
                                    <input type="text" class="form-control" name="app_type" value="{{$p->app_type}}">
                                </div>

                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <input type="text" class="form-control" name="description" value="{{$p->description}}">
                                </div>

                                <div class="form-group">
                                    <label for="text">Nama Menu</label>
                                    <input type="text" class="form-control" name="menu_name" value="{{$p->menu_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">URL Menu</label>
                                    <input type="text" class="form-control" name="menu_url" value="{{$p->menu_url}}">
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ni ni-fat-remove"></i></button>
                            <button type="submit" form="app_form_{{$p->id}}" class="btn btn-primary"><i class="ni ni-check-bold"></i></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            
            @foreach ($app as $p)
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
                            <a href="{{ url('destroy', [$p->id]) }}" class="btn btn-danger"><i class="ni ni-check-bold"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<script>
    var row = 0;

        $(document).ready(function() {
           
           
            $('#app thead tr').clone(true).appendTo( '#app thead' );
    $('#app thead tr:eq(1) th').each( function (i) {
        if (row < 5) {
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

    var table =   $('#app').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata.app') }}",
            "lengthMenu" : [[20, 50, 100, 500, 1000, -1],[20, 50, 100, 500, 1000, "All"]],
            "columns":[
                { "data": "app_name" },
                { "data": "app_type" },
                { "data": "description" },
                { "data": "menu_name" },
                { "data": "menu_url" },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit_'+full.id+'"><i class="ni ni-single-02"></i></button>';
                    }
                },

                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        return '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_hapus_'+full.id+'"><i class="ni ni-fat-delete"></i></button>';
                    }
                },

        ],
     });

     


    
} );
    </script>

