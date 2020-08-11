@extends('layouts.master')
@section('title','Display User')

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ implode(', ', $errors->all(':message')) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#InsertUserModal">Add User <span class="badge badge-light">+</span></button>

            <div class="modal fade" id="InsertUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Insert User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/user/insert-user" method="POST">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="username">username:</label>
                                    <input type="text" class="form-control" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="password">password:</label>
                                    <input type="password" class="form-control" onmouseover="this.type='text'" onmouseout="this.type='password'" name="password">
                                </div>

                                <div class="form-group">
                                    <label for="name">name:</label>
                                    <input type="text" class="form-control" name="name">
                                </div>

                                <div class="form-group">
                                    <label for="email">e-mail:</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">phone:</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <div class="form-group">
                                    <label for="address">address:</label>
                                    <input type="address" class="form-control" name="address">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Role</label>
                                    @foreach ($roles as $role)
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="role[]" type="checkbox" value="{{$role->id}}">
                                                <label class="form-check-label">{{$role->name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Is Active</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option name="Yes" value="1" selected>Yes</option>
                                        <option name="No" value="0">No</option>
                                    </select>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="user-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Is Active</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="dynamic-row">
                        </tbody>
                    </table>

                    @foreach ($users as $user)
                    <div class="modal fade" id="modal_hapus_{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Apakah anda yakin?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Setelah dihapus, data ini tidak dapat dikembalikan!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Tidak Jadi</button>
                                    <a href="{{ url('user/delete-user', [$user->id]) }}" class="btn btn-danger">Ya, Hapus Data ini</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal_ubah_{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Update User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('user/edit-user', [$user->id]) }}" method="POST">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="username">username:</label>
                                            <input type="text" class="form-control" name="username" value="{{$user->username}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">name:</label>
                                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">phone:</label>
                                            <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control-plaintext" name="email" value="{{$user->email}}" style="padding: .625rem .75rem;" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">address:</label>
                                            <input type="address" class="form-control" name="address" value="{{$user->address}}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Role</label>
                                            <?php foreach ($roles as $role) { ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <?php if ($user->role == '-') { ?>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" name="role[]" type="checkbox" value="{{$role->id}}">
                                                                <label class="form-check-label">{{$role->name}}</label>
                                                            </div>
                                                            <?php } else {
                                                            $rolesUser = explode("|", $user->role);
                                                            $checked = FALSE;
                                                            for ($k = 0; $k < count($rolesUser); $k++) {
                                                                if ($rolesUser[$k] == $role->name) {
                                                                    $checked = TRUE;
                                                                }
                                                            }
                                                            if ($checked) { ?>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="role[]" type="checkbox" value="{{$role->id}}" checked>
                                                                    <label class="form-check-label">{{$role->name}}</label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" name="role[]" type="checkbox" value="{{$role->id}}">
                                                                    <label class="form-check-label">{{$role->name}}</label>
                                                                </div>
                                                        <?php }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Is Active</label>
                                            <select name="is_active" id="active" class="form-control">
                                                @if ($user->is_active == 1)
                                                <option name="Yes" value="1" selected>Yes</option>
                                                <option name="No" value="0">No</option>
                                                @elseif ($user->is_active == 0)
                                                <option name="Yes" value="1">Yes</option>
                                                <option name="No" value="0" selected>No</option>
                                                @else
                                                <option name="Yes" value="1">Yes</option>
                                                <option name="No" value="0" selected>No</option>
                                                @endif
                                            </select>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<script type="text/javascript">
    var row = 0;
    $(document).ready(function() {
        var table = $('#user-table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax": "{{route('user.getData')}}",
            "lengthMenu": [
                [20, 50, 100, 500, 1000, -1],
                [20, 50, 100, 500, 1000, "All"]
            ],
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "address"
                },
                {
                    "render": function(data, type, full, meta) {
                        if (full.is_active == '1') {
                            return 'Yes';
                        } else {
                            return 'No';
                        }
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        if (full.role == '-') {
                            return '<span class="badge badge-danger mr-1" style="text-transform: uppercase;">No Role</span>';
                        } else {
                            var role = full.role.split("|");
                            var strRole = '';
                            for (i = 0; i < role.length; i++) {
                                strRole = strRole + '<span class="badge badge-primary mr-1" style="text-transform: uppercase;">' + role[i] + '</span> ';
                            }
                            return strRole;
                        }
                    }
                },
                {
                    sortable: false,
                    "render": function(data, type, full, meta) {
                        return '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_ubah_' + full.id + '">Update</button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_hapus_' + full.id + '">Delete</button></div>';
                    }
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            }
        });

        $('#user-table thead tr').clone(true).appendTo('#user-table thead');
        $('#user-table thead tr:eq(1) th').each(function(i) {
            if (row < 6) {
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
    });
</script>
@endsection