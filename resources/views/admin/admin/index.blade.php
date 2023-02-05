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
				<div class="left"><!-- <i class="fa fa-user"></i> --> <span>Admins</span></div>
				<div class="float-sm-right">		
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('admins.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Admin">
						<!-- <i class="icon-user-follow icons"></i> --> <span class="name">Add Admin</span>
					</a>
				</div>
			</div>
			<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>ROLE</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($admins as $key => $admin)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{$admin->name}}</td>
										<td>{{$admin->email}}</td>
										<td>{{$admin->role_name}}</td>
										<td class="action">
											<form id="deletefrm_{{$admin->id}}" action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
												@csrf
												@method('DELETE')
												<a href="{{ route('admins.edit', $admin->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Admin">
													<i class="icon-note icons"></i>
												</a>

												<a href="javascript:void(0);" onclick="deleteRow('{{$admin->id}}')"><i class="icon-trash icons" data-toggle="tooltip" data-placement="bottom" title="Delete Admin"></i>
												</a>

												<a href="javascript:void(0);" onclick="changeStatus('{{$admin->id}}')" >
											 		<i class="fa fa-circle status_{{$admin->id}}" style="@if($admin->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$admin->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
												</a>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>ROLE</th>
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
 	$('[data-toggle="tooltip"]').tooltip(); 
    var table = $('#example').DataTable( {
        lengthChange: false,
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
        	{
                extend: 'copy',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                title: 'Admin List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            'colvis'
        ],
        columnDefs: [
        	{ "orderable": false, "targets": 4 }
      	]
      	/*columnDefs: [
            { width: "5%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "50%", targets: 2 },
            { width: "15%", targets: 3 },
            { "orderable": false, width: "15%", targets: 4 },
        ],*/
    });
    table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
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
	        url: "{{ url('admin/admins') }}/"+id,
	        type: "GET",
	        dataType: 'json',
	        success: function (data) {
	        	var status = '';
	            if(data == 'active'){
	            	status = 'activated';
	                $('.status_'+id).css('color','#009933');
	            }else{
	            	status = 'deactivated';
	                $('.status_'+id).css('color','#ff0000');
	            }
	            // $('.status_'+id).attr('data-toggle',"tooltip");
	            // $('.status_'+id).attr('data-placement',"bottom");

	            $('.success-alert').show();
				var suc_str = '';
				suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
				suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
				suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
				suc_str +='<div class="alert-message"><span><strong>Success!</strong> Admin has been '+status+'.</span></div>';
				suc_str +='</div>';
				$('.success-alert').html(suc_str);
	        },
	        error: function (data) {
	        }
	    });
	}
</script>
@endsection
