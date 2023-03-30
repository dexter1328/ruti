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
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<i class="fa fa-users"></i><span>Customers</span>
				</div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('supplier.customer.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Customer">
						<i class="fa fa-users" style="font-size:15px;"></i> <span class="name">Add Customer</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>Sr. No</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Mobile</th>
								<th>DOB</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($customers as $key=> $customer)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$customer->first_name}}</td>
									<td>{{$customer->email}}</td>
									<td>{{$customer->mobile}}</td>
									<td>{{$customer->dob}}</td>
									<td class="action">
									<form id="deletefrm_{{$customer->id}}" action="{{ route('supplier.customer.destroy', $customer->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('supplier.customer.edit', $customer->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$customer->id}}')"><i class="icon-trash icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Sr. No</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Mobile</th>
								<th>DOB</th>
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
				title: 'customer-list',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'customer-list',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'customer-list',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'customer-list',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 5 }
		]
	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});
function deleteRow(id)
{
	$('#deletefrm_'+id).submit();
}
</script>
@endsection

