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
				<div class="left"><!-- <i class="fa fa-bell"></i> --><span>Push Notifications</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('push_notifications.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Push Notification">
						<span class="name">Add Notification</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Description</th>
								<th>Created By</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($push_notifications as $key=>$push_notification)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$push_notification->title}}</td>
									<td>{{$push_notification->description}}</td>
									<td>{{$push_notification->user_name}} ({{$push_notification->created_type}})</td>
									<td>
										<form id="deletefrm_{{$push_notification->id}}" action="{{ route('push_notifications.destroy', $push_notification->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<!-- <a href="{{ url('admin/push_notifications/get-user-notifications', $push_notification->id) }}" title="View Notification"><i class="icon-eye icons"></i></a> -->
											<a href="{{ route('push_notifications.edit', $push_notification->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Push Notification">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$push_notification->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Push Notification"><i class="icon-trash icons"></i></a>
											<a href="{{ route('push_notifications.show', $push_notification->id) }}" data-toggle="tooltip" data-placement="bottom" title="Send Push Notification"><i class="icon-paper-plane icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Description</th>
								<th>Created By</th>
								<th>Action</th>
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
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'print',
				title: 'Notification List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			'colvis'
		],
		/*columnDefs: [
			{ "orderable": false, "targets": 3 }
		]*/
		"columnDefs": [
			{ "width": "5%", "targets": 0 },
			{ "width": "20%", "targets": 1 },
			{ "width": "45%", "targets": 2 },
			{ "width": "20%", "targets": 3 },
			{ "width": "10%", "targets": 4 },
    	]
	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
function deleteRow(id)
{   
	$('#deletefrm_'+id).submit();
}
</script>
@endsection

