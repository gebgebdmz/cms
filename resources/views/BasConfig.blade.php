@extends('layouts.master')

@section('title', 'Bas_Config Page')

@section('content')
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<script>  
    var row = 0;
        $(document).ready(function(){  
           // $('#tabel_bas_config').DataTable(); 

           $('#tabel_bas_config thead tr').clone(true).appendTo( '#tabel_bas_config thead' );
            $('#tabel_bas_config thead tr:eq(1) th').each( function (i) {
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
                });
            }); 



            var table = $('#tabel_bas_config').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('ajaxdata.getsomething') }}",
                "lengthMenu" : [[20, 50, 100, 500, 1000, -1],[20, 50, 100, 500, 1000, "All"]],
                "columns":[
                    { "data": "id" },
                    { "data": "key" },
                    { "data": "value" },
                    { "data": "description" },
                    {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                        var buttonID = '/BasConfig/'+full.id;
                        return '<a href='+buttonID+' class="btn btn-info rolloverBtn" role="button">Details</a>';
                        }
                    },

                    {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                        var buttonID = '/BasConfig/Update/'+full.id;
                        return '<a href='+buttonID+' class="btn btn-warning rolloverBtn" role="button">Update</a>';
                        }
                    },

]       
});

        });  
 </script>   

<div class="container">
    <div class="col-md-3">
        <ul class="breadcrumb">
            <li><a href="/BasConfig">Display</a></li>
            <li><a href="/BasConfig/Insert">Insert</a></li>
        </ul>
    </div>
    
    <!--
    <div class="col-md-10">
    -->
        <div class="table-responsive m-b-40">
            <br>
            <table id="tabel_bas_config" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr >
                        <th>ID</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Description</th>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Description</th>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    <!--
    </div>
        -->
</div>




@endsection