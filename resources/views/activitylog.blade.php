@extends('layouts.master')

@section('title', 'Activity Log Page')

@section('content')
<div class="container">
    <div class="table-responsive m-b-40">
        <br>
        <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr >
                    <th>ID</th>
                    <th>Date</th>
                    <th>Username</th>
                    <th>Application</th>
                    <th>Creator</th>
                    <th>Ip Address</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Username</th>
                    <th>Application</th>
                    <th>Creator</th>
                    <th>Ip Address</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>UserAgent</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
@section('javascript')

<script>

// Simple server-side processing
$(document).ready(function() {
    
// Setup - add a text input to each footer cell
$('#example tfoot th').each(function() {
var title = $(this).text();
$(this).html('<input style="width:auto" type="search" placeholder="Search ' + title + '" />');
});
var table = $('#example').dataTable({
    "processing": true,
    "serverSide": true,
    "ajax" : {
        url: "{{ route('activity.getData') }}",
    },
    "columns":[
                { "data": "id" },
                { "data": "inserted_date" },
                { "data": "username" },
                { "data": "application" },
                { "data": "creator" },
                { "data": "ip_user" },
                { "data": "action" },
                { "data": "description" },
                { "data": "user_agent" },],
    select: true,
    retrieve: true,
    orderCellsTop: true,
    fixedHeader: false,
    "language": {"paginate": {"next": ">","previous": "<"} },
    "order": [[ 0, "desc" ]],
    "lengthMenu" : [[20, 50, 100, 500, 1000, -1],[20, 50, 100, 500, 1000, "All"]],
    
    
    
    initComplete: function() {
    var api = this.api();

    // Apply the search
    api.columns().every(function() {
        var that = this;

        $('input', this.footer()).on('keyup change', function() {
        if (that.search() !== this.value) {
            that
            .search(this.value)
            .draw();
        }
        });
    });
    }
});
});
</Script>
   
@endsection