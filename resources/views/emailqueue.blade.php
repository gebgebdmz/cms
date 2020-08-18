@extends('layouts.master')

@section('title', 'Email Queue')

@section('content')
<div class="container">
    <div class="table-responsive m-b-40">
        <br>
        
        <table class="table table-striped" id="email">
            <thead >
                <tr >
                    <th>Destination Email</th>
                    <th>Email Body</th>
                    <th>Email Subject</th>
                    <th>Created At</th>
                    <th>Sent At</th>
                    <th>Is Proccessed</th>
                </tr>
            </thead>
            <tbody id="dynamic-row">
                 
                </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<link  rel="stylesheet" href="{{ asset('css/breadcrumb.css') }}">
<script>
    var row = 0;

        $(document).ready(function() {
           
           
            $('#email thead tr').clone(true).appendTo( '#email thead' );
    $('#email thead tr:eq(1) th').each( function (i) {
        if (row < 5) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:250px;" placeholder="Search ' + title + '" />');
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

    var table =   $('#email').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata.email') }}",
            "lengthMenu" : [[20, 50, 100, 500, 1000, -1],[20, 50, 100, 500, 1000, "All"]],
            "columns":[
                { "data": "destination_email" },
                { "data": "email_body" },
                { "data": "email_subject" },
                { "data": "created_at" },
                { "data": "sent_at" },
                { "data": "is_processed" },
        ],
     });

     


    
} );
    </script>

    
@endsection