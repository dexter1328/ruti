@extends('admin.layout.main')
@section('content')
<style type="text/css">
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 450px;
    overflow-y: auto;
}
</style>
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-users"></i> --><span>Login Supplier Activities</span>
				</div>
				<div class="float-sm-right">

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Type</th>
								<th>Date Time</th>
								<th>Location</th>
							</tr>
						</thead>
						<tbody>
							@foreach($login_history as $key=> $value)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$value->name}} </td>
									<td>{{$value->type}} @if(!empty($value->role_name))({{$value->role_name}}) @else @endif</td>
									<td>{{$value->created_at ? date('Y-m-d H:i:m', strtotime($value->created_at)) : '-' }}</td>
									<td>{{$value->ip}}</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Type</th>
								<th>Date Time</th>
								<th>Location</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

<script>
$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Login History List',
				exportOptions: {
				columns: [ 0, 1,2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Login History List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Login History List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Login History List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]

        fixedColumns: true
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});


</script>
@endsection

