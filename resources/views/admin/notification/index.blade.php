@extends('admin.layout.main')
@section('content')
<link href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-bell"></i> --><span>Notification List</span></div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered display" style="width: 100%">
						<thead>
							<tr>
								<th>User</th>
								<th>Title</th>
								<th>Description</th>
								<th>Priority</th>
								<th>Type</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	//$('#example').DataTable();
	getUserNotifications();
});

function getUserNotifications(){

	//$('#example').DataTable().destroy();

	$('#example').removeAttr('width').DataTable({
		//"pageLength": 100,
		"processing": true,
		"serverSide": true,
		"ajax":{
			"url": "{{ url('admin/notifications/get-user-notifications') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}" }
		},
		"columns": [
			//{ "data": "id" },
			{ "data": "user" },
			{ "data": "title" },
			{ "data": "description" },
			{ "data": "priority" },
			{ "data": "Type" },
			{ "data": "date" },
		],
		columnDefs: [
            { width: "20%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "30%", targets: 2 },
            { width: "10%", targets: 3 },
            { width: "10%", targets: 4 },
            { width: "10%", targets: 5 },
        ],
        fixedColumns: true
	});
}
</script>
@endsection