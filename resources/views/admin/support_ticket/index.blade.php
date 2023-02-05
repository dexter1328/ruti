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
				<div class="left"><span>Support Tickets</span></div>
				<div class="float-sm-right">        
					<!-- <a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('support_ticket.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Ticket">
						<span class="name">Add Ticket</span>
					</a> -->
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Ticket No</th>
								<th>Subject</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($support_tickets as $key => $support_ticket)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$support_ticket->ticket_no}}</td>
									<td>{{$support_ticket->subject}}</td>
									<td>
										<a href="{{ route('support_ticket.show', $support_ticket->id) }}" class="view ticket-msg" data-toggle="tooltip" data-placement="bottom" title="Chat">
                                            <i class="icon-speech icons" style="font-size: 20px;"></i>
                                        </a>
                                    </td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Ticket No</th>
								<th>Subject</th>
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
				title: 'Ticket List',
				exportOptions: {
				columns: [ 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Ticket List',
				exportOptions: {
				columns: [ 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Ticket List',
				exportOptions: {
				columns: [ 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Ticket List',
				autoPrint: true,
				exportOptions: {
				columns: [ 1, 2]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 3 }
		]
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

</script>
@endsection

