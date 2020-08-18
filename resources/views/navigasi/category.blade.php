@extends('layouts.master')
    @section('title', 'category')
    @section('content')
 <div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <!-- button modal  -->
            <div class="float-left">
            <div class="form-group mx-sm-3 mb-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            +Add Category
            </button>
            </div>
            </div>
            <!-- end button  -->
           
          
            <!-- view modal  -->
                             
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                   
                        <div class="modal-body">
                            <form action="{{ route('category.create') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="username">Category Code</label>
                                    <input type="text" class="form-control" name="category_code" required>
                                </div>
                                <div class="form-group">
                                    <label for="Type">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Category Fullname</label>
                                    <input type="text" class="form-control" name="category_fullname" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Parent Category Code</label>
                                    <input type="text" class="form-control" name="parent_category_code" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Category Desc</label>
                                    <input type="text" class="form-control" name="category_desc" required>
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
                        <table id="category" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Category Code</th>
                                    <th class="text-center">Category Name</th>
                                    <th class="text-center">Category Fullname</th>
                                    <th class="text-center">Parent Category Code</th>
                                    <th class="text-center">Category Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
            <!-- end table   -->

            <!-- Edit modal  -->
            @foreach ($category as $m)
            <div class="modal fade" id="modal_edit_{{$m->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="category_form_{{$m->id}}" action="{{ url('category/update', [$m->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" form="category_form_{{$m->id}}" />

                            <div class="form-group">
                                <label for="username">Category Code</label>
                                <input type="text" class="form-control" name="category_code" value="{{$m->category_code}}">
                            </div>
                            <div class="form-group">
                                <label for="Type">Category Name</label>
                                <input type="text" class="form-control" name="category_name" value="{{$m->category_name}}">
                            </div>

                            <div class="form-group">
                                <label for="name">Category Fullname</label>
                                <input type="text" class="form-control" name="category_fullname" value="{{$m->category_fullname}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Parent Category Code</label>
                                <input type="text" class="form-control" name="parent_category_code" value="{{$m->parent_category_code}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Category Description </label>
                                <input type="text" class="form-control" name="category_desc" value="{{$m->category_desc}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" form="category_form_{{$m->id}}" class="btn btn-primary">Ok</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- end edit  -->
            @foreach ($category as $m)
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
                            <a href="{{ url('category/destroy', [$m->id]) }}" class="btn btn-primary">Ok</a>
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


    $('#category thead tr').clone(true).appendTo('#category thead');
    $('#category thead tr:eq(1) th').each(function(i) {
        if (row < 5) {
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

    var table = $('#category').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('ajaxdata.getcategory') }}",
        "lengthMenu": [
            [20, 50, 100, 500, 1000, -1],
            [20, 50, 100, 500, 1000, "All"]
        ],
        "columns": [{
                "data": "category_code"
            },
            {
                "data": "category_name"
            },
            {
                "data": "category_fullname"
            },
            {
                "data": "parent_category_code"
            },
            {
                "data": "category_desc"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    return '<div class="btn-group" role="group"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit_' + full.id + '">Edit <i class="ni ni-single-02"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_hapus_' + full.id + '">Delete <i class="ni ni-fat-delete"></i></button></div>';
                }
            },
        ],
    });


    $('.selectpicker').selectpicker({
        style: 'btn-default',
        //  size: false
    });

});
    </script>

<!-- end live search  -->
@endsection


