@extends('vendor.layout.main')

@section('content')
<style type="text/css">
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
   /* height: 450px;*/
    overflow-y: auto;
}
.schedule-booking .row {
        width: 100%;
        margin: auto;
}
div#myModal {
        width: 50%;
        margin: auto;
    }

</style>
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
                <div class="left"><span>Vendor Roles</span></div>
                <!-- <div class="float-sm-right"> <a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.vendor_roles.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Role"> <span class="name">Add Role</span> </a> </div> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ROLE NAME</th>
                                <th>DATE</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendor_roles as $key => $vendor_role)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="JavaScript:void(0);" onclick="viewRoles({{$vendor_role->id}})">{{$vendor_role->role_name}} </a></td>
                                <td>{{$vendor_role->created_at->format('d M Y - H:i:s')}}</td>
                                <td class="action">
                                    <form id="deletefrm_{{$vendor_role->id}}" action="{{ route('vendor.vendor_roles.destroy', $vendor_role->id) }}" class="delete" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('vendor.vendor_roles.edit', $vendor_role->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Role">
                                            <i class="icon-note icons"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteRow('{{$vendor_role->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Role"><i class="icon-trash icons"></i>

                                        <a href="javascript:void(0);" onclick="changeStatus('{{$vendor_role->id}}')" >
                                            <i class="fa fa-circle status_{{$vendor_role->id}}" style="@if($vendor_role->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$vendor_role->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>ROLE NAME</th>
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

<div class="modal fade" id="customerListModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content schedule-booking" style="width: 56%;margin-left: 303px;">
            <div class="modal-header" style="margin-left:15px;">
                <div class="row">
                    <div class="col-sm-6"><h5 class="modal-title">Vendors</h5></div>
                    <div class="col-sm-6"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                </div>
            </div>
            <div class="modal-body" id="assign-modal">
                <table id="customer-list" class="table table-striped">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Action</td>
                        </tr>
                        <tbody class="role_customer">
                          
                        </tbody>
                    </thead>
                </table>
            </div>
           <!--  <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        lengthChange: false,
        columnDefs: [{
            "orderable": false,
            "targets": 3
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
        url: "{{ url('vendor/vendor_roles') }}/"+id,
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

function viewRoles(id)
{
    $('#customer-list').DataTable().destroy();
    var html ='';
    $.ajax({
        url:'{{ url("vendor/vendor_roles/show") }}/'+id,
        type: "GET",
        dataType: 'html',
        success: function (data) {
            var modal_data = $.parseJSON(data);
            $("#customerListModal").modal("show");
            $.each(modal_data, function( key, value ) {
                var url = '{{ url("vendor/vendor_roles/delete") }}/'+value.id;
                html += '<tr><td>'+value.name+'</td><td>'+value.email+'</td><td><a href="javaScript:void(0)" onclick="deleteRoles('+value.id+')"><i class="icon-trash icons" data-toggle="tooltip" data-placement="bottom" title="Delete Customer Role"></i></a></td></tr>';

            });
            $('#customerListModal .role_customer').html(html);
            $('#customer-list').DataTable();
        },
        error: function (data) {
        }
    });
}

function deleteRoles(id)
{
    $.ajax({
        url:'{{ url("vendor/vendor_roles/delete") }}/'+id,
        type: "GET",
        dataType: 'html',
        success: function (data) {
            $("#customerListModal").modal("hide");
             $('.success-alert').show();
            var suc_str = '';
            suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
            suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
            suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
            suc_str +='<div class="alert-message"><span><strong>Success!</strong>'+data+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script> 
@endsection 