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
				<div class="left"><span>Customers Used Reward Points</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.customer_used_reward_points.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Used Reward Point">
						<span class="name">Add Customer Used Reward Point</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>User</th>
								<th>Order Number</th>
								<th>Reward Points</th>
								<th>Date Time</th>
								<!-- <th>Actions</th> -->
							</tr>
						</thead>
						<tbody>
							@foreach($used_reward_points as $key=> $used_reward_point)
								<tr>
									<td>{{$used_reward_point->first_name.' '.$used_reward_point->last_name}}</td>
									<td>#{{$used_reward_point->order_no}}</td>
									<td>{{$used_reward_point->reward_point}}</td>
									<td>{{date('m/d/Y H:i:s', strtotime($used_reward_point->created_at))}}</td>
									@php /* @endphp
									<td class="action">
										<form id="deletefrm_{{$used_reward_point->id}}" action="{{ route('vendor.customer_used_reward_points.destroy', $used_reward_point->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
										@csrf
											@method('DELETE')
											<a href="{{ route('vendor.customer_used_reward_points.edit', $used_reward_point->id) }}" class="edit">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$used_reward_point->id}}')"><i class="icon-trash icons"></i></a>
										</form>
									</td>
									@php */ @endphp
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>User</th>
								<th>Order Number</th>
								<th>Reward Points</th>
								<th>Date Time</th>
								<!-- <th>Actions</th> -->
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
				title: 'Customers Reward Points',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Customers Reward Points',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Customers Reward Points',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'print',
				title: 'Customers Reward Points',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			'colvis'
		],
		/*columnDefs: [
			{ "orderable": false, "targets": 5 }
		]*/
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});
function deleteRow(id)
{   
	$('#deletefrm_'+id).submit();
}
</script>
@endsection

