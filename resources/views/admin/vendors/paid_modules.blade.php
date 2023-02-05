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
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-users"></i> --><span>Add Paid Activity</span></div>
				<div class="float-sm-right">		
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ url('admin/vendor/paid_modules/create') }}/{{$id}}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Admin">
						<!-- <i class="icon-user-follow icons"></i> --> <span class="name">Add Module</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Module</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($paid_modules as $key=>$paid_module)
								<tr>
									<td >{{$key+1}}</td>
									<td >{{$paid_module->module_name}}</td>
									<td >{{$paid_module->status}}</td>
									<td>
										<a href="{{ url('admin/vendor/paid_modules/edit') }}/{{$paid_module->id}}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Paid Modules">
											<i class="icon-note icons"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Module</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
            	<div class="container-fluid">
					<!-- <form id="signupForm" method="post" action="{{ url('admin/vendor/paid_modules',$id) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Module Name<span class="text-danger">*</span></label>
						
					</div>
					<div class="form-group row">
						@foreach(vendor_paid_modules() as $key => $vendor_paid_module)
						<div class="col-sm-3">
							<label>@php echo str_replace("_"," ",$vendor_paid_module);@endphp</label>
						</div>
						<div class="col-sm-7">
							<input type="radio" name="{{$vendor_paid_module}}" value="yes" {{isset($paid_modules[$vendor_paid_module]) && $paid_modules[$vendor_paid_module] == 'yes'?'checked':''}}> Yes
							<input type="radio" name="{{$vendor_paid_module}}" value="no"{{isset($paid_modules[$vendor_paid_module]) && $paid_modules[$vendor_paid_module] == 'no'?'checked':''}}> No
						</div>
						@endforeach
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/vendor')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form> -->
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 
<script>

$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
				buttons: [
			{
				extend: 'copy',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'print',
				title: 'Product List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			'colvis'
		],
		columnDefs: [
            { width: "15%", targets: 0 },
            { width: "15%", targets: 1 },
        ],

	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});
</script>
@endsection 