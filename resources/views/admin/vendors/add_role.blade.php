@extends('admin.layout.main')

@section('content')
@if(session()->get('errors'))
	<script type="text/javascript">
		$(document).ready(function() {
			$('#myAddModal').modal('show');			
		});		
	</script>
@endif
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
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-users"></i> --><span>Vendor Roles</span></div>
				<div class="float-sm-right"> 
					<a style="padding-bottom: 3px; padding-top: 4px;" href="#" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Role" data-toggle="modal" data-target="#myAddModal"> <span class="name">Add Role</span> </a>
				</div>
				<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
			</div>
			<div class="card-body">
            	<div class="container-fluid">
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
	                                <td>{{$vendor_role->role_name}}</td>
	                                <td>{{$vendor_role->created_at->format('d M Y - H:i:s')}}</td>
	                                <td class="action">
	                                    <form id="deletefrm_{{$vendor_role->id}}" action="{{ url('admin/vendor/delete_role', $vendor_role->id) }}" class="delete" method="GET" onsubmit="return confirm('Are you sure?');">
	                                        <!-- @csrf -->
	                                        <!-- @method('DELETE') -->
	                                        <!-- <a href="{{ url('admin/vendor/edit_role', $vendor_role->id) }}" class="edit">
	                                            <i class="icon-note icons"></i>
	                                        </a> -->
	                                        <a href="javaScript:void(0)" class="edit" onclick="editRole('{{$vendor_role->id}}')">
	                                            <i class="icon-note icons"></i>
	                                        </a>
	                                        <a href="javascript:void(0);" onclick="deleteRow('{{$vendor_role->id}}')"><i class="icon-trash icons"></i>
	                                    <!-- </form> -->
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
			<!-- add Modal -->

				<!-- <div id="myAddModal" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width:53%;">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Add Role</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								
								<form method="post" action="{{ url('admin/vendor/vendor_add_role',$id) }}" enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="input-12" class="col-sm-2 col-form-label">Role Name<span class="text-danger">*</span></label>
										<div class="col-sm-10">
											<input type="text" name="role_name" class="form-control" value="{{old('role_name')}}" placeholder="Enter Role Name">
											@if ($errors->has('role_name'))
											<span class="text-danger">{{ $errors->first('role_name') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label for="input-12" class="col-sm-2 col-form-label"></label>
										<div class="col-sm-10">
											<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
											
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div> -->
			<!-- end add modals -->
			<!-- edit Modal -->
				<div id="editmyModal" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width:53%;">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Edit Role</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form id="signupForm" method="post" action="{{ url('admin/vendor/update_role') }}" enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="input-12" class="col-sm-2 col-form-label">Role Name<span class="text-danger">*</span></label>
										<div class="col-sm-10">
											<input type="text" id="edit_role_name" name="role_name" class="form-control" value="{{old('role_name')}}" placeholder="Enter Role Name">
											@if ($errors->has('role_name'))
											<span class="text-danger">{{ $errors->first('role_name') }}</span>
											@endif
											<input type="hidden" name="role_id" id="role_id">
											<input type="hidden" name="vendor_id" id="vendor_id">
										</div>
									</div>
									<div class="form-group row">
										<label for="input-12" class="col-sm-2 col-form-label"></label>
										<div class="col-sm-10">
											<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
											
										</div>
									</div>
								</form>
							</div>
							<!-- <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div> -->
						</div>
					</div>
				</div>
			<!-- end add modals -->
		</div>
	</div>
</div>
<!--End Row--> 
<!-- add Modal -->

<div id="myAddModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:53%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Role</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				
				<form method="post" action="{{ url('admin/vendor/vendor_add_role',$id) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Role Name<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="role_name" class="form-control" value="{{old('role_name')}}" placeholder="Enter Role Name">
							@if ($errors->has('role_name'))
							<span class="text-danger">{{ $errors->first('role_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label"></label>
						<div class="col-sm-10">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
			<!-- end add modals -->
<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
          <form></form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div> -->	
<script type="text/javascript">

	function deleteRow(id)
    {   
        $('#deletefrm_'+id).submit();
    }
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
	function editRole(id){
		$.ajax({
			url: "{{ url('admin/vendor/edit_role') }}/"+id,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$('#editmyModal').modal('show');
				$("#edit_role_name").val(data.role_name);
				$("#role_id").val(data.id);
				$("#vendor_id").val(data.vendor_id);
			},
			error: function (data) {
			}
		});
	
	}
</script>
@endsection 