@extends('admin.layout.main')

@section('content')
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div class="alert-icon">
        <i class="fa fa-check"></i>
    </div>
    <div class="alert-message">
        <span><strong>Success!</strong> {{ session()->get('success') }}</span>
    </div>
</div>
@endif
<div class="success-alert" style="display:none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Admin Roles</span></div>
                <div class="float-sm-right"> 
                    <a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('admin_roles.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Role"><span class="name">Add Admin Role</span> </a> 
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ROLE NAME</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admin_roles as $key => $admin_role)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$admin_role->role_name}}</td>
                                <td>{{$admin_role->status}}</td>
                                <td>{{$admin_role->created_at->format('d M Y - H:i:s')}}</td>
                                <td class="action">
                                    <form id="deletefrm_{{$admin_role->id}}" action="{{ route('admin_roles.destroy', $admin_role->id) }}" class="delete" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('admin_roles.edit', $admin_role->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Role">
                                            <i class="icon-note icons"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteRow('{{$admin_role->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Role"><i class="icon-trash icons"></i>

                                        <a href="javascript:void(0);" onclick="changeStatus('{{$admin_role->id}}')" ><i class="fa fa-circle status_{{$admin_role->id}}" style="@if($admin_role->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$admin_role->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i></a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>ROLE NAME</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            lengthChange: false,
            columnDefs: [{
                "orderable": false,
                "targets": 4
            }],
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        });
        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    });

    function deleteRow(id)
    {   
        $('#deletefrm_'+id).submit();
    }

    function changeStatus(id) {
        $.ajax({
            data: {
            "_token": "{{ csrf_token() }}",
            "id": id
            },
            url: "{{ url('admin/admin_roles') }}/"+id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                var status = '';
                 // $('.status_'+id).attr('title',data);
                if(data == 'active'){
                    status = 'activated';
                    $('.status_'+id).css('color','#009933');
                    
                }else{
                    status = 'deactivated';
                    $('.status_'+id).css('color','#ff0000');
                }
                $('.success-alert').show();
                var suc_str = '';
                suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
                suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
                suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
                suc_str +='<div class="alert-message"><span><strong>Success!</strong> Role has been '+status+'.</span></div>';
                suc_str +='</div>';
                $('.success-alert').html(suc_str);
            },
            error: function (data) {
            }
        });
    }
</script> 
@endsection 