@extends('supplier.layout.main')
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

@php
	foreach($push_notifications as $key => $push_notification){
		$title = $push_notification->title;
		$description = $push_notification->description;
	}
@endphp
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>View Notification</span></div>
				<div class="float-sm-right">

				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<label for="input-10" class="col-sm-2 col-form-label">Title</label>
					<div class="col-sm-10">
						<p>{{$title}}</p>
					</div>
				</div>
				<div class="row">
					<label for="input-10" class="col-sm-2 col-form-label">Description</label>
					<div class="col-sm-10">
						<p>{{$description}}</p>
					</div>
				</div>
			 	<br>
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th >#</th>
								<th >User</th>
								<th >Is Send</th>
								<th >Is Read</th>
								<th >Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($push_notifications as $key => $push_notification)
								<tr>
									<td >{{$key+1}}</td>
									<td >{{$push_notification->first_name}} {{$push_notification->last_name}}</td>
									<td >@php if($push_notification->is_send == 0){echo 'no';}else{echo'yes';} @endphp</td>
									<td >@php if($push_notification->is_read == 0){echo 'no';}else{echo'yes';} @endphp</td>
									<td> @php echo date('d-m-Y H:i:s:a',strtotime($push_notification->created_at));@endphp </td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th >#</th>
								<th >User</th>
								<th >Is Send</th>
								<th >Is Read</th>
								<th >Date</th>
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
		// lengthChange: false,
		// searching: true,
		columnDefs: [
			{ "orderable": false, "targets": 3 }
		]
	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

</script>
@endsection

