@extends('admin.layout.main')
@section('content')
<link href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-bell"></i> --><span>View Notification</span></div>
				<div class="float-sm-right">        

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<!-- <tr> -->
								<th>Title</th>
								<th >User</th>
								<th >Is Send</th>
								<th >Is Read</th>
								<th >Date</th>
							<!-- </tr> -->
						</thead>
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->
<script>
$(document).ready(function() {
	
	var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('admin/user_notification/view_datatable') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}"}
               },
        "columns": [
            { "data": "title" },
            { "data": "user" },
            { "data": "is_send" },
            { "data": "is_read" },
            { "data": "date" }
        ],
        "dom" : 'Bfrtip',
        buttons: [
			{
				extend: 'copy',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Notification List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			'colvis'
		]	 

    });
	 table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

</script>
@endsection

