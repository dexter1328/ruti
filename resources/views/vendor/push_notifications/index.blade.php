@extends('vendor.layout.main')
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
				<div class="left"><span></span></div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.push_notifications.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Notification">
						<span class="name">Add Notification</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th >#</th>
								<th >Title</th>
								<th >Description</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($push_notifications as $key=>$push_notification)
								<tr>
									<td >{{$key+1}}</td>
									<td >{{$push_notification->title}}</td>
									<td >{{$push_notification->description}}</td>
									<td class="action">
									<form id="deletefrm_{{$push_notification->id}}" action="{{ route('vendor.push_notifications.destroy', $push_notification->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
										@csrf
										@method('DELETE')
										<a href="{{ route('vendor.push_notifications.edit', $push_notification->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Push Notification">
										<i class="icon-note icons"></i>
										</a>
										<a href="javascript:void(0);" onclick="deleteRow('{{$push_notification->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Push Notification"><i class="icon-trash icons"></i></a>

										<a href="{{ route('vendor.push_notifications.show', $push_notification->id) }}" data-toggle="tooltip" data-placement="bottom" title="Send Push Notification"><i class="icon-paper-plane icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th >#</th>
								<th >Title</th>
								<th >Description</th>
								<th >Action</th>
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
				columns: [ 0, 1,2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Notification List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Notification List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			'colvis'
		],
		"columnDefs": [
			{ "width": "10%", "targets": 0 },
			{ "width": "20%", "targets": 1 },
			{ "width": "60%", "targets": 2 },
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

