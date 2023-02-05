@extends('vendor.layout.main')
@section('content')
@if(session()->get('error'))
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-message">
			<span><strong>Error!</strong> {{ session()->get('error') }}</span>
		</div>
	</div>
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
				<div class="row">
					<div class="col-3">
						<div class="left"><span>Active Plan(s)</span></div>
					</div>
					<div class="col-9">
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>Store Name</th>
								<th>Plan</th>
								<th>Description</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($plans as $plan)
								<tr>
									<td>{{$plan->store_name}}</td>
									<td>{{$plan->plan_name}}</td>
									<td>${{$plan->price.'/'.$plan->billing_period}}</td>
									<td>{{date('m/d/Y', strtotime($plan->start_date))}}</td>
									<td>{{date('m/d/Y', strtotime($plan->end_date))}}</td>
									<td class="action">
										<form id="cancelfrm_{{$plan->id}}" action="{{ route('vendor.cancel-subscription', $plan->id) }}" method="POST" class="cancel"  onsubmit="return confirm('Are you sure want to cancel the plan?');">
											@csrf
											@method('DELETE')
											<button type="button" class="btn btn-block btn-outline-primary btn-rounded" onclick="cancelPlan('{{$plan->id}}');">Cancel</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Store Name</th>
								<th>Plan</th>
								<th>Description</th>
								<th>Start Date</th>
								<th>End Date</th>
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
					columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Notification List',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Notification List',
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'print',
				title: 'Notification List',
				autoPrint: true,
				exportOptions: {
					columns: [ 0, 1, 2, 3, 4]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ orderable: false, targets: 5 }
		]
	});

	table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

function cancelPlan(id)
{
	$('#cancelfrm_'+id).submit();
}
</script>
@endsection